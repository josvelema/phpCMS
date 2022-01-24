<?php

function escape($cleanMe)
{
  global $conn;

  return mysqli_real_escape_string($conn, trim(strip_tags($cleanMe)));
}



function confirm_query($result)
{

  global $conn;

  if (!$result) {

    die("Query Failed : " . mysqli_error($conn));
  }
}


// Create Category

function insert_category()
{

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

function read_categories()
{

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

function delete_category()
{

  global $conn;

  if (isset($_GET['delete'])) {
    $del_cat_id = $_GET['delete'];

    $query = "DELETE FROM categories WHERE cat_id = {$del_cat_id} ";
    $delete_query = mysqli_query($conn, $query);
    header("Location: categories.php");
  }
}

function users_online()
{

  // users online 
  global $conn;

  $session_catcher = session_id();
  $time = time();
  $time_out_sec = 60;
  $time_out = $time - $time_out_sec;

  $query = "SELECT * FROM users_online WHERE session = '$session_catcher'";
  $send_query = mysqli_query($conn, $query);
  $count_rows = mysqli_num_rows($send_query);

  if ($count_rows == NULL) {
    mysqli_query($conn, "INSERT INTO users_online(session, time) VALUES('$session_catcher','$time')");
  } else {
    mysqli_query($conn, "UPDATE users_online SET time = '$time' WHERE session = '$session_catcher')");
  }


  $users_online_query = mysqli_query($conn, "SELECT * FROM users_online WHERE time > '$time_out'");
  return $count_users = mysqli_num_rows($users_online_query);
}

function recordCount($table)
{

  global $conn;

  $query = "SELECT * FROM " . $table;
  $sel_all_posts = mysqli_query($conn, $query);
  $result = mysqli_num_rows($sel_all_posts);

  confirm_query($result);

  return $result;
}

function statusCheck($table, $column, $status)
{

  global $conn;

  $query = "SELECT * FROM $table WHERE $column = '$status' ";
  $result = mysqli_query($conn, $query);

  confirm_query($result);

  return mysqli_num_rows($result);

}
