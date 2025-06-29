<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>資安互動式闖關平台​</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;700&display=swap');
  </style>
</head>
<body>
  <?php
    // 這裡未來可以加上 session 或登入狀態檢查
    // session_start();
    // if (isset($_SESSION['username'])) { ... }
  ?>

  <div class="background-overlay"></div>
  <header>
    <div class="logo"> 資安互動式闖關平台</div>
    <nav>
      <a href="#">學習區</a>
      <a href="#">挑戰區</a>
      <a href="#">公告</a>
    </nav>
    <div class="actions">
      <button class="login">登入</button>
      <button class="join">註冊</button>
    </div>
  </header>

  <section class="hero">
    <div class="hero-text">  
      <h1>資安互動式闖關平台​</h1>
      <p>從基礎觀念到攻防實戰，打造你的資安實力</p>
      <button class="learn-more">立即開始挑戰</button>
    </div>
    <div class="hero-badge">
     
    </div>
  </section>

  <footer>
    <p>© 2025 資工資安挑戰平台 - DEMO版</p>
  </footer>
</body>
</html>
