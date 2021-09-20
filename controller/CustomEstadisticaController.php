<?php

class CustomEstadisticaController {

    function promedio($array){
        $sum = $this->sumatoria($array);

        return $sum / count($array);
    }

    function sumatoria($array){
        return array_reduce($array  , function($prev, $curr){
            return $prev + $curr;
        }, 0);
    }

    function desviacionEstandar($array, $promedio){
        $arrayResta = [];
        $arrayCuadrado = [];

        foreach ($array AS $valor){
            $desviacionResta = ($valor - $promedio);
            array_push($arrayResta, $desviacionResta);
        }

        foreach ($arrayResta AS $valor){
            $desviacionCubo = pow($valor,2);
            array_push($arrayCuadrado, $desviacionCubo);
        }

        $desviacionSuma = $this->sumatoria($arrayCuadrado);

        $desviacionDivision = ($desviacionSuma / (count($array) - 1));

        $result = sqrt($desviacionDivision);

        return $result;
    }

    function coeficienteVariacion($desviacionEstandar, $promedio){
        return (($desviacionEstandar / $promedio) * 100);
    }

    function factorDilucion($volumenes, $alicuotas){
        $arrayMultiplica = [];
        if (count($volumenes) > 1 && count($alicuotas) >= 1){
            array_push($arrayMultiplica, (1 / $volumenes[0]["volumen"]));
            foreach ($volumenes AS $keyVolumen => $volumen){
                if($keyVolumen > 0){
                    array_push($arrayMultiplica, ($alicuotas[$keyVolumen - 1]["alicuota"] / $volumen["volumen"]));
                }
            }
        } else if (count($volumenes) == 1){
            array_push($arrayMultiplica, (1 / $volumenes[0]["volumen"]));
        } else {
            return null;
        }

        return array_reduce($arrayMultiplica  , function($prev, $curr){
            return $prev * $curr;
        }, 1);
    }

}
