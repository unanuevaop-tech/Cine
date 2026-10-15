<?php
require_once __DIR__ . "/Config/database.php";
require_once __DIR__ . "/modelo/Pelicula.php";
require_once __DIR__ . "/modelo/PeliculaDao.php";
require_once __DIR__ . "/Controlador/PeliculaController.php";

$database = new Database();
$conexion = $database->conectar();

$dao = new PeliculaDao($conexion);
$controller = new PeliculaController($dao);

$accion = $_POST["accion"] ?? $_GET["accion"] ?? "listar";

switch ($accion) {
    case "insertar":
        $controller->guardar();
        break;

    case "editar":
        $controller->editar();
        break;

    case "actualizar":
        $controller->actualizar();
        break;

    case "eliminar":
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            http_response_code(405);
            exit("Método no permitido");
        }
        $controller->eliminar();
        break;

    default:
        $controller->index();
        break;
}