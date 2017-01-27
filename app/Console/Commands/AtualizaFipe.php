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

                    $bar->advance();
                    $this->line('ATUALIZA STATUS DE ACEITAÇÃO MOTOS => NÃO ACEITAS ABAIXO DE 300CC - idstatus = 29 para MODELOS especificos...');

                    DB::unprepared('update FIPE set idstatus = 29 where codefipe in (select codefipe FROM fipe where modelo ilike \'%SXT 27.5 EX 190cc%\'
																			or modelo ilike \'%SCARABEO DE LUXE 50cc%\'
																			or modelo ilike \'%ELEFANTRE 16.5 ES 125cc%\'
																			or modelo ilike \'%SXT 27.5 E 190cc%\'
																			or modelo ilike \'%DAKAR 30.0 190cc%\'
																			or modelo ilike \'%ELEFANT 16.5 125cc%\'
																			or modelo ilike \'%FORCE 90%\'
																			or modelo ilike \'%SUPER CITY 150%\'
																			or modelo ilike \'%AREA-51 50cc%\'
																			or modelo ilike \'%RS 50cc%\'
																			or modelo ilike \'%SCARABEO BRIGTH 50cc%\'
																			or modelo ilike \'%ELEFANT 27.5 190cc%\'
																			or modelo ilike \'%CITY 50%\'
																			or modelo ilike \'%CITY 90%\'
																			or modelo ilike \'%DAKAR 50%\'
																			or modelo ilike \'%ELEFANTRE 30.0 ES 190cc%\'
																			or modelo ilike \'%FORCE 50%\'
																			or modelo ilike \'%JUNIOR 50%\'
																			or modelo ilike \'%SST 13.5 125cc%\'
																			or modelo ilike \'%TCHAU 50%\'
																			or modelo ilike \'%SUPER CITY 125%\'
																			or modelo ilike \'%CLASSIC 50cc%\'
																			or modelo ilike \'%LEONARDO 150cc%\'
																			or modelo ilike \'%RALLY 50cc%\'
																			or modelo ilike \'%RS 250cc%\'
																			or modelo ilike \'%RX 50cc%\'
																			or modelo ilike \'%SR WWW 50cc%\'
																			or modelo ilike \'%ELEGANT 50%\'
																			or modelo ilike \'%MITO 125%\'
																			or modelo ilike \'%MOBILETE 50cc%\'
																			or modelo ilike \'%ZANELLA NEW FIRE 50 FULL%\'
																			or modelo ilike \'%VC 125 ADVANCED%\'
																			or modelo ilike \'%VT 125 CUSTOM - Magma%\'
																			or modelo ilike \'%PISTA 70%\'
																			or modelo ilike \'%TURBO PLUS%\'
																			or modelo ilike \'%PLANET 125%\'
																			or modelo ilike \'%ROADSTER 200cc%\'
																			or modelo ilike \'%ALTINO 100cc%\'
																			or modelo ilike \'%MESSAGE 50cc%\'
																			or modelo ilike \'%VF 125 D%\'
																			or modelo ilike \'%VS 125 CUSTOM%\'
																			or modelo ilike \'%DESMOSEDICI 16RR 200cv%\'
																			or modelo ilike \'%ONE 50cc%\'
																			or modelo ilike \'%MIRAGE 50cc%\'
																			or modelo ilike \'%CH 125-R SPACY%\'
																			or modelo ilike \'%CG 125%\'
																			or modelo ilike \'%XLR 125%\'
																			or modelo ilike \'%BIZ 125 ES/ ES F.INJ./ES MIX F.INJECTION%\'
																			or modelo ilike \'%CBX 200 STRADA%\'
																			or modelo ilike \'%XL 125 S%\'
																			or modelo ilike \'%CR 125%\'
																			or modelo ilike \'%XR 250 TORNADO%\'
																			or modelo ilike \'%CG 150 TITAN-ESD/ TITAN SPECIAL EDITION%\'
																			or modelo ilike \'%BIZ 125 KS/ KS F.INJ./KS MIX F.INJECTION%\'
																			or modelo ilike \'%C 100 DREAM%\'
																			or modelo ilike \'%CBX 150 AERO%\'
																			or modelo ilike \'%CG 125 CARGO/ CARGO KS/125i CARGO%\'
																			or modelo ilike \'%CG 125 TITAN%\'
																			or modelo ilike \'%XL 125 DUTY%\'
																			or modelo ilike \'%XR 200 R%\'
																			or modelo ilike \'%CR 250%\'
																			or modelo ilike \'%CBX 250 TWISTER%\'
																			or modelo ilike \'%NXR 150 Bros ESD%\'
																			or modelo ilike \'%CG 150 TITAN-ES%\'
																			or modelo ilike \'%CG 125 FAN / FAN KS / 125 i FAN%\'
																			or modelo ilike \'%C 100 BIZ-ES%\'
																			or modelo ilike \'%C 100 BIZ/ 100 BIZ KS%\'
																			or modelo ilike \'%CG 125 TITAN-ES%\'
																			or modelo ilike \'%CG 125 TITAN-KS%\'
																			or modelo ilike \'%NX 150%\'
																			or modelo ilike \'%NX 200%\'
																			or modelo ilike \'%XLX 250 R%\'
																			or modelo ilike \'%CR 80%\'
																			or modelo ilike \'%XLR 125 ES%\'
																			or modelo ilike \'%NXR 125 Bros KS%\'
																			or modelo ilike \'%CG 150 TITAN-KS/ TITAN-JOB%\'
																			or modelo ilike \'%CG 150 Sport%\'
																			or modelo ilike \'%NXR 150 Bros ES%\'
																			or modelo ilike \'%NXR 125 Bros ES%\'
																			or modelo ilike \'%CRF 250 X%\'
																			or modelo ilike \'%CG 125 CARGO ES%\'
																			or modelo ilike \'%JL 135 Fly%\'
																			or modelo ilike \'%CRF 230 F%\'
																			or modelo ilike \'%CG 150 TITAN-KS MIX%\'
																			or modelo ilike \'%NXR 150 Bros ES MIX/FLEX%\'
																			or modelo ilike \'%CBR 250R%\'
																			or modelo ilike \'%NXR 160 Bros%\'
																			or modelo ilike \'%WR 250%\'
																			or modelo ilike \'%JH 70%\'
																			or modelo ilike \'%JL 125-9 SKY%\'
																			or modelo ilike \'%LEAD 110%\'
																			or modelo ilike \'%NXR 150 Bros KS MIX/FLEX%\'
																			or modelo ilike \'%BIZ 125 EX/ 125 EX FLEX%\'
																			or modelo ilike \'%CG 125 FAN ESD%\'
																			or modelo ilike \'%CG 125 CARGO ESD%\'
																			or modelo ilike \'%POP 110i%\'
																			or modelo ilike \'%CB TWISTER/FLEXone 250cc%\'
																			or modelo ilike \'%CG 160 Start%\'
																			or modelo ilike \'%CG 160 Cargo%\'
																			or modelo ilike \'%JH 125 L/ FLY%\'
																			or modelo ilike \'%JH 70 III%\'
																			or modelo ilike \'%JL 110-11 PRINCE%\'
																			or modelo ilike \'%Work 125%\'
																			or modelo ilike \'%SKY 50%\'
																			or modelo ilike \'%BIZ 125+%\'
																			or modelo ilike \'%POP 100 97cc%\'
																			or modelo ilike \'%CG 125 FAN ES%\'
																			or modelo ilike \'%CG 150 TITAN-ES MIX%\'
																			or modelo ilike \'%CG 150 TITAN-EX MIX/FLEX%\'
																			or modelo ilike \'%NXR 150 Bros ESD MIX/FLEX%\'
																			or modelo ilike \'%CG 150 FAN ESDi/ 150 FAN ESDi FLEX%\'
																			or modelo ilike \'%CRF 150F%\'
																			or modelo ilike \'%CRF 250L%\'
																			or modelo ilike \'%PCX 150/DLX%\'
																			or modelo ilike \'%CRF 110F%\'
																			or modelo ilike \'%CG 150 CARGO ESD FLEX%\'
																			or modelo ilike \'%NXR 160 Bros ESDD FLEXone%\'
																			or modelo ilike \'%CG 160 TITAN FLEXone/Ed.Especial 40 Anos%\'
																			or modelo ilike \'%CG 160 FAN ESDi FLEXone%\'
																			or modelo ilike \'%BIZ 125 Flexone%\'
																			or modelo ilike \'%BIZ 110i%\'
																			or modelo ilike \'%XRE 190%\'
																			or modelo ilike \'%CR 125%\'
																			or modelo ilike \'%CR 250%\'
																			or modelo ilike \'%HUSQY BOY J%\'
																			or modelo ilike \'%CJ 50-F%\'
																			or modelo ilike \'%JH 125 G/ BEST%\'
																			or modelo ilike \'%JH 50%\'
																			or modelo ilike \'%JL 110-3/ 110-8/ SKY%\'
																			or modelo ilike \'%JL 50 Q-2/ STAR%\'
																			or modelo ilike \'%JL 50 Q8/MOBY 50%\'
																			or modelo ilike \'%JH 250 Fly%\'
																			or modelo ilike \'%NXR 160 Bros ESD FLEXone%\'
																			or modelo ilike \'%MIDAS FX 110cc%\'
																			or modelo ilike \'%JH 150-7 TSS 150%\'
																			or modelo ilike \'%CRUISE 125%\'
																			or modelo ilike \'%MOTOKAR Furgo/ Pick-up 174cc (1 pessoa%\'
																			or modelo ilike \'%FLASH K 150cc%\'
																			or modelo ilike \'%Mirage 150%\'
																			or modelo ilike \'%KX 250/ 250 F%\'
																			or modelo ilike \'%D-TRACKER X 250cc%\'
																			or modelo ilike \'%JH 150 FLY%\'
																			or modelo ilike \'%TN 125%\'
																			or modelo ilike \'%GV 250 MIRAGE%\'
																			or modelo ilike \'%SETA 150%\'
																			or modelo ilike \'%ERO PLUS 125cc%\'
																			or modelo ilike \'%SETA 125%\'
																			or modelo ilike \'%CRZ 150 SUPER MOTO%\'
																			or modelo ilike \'%Prima 150%\'
																			or modelo ilike \'%JH 250-8 TSS 250%\'
																			or modelo ilike \'%SKY 50 PLUS%\'
																			or modelo ilike \'%JS 250 ATV-5 MONTEZ 250%\'
																			or modelo ilike \'%SUPER CAB 50cc%\'
																			or modelo ilike \'%CRUISE II 125%\'
																			or modelo ilike \'%PRIMA 50%\'
																			or modelo ilike \'%RX 125%\'
																			or modelo ilike \'%WIN 110%\'
																			or modelo ilike \'%Comet GT-R 250cc%\'
																			or modelo ilike \'%WAY 125%\'
																			or modelo ilike \'%Comet 150%\'
																			or modelo ilike \'%CRZ 150%\'
																			or modelo ilike \'%Prima Electra 2000W (Eltrica%\'
																			or modelo ilike \'%SOFT 50cc%\'
																			or modelo ilike \'%MAXI II 100cc%\'
																			or modelo ilike \'%KX 125%\'
																			or modelo ilike \'%AVAJET 100cc/ Classic 100cc%\'
																			or modelo ilike \'%KLX 110%\'
																			or modelo ilike \'%KX 65%\'
																			or modelo ilike \'%KX 65 Monster%\'
																			or modelo ilike \'%KLX 110 Monster%\'
																			or modelo ilike \'%NINJA 250R%\'
																			or modelo ilike \'%KLX 250%\'
																			or modelo ilike \'%Win Electra 1000W (Eltrica%\'
																			or modelo ilike \'%125 K-TOP%\'
																			or modelo ilike \'%125 TOP%\'
																			or modelo ilike \'%250 DUAL%\'
																			or modelo ilike \'%250 DUAL-T%\'
																			or modelo ilike \'%AKROS 90%\'
																			or modelo ilike \'%AKROS 90cc%\'
																			or modelo ilike \'%EXC 125%\'
																			or modelo ilike \'%NRG MC3 DD 49.4cc%\'
																			or modelo ilike \'%SX 125%\'
																			or modelo ilike \'%SX 65%\'
																			or modelo ilike \'%EXC-F 250%\'
																			or modelo ilike \'%ERGON 50%\'
																			or modelo ilike \'%JC 125%\'
																			or modelo ilike \'%SPEEDFIGHT 50%\'
																			or modelo ilike \'%RUNNER 50%\'
																			or modelo ilike \'%PASSING 110%\'
																			or modelo ilike \'%SX 50%\'
																			or modelo ilike \'%EXC 250%\'
																			or modelo ilike \'%AX 100-A%\'
																			or modelo ilike \'%JC 125-8%\'
																			or modelo ilike \'%SPEEDFIGHT 50-LC%\'
																			or modelo ilike \'%VIVACITY 50%\'
																			or modelo ilike \'%VESPA PX 200%\'
																			or modelo ilike \'%VESPA LX 150 151cc%\'
																			or modelo ilike \'%Liberty 200 200cc%\'
																			or modelo ilike \'%SCOOT%\' 
																			or modelo ilike \'%ELEC%\'
																			or modelo ilike \'%HUSKY 150%\'
																			or modelo ilike \'%EXC 200%\'
																			or modelo ilike \'%SX 250/ SX 250 F%\'
																			or modelo ilike \'%SX 85%\'
																			or modelo ilike \'%EXC-F 250 SIX DAYS%\'
																			or modelo ilike \'%DUKE 200%\'
																			or modelo ilike \'%AKROS 50cc%\'
																			or modelo ilike \'%NIX 50%\'
																			or modelo ilike \'%PALIO 50%\'
																			or modelo ilike \'%AX 100%\'
																			or modelo ilike \'%JC 125-2%\'
																			or modelo ilike \'%BUXY 50%\'
																			or modelo ilike \'%ELYSEO 125%\'
																			or modelo ilike \'%SPEEDAKE 50%\'
																			or modelo ilike \'%SPEEDFIGHT 100%\'
																			or modelo ilike \'%SQUAB 50%\'
																			or modelo ilike \'%TREKKER 100%\'
																			or modelo ilike \'%ZENITH 50%\'
																			or modelo ilike \'%VESPA PX 150 ORIGINALE%\'
																			or modelo ilike \'%BEVERLY 250 224cc%\'
																			or modelo ilike \'%ENJOY 50%\'
																			or modelo ilike \'%AKROS 50%\'
																			or modelo ilike \'%MAX 125 SED%\'
																			or modelo ilike \'%HUNTER 100 95cc%\'
																			or modelo ilike \'%STX 125cc%\'
																			or modelo ilike \'%ADDRESS/AG 100%\'
																			or modelo ilike \'%INTRUDER 250%\'
																			or modelo ilike \'%RMX 250%\'
																			or modelo ilike \'%RM 125%\'
																			or modelo ilike \'%RM 80%\'
																			or modelo ilike \'%BURGMAN 400%\'
																			or modelo ilike \'%LT 80 Quadriciclo%\'
																			or modelo ilike \'%LT F160 Quadriciclo%\'
																			or modelo ilike \'%INTRUDER 125%\'
																			or modelo ilike \'%AN 125 Burgman%\'
																			or modelo ilike \'%EN 125 Yes SE%\'
																			or modelo ilike \'%GSR 125%\'
																			or modelo ilike \'%GSR 125S%\'
																			or modelo ilike \'%GS 120%\'
																			or modelo ilike \'%GSX 1250 F%\'
																			or modelo ilike \'%LT 50 Quadriciclo%\'
																			or modelo ilike \'%BURGMAN i 125 cc%\'
																			or modelo ilike \'%INAZUMA 250cc%\'
																			or modelo ilike \'%Vblade 250cc%\'
																			or modelo ilike \'%Future 125%\'
																			or modelo ilike \'%STX MOTARD 200cc%\'
																			or modelo ilike \'%KATANA 125%\'
																			or modelo ilike \'%PGO SPEED 50cc%\'
																			or modelo ilike \'%ERGON 50cc%\'
																			or modelo ilike \'%PGO SPEED 90cc%\'
																			or modelo ilike \'%HUNTER 125 SE%\'
																			or modelo ilike \'%Web evo 97cc%\'
																			or modelo ilike \'%HUNTER 90  86cc%\'
																			or modelo ilike \'%STX 200cc%\'
																			or modelo ilike \'%STX MOTARD 125cc%\'
																			or modelo ilike \'%RM 250%\'
																			or modelo ilike \'%Lets II 50cc%\'
																			or modelo ilike \'%EN 125 Yes%\'
																			or modelo ilike \'%GSR 150i%\'
																			or modelo ilike \'%EN 125 Yes CARGO%\'
																			or modelo ilike \'%ADDRESS/AE 50%\'
																			or modelo ilike \'%DT 180-Z TRAIL%\'
																			or modelo ilike \'%DT 200 R%\'
																			or modelo ilike \'%JOG 50%\'
																			or modelo ilike \'%JOG TEEN 50%\'
																			or modelo ilike \'%RDZ 125%\'
																			or modelo ilike \'%TDM 225%\'
																			or modelo ilike \'%XV 250 VIRAGO%\'
																			or modelo ilike \'%YBR 125 E%\'
																			or modelo ilike \'%MAJESTY YP 250%\'
																			or modelo ilike \'%YZ 250%\'
																			or modelo ilike \'%WR 200%\'
																			or modelo ilike \'%YZ 125%\'
																			or modelo ilike \'%DT 200%\'
																			or modelo ilike \'%RD 135%\'
																			or modelo ilike \'%YBR 125 K%\'
																			or modelo ilike \'%AXIS 90%\'
																			or modelo ilike \'%RDZ 135%\'
																			or modelo ilike \'%TDR 180%\'
																			or modelo ilike \'%XT 225%\'
																			or modelo ilike \'%YFM 80 79cc%\'
																			or modelo ilike \'%NEO Automatic 115cc%\'
																			or modelo ilike \'%FZ6 N%\'
																			or modelo ilike \'%XTZ 250X%\'
																			or modelo ilike \'%T115 CRYPTON K%\'
																			or modelo ilike \'%T115 CRYPTON ED%\'
																			or modelo ilike \'%T115 CRYPTON ED Penelope%\'
																			or modelo ilike \'%YBR 125 FACTOR Pro E%\'
																			or modelo ilike \'%YS 150 Fazer ED/Flex%\'
																			or modelo ilike \'%XTZ 150 E CROSSER/Flex%\'
																			or modelo ilike \'%XTZ 150 ED CROSSER/Flex%\'
																			or modelo ilike \'%TT-R 125 LWE%\'
																			or modelo ilike \'%YBR 150 FACTOR ED/Flex%\'
																			or modelo ilike \'%MT-09 TRACER%\'
																			or modelo ilike \'%NMAX 160%\'
																			or modelo ilike \'%CALIFFONE 50cc%\'
																			or modelo ilike \'%SKEGIA 50cc%\'
																			or modelo ilike \'%ZING 150%\'
																			or modelo ilike \'%PAMPERA 125cc%\'
																			or modelo ilike \'%PAMPERA 250cc%\'
																			or modelo ilike \'%EC 200 ENDUCROSS%\'
																			or modelo ilike \'%EC 250 ENDUCROSS%\'
																			or modelo ilike \'%MX-50 ENDURO 50cc%\'
																			or modelo ilike \'%YBR 125 FACTOR E%\'
																			or modelo ilike \'%MX-50 CROSS 50cc%\'
																			or modelo ilike \'%YS 150 Fazer SED/ Flex%\'
																			or modelo ilike \'%YBR 150 FACTOR E/Flex%\'
																			or modelo ilike \'%TX BOY 50%\'
																			or modelo ilike \'%XTZ 250 LANDER 249cc/Lander BlueFlex%\'
																			or modelo ilike \'%XTZ 125 XK%\'
																			or modelo ilike \'%XTZ 250 TENERE/TENERE BLUEFLEX%\'
																			or modelo ilike \'%YBR 125 FACTOR Pro K%\'
																			or modelo ilike \'%MBOY 90cc%\'
																			or modelo ilike \'%MC 250%\'
																			or modelo ilike \'%YS 250 FAZER/ FAZER L. EDITION /BlueFlex%\'
																			or modelo ilike \'%YBR 125 FACTOR ED/FACTOR EDITION%\'
																			or modelo ilike \'%YBR 125 ED%\'
																			or modelo ilike \'%NEO AT 115cc%\'
																			or modelo ilike \'%YFS 200 BLASTER 195cc%\'
																			or modelo ilike \'%YFM 250 BRUIN 230cc%\'
																			or modelo ilike \'%TT-R 125 E%\'
																			or modelo ilike \'%XTZ 125 XE%\'
																			or modelo ilike \'%YBR 125i FACTOR ED/Flex%\'
																			or modelo ilike \'%NEO Automatic 125cc%\'
																			or modelo ilike \'%SCROSS 50cc%\'
																			or modelo ilike \'%DJW 50 50cc%\'
																			or modelo ilike \'%PEOPLE 50%\'
																			or modelo ilike \'%EC 300 ENDUCROSS%\'
																			or modelo ilike \'%EC 125 ENDUCROSS%\'
																			or modelo ilike \'%YBR 125 FACTOR K/ FACTOR K1%\'
																			or modelo ilike \'%TXT 280 Contact%\'
																			or modelo ilike \'%EC BOY 50%\'
																			or modelo ilike \'%EC 50 ROOKIE  ENDURO%\'
																			or modelo ilike \'%CHAMPION 45 100cc%\'
																			or modelo ilike \'%ATV 50%\'
																			or modelo ilike \'%ATV 100%\'
																			or modelo ilike \'%Triciclo Star I / Sport%\'
																			or modelo ilike \'%Triciclo Star II / Top%\'
																			or modelo ilike \'%MA 100-3B%\'
																			or modelo ilike \'%MA/ BLACK STAR 125-7%\'
																			or modelo ilike \'%HALLEY 150%\'
																			or modelo ilike \'%BLACK STAR 150%\'
																			or modelo ilike \'%FOX 110%\'
																			or modelo ilike \'%Skema LJ 125-6%\'
																			or modelo ilike \'%RT 50%\'
																			or modelo ilike \'%FENIX GOLD 240%\'
																			or modelo ilike \'%FY125-20 Sachs 125cc%\'
																			or modelo ilike \'%GR125Z%\'
																			or modelo ilike \'%JAGUAR JT 50%\'
																			or modelo ilike \'%PREDATOR LC 49cc%\'
																			or modelo ilike \'%DUAL 200%\'
																			or modelo ilike \'%GR125ST%\'
																			or modelo ilike \'%EASY LJ 125-10%\'
																			or modelo ilike \'%PUCH 65%\'
																			or modelo ilike \'%JAGUAR JT 100%\'
																			or modelo ilike \'%SENDA SM 49cc%\'
																			or modelo ilike \'%PREDATOR AR 49cc%\'
																			or modelo ilike \'%GO 100%\'
																			or modelo ilike \'%XRT 110%\'
																			or modelo ilike \'%SIMBA 50 Quadriciclo%\'
																			or modelo ilike \'%BRX 140%\'
																			or modelo ilike \'%GR150U%\'
																			or modelo ilike \'%GR150ST%\'
																			or modelo ilike \'%EASY LJ 110-10%\'
																			or modelo ilike \'%VITE LJ 150T-7%\'
																			or modelo ilike \'%TXT 50 ROOKIE%\'
																			or modelo ilike \'%Classic 150cc%\'
																			or modelo ilike \'%LEGION 125%\'
																			or modelo ilike \'%STREAM 50%\'
																			or modelo ilike \'%Triciclo Star II Top / Super Top%\'
																			or modelo ilike \'%ATLANTIS 49cc%\'
																			or modelo ilike \'%RED BULLET 49cc%\'
																			or modelo ilike \'%MA/ FOXX 100-3%\'
																			or modelo ilike \'%MA 125-GY%\'
																			or modelo ilike \'%HALLEY / FENIX 200%\'
																			or modelo ilike \'%SUPER X 125 R%\'
																			or modelo ilike \'%SPYDER 270 / 320%\'
																			or modelo ilike \'%BIG FORCE 250 Quadriciclo%\'
																			or modelo ilike \'%SPORT 150 Quadriciclo%\'
																			or modelo ilike \'%GR125S%\'
																			or modelo ilike \'%GR250T3%\'
																			or modelo ilike \'%GR125U%\'
																			or modelo ilike \'%GR150P/ GR150PI%\'
																			or modelo ilike \'%GR150T3/ GR150TI%\'
																			or modelo ilike \'%WY 125-ESD%\'
																			or modelo ilike \'%Formigo Furgo 200cc%\'
																			or modelo ilike \'%XY 125-14 ESD%\'
																			or modelo ilike \'%SUPER SMART 50%\'
																			or modelo ilike \'%DY150-12%\'
																			or modelo ilike \'%Formigo Pick-Up 200cc%\'
																			or modelo ilike \'%XY 200-5 A RACING%\'
																			or modelo ilike \'%THOR 230%\'
																			or modelo ilike \'%XY 50-Q Phoenix%\'
																			or modelo ilike \'%BOLT 250%\'
																			or modelo ilike \'%JET+ 50%\'
																			or modelo ilike \'%DY200%\'
																			or modelo ilike \'%DY125-37%\'
																			or modelo ilike \'%DY50 WARRIOR%\'
																			or modelo ilike \'%DY125 SPRINT%\'
																			or modelo ilike \'%XY 150-5 MAX%\'
																			or modelo ilike \'%XY 50Q-2 VENICE%\'
																			or modelo ilike \'%WY 48Q-2 Phoenix + 50%\'
																			or modelo ilike \'%250T-10 Elite%\'
																			or modelo ilike \'%HB 50Q%\'
																			or modelo ilike \'%XY 200-5 Speed/ XY 200-5%\'
																			or modelo ilike \'%DY50 Job%\'
																			or modelo ilike \'%DY150-28 THOR%\'
																			or modelo ilike \'%XY 110V Wave%\'
																			or modelo ilike \'%XY 150-GY/Explorer%\'
																			or modelo ilike \'%XY 50Q VMV%\'
																			or modelo ilike \'%XY 50-Q Cross%\'
																			or modelo ilike \'%WY 200 ZH/Cargo 200%\'
																			or modelo ilike \'%mind X50q%\'
																			or modelo ilike \'%AME-250 C1%\'
																			or modelo ilike \'%HB150%\'
																			or modelo ilike \'%DY100-31%\'
																			or modelo ilike \'%DY150-58 Eagle/Copa%\'
																			or modelo ilike \'%DY250 REV%\'
																			or modelo ilike \'%DY200 THOR%\'
																			or modelo ilike \'%FY150-3 150cc%\'
																			or modelo ilike \'%FY150T-18 150cc%\'
																			or modelo ilike \'%XY 250-5%\'
																			or modelo ilike \'%XY 50-Q2 RETRO/JET/BIKE%\'
																			or modelo ilike \'%XY 250-6B DISCOVER%\'
																			or modelo ilike \'%SUN 150%\'
																			or modelo ilike \'%WY 125-ESD PLUS%\'
																			or modelo ilike \'%WY 48Q-2 LIBERTY 50%\'
																			or modelo ilike \'%SPORT 150cc%\'
																			or modelo ilike \'%EASY 110cc%\'
																			or modelo ilike \'%HB150-T R5 FEARFULSPEED%\'
																			or modelo ilike \'%XY 150-5 Speed%\'
																			or modelo ilike \'%DY125-52%\'
																			or modelo ilike \'%DY125-5%\'
																			or modelo ilike \'%DY125-36A%\'
																			or modelo ilike \'%FY250 250cc%\'
																			or modelo ilike \'%XY 150 ZH%\'
																			or modelo ilike \'%DY200 REV%\'
																			or modelo ilike \'%DY250 THOR%\'
																			or modelo ilike \'%FY100-10A 100cc%\'
																			or modelo ilike \'%FY125-19 125cc%\'
																			or modelo ilike \'%FY125Y-3 125cc%\'
																			or modelo ilike \'%FY125EY-2 125cc%\'
																			or modelo ilike \'%XY 50-Q%\'
																			or modelo ilike \'%XY 200-5 ROAD WIND NAKED%\'
																			or modelo ilike \'%XY 125 New Wave%\'
																			or modelo ilike \'%XY 125 JET%\'
																			or modelo ilike \'%XY 150-5 Fire/Maxi Fire%\'
																			or modelo ilike \'%XY 200-III%\'
																			or modelo ilike \'%WY 150-EX%\'
																			or modelo ilike \'%YB 150T-15 150cc%\'
																			or modelo ilike \'%SAFARI 150cc%\'
																			or modelo ilike \'%RUNNER 125cc%\'
																			or modelo ilike \'%AME-150 TC/ SC%\'
																			or modelo ilike \'%AME-LX 125/26%\'
																			or modelo ilike \'%HB125-9 FEARFULSPEED%\'
																			or modelo ilike \'%HB110-3%\'
																			or modelo ilike \'%DY110-6%\'
																			or modelo ilike \'%Kansas 150%\'
																			or modelo ilike \'%Kansas 250%\'
																			or modelo ilike \'%LASER 150%\'
																			or modelo ilike \'%SMART 125cc%\'
																			or modelo ilike \'%SPEED 150%\'
																			or modelo ilike \'%SUPER 100%\'
																			or modelo ilike \'%ZIG 100%\'
																			or modelo ilike \'%150T-3 Adventure%\'
																			or modelo ilike \'%JBr 125e%\'
																			or modelo ilike \'%LY 125T -5 RETR%\'
																			or modelo ilike \'%LY 150T-5 RETR%\'
																			or modelo ilike \'%LY 150T-6A CLASSIC%\'
																			or modelo ilike \'%LY 150T-7A RACER LIMITED EDITION%\'
																			or modelo ilike \'%MOTO TRUCK LD 150 ZH%\'
																			or modelo ilike \'%MOVING 125 ES%\'
																			or modelo ilike \'%MOVING 125 ESD%\'
																			or modelo ilike \'%Matrix 150%\'
																			or modelo ilike \'%Meet 50cc%\'
																			or modelo ilike \'%NEXT 250cc%\'
																			or modelo ilike \'%Naked 150cc%\'
																			or modelo ilike \'%ONE 125 ES%\'
																			or modelo ilike \'%ONE 125 ESD%\'
																			or modelo ilike \'%ONE 125 EX%\'
																			or modelo ilike \'%Orbit 150cc%\'
																			or modelo ilike \'%PEGASUS 150cc%\'
																			or modelo ilike \'%QUICK 150cc%\'
																			or modelo ilike \'%RACER 150cc%\'
																			or modelo ilike \'%RIVA 150cc%\'
																			or modelo ilike \'%RIVA Cargo 150cc%\'
																			or modelo ilike \'%Roadwin 250R%\'
																			or modelo ilike \'%SUPER 50%\'
																			or modelo ilike \'%TR 150cc%\'
																			or modelo ilike \'%Texas 150cc%\'
																			or modelo ilike \'%Vintage 150%\'
																			or modelo ilike \'%WARRIOR 250 Quadriciclo%\'
																			or modelo ilike \'%ZIG 100+%\'
																			or modelo ilike \'%ZIG 50%\'
																			or modelo ilike \'%can-am DS 250 EFI 4X2 Quadr.%\'
																			or modelo ilike \'%VESPA LXV 150 155cc%\'
																			or modelo ilike \'%FIFTY 50cc%\'
																			or modelo ilike \'%PALIO 50cc%\'
																			or modelo ilike \'%SUPER FIFTY 50cc%\'
																			or modelo ilike \'%Web 97cc%\'
																			or modelo ilike \'%MAX 125 SE%\'
																			or modelo ilike \'%BWS 50%\'
																			or modelo ilike \'%CRYPTON 100%\'
																			or modelo ilike \'%XTZ 125 K%\'
																			or modelo ilike \'%XTZ 125 E%\'
																			or modelo ilike \'%TT-R 125 LE%\'
																			or modelo ilike \'%TT-R 230%\'
																			or modelo ilike \'%TXT 200 Contact%\'
																			or modelo ilike \'%ANKUR 50%\'
																			or modelo ilike \'%PUCH 50%\'
																			or modelo ilike \'%QUATTOR 30.0 190cc%\'
																			or modelo ilike \'%SENDA R 49cc%\'
																			or modelo ilike \'%GPR 50R 49cc%\'
																			or modelo ilike \'%REPLICAS 49cc%\'
																			or modelo ilike \'%STREET 150/Street Limited%\'
																			or modelo ilike \'%JP 150%\'
																			or modelo ilike \'%ONE RACING 50cc%\'
																			or modelo ilike \'%C 100 BIZ+%\'
																			or modelo ilike \'%CG 150 Start FLEXone%\'
																			or modelo ilike \'%SUPER CAB 100cc%\'
																			or modelo ilike \'%RETRO EX 50%\'
																			or modelo ilike \'%WY 48Q-2 Phoenix S 50%\'
																			or modelo ilike \'%DY110-20%\'
																			or modelo ilike \'%DY125-18%\'
																			or modelo ilike \'%SONIC 50cc%\'
																			or modelo ilike \'%FOSTI 125%\'
																			or modelo ilike \'%CG 125 TITAN-KSE%\'
																			or modelo ilike \'%MONDO 75cc%\'
																			or modelo ilike \'%GF 125 SPEED%\'
																			or modelo ilike \'%QM 50%\'
																			or modelo ilike \'%ZIP 50%\'
																			or modelo ilike \'%MCA-200%\'
																			or modelo ilike \'%MCF-200%\'
																			or modelo ilike \'%MTX-150%\'
																			or modelo ilike \'%Star 150cc%\'
																			or modelo ilike \'%Star 200cc%\'
																			or modelo ilike \'%Star automatic 125cc%\'
																			or modelo ilike \'%TRIMOTO 125cc Picape%\'
																			or modelo ilike \'%TRIMOTO 125cc Picape Ba%\'
																			or modelo ilike \'%TRITON Li 150%\'
																			or modelo ilike \'%Trciclo TC Cargo Chassi%\'
																			or modelo ilike \'%Triciclo TB Cargo Bau%\'
																			or modelo ilike \'%Triciclo TC Cargo Carroceria%\'
																			or modelo ilike \'%Triciclo TC Cargo Plataforma%\'
																			or modelo ilike \'%Velocette 150cc%\'
																			or modelo ilike \'%Velvet 150cc%\'
																			or modelo ilike \'%Vitesse 150cc%\'
																			or modelo ilike \'%Vthunder 250%\'
																			or modelo ilike \'%rebellian 250%\'
																			or modelo ilike \'%SCARABEO CLASSIC 50cc%\'
																			or modelo ilike \'%VX 125%\'
																			or modelo ilike \'%CG 125 TODAY%\'
																			or modelo ilike \'%MASTER 50cc%\'
																			or modelo ilike \'%CG 150 TITAN-ESD MIX/FLEX%\'
																			or modelo ilike \'%FRIA 250cc%\'
																			or modelo ilike \'%SR RACING 50cc%\'
																			or modelo ilike \'%NXR 150 Bros KS%\'
																			or modelo ilike \'%CG 150 FAN ESi/ 150 FAN ESi FLEX%\'
																			or modelo ilike \'%WRE 125%\'
																			or modelo ilike \'%JH 125-35A  JOTO / JH 135-35A JOTO%\'
																			or modelo ilike \'%JH 250E-5 Shark%\'
																			or modelo ilike \'%MOTOKAR Taxi-Kar 174cc (4 pessoas%\'
																			or modelo ilike \'%MAGIK 125cc%\'
																			or modelo ilike \'%Comet 250cc / Comet GT 250cc%\'
																			or modelo ilike \'%PRIMA RALLY 50cc%\'
																			or modelo ilike \'%VESPA GTS/Super/Super Sport 250 i.e%\'
																			or modelo ilike \'%GR125T3%\'
																			or modelo ilike \'%FAST LJ 150-2%\'
																			or modelo ilike \'%DRAGO LJ 150-7%\'
																			or modelo ilike \'%JP 110%\'
																			or modelo ilike \'%BR III 150CC%\'
																			or modelo ilike \'%TRC-01 GRAN LUXO 1.8%\'
																			or modelo ilike \'%230R%\'
																			or modelo ilike \'%ACTION 100 ES%\'
																			or modelo ilike \'%ACTION 100 ESA%\'
																			or modelo ilike \'%ATLANTIC 150cc%\'
																			or modelo ilike \'%ATLANTIC 250cc%\'
																			or modelo ilike \'%Apache 150cc%\'
																			or modelo ilike \'%Bacio 125cc%\'
																			or modelo ilike \'%Bellavita 150cc%\'
																			or modelo ilike \'%Brave 150 Quadriciclo%\'
																			or modelo ilike \'%Brave 70  Quadriciclo%\'
																			or modelo ilike \'%CARGO 200 ZH (triciclo carga%\'
																			or modelo ilike \'%CIAK MASTER 200%\'
																			or modelo ilike \'%CITYCLASS 200i%\'
																			or modelo ilike \'%Cappuccino150cc%\'
																			or modelo ilike \'%Custom 150cc%\'
																			or modelo ilike \'%Custom S 150cc%\'
																			or modelo ilike \'%DE LUXE 152cc%\'
																			or modelo ilike \'%DY125-8%\'
																			or modelo ilike \'%DY125T-10%\'
																			or modelo ilike \'%DY150-7%\'
																			or modelo ilike \'%DY150-9%\'
																			or modelo ilike \'%DY150GY%\'
																			or modelo ilike \'%DY150ZH   (triciclo carga%\'
																			or modelo ilike \'%DY200ZH  (triciclo carga%\'
																			or modelo ilike \'%DY250-2%\'
																			or modelo ilike \'%E RETR 2000 Watts (Eltrica%\'
																			or modelo ilike \'%FENIX GOLD 240%\'
																			or modelo ilike \'%Ghost 270/320%\'
																			or modelo ilike \'%HYPE 110cc%\'
																			or modelo ilike \'%HYPE 125cc%\'
																			or modelo ilike \'%HYPE 50cc%\'
																			or modelo ilike \'%Horizon 150%\'
																			or modelo ilike \'%Horizon 250%\'
																			or modelo ilike \'%JBr 150e%\'
																			or modelo ilike \'%JBr 250e%\'
																			or modelo ilike \'%JONNY 50 49cc%\');');


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
