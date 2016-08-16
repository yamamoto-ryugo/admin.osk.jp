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

    $party_id = $_POST['party_id'];
    $party_name = $_POST['party_name'];
    $zip31 = $_POST['zip31'];
    $zip32 = $_POST['zip32'];
    $pref31 = $_POST['pref31'];
    $addr31 = $_POST['addr31'];
    $address = $_POST['address'];
    $tell = $_POST['tell'];
    $service = $_POST['service'];
    $special = $_POST['special'];
    $url = $_POST['url'];
    $created_person = $me['name1'] . " " . $me['name2'];
    $modified_person = $me['name1'] . " " . $me['name2'];

    $err = array();

    // 登録処理
    $sql = "INSERT INTO party (
      party_id,
      party_name,
      zip31,
      zip32,
      pref31,
      addr31,
      address,
      tell,
      service,
      special,
      url,
      created_person,
      created,
      modified_person,
      modified
    ) VALUES (
      :party_id,
      :party_name,
      :zip31,
      :zip32,
      :pref31,
      :addr31,
      :address,
      :tell,
      :service,
      :special,
      :url,
      :created_person,
      now(),
      :modified_person,
      now()
    )";
    $stmt = $dbh->prepare($sql);
    $params = array(
      ":party_id" => $party_id,
      ":party_name" => $party_name,
      "zip31" => $zip31,
      ":zip32" => $zip32,
      ":pref31" => $pref31,
      ":addr31" => $addr31,
      ":address" => $address,
      ":tell" => $tell,
      ":service" => $service,
      ":special" => $special,
      ":url" => $url,
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
        <a href="/">新規団体登録</a>
      </div>

      <div class="login-box-body">
        <p class="login-box-msg">必要事項を入力してください。</p>
        <form action="" method="post">
          <div class="form-group has-feedback">
            <input type="text" name="party_id" class="form-control" value="" placeholder="事業所番号" />
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="party_name" class="form-control" placeholder="事業所名">
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="zip31" class="form-control" value="" placeholder="郵便番号（上3桁）" />
            <input type="text" name="zip32" class="form-control" value="" placeholder="郵便番号（下4桁）" onKeyUp="AjaxZip3.zip2addr('zip31','zip32','pref31','addr31','addr31');" />
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="pref31" class="form-control" placeholder="都道府県" />
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="addr31" class="form-control" placeholder="市区町村" />
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="address" class="form-control" placeholder="市区町村以下" />
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="tell" class="form-control" placeholder="電話番号" />
          </div>
          <div class="form-group has-feedback">
            <textarea name="service" class="form-control" placeholder="併設サービス"></textarea>
          </div>
          <div class="form-group has-feedback">
            <textarea name="special" class="form-control" placeholder="支援の特徴"></textarea>
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="url" class="form-control" placeholder="URL" />
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
