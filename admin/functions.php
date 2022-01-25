<?php

function escape($cleanMe)
{
  global $conn;

  return mysqli_real_escape_string($conn, trim(strip_tags($cleanMe)));
}

function redirect($loc)
{

  return header("Location: " . $loc);
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

      $stmt = mysqli_prepare($conn, "INSERT INTO categories(cat_title) VALUES(?) ");

      mysqli_stmt_bind_param($stmt, 's', $cat_title);

      mysqli_stmt_execute($stmt);

      confirm_query($stmt);

    }


    mysqli_stmt_close($stmt);
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


function isAdmin($user_name)
{
  global $conn;

  $query = "SELECT user_role FROM users WHERE user_name = '$user_name'";

  $result = mysqli_query($conn, $query);

  confirm_query($result);

  $row = mysqli_fetch_array($result);

  if ($row['user_role'] == 'admin') {

    return true;
  } else {

    return false;
  }
}

function userExists($user_name)
{
  global $conn;

  $query = "SELECT user_name FROM users WHERE user_name = '$user_name'";

  $result = mysqli_query($conn, $query);

  confirm_query($result);

  $row = mysqli_fetch_array($result);

  if (mysqli_num_rows($result) > 0) {
    return true;
  } else {
    return false;
  }
}

function userEmailExists($user_email)
{
  global $conn;

  $query = "SELECT user_email FROM users WHERE user_email = '$user_email'";

  $result = mysqli_query($conn, $query);

  confirm_query($result);

  $row = mysqli_fetch_array($result);

  if (mysqli_num_rows($result) > 0) {
    return true;
  } else {
    return false;
  }
}


function registerUser($user_name, $user_email, $user_pass)
{

  global $conn;


  $user_name = escape($_POST['user_name']);
  $user_email = escape($_POST['user_email']);
  $user_pass = escape($_POST['user_pass']);


  $user_pass = password_hash($user_pass, PASSWORD_BCRYPT, array('cost' => 12));





  $query = "INSERT INTO users (user_name, user_email, user_pass, user_role) ";
  $query .= "VALUES('{$user_name}','{$user_email}', '{$user_pass}','subscriber' ) ";

  $register_user_query = mysqli_query($conn, $query);

  confirm_query($register_user_query);
}


function loginUser($username, $password)
{

  global $conn;


  $query = "SELECT * FROM users WHERE user_name = '{$username}' ";

  $select_user_query = mysqli_query($conn, $query);

  confirm_query($select_user_query);

  while ($row = mysqli_fetch_array($select_user_query)) {

    $db_user_id = $row['user_id'];
    $db_user_name = $row['user_name'];
    $db_user_pass = $row['user_pass'];

    $db_user_first_name = $row['user_first_name'];
    $db_user_last_name = $row['user_last_name'];
    $db_user_email = $row['user_email'];
    $db_user_role = $row['user_role'];
  }


  if (password_verify($password, $db_user_pass)) {
    $_SESSION['session_user_name'] = $db_user_name;
    $_SESSION['session_user_first_name'] = $db_user_first_name;
    $_SESSION['session_user_last_name'] = $db_user_last_name;
    $_SESSION['session_user_role'] = $db_user_role;

    redirect("/cms/admin");
  } else {


    redirect("/cms/index.php");
  }
}
