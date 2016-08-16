<?php

  require_once("../../setting/config.php");
  require_once("../../setting/functions.php");

  session_start();

  if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // CSRF対策
    setToken();
  } else {
    checkToken();

    $login_id = $_POST['login_id'];
    $name1 = $_POST['name1'];
    $name2 = $_POST['name2'];
    $office = $_POST['office'];
    $password = $_POST['password'];

    $err = array();

    // ログインIDが空
    if ($login_id == '') {
      $err['login_id'] = 'ログインIDを入力してください。';
    }

    # ログインIDに重複がないか
    if (login_id_Exists($login_id, $dbh)) {
      $err['login_id'] = 'ご入力頂いたログインIDはすでに登録されています。';
    }

    // 名前が空
    if ($name1 == '') {
      $err['name'] = '姓を入力してください。';
    }
    if ($name2 == '') {
      $err['name'] = '名を入力してください。';
    }

    // 所属事業所が空
    if ($office == '') {
      $err['office'] = '所属事業所を入力してください。';
    }

    // パスワードが空
    if ($password == '') {
      $err['password'] = 'パスワードを入力してください。';
    }

    if (empty($err)) {
      // 登録処理
      $sql = "INSERT INTO user (
        login_id,
        name1,
        name2,
        office,
        password,
        created,
        modified
      ) VALUES (
        :login_id,
        :name1,
        :name2,
        :office,
        :password,
        now(),
        now()
      )";
      $stmt = $dbh->prepare($sql);
      $params = array(
        ":login_id" => $login_id,
        ":name1" => $name1,
        ":name2" => $name2,
        ":office" => $office,
        ":password" => getSha1Password($password)
      );
      $stmt->execute($params);
      header("Location: ../../");
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
        <a href="/">新規ユーザー登録</a>
      </div>

      <div class="login-box-body">
        <p class="login-box-msg">必要事項を入力してください。</p>
        <?php if (!empty($err['login_id'])) : ?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="閉じる">
              <span aria-hidden="true">×</span>
            </button>
            <strong>エラー</strong>：<?php echo h($err['login_id']); ?>
          </div>
        <?php elseif (!empty($err['name'])) : ?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="閉じる">
              <span aria-hidden="true">×</span>
            </button>
            <strong>エラー</strong>：<?php echo h($err['name']); ?>
          </div>
        <?php elseif (!empty($err['office'])) : ?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="閉じる">
              <span aria-hidden="true">×</span>
            </button>
            <strong>エラー</strong>：<?php echo h($err['office']); ?>
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
            <input type="text" name="login_id" class="form-control" value="<?php echo h($login_id); ?>" placeholder="ログインID" />
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="name1" class="form-control" value="<?php echo h($name1); ?>" placeholder="姓" />
            <input type="text" name="name2" class="form-control" value="<?php echo h($name2); ?>" placeholder="名" />
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="office" class="form-control" value="<?php echo h($office); ?>" placeholder="所属事業所" />
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Password" />
          </div>

          <div class="row">
            <div class="col-xs-4">
              <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
            </div>
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">
                登録
              </button>
            </div>
            <div class="col-xs-4">
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
