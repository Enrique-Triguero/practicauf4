<?PHP

    namespace jesusyenrique\practicauf4;
    
    include "Consultas.php";

    class APIConsulta {        
        
        function cogerCompras() {
            // generamos las variables
            $consulta= new Consultas();
            $cliente = array();
            $cliente['register'] = array();

            // recogemos los datos de la BBDD
            $result = $consulta->consultaCliente($_GET['nombre']);
            
            // recorremos los resultados
            if($result->rowCount()){
                while($row = $result->fetch(PDO::FETCH_ASSOC)){
                    $register = array(
                        'nombre' => $row['nombre'],
                        'fecha' => $row['fecha'],
                        'cantidad' => $row['cantidad'],
                    );
                    array_push($cliente['register'], $register);
                }
                http_response_code(200);
                echo json_encode($cliente);
            }else{
                http_response_code(404);
                echo json_encode(array('message' => 'Elemento no encontrado'));
            }
        }

        function cogerFechas() {

            // comprobamos formato recibido de fecha
            $fecha = $_GET['fecha'];
            $valores = explode('-', $fecha);

            // comprobamos que la fecha tiene 
            if (count($valores) != 3 || strlen($valores[1]) != 2 || strlen($valores[2]) != 2){
                http_response_code(404);
                echo json_encode(array('message' => 'Fecha mal formada. Forma correcta YYYY-MM-DD'));

            } elseif (checkdate($valores[1], $valores[2], $valores[0])) {

                // definimos formato de fecha y cogemos la fecha actual
                $fechaActual = date("Y-m-d");

                // comprobamos que la fecha introducida es anterior a la de hoy
                if ($fechaActual <= $fecha ){
                    http_response_code(404);
                    echo json_encode(array('message' => 'Introduce una fecha anterior a la de hoy ' . $fechaActual));

                } else {

                    // generamos las variables
                    $consulta= new Consultas();
                    $fechas = array();
                    $fechas['register'] = array();

                    // recuperamos los datos de la BBDD
                    $result = $consulta->consultaFechas($fecha);
                    
                    // recorremos los resultados
                    if($result->rowCount()){
                        while($row = $result->fetch(PDO::FETCH_ASSOC)){
                            $register = array(
                                'fecha' => $row['fecha'],
                                'cantidad' => $row['cantidad'],
                            );
                            array_push($fechas['register'], $register);
                        }
                        http_response_code(200);
                        echo json_encode($fechas);
                    }else{
                        http_response_code(404);
                        echo json_encode(array('message' => 'Elemento no encontrado'));
                    }

                 }
                        
            } else {

                 http_response_code(404);
                 echo json_encode(array('message' => 'No es una fecha valida. Forma correcta YYYY-MM-DD'));
            }
        }
    }

    $api = new APIConsulta();

    // comprobamos datos introducidos
    if (isset($_GET['nombre'])) {
        $api->cogerCompras();
    } elseif (isset($_GET['fecha'])) {
        $api->cogerFechas();
    }

?>
