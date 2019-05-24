<?php

namespace App\Console\Commands;

use App\Packaging;
use App\Services\FattureInCloud;
use GuzzleHttp\RequestOptions;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports products from Fatture in Cloud.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(FattureInCloud $fattureInCloud)
    {
        $headers = ['type', 'quantity', 'capacity'];
        $lines = $fattureInCloud->parsePackagings()->toArray();

        /*
        $this->getProducts()->each(function ($product) use (&$lines) {
            array_push($lines, [
                'name' => $this->matchBeer($product->nome),
                'brewery' => $this->matchBrewery($product->nome),
                'style' => $this->matchStyle($product->nome),
                'packaging' => $this->matchPackaging($product->nome),
                'abv' => $this->matchAbv($product->nome),
            ]);
        });
        */

        /*
        $this->getProducts()->each(function ($product) use (&$lines) {
            if ($packaging = $this->parsePackagin($product->nome)) {
                array_push($lines, $packaging->toArray());
            }
        });
        */

        $this->table($headers, $lines);
    }

    private function getProducts(): Collection
    {
        $endpoint = config('services.fatture_in_cloud.url') . '/prodotti/lista';

        $response = (new Client())->post($endpoint, [
          RequestOptions::JSON => [
            'api_uid' => config('services.fatture_in_cloud.key'),
            'api_key' => config('services.fatture_in_cloud.secret'),
          ]
        ])->getBody()->getContents();

        return collect(json_decode($response)->lista_prodotti);
    }

    private function getPackagings(): Collection
    {
        $products = $this->getProducts();
        $packagings = [];

        $products->each(function ($product) use (&$packagings) {
            if ($packaging = $this->matchPackaging($product->nome)) {
                array_push($packagings, $packaging);
            }
        });
    }

    private function matchBrewery(string $string) : string
    {
        if (preg_match('/ di (.*?), /', $string, $matches)) {
            return $matches[1];
        }

        return '...';
    }

    private function matchBeer(string $string) : string
    {
        if (preg_match('/ -(.*?) di /', $string, $matches)) {
            return trim($matches[1]);
        }

        return '...';
    }

    private function matchAbv(string $string) : string
    {
        if (preg_match('/da  (.*?)%/', $string, $matches)) {
            return trim($matches[1]);
        }

        return '...';
    }

    private function matchStyle(string $string) : string
    {
        if (preg_match('/, (.*?) da  /', $string, $matches)) {
            return trim($matches[1]);
        }

        return '...';
    }

    private function parsePackagin(string $string): ?Packaging
    {
        if ($match = $this->matchPackaging($string)) {
            return Packaging::firstOrCreate([
                'type' => $this->matchType($match),
                'quantity' => $this->matchQuantity($match),
                'capacity' => $this->matchCapacity($match)
            ]);
        }

        return null;
    }

    private function matchPackaging(string $string) : ?string
    {
        if (preg_match('/^(.*?) -/', $string, $matches)) {
            return trim($matches[1]);
        }

        return null;
    }

    private function matchQuantity(string $string) : int
    {
        if (preg_match('/ X (.*?)$/', $string, $matches)) {
            return (int) $matches[1];
        }

        return 1;
    }

    private function matchCapacity(string $string) : ?int
    {
        if (preg_match('/(^F-|^Bottiglia )(.*?)(lt.| Lt.)/', $string, $matches)) {
            return (int) (str_replace(',', '.', $matches[2]) * 100);
        }

        return null;
    }

    private function matchType(string $string) : ?string
    {
        if (preg_match('/(^F-|^Bottiglia )/', $string, $matches)) {
            switch ($matches[1]) {
                case 'F-':
                    return 'fusti';
                case 'Bottiglia ':
                    return 'bottiglie';
            }
        }

        return null;
    }
}
