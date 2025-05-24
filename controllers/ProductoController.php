<?php

namespace Controllers;

use Exception;

use Model\ActiveRecord;
use Model\Productos;
use Model\Categorias;
use MVC\Router;

class ProductoController extends ActiveRecord
{
    //RENDERIZAR PAGINA
    //Esta función se encarga de renderizar la vista de productos
    //Recibe el objeto Router como parámetro y lo utiliza para renderizar la vista
    //La vista se encuentra en la carpeta views/productos/index.php

    public function renderizarPaginaa(Router $router) //renderizar muestra HTML
    {
        $router->render('productos/index', []);
    }




    //GUARDAR PRODUCTO
    //Esta función se encarga de guardar un producto en la base de datos
    //Recibe los datos del producto a través de un formulario y los valida
    //Si los datos son válidos, se crea un nuevo producto en la base de datos
    //Si los datos no son válidos, se devuelve un mensaje de error

    public static function guardarAPI() //devuelve JSON
    {
        getHeadersApi();
        //Recibimos los datos del formulario, validacion nombre letras mayores a 2
        $_POST['producto_nombre'] = htmlspecialchars($_POST['producto_nombre']);
        $cantidad_nombre = strlen($_POST['producto_nombre']);

        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre del producto debe tener al menos 2 letras'
            ]);
            return;
        }


        //Validamos la cantidad, que sea un número entero mayor a 0
        $_POST['producto_cantidad'] = filter_var($_POST['producto_cantidad'], FILTER_VALIDATE_INT);
        if ($_POST['producto_cantidad'] < 1) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad debe ser mayor a 0'
            ]);
            return;
        }



        // Validar que la categoría existe
        $_POST['producto_categoria_id'] = filter_var($_POST['producto_categoria_id'], FILTER_VALIDATE_INT);
        $_POST['producto_prioridad'] = htmlspecialchars($_POST['producto_prioridad']);

        $prioridad = $_POST['producto_prioridad'];

        if ($prioridad == "A" || $prioridad == "M" || $prioridad == "B") {

            //verificar si el producto ya existe en la base de datos, si ya existe, no se puede agregar
            $sql_verificar = "SELECT COUNT(*) as total FROM productos 
                            WHERE producto_nombre = '" . $_POST['producto_nombre'] . "' 
                            AND producto_categoria_id = " . $_POST['producto_categoria_id'] . " 
                            AND producto_situacion = 1";

            $verificacion = Productos::fetchFirst($sql_verificar);
            if ($verificacion['total'] > 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Este producto ya existe en la categoría seleccionada'
                ]);
                return;
            }





            //Crea un nuevo objeto Producto con los datos validados
            try {
                $data = new Productos([
                    'producto_nombre' => $_POST['producto_nombre'],
                    'producto_cantidad' => $_POST['producto_cantidad'],
                    'producto_categoria_id' => $_POST['producto_categoria_id'],
                    'producto_prioridad' => $_POST['producto_prioridad'],
                    'producto_comprado' => 0,
                    'producto_situacion' => 1
                ]);

                //crear() inserta en la base de datos
                $crear = $data->crear();

                http_response_code(200);
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => 'El producto se guardo correctamente'
                ]);
                
            } catch (Exception $e) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Error al guardar',
                    'detalle' => $e->getMessage(),
                ]);
            }
        // } else {
        //     http_response_code(400);
        //     echo json_encode([
        //         'codigo' => 0,
        //         'mensaje' => 'La prioridad solo puede ser "A, M, B"'
        //     ]);
        //     return;
        // }
    }
}








    //BUSCAR PRODUCTOS
    //Esta función se encarga de buscar los productos en la base de datos
    //Recibe los datos del producto a través de un formulario y los valida
    //Si los datos son válidos, se busca el producto en la base de datos
    //Si los datos no son válidos, se devuelve un mensaje de error

    public static function buscarAPI()
    {
        try {
            //Une las tablas productos y categorias
            $sql = "SELECT p.*, c.categoria_nombre, c.categoria_codigo 
        FROM productos p 
        INNER JOIN categorias c ON p.producto_categoria_id = c.categoria_id 
        WHERE p.producto_situacion = 1 
        ORDER BY  
            c.categoria_nombre ASC,
            CASE p.producto_prioridad 
                WHEN 'A' THEN 1 
                WHEN 'M' THEN 2 
                WHEN 'B' THEN 3 
            END ASC,
            p.producto_comprado ASC";



            //Ejecuta la consulta y obtiene los resultados
            //Devuelve respuesta JSON exitosa con los datos
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




    //MODIFICAR PRODUCTO
    //Esta función se encarga de modificar un producto en la base de datos
    //Recibe los datos del producto a través de un formulario y los valida
    //Si los datos son válidos, se modifica el producto en la base de datos
    //Si los datos no son válidos, se devuelve un mensaje de error

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



    //ELIMINAR PRODUCTO
    //Esta función se encarga de eliminar un producto en la base de datos
    //Recibe el id del producto a través de un formulario y lo valida
    //Si el id es válido, se elimina el producto en la base de datos
    //Si el id no es válido, se devuelve un mensaje de error
    //Eliminamos el producto de la base de datos

    public static function EliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            $ejecutar = Productos::EliminarProducto($id);

            if ($ejecutar) {
                http_response_code(200);
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => 'El producto ha sido eliminado correctamente'
                ]);
                return;
            }

            //no se estaba utilizando o ejecutando la variable $ejecutar
            // http_response_code(200);
            // echo json_encode([
            //     'codigo' => 1,
            //     'mensaje' => 'El producto ha sido eliminado correctamente'
            // ]);


        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al Eliminar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }







    //MARCAR PRODUCTO COMO COMPRADO
    //Esta función se encarga de marcar un producto como comprado en la base de datos
    //Recibe el id del producto a través de un formulario y lo valida
    //Si el id es válido, se marca el producto como comprado en la base de datos
    //Si el id no es válido, se devuelve un mensaje de error

    public static function marcarCompradoAPI()
    {
        try {
            $id = filter_var($_POST['producto_id'], FILTER_SANITIZE_NUMBER_INT);
            $comprado = filter_var($_POST['producto_comprado'], FILTER_VALIDATE_INT);

            $sql = "UPDATE productos SET producto_comprado = $comprado WHERE producto_id = $id";
            $ejecutar = self::SQL($sql);

            $mensaje = $comprado == 1 ? 'Producto marcado como comprado' : 'Producto desmarcado como comprado';

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => $mensaje
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al actualizar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }






    //OBTENER CATEGORÍAS
    //Esta función se encarga de obtener las categorías de la base de datos
    //Recibe el id de la categoría a través de un formulario y lo valida
    //Si el id es válido, se obtiene la categoría en la base de datos
    //Si el id no es válido, se devuelve un mensaje de error


    public static function categoriasAPI()
    {
        try {
            $sql = "SELECT * FROM categorias WHERE categoria_situacion = 1 ORDER BY categoria_nombre";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Categorías obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las categorías',
                'detalle' => $e->getMessage(),
            ]);
        }
    }






    //BUSCAR PRODUCTOS COMPRADOS
    //Esta función se encarga de buscar los productos comprados en la base de datos
    //Recibe los datos del producto a través de un formulario y los valida
    //Si los datos son válidos, se busca el producto en la base de datos
    //Si los datos no son válidos, se devuelve un mensaje de error

    public static function buscarCompradosAPI()
    {
        try {
            $sql = "SELECT p.*, c.categoria_nombre, c.categoria_codigo 
                FROM productos p 
                INNER JOIN categorias c ON p.producto_categoria_id = c.categoria_id 
                WHERE p.producto_situacion = 1 
                AND p.producto_comprado = 1
                ORDER BY c.categoria_nombre, 
                CASE p.producto_prioridad 
                    WHEN 'A' THEN 1 
                    WHEN 'M' THEN 2 
                    WHEN 'B' THEN 3 
                END";

            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Datos de Productos comprados obtenidos correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener datos de los productos comprados',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}
