<?php

use Illuminate\Database\Seeder;

class ConfigTablesConfigs extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        DB::table('configs')->insert([
        [
            'env_local'=>'homologacao',
            'url'=>'http://www.seguroautopratico.com.br/api/gerar/',
            'webservice'=>'SAP',
        ],
        [
            'env_local'=>'producao',
            'url'=>'http://producao.seguroautopratico.com.br/gerar/',
            'webservice'=>'SAP',
        ],
        [
            'env_local'=>'homologacao',
            'url'=>'http://www.usebens.com.br/homologacao/webservice/i4prowebservice.asmx?wsdl',
            'webservice'=>'USEBENS',
        ],
        [
            'env_local'=>'producao',
            'url'=>'http://www.usebens.com.br/i4pro/webservice/i4prowebservice.asmx?wsdl',
            'webservice'=>'USEBENS',
        ],
    ]);
    }
}
