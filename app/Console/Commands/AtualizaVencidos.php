<?php

namespace App\Console\Commands;

use App\Model\Cotacoes;
Use App\Model\Propostas;

use Illuminate\Console\Command;
use Mockery\CountValidator\Exception;


class AtualizaVencidos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verificar:vencidas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica se há propostas e cotações vencidas e muda o status';

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
        
        Cotacoes::where('dtvalidade', '<=', date('Y-m-d'))->where('idstatus', 9)->update(['idstatus' => 11,
            'dtupdate' => date('Y-m-d H:i:s')]);
        Propostas::where('dtvalidade', '<=', date('Y-m-d'))->where('idstatus', 10)->update(['idstatus' => 11]);

    }
}
