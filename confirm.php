<?php
require_once('function.php');
header('X-FRAME-OPTIONS: SAMEORIGIN');

session_start();

if(isset($_POST['send']) && isset($_SESSION['contact'])){
  mb_language("ja");
  mb_internal_encoding("UTF-8");

  $subject = "お問い合わせがありました";
  $to      = "k.honda.webe9973@gmail.com";
  $header  = "From: ". mb_encode_mimeheader("お問い合わせ通知");
  $body    =
    "
    以下の内容のお問い合わせがありました。\n
    【お名前】\n
    {$_SESSION['contact']['name']}\n
    【メールアドレス】\n
    {$_SESSION['contact']['email']}\n
    【お電話番号】\n
    {$_SESSION['contact']['tel']}\n
    【お問い合わせ内容】\n
    {$_SESSION['contact']['content']}\n
    "; 
  $result = mb_send_mail($to, $subject, $body, $header);

  if($result){
    $_SESSION = [];
    session_destroy();
    header('Location: thanks.html');
    exit();
  }else{
    $message = "お問い合わせの送信に失敗しました。";
  }
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
            <h3 class="section-title"><送信確認フォーム></h3>
          </div>
          <div class="row">
            <div class="section-contact-wrapper col-sm-12 col-md-8 offset-md-2">
                <p>お問い合わせありがとうございます。<br>
                内容をご確認の上、送信ボタンを押して下さい。 <p style="text-align:right"><a href="contact.php?action=rewrite"  style="color:red"><修正する></a></p>
                <p style="color: red"><?php echo $message; ?></p>
                <form action="" method="POST">
                  <input type="hidden" name="name" value="<?php echo $_POST['name']; ?>">
                  <input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">   
                  <input type="hidden" name="tel" value="<?php echo $_POST['tel']; ?>">   
                  <input type="hidden" name="content" value="<?php echo $_POST['content']; ?>">   
                  <table class="table">
                      <tr>
                          <th>お名前・企業名</th>
                          <td><?php echo h($_SESSION['contact']['name']); ?></td>
                      </tr>
                      <tr>
                          <th>メールアドレス</th>
                          <td><?php echo h($_SESSION['contact']['email']); ?></td>
                      </tr>
                      <tr>
                          <th>お電話番号</th>
                          <td><?php echo h($_SESSION['contact']['tel']); ?></td>
                      </tr>
                      <tr>
                          <th>お問い合わせ内容　</th>
                          <td><?php echo h($_SESSION['contact']['content']); ?></td>
                      </tr>
                      <tr><th></th><td></td></tr>
                   </table>
                   <button type="submit" name="send" class="btn btn-info btn-lg d-block">送信する</button>
                </form>
              </div><!-- ./ wwrapper -->
            </div><!--./ row -->
        </div><!-- ./inner -->
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