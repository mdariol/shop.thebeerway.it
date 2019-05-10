<?php

namespace App\Console\Commands;

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
    public function handle()
    {
        $products = $this->getProducts();

        $products->each(function ($product) {
            $this->line($product->nome);
        });
    }

    /**
     * Gets the products from Fatture in Cloud.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getProducts() : Collection
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
}
