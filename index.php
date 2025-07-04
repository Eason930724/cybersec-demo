<?php
session_start();
?>
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
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #0f172a 100%) !important;
            min-height: 100vh !important;
        }
        
        /* 模態框樣式 */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            animation: fadeIn 0.3s ease-out;
        }
        
        .modal-overlay.show {
            display: flex;
        }
        
        .modal {
            background: white;
            border-radius: 16px;
            padding: 32px;
            max-width: 480px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            transform: scale(0.9);
            animation: modalSlideIn 0.3s ease-out forwards;
        }
        
        .modal-header {
            text-align: center;
            margin-bottom: 24px;
        }
        
        .modal-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            color: white;
            font-size: 24px;
        }
        
        .modal-title {
            font-size: 24px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
        }
        
        .modal-subtitle {
            color: #6b7280;
            font-size: 16px;
        }
        
        .modal-content {
            margin-bottom: 32px;
        }
        
        .option-card {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f9fafb;
        }
        
        .option-card:hover {
            border-color: #3b82f6;
            background: #eff6ff;
            transform: translateY(-2px);
        }
        
        .option-card:last-child {
            margin-bottom: 0;
        }
        
        .option-header {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }
        
        .option-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            color: white;
            font-size: 16px;
        }
        
        .option-icon.guest {
            background: linear-gradient(135deg, #10b981, #059669);
        }
        
        .option-icon.login {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }
        
        .option-title {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
        }
        
        .option-description {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .modal-actions {
            display: flex;
            gap: 12px;
        }
        
        .modal-btn {
            flex: 1;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .modal-btn.cancel {
            background: #f3f4f6;
            color: #6b7280;
        }
        
        .modal-btn.cancel:hover {
            background: #e5e7eb;
        }
        
        .modal-btn.primary {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
        }
        
        .modal-btn.primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }
        
        /* 課程下拉選單樣式 */
        .course-dropdown {
            position: relative;
            display: inline-block;
        }

        .course-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            min-width: 280px;
            max-width: 320px;
            z-index: 1001;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            margin-top: 8px;
        }

        .course-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .course-list {
            padding: 8px 0;
            max-height: 300px;
            overflow-y: auto;
        }
        
        .course-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            cursor: pointer;
            transition: all 0.2s ease;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .course-item:hover {
            background: #f8fafc;
            padding-left: 24px;
        }
        
        .course-item:last-child {
            border-bottom: none;
        }
        
        .course-number {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            margin-right: 12px;
            flex-shrink: 0;
        }
        
        .course-info {
            flex: 1;
        }
        
        .course-title {
            font-weight: 500;
            color: #1f2937;
            font-size: 14px;
            margin-bottom: 2px;
        }
        
        .course-subtitle {
            color: #6b7280;
            font-size: 12px;
        }
        
        .course-arrow {
            color: #9ca3af;
            font-size: 12px;
            opacity: 0;
            transition: all 0.2s ease;
        }
        
        .course-item:hover .course-arrow {
            opacity: 1;
            transform: translateX(4px);
        }
        
        /* 課程編號顏色變化 */
        .course-item:nth-child(1) .course-number { background: linear-gradient(135deg, #ef4444, #dc2626); }
        .course-item:nth-child(2) .course-number { background: linear-gradient(135deg, #f97316, #ea580c); }
        .course-item:nth-child(3) .course-number { background: linear-gradient(135deg, #eab308, #ca8a04); }
        .course-item:nth-child(4) .course-number { background: linear-gradient(135deg, #22c55e, #16a34a); }
        .course-item:nth-child(5) .course-number { background: linear-gradient(135deg, #06b6d4, #0891b2); }
        .course-item:nth-child(6) .course-number { background: linear-gradient(135deg, #3b82f6, #2563eb); }
        .course-item:nth-child(7) .course-number { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
        .course-item:nth-child(8) .course-number { background: linear-gradient(135deg, #ec4899, #db2777); }
        .course-item:nth-child(9) .course-number { background: linear-gradient(135deg, #f43f5e, #e11d48); }
        .course-item:nth-child(10) .course-number { background: linear-gradient(135deg, #6366f1, #4f46e5); }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes modalSlideIn {
            from {
                transform: scale(0.9) translateY(-20px);
                opacity: 0;
            }
            to {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }
        
        /* 響應式設計 */
        @media (max-width: 768px) {
            .modal {
                padding: 24px;
                margin: 20px;
            }
            
            .modal-actions {
                flex-direction: column;
            }
            
            .course-menu {
                left: 50%;
                transform: translateX(-50%) translateY(-10px);
                min-width: 260px;
                max-width: 90vw;
            }
            
            .course-menu.show {
                transform: translateX(-50%) translateY(0);
            }
            
            .course-item {
                padding: 10px 16px;
            }
            
            .course-item:hover {
                padding-left: 20px;
            }
        }

        @media (max-width: 480px) {
            .course-menu {
                left: 0;
                right: 0;
                transform: translateY(-10px);
                margin: 8px 10px 0 10px;
                min-width: auto;
                max-width: none;
            }
            
            .course-menu.show {
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <!-- 選擇模態框 -->
    <div class="modal-overlay" id="choiceModal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <h2 class="modal-title">選擇進入方式</h2>
                <p class="modal-subtitle">請選擇您要如何開始挑戰</p>
            </div>
            
            <div class="modal-content">
                <div class="option-card" id="guestOption">
                    <div class="option-header">
                        <div class="option-icon guest">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="option-title">訪客模式</div>
                    </div>
                    <div class="option-description">
                        快速開始體驗挑戰，無需註冊即可進行基礎關卡
                    </div>
                </div>
                
                <div class="option-card" id="loginOption">
                    <div class="option-header">
                        <div class="option-icon login">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <div class="option-title">登入帳號</div>
                    </div>
                    <div class="option-description">
                        登入後可保存進度、獲得認證，享受完整功能
                    </div>
                </div>
            </div>
            
            <div class="modal-actions">
                <button class="modal-btn cancel" id="cancelBtn">
                    <i class="fas fa-times"></i> 取消
                </button>
                <button class="modal-btn primary" id="confirmBtn" disabled>
                    <i class="fas fa-arrow-right"></i> 確認
                </button>
            </div>
        </div>
    </div>

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
                    <?php if (isset($_SESSION['username'])): ?>
                        <span style="color:white; margin-right: 10px;">
                            歡迎，<?= htmlspecialchars($_SESSION['username']) ?>
                        </span>
                        <a href="logout.php" class="btn btn-ghost">登出</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-ghost">登入</a>
                        <a href="register.php" class="btn btn-primary">註冊</a>
                    <?php endif; ?>
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
                    <button class="btn btn-cta" id="startChallengeBtn">
                        <i class="fas fa-crosshairs"></i> 立即開始挑戰
                    </button>
                    <div class="course-dropdown">
                        <button class="btn btn-outline" id="browseCourseBtn">
                            <i class="fas fa-book-open"></i> 瀏覽課程
                        </button>
                        <div class="course-menu" id="courseMenu">
                            <div class="course-menu-header">
                                <i class="fas fa-graduation-cap"></i> 課程項目選單
                            </div>
                            <div class="course-list">
                                <div class="course-item" data-course="unit1">
                                    <div class="course-number">1</div>
                                    <div class="course-info">
                                        <div class="course-title">網路釣魚防範</div>
                                        <div class="course-subtitle">識別和防範釣魚攻擊</div>
                                    </div>
                                    <i class="fas fa-chevron-right course-arrow"></i>
                                </div>
                                <div class="course-item" data-course="unit2">
                                    <div class="course-number">2</div>
                                    <div class="course-info">
                                        <div class="course-title">惡意軟體識別</div>
                                        <div class="course-subtitle">認識各種惡意軟體類型</div>
                                    </div>
                                    <i class="fas fa-chevron-right course-arrow"></i>
                                </div>
                                <div class="course-item" data-course="unit3">
                                    <div class="course-number">3</div>
                                    <div class="course-info">
                                        <div class="course-title">強化密碼安全</div>
                                        <div class="course-subtitle">建立安全的密碼策略</div>
                                    </div>
                                    <i class="fas fa-chevron-right course-arrow"></i>
                                </div>
                                <div class="course-item" data-course="unit4">
                                    <div class="course-number">4</div>
                                    <div class="course-info">
                                        <div class="course-title">社交工程陷阱</div>
                                        <div class="course-subtitle">防範社交工程攻擊</div>
                                    </div>
                                    <i class="fas fa-chevron-right course-arrow"></i>
                                </div>
                                <div class="course-item" data-course="unit5">
                                    <div class="course-number">5</div>
                                    <div class="course-info">
                                        <div class="course-title">保護個人資料</div>
                                        <div class="course-subtitle">個人隱私保護策略</div>
                                    </div>
                                    <i class="fas fa-chevron-right course-arrow"></i>
                                </div>
                                <div class="course-item" data-course="unit6">
                                    <div class="course-number">6</div>
                                    <div class="course-info">
                                        <div class="course-title">公用 Wi-Fi 安全</div>
                                        <div class="course-subtitle">安全使用公共網路</div>
                                    </div>
                                    <i class="fas fa-chevron-right course-arrow"></i>
                                </div>
                                <div class="course-item" data-course="unit7">
                                    <div class="course-number">7</div>
                                    <div class="course-info">
                                        <div class="course-title">行動裝置安全</div>
                                        <div class="course-subtitle">手機和平板安全設定</div>
                                    </div>
                                    <i class="fas fa-chevron-right course-arrow"></i>
                                </div>
                                <div class="course-item" data-course="unit8">
                                    <div class="course-number">8</div>
                                    <div class="course-info">
                                        <div class="course-title">雲端儲存風險</div>
                                        <div class="course-subtitle">雲端服務安全使用</div>
                                    </div>
                                    <i class="fas fa-chevron-right course-arrow"></i>
                                </div>
                                <div class="course-item" data-course="unit9">
                                    <div class="course-number">9</div>
                                    <div class="course-info">
                                        <div class="course-title">物聯網(IoT)安全</div>
                                        <div class="course-subtitle">智慧裝置安全防護</div>
                                    </div>
                                    <i class="fas fa-chevron-right course-arrow"></i>
                                </div>
                                <div class="course-item" data-course="unit10">
                                    <div class="course-number">10</div>
                                    <div class="course-info">
                                        <div class="course-title">安全總複習</div>
                                        <div class="course-subtitle">綜合安全知識測驗</div>
                                    </div>
                                    <i class="fas fa-chevron-right course-arrow"></i>
                                </div>
                            </div>
                        </div>
                    </div>
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

    <script>
    // 將PHP session狀態傳遞給JavaScript
    const isLoggedIn = <?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>;
    
    document.addEventListener('DOMContentLoaded', function() {
        const startChallengeBtn = document.getElementById('startChallengeBtn');
        const choiceModal = document.getElementById('choiceModal');
        const guestOption = document.getElementById('guestOption');
        const loginOption = document.getElementById('loginOption');
        const confirmBtn = document.getElementById('confirmBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        
        // 課程下拉選單相關元素
        const browseCourseBtn = document.getElementById('browseCourseBtn');
        const courseMenu = document.getElementById('courseMenu');
        const courseItems = document.querySelectorAll('.course-item');
        
        let selectedOption = null;
        
        // 挑戰按鈕功能
        if (startChallengeBtn) {
            startChallengeBtn.addEventListener('click', function() {
                if (isLoggedIn) {
                    window.location.href = 'home1.php';
                } else {
                    showChoiceModal();
                }
            });
        }
        
        // 課程下拉選單功能
        if (browseCourseBtn) {
            browseCourseBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleCourseMenu();
            });
        }
        
        // 課程項目點擊事件
        courseItems.forEach(item => {
            item.addEventListener('click', function() {
                const courseId = this.getAttribute('data-course');
                const courseTitle = this.querySelector('.course-title').textContent;
                
                // 這裡可以跳轉到對應的課程頁面
                console.log(`選擇課程: ${courseTitle} (${courseId})`);
                
                // 暫時顯示提示，之後可以改為實際跳轉
                alert(`即將進入課程：${courseTitle}`);
                
                // 隱藏選單
                hideCourseMenu();
                
                // 實際使用時可以取消註解下面這行來跳轉
                // window.location.href = `course.php?unit=${courseId}`;
            });
        });
        
        // 顯示/隱藏課程選單
        function toggleCourseMenu() {
            if (courseMenu.classList.contains('show')) {
                hideCourseMenu();
            } else {
                showCourseMenu();
            }
        }
        
        function showCourseMenu() {
            courseMenu.classList.add('show');
        }
        
        function hideCourseMenu() {
            courseMenu.classList.remove('show');
        }
        
        // 點擊其他地方關閉課程選單
        document.addEventListener('click', function(e) {
            if (!browseCourseBtn.contains(e.target) && !courseMenu.contains(e.target)) {
                hideCourseMenu();
            }
        });
        
        // 模態框相關功能
        function showChoiceModal() {
            choiceModal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        
        function hideChoiceModal() {
            choiceModal.classList.remove('show');
            document.body.style.overflow = 'auto';
            selectedOption = null;
            updateConfirmButton();
            clearSelection();
        }
        
        guestOption.addEventListener('click', function() {
            selectOption('guest');
        });
        
        loginOption.addEventListener('click', function() {
            selectOption('login');
        });
        
        function selectOption(option) {
            selectedOption = option;
            clearSelection();
            
            if (option === 'guest') {
                guestOption.style.borderColor = '#10b981';
                guestOption.style.background = '#ecfdf5';
            } else if (option === 'login') {
                loginOption.style.borderColor = '#3b82f6';
                loginOption.style.background = '#eff6ff';
            }
            
            updateConfirmButton();
        }
        
        function clearSelection() {
            guestOption.style.borderColor = '#e5e7eb';
            guestOption.style.background = '#f9fafb';
            loginOption.style.borderColor = '#e5e7eb';
            loginOption.style.background = '#f9fafb';
        }
        
        function updateConfirmButton() {
            if (selectedOption) {
                confirmBtn.disabled = false;
                confirmBtn.style.opacity = '1';
            } else {
                confirmBtn.disabled = true;
                confirmBtn.style.opacity = '0.5';
            }
        }
        
        confirmBtn.addEventListener('click', function() {
            if (selectedOption === 'guest') {
                window.location.href = 'home1.php';
            } else if (selectedOption === 'login') {
                window.location.href = 'login.php';
            }
        });
        
        cancelBtn.addEventListener('click', function() {
            hideChoiceModal();
        });
        
        choiceModal.addEventListener('click', function(e) {
            if (e.target === choiceModal) {
                hideChoiceModal();
            }
        });
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (choiceModal.classList.contains('show')) {
                    hideChoiceModal();
                }
                if (courseMenu.classList.contains('show')) {
                    hideCourseMenu();
                }
            }
        });
    });
    </script>
</body>
</html>
