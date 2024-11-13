<?php
include "top.php";
require 'connectionPDO.php';

$film_id = isset($_GET['film_id']) ? $_GET['film_id'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($film_id)) {

  try {
    $link->beginTransaction();

    //Borrar todas las categorías actuales de la película
    $stmtDeleteCategories = $link->prepare('DELETE FROM film_category WHERE film_id=:film_id');
    $stmtDeleteCategories->bindParam(':film_id', $film_id, PDO::PARAM_INT);
    $stmtDeleteCategories->execute();

    //Insertar nuevas categorías seleccionadas
    if (isset($_POST['categories'])) {
      $categories = $_POST['categories'];

      foreach ($categories as $category_id) {
        $stmtInsertAgain = $link->prepare('INSERT INTO film_category(film_id, category_id, last_update) VALUES (:film_id, :category_id, CURRENT_TIMESTAMP)');
        $stmtInsertAgain->bindParam(':film_id', $film_id, PDO::PARAM_INT);
        $stmtInsertAgain->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmtInsertAgain->execute();
      }
    }

    $link->commit();
    $message = '<div class="alert alert-success">¡Categorías actualizadas correctamente!</div>';
  } catch (Exception $e) {
    $link->rollBack();
    $message = '<div class="alert alert-error">Error al actualizar las categorías: '. $e->getMessage() . '</div>';
  }
}
  //Obtener todas las categorías
  $stmtCategory = $link->prepare('SELECT category_id, name FROM category');
  $stmtCategory->execute();
  $categories = $stmtCategory->fetchAll(PDO::FETCH_OBJ);

  //Obtener las categorías actuales de la película
  $stmtFilmCategory = $link->prepare('SELECT category_id FROM film_category WHERE film_id = :film_id');
  $stmtFilmCategory->bindParam(':film_id', $film_id, PDO::PARAM_INT);
  $stmtFilmCategory->execute();
  $filmCategory = $stmtFilmCategory->fetchAll(PDO::FETCH_COLUMN);
?>
  <nav>
    <p><a href="film.php">Volver</a></p>
  </nav>
  <section id="films">
    <h2>Categorías de la pelicula: Nombre de la película</h2>
    <form action="category_film.php?film_id=<?php echo $film_id; ?>" method="post">
      <input type="hidden" name="film_id" value="<?php echo $film_id; ?>">
      <ul>
        <?php
        foreach ($categories as $category) {
          $checked = in_array($category->category_id, $filmCategory) ? 'checked' : '';
          printf('<li><label><input type="checkbox" name="categories[]" value="%d" %s>%s</label></li>',
                $category->category_id, $checked, $category->name);
        }
        ?>
      </ul>
      <p>
        <input type="submit" value="Actualizar">
      </p>
    </form>
  </section>
<?php
  if (!empty($message)) {
    echo $message;
  }
?>
<?php include "bottom.php"; ?>