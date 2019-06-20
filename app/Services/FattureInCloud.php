<?php

namespace App\Services;

use App\Beer;
use App\Brewery;
use App\Color;
use App\Packaging;
use App\Price;
use App\Style;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Collection;

class FattureInCloud
{
    const DUNNO = '';

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
    public function __construct($key, $secret)
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

    public function putProduct(array $attributes): bool
    {
        $response = $this->client->post($this->url . '/prodotti/modifica', [
            RequestOptions::JSON => $this->headers() + $attributes
        ])->getBody()->getContents();

        return json_decode($response)->success;
    }

    public function parseBeer($product): ?Beer
    {
        $name = $product->nome;

        if (empty($name)) return null;

        $beer = new Beer([
            'name' => $this->matchBeer($name),
            'abv' => $this->matchAbv($name),
            'code' => $product->cod,
            'description' => $product->note,
            'stock' => $product->magazzino ? $product->giacenza : 0,
        ]);

        $beer->brewery = array_values($this->parseBrewery($name))[0];
        $beer->packaging = array_values($this->parsePackaging($name))[0];
        $beer->style = array_values($this->parseStyle($name))[0];
        $beer->price = $this->parsePrice($product);
        $beer->color = $this->parseColor($product);

        return $beer;
    }

    public function parseBeers(): Collection
    {
        $beers = new Collection();

        $this->getProducts()->each(function ($product) use ($beers) {
            $beer = $this->parseBeer($product);

            if ( ! $beer) return;

//            $name = $product->nome;
//
//            if ( ! $name) {
//                return;
//            }
//
//            $beer = $this->parseBeer($name);


            $key = $beer->code;

            if ($beers->has($key)) return;

            // TODO: Improves Color parsing.
            // Despite other relations Color cannot be parsed via parseBeer(),
            // because that function accepts $product->nome - returned by
            // getProducts() - as parameter. A viable solutions could be
            // accepting the $product instead of $product->nome for each
            // parse*() functions. This way it should be more consistent.
//            $color = array_values($this->parseColor($product->categoria))[0];

//            reset($beer)->code = $product->cod;
//            reset($beer)->description = $product->note;
//            reset($beer)->color = $color;

//            if ($product->magazzino) {
//                reset($beer)->stock = $product->giacenza;
//            }

            $beers->put($key, $beer);
        });

        return $beers->values();
    }

    public function parsePackaging(string $string): array
    {
        $match = $this->matchPackaging($string);

        return [
            $match => new Packaging([
              'type' => $this->matchType($match),
              'quantity' => $this->matchQuantity($match),
              'capacity' => $this->matchCapacity($match),
            ])
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

        return $packagings->values();
    }

    public function parseBrewery(string $string): array
    {
        $match = $this->matchBrewery($string);

        return [
            $match => new Brewery([
              'name' => $match
            ])
        ];
    }

    public function parseBreweries(): \Illuminate\Database\Eloquent\Collection
    {
        $breweries = new \Illuminate\Database\Eloquent\Collection();

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

        return $breweries->values();
    }

    public function parseStyle(string $string): array
    {
        $match = $this->matchStyle($string);

        return [
            $match => new Style([
              'name' => $match
            ])
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

        return $styles->values();
    }

    /**
     * Return a Color object reading Fatture in Cloud product.
     *
     * @param $product
     * @return \App\Color
     */
    public function parseColor($product): ?Color
    {
        $string = $product->categoria;

        if (empty($string)) return null;

        $match = $this->matchColor($string);

        if (empty($match)) return null;

        return new Color([
          'name' => $match
        ]);
    }

    /**
     * Return a Collection of Color objects reading Fatture in Cloud products.
     *
     * @return \Illuminate\Support\Collection
     */
    public function parseColors(): Collection
    {
        $colors = new Collection();

        $this->getProducts()->each(function ($product) use ($colors) {
            $color = $this->parseColor($product);

//            $category = $product->categoria;
//
//            if ( ! $category) {
//                return;
//            }

            if ( ! $color) return;

//            $color = $this->parseColor($category);
            $key = $color->name;

            if ($colors->has($key)) return;

            $colors->put($key, $color);
        });

        return $colors->values();
    }

    /**
     * Return a Price object reading Fatture in Cloud product.
     *
     * @param $product
     * @return \App\Price
     */
    public function parsePrice($product): Price
    {
        return new Price([
            'purchase' => $product->costo,
            'distribution' => $product->prezzo_netto,
        ]);
    }

    /**
     * Return a Collection of Price objects reading Fatture in Cloud products.
     *
     * @return \Illuminate\Support\Collection
     */
    public function parsePrices(): Collection
    {
        $prices = new Collection();

        $this->getProducts()->each(function ($product) use ($prices) {
            $prices->push($this->parsePrice($product));
        });

        return $prices;
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

    protected function matchAbv(string $string): float
    {
        if (preg_match('/da  (.*?)%/', $string, $matches)) {
            return (float) str_replace(',', '.', $matches[1]);
        }

        return 0.0;
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

    private function matchCapacity(string $string): int
    {
        if (preg_match('/(^F-|^Bottiglia )(.*?)(lt.| Lt.)/', $string, $matches)) {
            return (int) (str_replace(',', '.', $matches[2]) * 100);
        }

        return 0;
    }

    protected function matchBrewery(string $string): string
    {
        if (preg_match('/ di (.*?), /', $string, $matches)) {
            return trim($matches[1]);
        }

        return self::DUNNO;
    }

    protected function matchColor(string $string): string
    {
        if (preg_match('/^(.*?) - /', $string, $matches)) {
            return trim($matches[1]);
        }

        return self::DUNNO;
    }
}