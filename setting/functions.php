<?php

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

function setToken() {
  $token = sha1(uniqid(mt_rand(), true));
  $_SESSION['token'] = $token;
}

function checkToken() {
  if (empty($_SESSION['token']) || ($_SESSION['token'] != $_POST['token'])) {
    echo "不正なPOSTが行われました！";
    exit;
  }
}

function login_id_Exists($login_id, $dbh) {
  $sql = "SELECT * FROM user WHERE login_id = :login_id LIMIT 1";
  $stmt = $dbh->prepare($sql);
  $stmt->execute(array(":login_id" => $login_id));
  $user = $stmt->fetch();
  return $user ? true : false;
}

function getSha1Password($s) {
  return (sha1(PASSWORD_KEY.$s));
}

function getUser($login_id, $password, $dbh) {
  $sql = "SELECT * FROM user WHERE login_id = :login_id AND password = :password LIMIT 1";
  $stmt = $dbh->prepare($sql);
  $stmt->execute(array(":login_id"=>$login_id, ":password"=>getSha1Password($password)));
  $user = $stmt->fetch();
  return $user ? $user : false;
}
