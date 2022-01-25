<?php ob_start(); ?>
<?php include "db.php"; ?>
<?php include "../admin/functions.php"; ?>

<?php session_start(); ?>

<?php

if (isset($_POST['login'])) {

  loginUser(escape($_POST['user_name']), escape($_POST['user_pass']));

}