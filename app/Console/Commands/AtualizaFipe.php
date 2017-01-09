<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery\CountValidator\Exception;

class AtualizaFipe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atualiza:fipe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza a fipe mês e referencia';

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
        DB::beginTransaction();

        try {

            if ($this->confirm('Já importou os arquivos car_{mmaa}_cur.dbf e o tab_br{mmaa}_motos_cur para dentro do schmea pulic do bando de dados? [y|N]', 'yes')) {


                if (Schema::hasTable('fipedbf') && Schema::hasTable('fipedbfmoto')) {

                    $mes_referencia = $this->ask('Informe o ano e mês referencia da fipe no formato YYYYMM:', date('Ym', strtotime('-1 month')));

                    $bar = $this->output->createProgressBar(5);

                    DB::unprepared('ALTER TABLE fipedbf ALTER COLUMN "ANO" SET DATA TYPE  VARCHAR(4);
                                    UPDATE fipedbf set "ANO" = \'20\'||"ANO" WHERE "ANO" BETWEEN \'00\' and \'60\' and "ANO" != \'0K\';
                                    UPDATE fipedbf set "ANO" = \'19\'||"ANO" WHERE "ANO" > \'60\' and "ANO" <= \'99\';
                                    UPDATE fipedbf set "ANO" = \'0\' WHERE "ANO" = \'0K\';
                                    UPDATE fipedbf set "COMBUS" = \'1\' WHERE "COMBUS" = \'G\';
                                    UPDATE fipedbf set "COMBUS" = \'2\' WHERE "COMBUS" = \'A\';
                                    UPDATE fipedbf set "COMBUS" = \'3\' WHERE "COMBUS" = \'D\';
                                    
                                    CREATE TABLE fipeanovalor_atualizada as 
                                    SELECT
                                    "COD_FIPE" as codefipe,
                                    "MEDIA"::FLOAT as valor,
                                    "COMBUS"::int as idcombustivel,
                                    ' . $mes_referencia . ' as anomes_referencia,
                                    "ANO"::int as ano
                                    FROM "fipedbf";
                                    
                                    TRUNCATE TABLE fipeanovalor;
                                    
                                    INSERT INTO fipeanovalor SELECT * FROM fipeanovalor_atualizada;
                                    
                                    TRUNCATE fipe;
                                    INSERT INTO fipe
                                    SELECT DISTINCT
                                        "COD_FIPE" AS codefipe,
                                        "MARCA" AS marca,
                                        "MODELO" AS modelo,
                                        "PERIODO" AS preiodo,
                                        ' . $mes_referencia . ' anomes_referencia,
                                        1 as idstatus,
                                        1 as tipoveiculo_id
                                    FROM
                                        "public"."fipedbf"
                                    ORDER BY
                                        "MARCA";
                                    
                                    DROP TABLE fipeanovalor_atualizada, fipedbf;');
                    $bar->advance();

                    $this->line('ATUALIZA STATUS DE ACEITAÇÃO => SEM ACEITAÇÃO - idstatus = 22 para veiculos que não possuem aceitação para ALGUNS MODELOS especificos...');

                    DB::unprepared('update FIPE set idstatus = 22 where codefipe in 
                                    (select codefipe FROM fipe 
                                        where marca ILIKE \'%alfa romeo%\' 
                                            or marca ILIKE \'%aston%\'
                                            or marca ILIKE \'brm%\'  
                                            or marca ILIKE \'buggy%\' 
                                            or marca ILIKE \'bugre%\'
                                            or marca ILIKE \'CHANA%\'
                                            or marca ILIKE \'CHANGAN%\'
                                            or marca ILIKE \'Cross Lander%\'
                                            or marca ILIKE \'Daewoo%\'
                                            or marca ILIKE \'Daihatsu%\'
                                            or marca ILIKE \'EFFA%\'
                                            or marca ILIKE \'Ferrari%\'
                                            or marca ILIKE \'Fibravan%\'
                                            or marca ILIKE \'HAFEI%\'
                                            or marca ILIKE \'Isuzu%\'
                                            or marca ILIKE \'JAC%\'
                                            or marca ILIKE \'Jaguar%\'
                                            or marca ILIKE \'JINBEI%\'
                                            or marca ILIKE \'JPX%\'
                                            or marca ILIKE \'LAMBORGHINI%\'
                                            or marca ILIKE \'LIFAN%\'
                                            or marca ILIKE \'LOBINI%\'
                                            or marca ILIKE \'Lotus%\'
                                            or marca ILIKE \'Maserati%\'
                                            or marca ILIKE \'Matra%\'
                                            or marca ILIKE \'Mazda%\'
                                            or marca ILIKE \'MG%\'
                                            or marca ILIKE \'Miura%\'
                                            or marca ILIKE \'Porsche%\'
                                            or marca ILIKE \'Rely%\'
                                            or marca ILIKE \'Rolls-Royce%\'
                                            or marca ILIKE \'SHINERAY%\');');
                    $bar->advance();
                    $this->line('ATUALIZA STATUS DE ACEITAÇÃO => SEM ACEITAÇÃO - idstatus = 22 para veiculos que não possuem aceitação para ALGUNS MODELOS especificos...');

                    DB::unprepared('update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where modelo ilike \'%marru%\');
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where modelo ilike \'%hummer%\');
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where modelo ilike \'A7%\'
                                                                                                                  or modelo ilike \'A8%\'
                                                                                                                  or modelo ilike \'R8%\'
                                                                                                                  or modelo ilike \'RS8%\'
                                                                                                                  or modelo ilike \'S7%\'
                                                                                                                  or modelo ilike \'S8%\'
                                                                                                                  or modelo ilike \'TT%\'
                                                                                                                  or modelo ilike \'RS%\');
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'bmw\' 		and modelo like \'% M %\'								);
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'Citro%\' 	and modelo ilike \'Evasion%\'							);
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Chery%\' 	and (modelo ilike \'Cielo%\' or modelo ilike \'Face%\' or modelo ilike \'QQ%\' or modelo ilike \'S-18%\') 	);
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Ford%\' 	and (modelo ilike \'F-150%\' or modelo ilike \'Mustang%\' or modelo ilike \'Transit%\')					);
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%FOTON%\'	and (modelo ilike \'AUMARK%\' ) 						);
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Fyb%\' 	and (modelo ilike \'Buggy%\' ) 						);
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%GEELY%\' 	and (modelo ilike \'EC7%\' or  modelo ilike \'GC2%\' )	);
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%GREAT%\' 	and (modelo ilike \'HOVER%\' )						);
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Hyundai%\' and (modelo ilike \'Coup%\' or modelo ilike \'EQUUS%\' or modelo ilike \'Genesis%\' or modelo ilike \'Matrix%\' or modelo ilike \'Porter%\'));
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Jeep%\' 	and (modelo ilike \'Wrangler%\')						);
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Kia%\' 	and (modelo ilike \'Besta%\') 						);
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Lada%\' 	and  (modelo ilike \'Niva%\')							);
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Land%\' 	and  (modelo ilike \'New Range%\' or  modelo ilike \'Range Rover%\')									);
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Mitsubishi%\' and (modelo ilike \'3000%\' or modelo ilike \'Eclipse%\')											);
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Nissan%\' and (modelo ilike \'350%\')							);
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Peugeot%\' and (modelo ilike \'508%\' or modelo ilike \'605%\' or modelo ilike \'607%\' or modelo ilike \'806%\' or  modelo ilike \'807%\' or  modelo ilike \'RCZ%\'));
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%RAM%\' 	and (modelo ilike \'2500%\')							);
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%SSANGYONG%\' and (modelo ilike \'Chairman%\' or modelo ilike \'Istana%\' or modelo ilike \'Musso%\' or modelo ilike \'Korando%\' or modelo ilike \'Kyron%\' or modelo ilike \'Rexton%\'));
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%TAC%\' 	and (modelo ilike \'Stark%\')							);
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Toyota%\' and (modelo ilike \'%Jipe%\')							);
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Troller%\' and (modelo ilike \'%Pantanal%\'or modelo ilike \'RF%\'));
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Volvo%\' 	and (modelo ilike \'%C70%\')							);
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%VolksWagen%\' and (modelo ilike \'%Caravelle%\' or modelo ilike \'Eurovan%\' or modelo ilike \'EOS%\' or modelo ilike \'Fusca 2%\'));
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Wake%\' 	and (modelo ilike \'%Way%\')							);
                                    update FIPE set idstatus = 22 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Walk%\' 	and (modelo ilike \'%Buggy%\')						);');
                    $bar->advance();
                    $this->line('ATUALIZA STATUS DE ACEITAÇÃO => EXIGE 2o. RASTREADOR DE CONTINGENCIA - idstatus = 23 para ALGUNS MODELOS especificos...');

                    DB::unprepared('update FIPE set idstatus = 23 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%CHERY%\' 	and (modelo ilike \'%Tiggo%\')							);
                                    update FIPE set idstatus = 23 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Citro%\' 	and (modelo ilike \'%Jumper%\')						);
                                    update FIPE set idstatus = 23 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Dodge%\' 	and (modelo ilike \'%Dakota%\'or modelo ilike \'RAM%\')	);
                                    update FIPE set idstatus = 23 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Fiat%\' 	and (modelo ilike \'%Ducato%\')							);
                                    update FIPE set idstatus = 23 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Ford%\' 	and (modelo ilike \'%F-250%\'or modelo ilike \'Ranger%\')	);
                                    update FIPE set idstatus = 23 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Chevrolet%\' and (modelo ilike \'%S10%\'or modelo ilike \'Silverado%\'));	
                                    update FIPE set idstatus = 23 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Hyundai%\' and (modelo ilike \'%H1%\'or modelo ilike \'H100%\' or modelo ilike \'HR%\'));
                                    update FIPE set idstatus = 23 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Kia%\' 	and (modelo ilike \'%Bongo%\')							);
                                    update FIPE set idstatus = 23 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Land%\' 	and (modelo ilike \'Defender 110%\' or modelo ilike \'Defender 90%\' or modelo ilike \'Defender 130%\' or modelo ilike \'Discovery%\' or modelo ilike \'Freeelander%\'));
                                    update FIPE set idstatus = 23 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Mahindra%\' and (modelo ilike \'%UP%\'or modelo ilike \'Scorpio%\' or modelo ilike \'SUV%\'));
                                    update FIPE set idstatus = 23 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Mercedes%\' and (modelo ilike \'%Sprinter%\' or modelo ilike \'Vito%\'));	
                                    update FIPE set idstatus = 23 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Mitsubishi%\' and (modelo ilike \'%L200%\' or modelo ilike \'L300%\')	);	
                                    update FIPE set idstatus = 23 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Nissan%\' and (modelo ilike \'%Frontier%\')						);
                                    update FIPE set idstatus = 23 where codefipe in (select codefipe FROM fipe where (marca ILIKE \'%Renault%\' or marca ILIKE \'%Peugeot%\') and (modelo ilike \'%Boxer%\' or modelo ilike \'Partner%\' or modelo ilike \'Master%\' or modelo ilike \'Trafic%\'));
                                    update FIPE set idstatus = 23 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%SSANGYONG%\' and (modelo ilike \'%ACTYON%\'));
                                    update FIPE set idstatus = 23 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%Toyota%\' and (modelo ilike \'%Hilux%\' or modelo ilike \'%Cruiser%\' or modelo ilike \'%T-4%\'));
                                    update FIPE set idstatus = 23 where codefipe in (select codefipe FROM fipe where marca ILIKE \'%VolksWagen%\' and (modelo ilike \'%AMAROK%\')					);');


                    $bar->advance();
                    $this->line('ATUALIZANDO A FIPE DE MOTO...');

                    DB::unprepared('ALTER TABLE fipedbfmoto ALTER COLUMN "ANO" SET DATA TYPE  VARCHAR(4);
                                    UPDATE fipedbfmoto set "ANO" = \'20\'||"ANO" WHERE "ANO" BETWEEN \'00\' and \'60\' and "ANO" != \'0K\';
                                    UPDATE fipedbfmoto set "ANO" = \'19\'||"ANO" WHERE "ANO" > \'60\' and "ANO" <= \'99\';
                                    UPDATE fipedbfmoto set "ANO" = \'0\' WHERE "ANO" = \'0K\';
                                    UPDATE fipedbfmoto set "COMBUS" = \'1\' WHERE "COMBUS" = \'G\';
                                    UPDATE fipedbfmoto set "COMBUS" = \'2\' WHERE "COMBUS" = \'A\';
                                    UPDATE fipedbfmoto set "COMBUS" = \'3\' WHERE "COMBUS" = \'D\';
                                    
                                    CREATE TABLE fipeanovalor_atualizada as 
                                    SELECT
                                    "COD_FIPE" as codefipe,
                                    "MEDIA"::FLOAT as valor,
                                    "COMBUS"::int as idcombustivel,
                                    ' . $mes_referencia . ' as anomes_referencia,
                                    "ANO"::int as ano
                                    FROM "fipedbfmoto";                                    
                                    INSERT INTO fipeanovalor SELECT * FROM fipeanovalor_atualizada;
                                    INSERT INTO fipe
                                    SELECT DISTINCT
                                        "COD_FIPE" AS codefipe,
                                        "MARCA" AS marca,
                                        "MODELO" AS modelo,
                                        "PERIODO" AS preiodo,
                                        ' . $mes_referencia . ' anomes_referencia,
                                        1 as idstatus,
                                        4 as tipoveiculo_id
                                    FROM
                                        "public"."fipedbfmoto"
                                    ORDER BY
                                        "MARCA";
                                    
                                    DROP TABLE fipeanovalor_atualizada, fipedbfmoto;');

                    DB::unprepared('TRUNCATE "producoes"."fipe";
                                    INSERT INTO "producoes"."fipe" SELECT * FROM "public".fipe;
                                    TRUNCATE "producoes"."fipeanovalor";
                                    INSERT INTO "producoes"."fipeanovalor" SELECT * FROM "public".fipeanovalor;');
                    DB::commit();
                    $bar->finish();

                } else {
                    $this->error('Ops! Parece que não encontramos uma das tabelas fipedbf ou fipedbfmoto, por favor verifique e tente novamente!');

                }
            } else {
                $this->info('****ATENÇÃO****');
                $this->info('Antes de rodar o command é necessario baixar o dbf do mês no site http://site.usebens.com.br/arquivos-auto-rastreado.');
                $this->info('Importar o arquivos car_{mmaa}_cur.dbf e o tab_br{mmaa}_motos_cur para dentro do banco no schema public.');
                $this->info('Alterar o nome da tabela crida pelos arquivos dbf importado a do carro para fipedbf e a de moto para fipedbfmoto.');
            }


        } catch (Exception $e) {
            DB::rollback();
            print_r($e);
        }

    }
}
