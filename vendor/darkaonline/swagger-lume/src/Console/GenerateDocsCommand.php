<?php

namespace SwaggerLume\Console;

use Illuminate\Console\Command;
use SwaggerLume\Generator;

class GenerateDocsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'swagger-lume:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate docs';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Regenerating docs');
        Generator::generateDocs();
    }
}
