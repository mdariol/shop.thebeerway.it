<?php

namespace App\Console\Commands;

use App\Beer;
use App\Brewery;
use App\Packaging;
use App\Services\FattureInCloud;
use App\Style;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class FattureImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fatture:import {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var \App\Services\FattureInCloud
     */
    protected $fattureInCLoud;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FattureInCloud $fatture_in_cloud)
    {
        parent::__construct();

        $this->fattureInCLoud = $fatture_in_cloud;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = $this->argument('data');

        if ( ! method_exists($this, $data)) {
            throw new InvalidArgumentException("Data \"$data\" is not defined.");
        }

        $this->$data();
    }

    protected function beers()
    {
        $beers = $this->fattureInCLoud->parseBeers();

        $beers->each(function ($beer) {
            try {
                Beer::updateOrCreate(['code' => $beer->code], $beer->toArray() + [
                    'brewery_id' => Brewery::firstOrCreate($beer->brewery->toArray())->id,
                    'style_id' => Style::firstOrCreate($beer->style->toArray())->id,
                    'packaging_id' => Packaging::firstOrCreate($beer->packaging->toArray())->id,
                ]);
            } catch (\Exception $exception) {
                $this->error("Cannot import beer \"$beer->name\" with code \"$beer->code\"");
            }
        });
    }

    protected function breweries()
    {
        $breweries = $this->fattureInCLoud->parseBreweries();

        $breweries->each(function ($brewery) {
            try {
                Brewery::firstOrCreate($brewery->toArray());
            } catch (\Exception $exception) {
                $this->error("Cannot import brewery \"$brewery->name\"");
            }
        });
    }

    protected function packagings()
    {
        $packagings = $this->fattureInCLoud->parsePackagings();

        $packagings->each(function ($packaging) {
            try {
                Packaging::firstOrCreate($packaging->toArray());
            } catch (\Exception $exception) {
                $this->error("Cannot import packaging \"$packaging->name\"");
            }
        });
    }

    protected function styles()
    {
        $styles = $this->fattureInCLoud->parseStyles();

        $styles->each(function ($style) {
            try {
                Style::firstOrCreate($style->toArray());
            } catch (\Exception $exception) {
                $this->error("Cannot import style \"$style->name\"");
            }
        });
    }
}
