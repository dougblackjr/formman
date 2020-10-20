<?php

namespace App\Console\Commands;

use App\Form;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class BackfillSecrets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:backfill-secrets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fixing form secrests';

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
        $forms = Form::all();

        $forms->each(function($f) {
            if( ! $f->secret ) {
                $f->secret = Str::uuid()->toString();
                $f->save();
            }
        });
    }
}
