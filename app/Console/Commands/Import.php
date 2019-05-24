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
        dd($fattureInCloud->parseStyles());
    }
}
