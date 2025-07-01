<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>資安互動式闖關平台</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php
        // 這裡未來可以加上 session 或登入狀態檢查
        // session_start();
        // if (isset($_SESSION['username'])) { ... }
    ?>

    <div class="background-overlay"></div>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <i class="fas fa-shield-alt"></i>
                    <span>資安互動式闖關平台</span>
                </div>

                <nav class="nav">
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
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <main class="main">
        <div class="container">
            <section class="hero">
                <!-- Badge -->
                <div class="hero-badge">
                    <i class="fas fa-shield-alt"></i>
                    <span>專業資安培訓平台</span>
                </div>

                <!-- Main Title -->
                <h1 class="hero-title">
                    資安互動式<span class="gradient-text">闖關平台</span>
                </h1>

                <!-- Subtitle -->
                <p class="hero-subtitle">
                    從基礎概念到攻防實戰，打造你的資安實力<br>
                    <span class="highlight">實戰演練 • 技能提升 • 證書認證</span>
                </p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                    <button class="btn btn-cta">
                        <i class="fas fa-crosshairs"></i>
                        立即開始挑戰
                    </button>
                    <button class="btn btn-outline">
                        <i class="fas fa-book-open"></i>
                        瀏覽課程
                    </button>
                </div>

                <!-- Feature Cards -->
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

                <!-- Stats -->
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

    <!-- Footer -->
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
</body>
</html>
