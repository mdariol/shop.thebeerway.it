<?php

namespace App\Console\Commands;

use App\Beer;
use App\Brewery;
use App\Color;
use App\Packaging;
use App\Services\FattureInCloud;
use App\Style;
use Illuminate\Console\Command;
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
     * @param  \App\Services\FattureInCloud  $fattureInCLoud
     */
    public function __construct(FattureInCloud $fattureInCLoud)
    {
        parent::__construct();

        $this->fattureInCLoud = $fattureInCLoud;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = $this->argument('data');

        if ( ! method_exists($this, $data)) {
            throw new InvalidArgumentException("Data \"$data\" is not defined.");
        }

        $skipped = $this->$data();
        $this->footer($skipped);
    }

    /**
     * Reads beers from Fatture in Cloud products and try to import them into
     * the application.
     *
     * @return array
     */
    protected function beers()
    {
        $beers = $this->fattureInCLoud->parseBeers();

        $bar = $this->output->createProgressBar(count($beers));
        $bar->start();

        $skipped = [];

        $beers->each(function ($beer) use ($bar, &$skipped) {
            try {
                Beer::updateOrCreate(['code' => $beer->code], $beer->toArray() + [
                    'brewery_id' => Brewery::firstOrCreate($beer->brewery->toArray())->id,
                    'style_id' => Style::firstOrCreate($beer->style->toArray())->id,
                    'color_id' => Color::firstOrCreate($beer->color->toArray())->id,
                    'packaging_id' => Packaging::firstOrCreate($beer->packaging->toArray())->id,
                ]);
            } catch (\Exception $exception) {
                $skipped[] = $beer;
            }

            $bar->advance();
        });

        $bar->finish();

        return $skipped;
    }

    /**
     * Reads breweries from Fatture in Cloud products and try to import them
     * into the application.
     *
     * @return array
     */
    protected function breweries()
    {
        $breweries = $this->fattureInCLoud->parseBreweries();

        $bar = $this->output->createProgressBar(count($breweries));
        $bar->start();

        $skipped = [];

        $breweries->each(function ($brewery) use ($bar, &$skipped) {
            try {
                Brewery::firstOrCreate($brewery->toArray());
            } catch (\Exception $exception) {
                $skipped[] = $brewery;
                // $this->error("Cannot import brewery \"$brewery->name\"");
            }

            $bar->advance();
        });

        $bar->finish();

        return $skipped;
    }

    /**
     * Reads packagings from Fatture in Cloud products and try to import them
     * into the application.
     */
    protected function packagings()
    {
        $packagings = $this->fattureInCLoud->parsePackagings();

        $bar = $this->output->createProgressBar(count($packagings));
        $bar->start();

        $skipped = [];

        $packagings->each(function ($packaging) use ($bar, &$skipped) {
            try {
                Packaging::firstOrCreate($packaging->toArray());
            } catch (\Exception $exception) {
                $skipped[] = $packaging;
            }

            $bar->advance();
        });

        $bar->finish();

        return $skipped;
    }

    /**
     * Reads styles from Fatture in Cloud products and try to import them into
     * the application.
     */
    protected function styles()
    {
        $styles = $this->fattureInCLoud->parseStyles();

        $bar = $this->output->createProgressBar(count($styles));
        $bar->start();

        $skipped = [];

        $styles->each(function ($style) use ($bar, &$skipped) {
            try {
                Style::firstOrCreate($style->toArray());
            } catch (\Exception $exception) {
                $skipped[] = $style;
            }

            $bar->advance();
        });

        $bar->finish();

        return $skipped;
    }

    /**
     * Reads colors from Fatture in Cloud products and try to import them into
     * the application.
     */
    protected function colors()
    {
        $colors = $this->fattureInCLoud->parseColors();

        $bar = $this->output->createProgressBar(count($colors));
        $bar->start();

        $skipped = [];

        $colors->each(function ($color) use ($bar, &$skipped) {
            try {
                Color::firstOrCreate($color->toArray());
            } catch (\Exception $exception) {
                $skipped[] = $color;
            }

            $bar->advance();
        });

        $bar->finish();

        return $skipped;
    }

    /**
     * Prints sync results.
     *
     * @param array $skipped
     */
    protected function footer(array $skipped)
    {
        $data = $this->argument('data');

        $this->info("\n\nImported $data successfully!\n");

        if ($count = count($skipped)) {
            $this->line("Skipped elements ($count):\n");

            foreach ($skipped as $item) {
                $this->line("  - $item->name");
            }
        }
    }
}
