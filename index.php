<?php

  require_once("setting/config.php");
  require_once("setting/functions.php");

  session_start();

  if (empty($_SESSION['me'])) {
    header("Location: login/");
    exit;
  }

  $me = $_SESSION['me'];

  $user = array();


?>

<!DOCTYPE html>
<html lang="ja">
  <head>

    <meta charset="utf-8">

    <title>岡山県就労移行支援事業所協議会</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="/dist/css/skins/skin-blue.min.css" rel="stylesheet" type="text/css" />
    <!-- adminLTE style -->
    <link href="/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue">

    <div class="wrapper">
      <!-- トップメニュー -->
        <header class="main-header">

            <!-- ロゴ -->
            <a href="/" class="logo">管理画面</a>

            <!-- トップメニュー -->
            <nav class="navbar navbar-static-top" role="navigation">

                <!-- メニュー項目 -->
                <!-- 小さくなった時に消す -->
                <div class="collapse navbar-collapse" id="navbar-collapse">

                    <!-- サイドバー制御 -->
                    <a href="" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>

                    <!-- 右に寄せるメニュ :navbar-rightとかもあるが、マージが無い -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li><a href="/logout/"><i class="fa fa-sign-out"></i>ログアウト</a></li>
                        </ul>
                    </div>

                </div>
            </nav>
        </header><!-- end header -->

      <aside class="main-sidebar">
        <section class="sidebar">
          <ul class="sidebar-menu">
            <li class="header">各種設定</li>
            <li><a href="/">トップページ</a></li>
            <li><a href="/user/">ユーザー設定</a></li>
            <li><a href="/party/">加盟団体設定</a></li>
            <li><a href="/faq/">よくある質問設定</a></li>
            <li><a href="/logout/">ログアウト</a></li>
          </ul>
        </section>
      </aside>

      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            メインページ
          </h1>
          <p>ようこそ! <?php echo h($me['office']); ?> の <?php echo h($me['name1'] . " " . $me['name2']); ?> さん</p>
        </section>

        <section class="content">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">ユーザー一覧（最新5件）</h3>
            </div>
            <div class="box-body">
              <?php
                $sql = "SELECT * FROM user ORDER BY id DESC LIMIT 5";
                $users = array();
                foreach ($dbh->query($sql) as $row) {
                  array_push($users, $row);

                }
              ?>
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>
                      ID
                    </th>
                    <th>
                      ログインID
                    </th>
                    <th>
                      氏名
                    </th>
                    <th>
                      所属事業所
                    </th>
                    <th>
                      登録日時
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($users as $user) : ?>
                    <tr>
                      <td><?php echo h($user['id']); ?></td>
                      <td><?php echo h($user['login_id']); ?></td>
                      <td><?php echo h($user['name1'] . " " . $user['name2']); ?></td>
                      <td><?php echo h($user['office']); ?></td>
                      <td><?php echo h($user['created']); ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <p><a class="btn btn-primary" href="/user/">詳細</a></p>
            </div>
          </div>

          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">加盟団体一覧（最新5件）</h3>
            </div>
            <div class="box-body">
              <?php
                $sql = "SELECT * FROM party ORDER BY id DESC LIMIT 5";
                $partys = array();
                foreach ($dbh->query($sql) as $row) {
                  array_push($partys, $row);

                }
              ?>

              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>
                      ID
                    </th>
                    <th>
                      事業所番号
                    </th>
                    <th>
                      事業所名
                    </th>
                    <th>
                      市区町村
                    </th>
                    <th>
                      登録者
                    </th>
                    <th>
                      登録日
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($partys as $party) : ?>
                    <tr>
                      <td><?php echo h($party['id']); ?></td>
                      <td><?php echo h($party['party_id']); ?></td>
                      <td><?php echo h($party['party_name']); ?></td>
                      <td><?php echo h($party['addr31']); ?></td>
                      <td><?php echo h($party['created_person']); ?></td>
                      <td><?php echo h($party['created']); ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <p><a class="btn btn-primary" href="/party/">詳細</a></p>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">メニュー</h3>
                </div>
                <div class="box-body">
                  <p><a class="btn btn-danger" href="/">トップ</a> <a class="btn btn-danger" href="/user/">ユーザー設定</a></p>
                  <p><a class="btn btn-danger" href="/party/">加盟団体設定</a> <a class="btn btn-danger" href="/faq/">よくある質問設定</a></p>
                  <p><a class="btn btn-danger" href="/logout/">ログアウト</a></p>
                </div>
              </div>
            </div>
          </div>
        </section>


      </div>

      <footer class="main-footer">
        <div class="pull-right hidden-xs">Ver1.0.0 Beta</div>
        <strong>Copyright &copy; 2015 岡山県就労移行支援事業所協議会</strong>, All rights reserved
      </footer>

    </div>

    <!-- Script -->
    <!-- jquery -->
    <script src="/plugins/jQuery/jQuery-2.2.0.min.js" type="text/javascript"></script>
    <!-- bootstrap -->
    <script src="/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- adminLTE -->
    <script src="/dist/js/app.min.js" type="text/javascript"></script>

  </body>
</html>
