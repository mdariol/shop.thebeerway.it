<?php

namespace App\Console\Commands;

use App\Services\FattureInCloud;
use Illuminate\Console\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class FattureRead extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fatture:read {data=beers}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reads data from Fatture in Cloud';

    /**
     * @var \App\Services\FattureInCloud
     */
    protected $fattureInCloud;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FattureInCloud $fatture_in_cloud)
    {
        parent::__construct();

        $this->fattureInCloud = $fatture_in_cloud;
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

        /** @var \Illuminate\Support\Collection $collection */
        $collection = $this->$data();

        $this->table(
          array_keys($collection->first()->toArray()),
          $collection->toArray()
        );
    }

    protected function beers()
    {
        $beers = $this->fattureInCloud->parseBeers();

        $beers->each(function ($beer) {
            $beer->packaging = $beer->packaging->name;
            $beer->description = substr($beer->description, 0, 17);
            $beer->brewery = substr($beer->brewery->name, 0, 17);
            $beer->style = substr($beer->style->name, 0, 17);
        });

        return $beers;
    }

    protected function breweries()
    {
        return $this->fattureInCloud->parseBreweries();
    }

    protected function styles()
    {
        return $this->fattureInCloud->parseStyles();
    }

    protected function packagings()
    {
        return $this->fattureInCloud->parsePackagings();
    }

    protected function colors()
    {
        return $this->fattureInCloud->parseColors();
    }
}
