<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersTablesCertificadosPropostas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE OR REPLACE FUNCTION atualiza_status_proposta_trigger() RETURNS TRIGGER AS $atualiza_status_proposta_trigger$
                        DECLARE
                            statusid INTEGER;
                        BEGIN
                            IF NEW .idstatus IN (12, 11,13, 25, 20) THEN
	                            statusid := 9 ;
                            END IF;
                            
                            IF NEW .idstatus IN (10,14,15,16,17,18) THEN
	                            statusid := 10;
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
                               
                                IF NEW .idstatus IN (1, 18, 27) THEN
                                    statusid := 18 ;
                                END IF ;
                                
                                IF NEW .idstatus IN (12, 28, 29, 30, 31, 32, 33, 34) THEN
                                    statusid := 12 ;
                                END IF ; 
                                UPDATE proposta  SET idstatus = statusid
                                WHERE   idproposta = NEW .idproposta;
                                RETURN NEW ;
                            END ; 
                            $atualiza_status_certificado_trigger$ LANGUAGE plpgsql;');

        DB::unprepared('CREATE TRIGGER atualiza_status_proposta AFTER INSERT
                        OR UPDATE ON proposta FOR EACH ROW EXECUTE PROCEDURE atualiza_status_proposta_trigger ();

                        CREATE TRIGGER atualiza_status_certificado AFTER INSERT
                        OR UPDATE ON certificados FOR EACH ROW EXECUTE PROCEDURE atualiza_status_certificado_trigger ();');


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER atualiza_status_proposta ON proposta;
                        DROP TRIGGER atualiza_status_certificado ON certificados;');
    }
}
