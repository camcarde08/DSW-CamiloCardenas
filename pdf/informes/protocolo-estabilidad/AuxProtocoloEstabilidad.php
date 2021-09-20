<?php

require_once './../../../vendor/autoload.php';
require_once './../../../eloquent/database.php';
require_once './../../../eloquent/models/Empaque.php';
require_once './../../../eloquent/models/Ensayo.php';
require_once './../../../eloquent/models/Envase.php';
require_once './../../../eloquent/models/EstDuracionEstabilidad.php';
require_once './../../../eloquent/models/EstMuestra.php';
require_once './../../../eloquent/models/EstSubMuestra.php';
require_once './../../../eloquent/models/EstEnsayoSubMuestra.php';
require_once './../../../eloquent/models/FormaFarmaceutica.php';
require_once './../../../eloquent/models/Metodo.php';
require_once './../../../eloquent/models/Perfil.php';
require_once './../../../eloquent/models/Producto.php';
require_once './../../../eloquent/models/EstTemperatura.php';
require_once './../../../eloquent/models/EstTipoEstabilidad.php';
require_once './../../../eloquent/models/TipoMuestra.php';
require_once './../../../eloquent/models/Tercero.php';
require_once './../../../eloquent/models/Usuario.php';

use Illuminate\Database\Capsule\Manager as DB;

class AuxProtocoloEstabilidad
{

    public $muestra;

    public function __construct($idMuestra)
    {
        try {
            $muestra = EstMuestra::find($idMuestra);
            $muestra->producto->formaFarmaceutica;
            $muestra->tipoMuestra;
            $muestra->tipoEstabilidad;
            $muestra->tercero;
            $muestra->envase;
            $muestra->empaque;
            $muestra->duraciones = EstSubMuestra::join('sgm_est_duracion_estabilidad', 'sgm_est_duracion_estabilidad.id', '=', 'sgm_est_sub_muestra.id_duracion')
                ->where('sgm_est_sub_muestra.id_muestra', $idMuestra)
                ->groupBy('sgm_est_sub_muestra.id_duracion')
                ->select('sgm_est_duracion_estabilidad.*')
                ->get();
            foreach ($muestra->subMuestras as $subMuestra) {
                $subMuestra->ensayosSubMuestra;
            }

            $this->muestra = $muestra;


        } catch (Exception $ex) {
            $a = 0;
        }
        $a = 0;
    }

    public function getEnsayosByMuestra()
    {
        $ensayos = DB::select("SELECT t2.* FROM sgm_est_sub_muestra t1
            JOIN sgm_est_ensayo_sub_muestra t2 ON t1.id = t2.id_sub_muestra
            WHERE t1.id_muestra = ? 
            GROUP BY t2.id_ensayo
            ORDER BY descripcion_especifica ASC", [$this->muestra->id]);

        return $ensayos;
    }

    public function getDuracionesByMuestra()
    {
        $duraciones = DB::select("SELECT t2.id as id_duracion, t2.label as duracion, t3.id as id_temperatura, 
            t3.label as temperatura FROM sgm_est_sub_muestra t1
            JOIN sgm_est_duracion_estabilidad t2 ON t1.id_duracion = t2.id
            JOIN sgm_est_temperatura t3 ON t3.id = t1.id_temperatura
            WHERE t1.id_muestra = ?", [$this->muestra->id]);

        return $duraciones;
    }
}
