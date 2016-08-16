<?php

  require_once("../setting/config.php");
  require_once("../setting/functions.php");

  session_start();

  if (!empty($_SESSION['me'])) {
    header("Location: ../");
    exit;
  }

  if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // CSRF対策
    setToken();
  } else {
    checkToken();

    $login_id = $_POST['login_id'];
    $password = $_POST['password'];

    $err = array();

    // ログインが登録されていない
    if (!login_id_Exists($login_id, $dbh)) {
      $err['login_id'] = 'ご入力頂いたログインIDは登録されていません。';
    }

    // ログインIDが空
    if ($login_id == '') {
      $err['login_id'] = 'ログインIDを入力してください。';
    }

    // ログインIDとパスワードが正しくない
    if (!$me = getUser($login_id, $password, $dbh)) {
      $err['password'] = 'ログインIDとパスワードが不正です。';
    }

    // パスワードが空
    if ($password == '') {
      $err['password'] = 'パスワードを入力してください。';
    }

    if (empty($err)) {
      // セッションハイジャック対策
      session_regenerate_id(true);
      $_SESSION['me'] = $me;
      header('Location: ../');
      exit;
    }

  }

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">

    <title>岡山県就労移行支援事業所協議会</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="/">岡山県就労移行支援事業所協議会</a>
      </div>

      <div class="login-box-body">
        <p class="login-box-msg">ログインしてください。</p>

        <?php if (!empty($err['login_id'])) : ?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="閉じる">
              <span aria-hidden="true">×</span>
            </button>
            <strong>エラー</strong>：<?php echo h($err['login_id']); ?>
          </div>
        <?php elseif (!empty($err['password'])) : ?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="閉じる">
              <span aria-hidden="true">×</span>
            </button>
            <strong>エラー</strong>：<?php echo h($err['password']); ?>
          </div>
        <?php endif; ?>

        <form action="" method="post">
          <div class="form-group has-feedback">
            <input type="text" name="login_id" class="form-control" placeholder="ログインID" />
            <span class="glyphicon glyphicon-user form-control-feedback">
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Password" />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>

          <div class="row">
            <div class="col-xs-4">
              <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
            </div>
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">
                ログイン
              </button>
            </div>
            <div class="col-xs-4">
              <a class="btn btn-default" href="/user/add/">新規登録</a>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- jQuery 2.1.4 -->
    <script src="/plugins/jQuery/jQuery-2.2.0.min.js" type="text/javascript"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
  </body>
</html>
