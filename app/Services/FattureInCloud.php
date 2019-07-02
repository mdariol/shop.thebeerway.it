<?php

namespace App\Services;

use App\Beer;
use App\Brewery;
use App\Color;
use App\Packaging;
use App\Price;
use App\Style;
use App\Taste;
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

    /**
     * Return a Beer object reading Fatture in Cloud product.
     *
     * @param $product
     * @return \App\Beer|null
     */
    public function parseBeer($product): ?Beer
    {
        if (empty($product->nome)) return null;

        $name = $this->matchBeer($product->nome);

        if (empty($name)) return null;

        $beer = new Beer([
            'name' => $name,
            'abv' => $this->matchAbv($product->nome),
            'code' => $product->cod,
            'description' => $product->note,
            'stock' => $product->giacenza ?: 0,
        ]);

        $beer->brewery = $this->parseBrewery($product);
        $beer->packaging = $this->parsePackaging($product);
        $beer->style = $this->parseStyle($product);
        $beer->price = $this->parsePrice($product);
        $beer->color = $this->parseColor($product);
        $beer->taste = $this->parseTaste($product);

        return $beer;
    }

    /**
     * Return Beer objects reading Fatture in Cloud products.
     *
     * @return \Illuminate\Support\Collection
     */
    public function parseBeers(): Collection
    {
        $beers = new Collection();

        $this->getProducts()->each(function ($product) use ($beers) {
            $beer = $this->parseBeer($product);

            if ( ! $beer) return;

            $key = $beer->code;

            if ($beers->has($key)) return;

            $beers->put($key, $beer);
        });

        return $beers->values();
    }

    /**
     * Return Packaging object reading Fatture in Cloud product.
     *
     * @param  $product
     * @return \App\Packaging|null
     */
    public function parsePackaging($product): ?Packaging
    {
        if (empty($product->nome)) return null;

        $match = $this->matchPackaging($product->nome);

        if (empty($match)) return null;

        return new Packaging([
          'type' => $this->matchType($match),
          'quantity' => $this->matchQuantity($match),
          'capacity' => $this->matchCapacity($match),
        ]);
    }

    /**
     * Return a Collection of Packaging objects reading Fatture in Cloud products.
     *
     * @return \Illuminate\Support\Collection
     */
    public function parsePackagings(): Collection
    {
        $packagings = new Collection();

        $this->getProducts()->each(function ($product) use ($packagings) {
            $packaging = $this->parsePackaging($product);

            if ( ! $packaging) return;

            $key = $packaging->name;

            if ($packagings->has($key)) return;

            $packagings->put($key, $packaging);
        });

        return $packagings->values();
    }

    /**
     * Return Brewery object reading from Fatture in Cloud product.
     *
     * @param $product
     * @return \App\Brewery|null
     */
    public function parseBrewery($product): ?Brewery
    {
        if (empty($product->nome)) return null;

        $match = $this->matchBrewery($product->nome);

        if (empty($match)) return null;

        return new Brewery([
          'name' => $match
        ]);
    }

    /**
     * Return a Collection of Breweries objects reading from Fatture in Cloud products.
     *
     * @return \Illuminate\Support\Collection
     */
    public function parseBreweries(): Collection
    {
        $breweries = new Collection();

        $this->getProducts()->each(function ($product) use ($breweries) {
            $brewery = $this->parseBrewery($product);

            if ( ! $brewery) return;

            $key = $brewery->name;

            if ($breweries->has($key)) return;

            $breweries->put($key, $brewery);
        });

        return $breweries->values();
    }

    /**
     * Return Style object reading Fatture in Cloud product.
     *
     * @param $product
     * @return \App\Style|null
     */
    public function parseStyle($product): ?Style
    {
        if (empty($product->nome)) return null;

        $match = $this->matchStyle($product->nome);

        if (empty($match)) return null;

        return new Style([
          'name' => $match
        ]);
    }

    /**
     * Return a Collection of Style objects reading Fatture in Cloud products.
     *
     * @return \Illuminate\Support\Collection
     */
    public function parseStyles(): Collection
    {
        $styles = new Collection();

        $this->getProducts()->each(function ($product) use ($styles) {
            $style = $this->parseStyle($product);

            if ( ! $style) return;

            $key = $style->name;

            if ($styles->has($key)) return;

            $styles->put($key, $style);
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
        if (empty($product->categoria)) return null;

        $match = $this->matchColor($product->categoria);

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

            if ( ! $color) return;

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
          'purchase' => round($product->costo, 2),
          'distribution' => round($product->prezzo_netto, 2),
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

    /**
     * Return a Taste object reading Fatture in Cloud product.
     *
     * @param $product
     * @return \App\Taste|null
     */
    public function parseTaste($product): ?Taste
    {
        if (empty($product->categoria)) return null;

        $match = $this->matchTaste($product->categoria);

        if (empty($match)) return null;

        return new Taste([
          'name' => $match
        ]);
    }

    /**
     * Return a Collection of Taste objects reading Fatture in Cloud products.
     *
     * @return \Illuminate\Support\Collection
     */
    public function parseTastes(): Collection
    {
        $tastes = new Collection();

        $this->getProducts()->each(function ($product) use ($tastes) {
            $taste = $this->parseTaste($product);

            if ( ! $taste) return;

            $key = $taste->name;

            if ($tastes->has($key)) return;

            $tastes->put($key, $taste);
        });

        return $tastes->values();
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

    private function matchCapacity(string $string): float
    {
        if (preg_match('/(^F-|^Bottiglia )(.*?)(lt.| Lt.)/', $string, $matches)) {
            return (float) str_replace(',', '.', $matches[2]);
        }

        return 0.0;
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

    protected function matchTaste(string $string): string
    {
        if (preg_match('/ - (.*?)$/', $string, $matches)) {
            return trim($matches[1]);
        }

        return self::DUNNO;
    }
}