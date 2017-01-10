<?php

namespace App\Console\Commands;

use App\Model\Key;
use App\Model\Parceiros;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class GenerateKeyTeste extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:apikeytest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $parceiro = Parceiros::create(['idparceiro'=>rand(100,9999),'nomerazao'=>'QBETest']);

        $key = New Key;
        $key->id = rand(100,9999);
        $key->key = uniqid(rand(1000,9999));
        $key->level = 0;
        $key->ignore_limits = 0;
        $key->is_private_key = 0;
        $key->ip_addresses = '0.0.0.0';
        
        $parceiro->key()->save($key);
        $this->line('Key: '. $key->key);
    }
}
