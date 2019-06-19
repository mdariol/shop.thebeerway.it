<?php

namespace App\Console\Commands;

use App\Beer;
use App\Services\FattureInCloud;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class FattureSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fatture:sync {data} {--field=*}';

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
        $data = $this->argument('data');
        $method = 'sync' . ucfirst($data);

        if ( ! method_exists($this, $method)) {
            throw new InvalidArgumentException("Data \"$data\" is not defined.");
        }

        $skipped = $this->$method();
        $this->footer($skipped);
    }

    /**
     * Sync specified field from Fatture in Cloud to the application.
     *
     * @return array
     */
    protected function syncBeers()
    {
        $beers = $this->fattureInCloud->parseBeers();

        $bar = $this->output->createProgressBar(count($beers));
        $bar->start();

        $skipped = [];

        $beers->each(function ($beer) use ($bar, &$skipped) {
            $attributes = [];

            foreach ($this->option('field') as $attribute) {
                $attributes[$attribute] = $beer->$attribute;
            }

            try {
                Beer::where('code', $beer->code)->firstOrFail()
                  ->update($attributes);
            } catch (ModelNotFoundException $exception) {
                $skipped[] = $beer;
            }

            $bar->advance();
        });

        $bar->finish();

        return $skipped;
    }

    /**
     * Prints sync results.
     *
     * @param $skipped
     */
    protected function footer($skipped)
    {
        $data = $this->argument('data');

        if ($count = count($skipped)) {
            $this->line("\n\nSkipped elements ($count):\n");

            foreach ($skipped as $item) {
                $this->line("  - \"$item->name\" with code \"$item->code\"");
            }

            $this->line('');
        }
    }
}
