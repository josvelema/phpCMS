<?php 

function confirm_query($result) {

  global $conn;

  if(!$result) {

    die("Query Failed : " . mysqli_error($conn));
  }
  


}


// Create Category

function insert_category() {

  global $conn;

  if (isset($_POST['submit'])) {
    $cat_title = ($_POST['cat_title']);

    if ($cat_title == "" || empty($cat_title)) {
      echo "This field should not be empty";
    } else {

      $query = "INSERT INTO categories(cat_title) ";
      $query .= "VALUE('{$cat_title}') ";

      $create_cat_query = mysqli_query($conn, $query);

      if (!$create_cat_query) {
        die('Query failed : ' . mysqli_error($conn));
      }
    }
  }
}

// Read categories

function read_categories() {

  global $conn;

  $query = "SELECT * FROM categories";
  $select_categories = mysqli_query($conn, $query);

  while ($row = mysqli_fetch_assoc($select_categories)) {
    $cat_id = $row['cat_id'];
    $cat_title = $row['cat_title'];

    echo "<tr>";
    echo "<td>{$cat_id}</td>";
    echo "<td>{$cat_title}</td>";
    echo "<td><a href='categories.php?delete={$cat_id}' class='btn btn-danger'>Delete</a> ";
    echo "<a href='categories.php?update={$cat_id}' class='btn btn-warning'>Update</a></td>";
    echo "</tr>";

  }

}

// delete category

function delete_category() {

  global $conn;

  if (isset($_GET['delete'])) {
    $del_cat_id = $_GET['delete'];

    $query = "DELETE FROM categories WHERE cat_id = {$del_cat_id} ";
    $delete_query = mysqli_query($conn, $query);
    header("Location: categories.php");
  }

}



?>