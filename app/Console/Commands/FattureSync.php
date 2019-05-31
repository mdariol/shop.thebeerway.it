<?php

namespace App\Console\Commands;

use App\Services\FattureInCloud;
use Illuminate\Console\Command;

class FattureSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fatture:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var \App\Services\FattureInCloud
     */
    protected $fattureInCloud;

    /**
     * Create a new command instance.
     *
     * @param \App\Services\FattureInCloud $fattureInCloud
     * @return void
     */
    public function __construct(FattureInCloud $fattureInCloud)
    {
        parent::__construct();

        $this->fattureInCloud = $fattureInCloud;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        //
    }

    /*
    public function handle()
    {
        $webSelect = new FattureInCloud('', '');

        $fromProducts = $this->fattureInCloud->getProducts();
        $toProducts = $webSelect->getProducts();
        $attributes = $this->attributes($fromProducts, $toProducts);

        $bar = $this->output->createProgressBar($attributes->count());
        $bar->start();

        $attributes->chunk(27)->each(function (Collection $chunck) use ($webSelect, $bar) {
            $chunck->each(function ($attributes) use ($webSelect, $bar) {
                $webSelect->putProduct($attributes);

                $bar->advance();
            });

            sleep(60);
        });

        $bar->finish();
    }
    */

    /*
    protected function attributes(Collection $fromProducts, Collection $toProducts): Collection
    {
        $attributes = new Collection();

        $fromProducts->each(function ($fromProduct) use ($toProducts, $attributes) {
            if (empty($fromProduct->cod)) return;

            $toProduct = $toProducts->firstWhere('cod', $fromProduct->cod);

            if ( ! $toProduct) return;

            $attributes->push([
                'id' => $toProduct->id,
                'note' => $fromProduct->note,
                'categoria' => $fromProduct->categoria,
            ]);
        });

        return $attributes;
    }
    */
}
