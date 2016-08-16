<?php

  require_once("../../setting/config.php");
  require_once("../../setting/functions.php");

  session_start();

  if (empty($_SESSION['me'])) {
    header("Location: ../../login/");
    exit;
  }

  $me = $_SESSION['me'];

  $user = array();

  $id = (int) $_GET['id'];

  $sql = "DELETE FROM user WHERE id = ?";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(1, $id, PDO::PARAM_INT);
  $stmt->execute();
  $dbh = null;

  header("Location: ../");
  exit;
