<?php
require_once __DIR__ . "/../modelo/Pelicula.php";
require_once __DIR__ . "/../modelo/PeliculaDao.php";

class PeliculaController
{
    private $dao;

    public function __construct($dao)
    {
        $this->dao = $dao;
    }

    // LISTAR PELÍCULAS
    public function index()
    {
        $peliculas = $this->dao->listar();
        $pelicula = new Pelicula();

        require __DIR__ . "/../vista/formulario.php";
    }

    // GUARDAR PELÍCULA
    public function guardar()
    {
        $nombre = trim($_POST["nombre"] ?? "");
        $genero = trim($_POST["genero"] ?? "");
        $duracionHoras = (float)($_POST["duracion"] ?? 0);
        $imagen = trim($_POST["imagenportada"] ?? "");

        if ($nombre === "" || $genero === "" || $duracionHoras <= 0) {
            die("Completa todos los campos obligatorios.");
        }

        // Convertir horas a minutos
        $duracionMinutos = (int)round($duracionHoras * 60);

        $pelicula = new Pelicula(
            null,
            $nombre,
            $genero,
            $duracionMinutos,
            $imagen
        );

        $this->dao->insertar($pelicula);

        header("Location: index.php");
        exit;
    }

    // EDITAR PELÍCULA
    public function editar()
    {
        $id = $_GET["id"] ?? "";

        if (!ctype_digit((string)$id) || (int)$id < 1) {
            die("ID no válido.");
        }

        $pelicula = $this->dao->buscarPorId((int)$id);

        if (!$pelicula) {
            die("Película no encontrada.");
        }

        $peliculas = $this->dao->listar();

        require __DIR__ . "/../vista/formulario.php";
    }

    // ACTUALIZAR PELÍCULA
    public function actualizar()
    {
        $id = $_POST["id"] ?? "";

        if (!ctype_digit((string)$id) || (int)$id < 1) {
            die("ID no válido.");
        }

        $nombre = trim($_POST["nombre"] ?? "");
        $genero = trim($_POST["genero"] ?? "");
        $duracionHoras = (float)($_POST["duracion"] ?? 0);
        $imagen = trim($_POST["imagenportada"] ?? "");

        if ($nombre === "" || $genero === "" || $duracionHoras <= 0) {
            die("Completa todos los campos obligatorios.");
        }

        // Convertir horas a minutos
        $duracionMinutos = (int)round($duracionHoras * 60);

        $pelicula = new Pelicula(
            (int)$id,
            $nombre,
            $genero,
            $duracionMinutos,
            $imagen
        );

        $this->dao->actualizar($pelicula);

        header("Location: index.php");
        exit;
    }

    // ELIMINAR UNA PELÍCULA
    public function eliminar()
    {
        $id = $_POST["id"] ?? "";

        if (!ctype_digit((string)$id) || (int)$id < 1) {
            die("ID no válido.");
        }

        $this->dao->eliminar((int)$id);

        header("Location: index.php");
        exit;
    }
}