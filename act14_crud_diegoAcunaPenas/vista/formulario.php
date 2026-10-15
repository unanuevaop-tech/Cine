<?php
$pelicula = $pelicula ?? new Pelicula();
$peliculas = $peliculas ?? [];
$editando = $pelicula->getId() !== null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de películas</title>
    <link rel="stylesheet" href="public/estilos.css">
</head>
<body>

<main class="contenedor">

    <h1>Registro de películas</h1>

    <form method="POST" action="index.php" class="formulario">

        <h2><?= $editando ? "Editar película" : "Nueva película" ?></h2>

        <?php if ($editando): ?>
            <input type="hidden" name="id"
                   value="<?= (int)$pelicula->getId() ?>">
            <p><strong>ID:</strong> <?= (int)$pelicula->getId() ?></p>
        <?php endif; ?>

        <label for="nombre">Nombre:</label>
        <input id="nombre" type="text" name="nombre"
               value="<?= htmlspecialchars($pelicula->getNombre()) ?>"
               required>

        <label for="genero">Género:</label>
        <input id="genero" type="text" name="genero"
               value="<?= htmlspecialchars($pelicula->getGenero()) ?>"
               required>

        <label for="duracion">Duración (horas):</label>
<input
    id="duracion"type="number"name="duracion" min="0.1"step="0.1"
    value="<?= $editando ? htmlspecialchars((string)($pelicula->getDuracion() / 60)) : '' ?>"
    required>

        <label for="imagenportada">Imagen de portada (URL):</label>
        <input id="imagenportada" type="url" name="imagenportada"
               value="<?= htmlspecialchars($pelicula->getImagenportada()) ?>"
               placeholder="https://ejemplo.com/portada.jpg">

        <button type="submit" name="accion"
                value="<?= $editando ? "actualizar" : "insertar" ?>">
            <?= $editando ? "Guardar cambios" : "Guardar película" ?>
        </button>

        <?php if ($editando): ?>
            <a href="index.php">Cancelar</a>
        <?php endif; ?>

    </form>

    <h2>Películas guardadas</h2>

    <div class="tabla-contenedor">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Género</th>
                    <th>Duración</th>
                    <th>Portada</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
            <?php if (!$peliculas): ?>
                <tr>
                    <td colspan="6">No hay películas registradas.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($peliculas as $p): ?>
                    <tr>
                        <td><?= (int)$p->getId() ?></td>
                        <td><?= htmlspecialchars($p->getNombre()) ?></td>
                        <td><?= htmlspecialchars($p->getGenero()) ?></td>
                        <td><?= (int)$p->getDuracion() ?> min</td>
                        <td>
                            <?php if ($p->getImagenportada()): ?>
                                <img class="portada"
                                     src="<?= htmlspecialchars($p->getImagenportada()) ?>"
                                     alt="Portada de <?= htmlspecialchars($p->getNombre()) ?>">
                            <?php else: ?>
                                Sin imagen
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="index.php?accion=editar&id=<?= (int)$p->getId() ?>">
                                Editar
                            </a>

                            <form method="POST" action="index.php"
                                  onsubmit="return confirm('¿Eliminar esta película?')">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id"
                                       value="<?= (int)$p->getId() ?>">
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</main>

</body>
</html>