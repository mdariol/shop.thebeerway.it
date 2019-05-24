<?php

namespace App\Services;

use App\Packaging;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Collection;

class FattureInCloud
{
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

    public function parsePackagings(): Collection
    {
        $packagings = new Collection();

        $this->getProducts()->each(function ($product) use ($packagings) {
            $match = $this->matchPackaging($product->nome);

            if ($match && ! $packagings->has($match)) {
                $packagings->put($match, [
                    'type' => $this->matchType($match),
                    'quantity' => $this->matchQuantity($match),
                    'capacity' => $this->matchCapacity($match)
                ]);
            }
        });

        return $packagings;
    }

    public function parseBreweries(): Collection
    {
        $breweries = new Collection();

        $this->getProducts()->each(function ($product) use ($breweries) {
            $match = $this->matchBrewery($product->nome);

            if ($match && ! $breweries->has($match)) {
                $breweries->put($match, [
                    'name' => $match
                ]);
            }
        });

        return $breweries;
    }

    protected function headers(): array
    {
        return [
            'api_uid' => $this->key,
            'api_key' => $this->secret,
        ];
    }

    protected function matchPackaging(string $string): ?string
    {
        if (preg_match('/^(.*?) -/', $string, $matches)) {
            return trim($matches[1]);
        }

        return null;
    }

    protected function matchType(string $string): ?string
    {
        if (preg_match('/(^F-|^Bottiglia )/', $string, $matches)) {
            if ($matches[1] === 'F-') {
                return Packaging::TYPE['barrel'];
            }

            return Packaging::TYPE['bottle'];
        }

        return null;
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

    protected function matchBrewery(string $string): ?string
    {
        if (preg_match('/ di (.*?), /', $string, $matches)) {
            return $matches[1];
        }

        return null;
    }
}