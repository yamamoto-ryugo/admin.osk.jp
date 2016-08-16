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


  if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // CSRF対策
    setToken();
  } else {
    checkToken();

    $question = $_POST['question'];
    $answer = $_POST['answer'];
    $created_person = $me['name1'] . " " . $me['name2'];
    $modified_person = $me['name1'] . " " . $me['name2'];

    $err = array();

    // 登録処理
    $sql = "INSERT INTO faq (
      question,
      answer,
      created_person,
      created,
      modified_person,
      modified
    ) VALUES (
      :question,
      :answer,
      :created_person,
      now(),
      :modified_person,
      now()
    )";
    $stmt = $dbh->prepare($sql);
    $params = array(
      ":question" => $question,
      ":answer" => $answer,
      ":created_person" => $created_person,
      ":modified_person" => $modified_person
    );
    $stmt->execute($params);
    header("Location: ../");
    exit;
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

    <script src="http://ajaxzip3.googlecode.com/svn/trunk/ajaxzip3/ajaxzip3.js" charset="UTF-8"></script>
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="/">よくある質問登録</a>
      </div>

      <div class="login-box-body">
        <p class="login-box-msg">必要事項を入力してください。</p>
        <form action="" method="post">
          <div class="form-group has-feedback">
            <input type="text" name="question" class="form-control" value="" placeholder="質問" />
          </div>
          <div class="form-group has-feedback">
            <textarea name="answer" class="form-control" placeholder="回答" rows="20"></textarea>
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
