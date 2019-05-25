<?php

namespace App\Services;

use App\Packaging;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Collection;

class FattureInCloud
{
    const DUNNO = '  (´･_･｀)  ';

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    protected $url;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $secret;

    /**
     * FattureInCloud constructor.
     *
     * @param  string  $key
     * @param  string  $secret
     */
    public function __construct(string $key, string $secret)
    {
        $this->client = new Client();
        $this->url = config('services.fatture_in_cloud.url');
        $this->key = $key;
        $this->secret = $secret;
    }

    public function getProducts(): Collection
    {
        $response = $this->client->post($this->url . '/prodotti/lista', [
            RequestOptions::JSON => $this->headers()
        ])->getBody()->getContents();

        return collect(json_decode($response)->lista_prodotti);
    }

    public function parseBeer(string $string): array
    {
        $brewery = $this->parseBrewery($string);
        $packaging = $this->parsePackaging($string);
        $style = $this->parseStyle($string);

        return [
            $string => [
                'name' => $this->matchBeer($string),
                'style' => reset($style),
                'brewery' => reset($brewery),
                'packaging' => reset($packaging),
                'abv' => $this->matchAbv($string),
            ]
        ];
    }

    public function parseBeers(): Collection
    {
        $beers = new Collection();

        $this->getProducts()->each(function ($product) use ($beers) {
            $name = $product->nome;

            if ( ! $name) {
                return;
            }

            $beer = $this->parseBeer($name);
            $key = key($beer);

            if ($beers->has($key) || $key === self::DUNNO) {
                return;
            }

            $beers->put($key, reset($beer) + [
                'code' => $product->cod,
                'description' => $product->note,
            ]);
        });

        return $beers;
    }

    public function parsePackaging(string $string): array
    {
        $match = $this->matchPackaging($string);

        return [
            $match => [
                'type' => $this->matchType($match),
                'quantity' => $this->matchQuantity($match),
                'capacity' => $this->matchCapacity($match),
            ]
        ];
    }

    public function parsePackagings(): Collection
    {
        $packagings = new Collection();

        $this->getProducts()->each(function ($product) use ($packagings) {
            $name = $product->nome;

            if ( ! $name) {
                return;
            }

            $packaging = $this->parsePackaging($name);
            $key = key($packaging);

            if ($packagings->has($key) || $key === self::DUNNO) {
                return;
            }

            $packagings->put($key, reset($packaging));
        });

        return $packagings;
    }

    public function parseBrewery(string $string): array
    {
        $match = $this->matchBrewery($string);

        return [
            $match => [
                'name' => $match
            ]
        ];
    }

    public function parseBreweries(): Collection
    {
        $breweries = new Collection();

        $this->getProducts()->each(function ($product) use ($breweries) {
            $name = $product->nome;

            if ( ! $name) {
                return;
            }

            $brewery = $this->parseBrewery($name);
            $key = key($brewery);

            if ($breweries->has($key) || $key === self::DUNNO) {
                return;
            }

            $breweries->put($key, reset($brewery));
        });

        return $breweries;
    }

    public function parseStyle(string $string): array
    {
        $match = $this->matchStyle($string);

        return [
            $match => [
                'name' => $match
            ]
        ];
    }

    public function parseStyles(): Collection
    {
        $styles = new Collection();

        $this->getProducts()->each(function ($product) use ($styles) {
            $name = $product->nome;

            if ( ! $name) {
                return;
            }

            $style = $this->parseStyle($name);
            $key = key($style);

            if ($styles->has($key) || $key === self::DUNNO) {
                return;
            }

            $styles->put($key, reset($style));
        });

        return $styles;
    }

    protected function headers(): array
    {
        return [
            'api_uid' => $this->key,
            'api_key' => $this->secret,
        ];
    }

    protected function matchBeer(string $string): string
    {
        if (preg_match('/ -(.*?) di /', $string, $matches)) {
            return trim($matches[1]);
        }

        return self::DUNNO;
    }

    protected function matchStyle(string $string): string
    {
        if (preg_match('/, (.*?) da  /', $string, $matches)) {
            return trim($matches[1]);
        }

        return self::DUNNO;
    }

    protected function matchAbv(string $string): string
    {
        if (preg_match('/da  (.*?)%/', $string, $matches)) {
            return trim($matches[1]);
        }

        return self::DUNNO;
    }

    protected function matchPackaging(string $string): string
    {
        if (preg_match('/^(.*?) -/', $string, $matches)) {
            return trim($matches[1]);
        }

        return self::DUNNO;
    }

    protected function matchType(string $string): string
    {
        if (preg_match('/(^F-|^Bottiglia )/', $string, $matches)) {
            if ($matches[1] === 'F-') {
                return Packaging::TYPE['barrel'];
            }

            return Packaging::TYPE['bottle'];
        }

        return self::DUNNO;
    }

    private function matchQuantity(string $string): int
    {
        if (preg_match('/ X (.*?)$/', $string, $matches)) {
            return (int) $matches[1];
        }

        return 1;
    }

    private function matchCapacity(string $string): ?int
    {
        if (preg_match('/(^F-|^Bottiglia )(.*?)(lt.| Lt.)/', $string, $matches)) {
            return (int) (str_replace(',', '.', $matches[2]) * 100);
        }

        return null;
    }

    protected function matchBrewery(string $string): string
    {
        if (preg_match('/ di (.*?), /', $string, $matches)) {
            return trim($matches[1]);
        }

        return self::DUNNO;
    }
}