<?php

class ConsultaQrController {

    function consultaByQr() {



        $loginController = new LoginController();
        $logued = $loginController->login2();
        if ($logued) {
            if ($_POST['tipo'] == "FQ") {
                $this->getMuestraFQdata();
            }
        } else {
            echo "error";
        }
    }

    function getMuestraFQdata() {

        try {
            $muestra = Muestra::find($_POST['id_muestra']);
            $muestra->estado;
            $muestra->tercero;
            $muestra->envase;
            $muestra->empaque;
            $muestra->producto;
            $muestra->datosUsuarioConclusion;
            $muestra->lote;
            foreach ($muestra->ensayosMuestra as $key => $value) {
                $value->resultados;
                $value->metodo;
            }
            $muestra->showIdMuestra = $this->setShowIdMuestraFq($muestra);
        echo $muestra->toJson();
        } catch (Exception $ex) {
            $a = $ex;
        }



        
    }

    function setShowIdMuestraFq($muestra) {


        $aux = (string) $muestra->custom_id;

        $ceros = SystemParameters::where("propiedad", "leftCeroCustomIdMuestra")->first();
        $auxPrefijo = SystemParameters::where("propiedad", "prefixMuestraSeparator")->first();


        for ($i = strlen($aux); $i < (int) $ceros->valor; $i++) {
            $aux = "0" . $aux;
        }


        $aux = $muestra->prefijo . $auxPrefijo->valor . $aux;
        return $aux;
    }

    function remakeQrCodeAllMuestras($start, $end){

        $muestras = Muestra::where('id', '>=', $start)
            ->where('id', '<=', $end)
            ->get();

        $fecha = new DateTime();

        $cliente = SystemParameters::where("propiedad", "cliente")->first();

        $host = SystemParameters::where("propiedad", "urlqr")->first();

        foreach ($muestras as $muestra){


            $palabra = $fecha->format('sss') . "-" .$cliente->valor . "-" . $fecha->format('sss') . "-fq-" . $fecha->format('sss') . "-" . $muestra->id;

//            $encrypResult = $this->encrypt( $palabra );
            $encrypResult = openssl_encrypt ($palabra, 'aes128', "soulsystem9182");

            $qrString = $host->valor . "?code=" . $encrypResult;

            mkdir("docs/qr/fq/" . $muestra->id , 0777);

            \PHPQRCode\QRcode::png($qrString, "docs/qr/fq/" . $muestra->id . "/qrcode.png", 'L', 4, 2);
        }

        echo "OK";
    }

}
