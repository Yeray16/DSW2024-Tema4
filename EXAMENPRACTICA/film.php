<?php
include "top.php";
require 'connectionPDO.php';
?>
<!--
    <div class="alert alert-success">¡Ejemplo mensaje de éxito!</div>
    <div class="alert alert-error">¡Ejemplo mensaje de error!</div>
    -->

<section id="films">
    <h2>Peliculas</h2>
    <?php
    $category_film = isset($_GET['category']) ? $_GET['category'] : '';

    try {
        $stmtCategory = $link->prepare('SELECT category_id, name FROM category');
        $stmtCategory->execute();
        $categories = $stmtCategory->fetchAll(PDO::FETCH_OBJ);

    ?>
        <form action="film.php" method="get">
            <fieldset>
                <legend>Categorías</legend>
                <select name="category" id="">
                    <option selected disabled>Elige una categoría</option>
                    <?php
                    foreach ($categories as $category) {
                        printf('<option value="%d">%s</option>', $category->category_id, $category->name);
                    }
                    ?>
                </select>
                <input type="submit" name="search" value="buscar">
                <input type="submit" name="delete" value="eliminar">
            </fieldset>
        </form>
        <?php
        $stmtCategory = null;

        if (!empty($category_film)) {
            $stmtTable = $link->prepare('SELECT film.film_id, film.title, film.release_year, film.length FROM film, film_category WHERE film.film_id = film_category.film_id AND film_category.category_id = :category_film');
            $stmtTable->bindParam(':category_film', $category_film, PDO::PARAM_INT);
            $stmtTable->execute();
            $films = $stmtTable->fetchAll(PDO::FETCH_OBJ);

            if ($films) {
        ?>
                <nav>
                    <fieldset>
                        <legend>Acciones</legend>
                        <a href="create.php">
                            <button>Crear Categoria</button>
                        </a>
                    </fieldset>
                </nav>
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Año</th>
                            <th>Duración</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($films as $film) {
                            printf(
                                '<tr><td>%s</td><td>%d</td><td>%d</td>',
                                $film->title,
                                $film->release_year,
                                $film->length
                            );
                        }
                        ?>
                    </tbody>
                </table>
    <?php
            } else {
                echo "<p>No hay películas en esta categoría</p>";
            }
        }
    } catch (Exception $e) {
        die('Se jodio: ' . $e->getMessage());
    }
    ?>
</section>
<?php include "bottom.php"; ?>