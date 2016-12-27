<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTriggerFunctionCertificados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE OR REPLACE FUNCTION atualiza_status_certificado_trigger () RETURNS TRIGGER AS $atualiza_status_certificado_trigger$
                            DECLARE statusid INTEGER ;
                            BEGIN
                                statusid := 18 ; 
                               
                                IF NEW .status_id IN (1, 18, 27) THEN
                                    statusid := 18 ;
                                END IF ;
                                
                                IF NEW .status_id IN (12, 28, 29, 30, 31, 32, 33, 34) THEN
                                    statusid := 12 ;
                                END IF ; 
                                UPDATE proposta  SET idstatus = statusid
                                WHERE   idproposta = NEW .idproposta;
                                RETURN NEW ;
                            END ; 
                            $atualiza_status_certificado_trigger$ LANGUAGE plpgsql;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
