<?php
//　エラーログ出力用
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);

require_once('function.php');
require_once('vendor/autoload.php');

header('X-FRAME-OPTIONS: SAMEORIGIN');

session_start();
$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));

$_POST['email'] = mb_convert_kana($_POST['email'] , 'a');
$_POST['tel'] = mb_convert_kana($_POST['tel'] , 'n');

$message = '';
if(isset($_POST['submit'])){
  Valitron\Validator::lang('ja'); 
  $vali = new Valitron\Validator($_POST); 
  $vali->rule('required',['name','email','content'])->message('{field}は必ずご入力ください');
  $vali->rule('email','email')->message('{field}は正しい形式でご入力ください');
  $vali->rule('regex', 'tel', '/\A0[0-9]{9,10}\z/')->message('{field}は正しい形式でご入力ください');

  $vali->labels(array(
    'name' => 'お名前',
    'email' => 'メールアドレス',
    'tel' => '電話番号',
    'content' => 'お問い合わせ内容'
  ));
  if($vali->validate()){
      $_SESSION['contact'] = $_POST;
      header('Location: confirm.php');
      exit();
  }else{
    foreach ($vali->errors() as $errors) {
      foreach ($errors as $error) {
        $message .="※". $error. "<br>";
      }
    }
  }
}

if(isset($_SESSION['contact']) && $_REQUEST['action'] == 'rewrite'){
  $_POST = $_SESSION['contact'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
  <meta property='og:type' content='website'>
    <meta property='og:title' content='Kana Honda's Portfolio'>
  <meta property='og:url' content='URL入る'>
    <!--URL入れて-->
  <meta property='og:description' content='本多佳奈のポートフォリオです。'>
  <meta property="og:image" content="img/header.jpeg">
  <meta name="description" content="本多佳奈のポートフォリオです。" />
  <title>Kana Honda's portfolio</title>
  <link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light&display=swap" rel="stylesheet">
  <link href="css/reset.css" media="all" rel="stylesheet" type="text/css" />
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <link href="css/substyle.css" media="all" rel="stylesheet" type="text/css" />
  <link rel="shortcut icon" href="img/favicon.ico" />
</head>
<body>
  <div id="wrapper">
    <header id="header">
      <div class="main-image">  </div>    
      <a href="index.html">
        <h1 class="logo">
         <span class="logo-title">Kana Honda's </span>
         <span class="logo-desc">Portfolio</span>
        </h1>
      </a>
     </header>
    <main id="contents">
      <section class="section" id="contact">
        <div class="inner">
          <div class="section-title-block">
            <h3 class="section-title"><お問い合わせフォーム></h3>
          </div>
          <div class="row">
            <div class="section-contact-wrapper col-sm-12 col-md-8 offset-md-2">
              <p>お仕事のご依頼・ご相談や質問、その他お問い合わせやご意見など承っております。<br>
              こちらのフォームよりお気軽にお問い合わせ下さい。</p>
              <p style="color: red"><?php echo $message; ?></p>
              <form action="" method="post" name="form">
              <input type="hidden" name ="token" value="<?=$token?>">
                <div class="form-group">
                    <label>お名前・企業名　<span class="badge badge-danger">必須</span></label>
                    <input type="text" class="form-control" placeholder="" value="<?php if(isset($_POST['name'])) echo h($_POST['name']); ?>"  name="name">
                </div>
                <div class="form-group">
                    <label>メールアドレス　<span class="badge badge-danger">必須</span></label>
                    <input type="text" class="form-control" placeholder="" value="<?php if(isset($_POST['email'])) echo h($_POST['email']); ?>" name="email" >
                </div>
                <div class="form-group">
                    <label>お電話番号（ハイフンは省いてご入力ください）</label>
                    <input type="tel" class="form-control" placeholder="" value="<?php if(isset($_POST['tel'])) echo h($_POST['tel']); ?>"  name="tel">
                </div>
                <div class="form-group">
                    <label>お問い合わせ内容を記入して下さい　<span class="badge badge-danger">必須</span></label>
                    <textarea placeholder="" rows="10" class="form-control" value="" name="content"><?php if(isset($_POST['content'])) echo h($_POST['content']); ?></textarea>
                </div>
                <button type="submit" name="submit" class="btn btn-info btn-lg d-block">内容を確認する</button>
              </form>
            </div>
          </div><!-- /.row -->
        </div>
      </section>
    </main>
    <footer id="footer">
      <div class="inner">
        <nav class="footer-link">
          <ul>
            <li><a href="index.html#about">about</a></li>
            <li><a href="index.html#works">works</a></li>
            <li><a href="index.html#skill">skill</a></li>
            <li><a href="index.html#contact">contact</a></li>
          </ul>
        </nav>
        <p class="copyright">Copyright&copy; Kana Honda. All Rights Reserved.</p>
      </div>
    </footer>
  </div>
</body>
</html>
