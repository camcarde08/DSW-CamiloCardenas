<?php




        try {
            $conexion = new PDO('mysql:host=newtechway.com;port=3306;dbname=sgm', 'sgmadmin', '2712Admin');
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        
        $query = "SELECT * FROM sgm_cargo";
        $query = $conexion->prepare($query);
        if($query->execute()){
            $data = $query->fetchAll();
            foreach ($data as $cargo) {
               $cargos[] = array(
                   'id' => $cargo['id'],
                   'nombre' => $cargo['nombre']
               );
               
            }
            echo json_encode($cargos);
        } else {
            $data = false;
        }


?>

