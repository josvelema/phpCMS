<form action="" method="POST">

  <div class="form-group">
    <label for="cat_title">Update Category</label>
    <?php
    if (isset($_GET['update'])) {
      $cat_id = $_GET['update'];

      $query = "SELECT * FROM categories WHERE cat_id = $cat_id";
      $select_categories_id = mysqli_query($conn, $query);
      while ($row = mysqli_fetch_assoc($select_categories_id)) {
        $cat_id = $row['cat_id'];

        $cat_title = $row['cat_title'];

    ?>

        <input type="text" name="cat_title" class="form-control" value="
      <?php if (isset($cat_title)) {
          echo $cat_title;
        } ?>">



    <?php }
    }

    ?>

    <?php // update cat query
    if (isset($_POST['update_cat'])) {
      $upd_cat_title = $_POST['cat_title'];

      $query = "UPDATE categories SET cat_title = '{$upd_cat_title}'
      WHERE cat_id = {$cat_id} ";
      $update_query = mysqli_query($conn, $query);

      if (!$update_query) {
        die("Query failed!" . mysqli_error($conn));
      }
    }
    ?>




  </div>

  <div class="form-group">

    <input type="submit" name="update_cat" value="Update Category" class="btn btn-primary">

  </div>


</form>