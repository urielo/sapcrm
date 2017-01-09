<?php

use Illuminate\Database\Seeder;

class CreateTriggersFuntionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared('CREATE OR REPLACE FUNCTION atualiza_status_proposta_trigger() RETURNS TRIGGER AS $atualiza_status_proposta_trigger$
                        DECLARE
                            statusid INTEGER;
                        BEGIN
                            IF NEW .idstatus IN (SELECT id FROM status WHERE descricao ILIKE \'%cancelad%\' or descricao ILIKE \'%inati%\' or descricao ILIKE \'%recusad%\' or descricao ILIKE \'fim%\' or descricao ILIKE \'%vencida%\') THEN
	                            statusid := 9 ;
	                        ELSE 
	                            statusid := 10 ;
                            END IF;
                            
                            
	                        UPDATE cotacao SET idstatus = NEW .idstatus
                            WHERE 	idcotacao = NEW .idcotacao;
                            UPDATE veiculosegurado SET idstatus = statusid
                            FROM cotacao WHERE idcotacao = NEW.idcotacao
	                        AND veiculosegurado.veicid = cotacao.veicid;

                            RETURN NEW;
                        END;
                        $atualiza_status_proposta_trigger$ LANGUAGE plpgsql;');
        
        DB::unprepared('CREATE OR REPLACE FUNCTION atualiza_status_certificado_trigger () RETURNS TRIGGER AS $atualiza_status_certificado_trigger$
                            DECLARE statusid INTEGER ;
                            BEGIN
                                statusid := 18 ; 
                               
                                IF NEW .status_id IN (SELECT id FROM status WHERE descricao ILIKE \'%cancelad%\' or descricao ILIKE \'%inati%\' ) THEN
                                    statusid := 12 ;
                                ELSEIF NEW .status_id IN (SELECT id FROM status WHERE descricao ILIKE \'fim%\') THEN
                                    statusid := NEW .idstatus ;                                    
                                END IF;
                                
                                UPDATE proposta  SET idstatus = statusid
                                WHERE   idproposta = NEW .idproposta;
                                RETURN NEW;
                            END; 
                            $atualiza_status_certificado_trigger$ LANGUAGE plpgsql;');
    }
}
