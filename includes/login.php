<?php include "db.php"; ?>

<?php session_start(); ?>

<?php

if (isset($_POST['login'])) {

  $login_user_name = $_POST['user_name'];
  $login_user_pass = $_POST['user_pass'];

  $login_user_name = mysqli_real_escape_string($conn, $login_user_name);
  $login_user_pass = mysqli_real_escape_string($conn, $login_user_pass);

  $query = "SELECT * FROM users WHERE user_name = '{$login_user_name}' ";

  $select_user_query = mysqli_query($conn, $query);

  if (!$select_user_query) {
    die("Query failed! " . mysqli_error($conn));
  }


  while ($row = mysqli_fetch_array($select_user_query)) {

    $db_user_id = $row['user_id'];
    $db_user_name = $row['user_name'];
    $db_user_pass = $row['user_pass'];

    $db_user_first_name = $row['user_first_name'];
    $db_user_last_name = $row['user_last_name'];
    $db_user_email = $row['user_email'];
    $db_user_role = $row['user_role'];
  }

  // $login_user_pass = crypt($login_user_pass, $db_user_pass);


  // if ($login_user_name === $db_user_name &&  $login_user_pass === $db_user_pass) {

  //   $_SESSION['session_user_name'] = $db_user_name;
  //   $_SESSION['session_user_first_name'] = $db_user_first_name;
  //   $_SESSION['session_user_last_name'] = $db_user_last_name;
  //   $_SESSION['session_user_role'] = $db_user_role;

  //   header("Location: ../admin");
  //   // echo "pass!";
  // }
  //  else {

  //   // echo "something else";
  //   header("Location: ../index.php");
  // }

  if (password_verify($login_user_pass, $db_user_pass)) {
    $_SESSION['session_user_name'] = $db_user_name;
    $_SESSION['session_user_first_name'] = $db_user_first_name;
    $_SESSION['session_user_last_name'] = $db_user_last_name;
    $_SESSION['session_user_role'] = $db_user_role;

    header("Location: ../admin");
  } else {

    echo "something else";
    header("Location: ../index.php");
  }
}
