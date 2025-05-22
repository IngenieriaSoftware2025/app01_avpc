<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Productos;
use Model\Categorias;
use MVC\Router;

class ProductoController extends ActiveRecord
{

    public function renderizarPagina(Router $router)
    {
        $router->render('productos/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        $_POST['producto_nombre'] = htmlspecialchars($_POST['producto_nombre']);
        $cantidad_nombre = strlen($_POST['producto_nombre']);

        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre del producto debe tener al menos 2 caracteres'
            ]);
            return;
        }

        $_POST['producto_cantidad'] = filter_var($_POST['producto_cantidad'], FILTER_VALIDATE_INT);

        if ($_POST['producto_cantidad'] < 1) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad debe ser mayor a 0'
            ]);
            return;
        }

       $_POST['usuario_nombres'] = htmlspecialchars($_POST['usuario_nombres']);

        $cantidad_nombres = strlen($_POST['usuario_nombres']);


        if ($cantidad_nombres < 2) {

            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mennsaje' => 'la cantidad debe ser mayor a dos'
            ]);
            return;
        }
    }

    public static function buscarAPI()
    {
        try {
            $sql = "SELECT p.*, c.categoria_nombre, c.categoria_codigo 
                    FROM productos p 
                    INNER JOIN categorias c ON p.producto_categoria_id = c.categoria_id 
                    WHERE p.producto_situacion = 1 
                    ORDER BY c.categoria_nombre, 
                    CASE p.producto_prioridad 
                        WHEN 'A' THEN 1 
                        WHEN 'M' THEN 2 
                        WHEN 'B' THEN 3 
                    END, p.producto_comprado";
            
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Productos obtenidos correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los productos',
                'detalle' => $e->getMessage(),
            ]);
        }
    }




public static function buscarAPI()
    {

        try {

            // $data = Productos::all();

            $sql = "SELECT * FROM Productos where usuario_situacion = 1";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Productos obtenidos correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los Productos',
                'detalle' => $e->getMessage(),
            ]);
        }
    }



    public static function modificarAPI()
    {
        getHeadersApi();

        $id = $_POST['producto_id'];
        $_POST['producto_nombre'] = htmlspecialchars($_POST['producto_nombre']);

        $cantidad_nombre = strlen($_POST['producto_nombre']);

        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre del producto debe tener al menos 2 caracteres'
            ]);
            return;
        }

        $_POST['producto_cantidad'] = filter_var($_POST['producto_cantidad'], FILTER_VALIDATE_INT);

        if ($_POST['producto_cantidad'] < 1) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad debe ser mayor a 0'
            ]);
            return;
        }

        $_POST['producto_categoria_id'] = filter_var($_POST['producto_categoria_id'], FILTER_VALIDATE_INT);
        $_POST['producto_prioridad'] = htmlspecialchars($_POST['producto_prioridad']);

        $prioridad = $_POST['producto_prioridad'];

        if ($prioridad == "A" || $prioridad == "M" || $prioridad == "B") {


            $sql_verificar = "SELECT COUNT(*) as total FROM productos 
                            WHERE producto_nombre = '" . $_POST['producto_nombre'] . "' 
                            AND producto_categoria_id = " . $_POST['producto_categoria_id'] . " 
                            AND producto_situacion = 1 
                            AND producto_id != " . $id;
            
            $verificacion = Productos::fetchFirst($sql_verificar);
            
            if ($verificacion['total'] > 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Este producto ya existe en la categoría seleccionada'
                ]);
                return;
            }

            try {
                $data = Productos::find($id);
                $data->sincronizar([
                    'producto_nombre' => $_POST['producto_nombre'],
                    'producto_cantidad' => $_POST['producto_cantidad'],
                    'producto_categoria_id' => $_POST['producto_categoria_id'],
                    'producto_prioridad' => $_POST['producto_prioridad'],
                    'producto_situacion' => 1
                ]);
                $data->actualizar();

                http_response_code(200);
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => 'La información del producto ha sido modificada exitosamente'
                ]);
            } catch (Exception $e) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Error al guardar',
                    'detalle' => $e->getMessage(),
                ]);
            }
        } else {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La prioridad solo puede ser "A, M, B"'
            ]);
            return;
        }
    }

  
}