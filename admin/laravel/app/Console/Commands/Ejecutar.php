<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Ejecutar extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'task:ejecutar {--comando}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecutar comando';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $comando = $this->option('comando');
        exec($comando);
    }

    protected function getOptions()
    {
        return [
            ['comando', null, InputOption::VALUE_OPTIONAL, 'Comando a ejecutar.', null]
        ];
    }

}
