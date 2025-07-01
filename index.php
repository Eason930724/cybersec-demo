<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>資安互動式闖關平台</title>
    
    <link rel="stylesheet" href="css/style.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        /* 確保背景立即載入 */
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #0f172a 100%) !important;
            min-height: 100vh !important;
        }
    </style>
</head>
<body>
    <?php
        // 這裡未來可以加上 session 或登入狀態檢查
        // session_start();
        // if (isset($_SESSION['username'])) { ... }
    ?>

    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <i class="fas fa-shield-alt"></i>
                    <span>資安互動式闖關平台</span>
                </div>

                <nav class="nav" id="nav">
                    <a href="#" class="nav-link">
                        <i class="fas fa-book-open"></i>
                        <span>學習區</span>
                    </a>
                    <a href="#" class="nav-link">
                        <i class="fas fa-crosshairs"></i>
                        <span>挑戰區</span>
                    </a>
                    <a href="#" class="nav-link">
                        <i class="fas fa-bell"></i>
                        <span>公告</span>
                    </a>
                </nav>

                <div class="actions">
                    <button class="btn btn-ghost">登入</button>
                    <button class="btn btn-primary">註冊</button>
                </div>

                <button class="mobile-menu-btn" id="mobile-menu-btn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <section class="hero">
                <div class="hero-badge">
                    <i class="fas fa-shield-alt"></i>
                    <span>專業資安培訓平台</span>
                </div>

                <h1 class="hero-title">
                    資安互動式<span class="gradient-text">闖關平台</span>
                </h1>

                <p class="hero-subtitle">
                    從基礎概念到攻防實戰，打造你的資安實力<br>
                    <span class="highlight">實戰演練 • 技能提升 • 證書認證</span>
                </p>

                <div class="hero-actions">
                    <button class="btn btn-cta" id="startChallengeBtn"> <i class="fas fa-crosshairs"></i>
                        立即開始挑戰
                    </button>
                    <button class="btn btn-outline">
                        <i class="fas fa-book-open"></i>
                        瀏覽課程
                    </button>
                </div>

                <div class="features">
                    <div class="feature-card">
                        <div class="feature-icon blue">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h3>互動式學習</h3>
                        <p>透過實際操作和模擬環境，深入理解資安概念與技術</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon green">
                            <i class="fas fa-crosshairs"></i>
                        </div>
                        <h3>實戰挑戰</h3>
                        <p>多樣化的挑戰關卡，從初級到高級，循序漸進提升技能</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon purple">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <h3>成就認證</h3>
                        <p>完成挑戰獲得專業認證，展示你的資安專業能力</p>
                    </div>
                </div>

                <div class="stats">
                    <div class="stat-item">
                        <div class="stat-number blue">1000+</div>
                        <div class="stat-label">活躍用戶</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number green">50+</div>
                        <div class="stat-label">挑戰關卡</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number purple">95%</div>
                        <div class="stat-label">完成率</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number cyan">24/7</div>
                        <div class="stat-label">技術支援</div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <p>© 2025 資工資安挑戰平台 - DEMO版</p>
                <div class="footer-subtitle">
                    <i class="fas fa-users"></i>
                    <span>打造更安全的數位世界</span>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/script.js"></script>
    <script>
        // Add this script directly to index.php or into js/script.js
        document.addEventListener('DOMContentLoaded', function() {
            const startChallengeBtn = document.getElementById('startChallengeBtn');
            if (startChallengeBtn) {
                startChallengeBtn.addEventListener('click', function() {
                    window.location.href = 'home1.html';
                });
            }
        });
    </script>
</body>
</html>
