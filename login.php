<?php
include 'connect.php';
session_start();

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Input validation
    if (empty($username) || empty($password)) {
        $error_message = "請填寫所有欄位";
    } else {
        $query = "SELECT * FROM users WHERE username = $1";
        $result = pg_query_params($conn, $query, array($username));
        
        if ($row = pg_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $row['username'];
                $success_message = "登入成功！正在跳轉...";
                echo "<script>
                    setTimeout(function() {
                        window.location.href = 'index.php';
                    }, 1500);
                </script>";
            } else {
                $error_message = "密碼錯誤，請重新輸入";
            }
        } else {
            $error_message = "查無此帳號，請檢查帳號是否正確";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>使用者登入</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            position: relative;
            overflow: hidden;
        }
        
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }
        
        /* 返回首頁按鈕 */
        .back-home-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 16px;
        }
        
        .back-home-btn:hover {
            background: rgba(102, 126, 234, 0.2);
            transform: translateX(-2px);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
            margin-top: 20px;
        }
        
        .login-header h2 {
            color: #333;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .login-header p {
            color: #666;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .form-group input::placeholder {
            color: #aaa;
        }
        
        .login-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .login-btn:active {
            transform: translateY(0);
        }
        
        .alert {
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert-error {
            background: #fee;
            color: #c53030;
            border: 1px solid #fed7d7;
        }
        
        .alert-success {
            background: #f0fff4;
            color: #38a169;
            border: 1px solid #c6f6d5;
        }
        
        .alert-icon {
            font-size: 18px;
        }
        
        .form-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e1e5e9;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .form-footer a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .form-footer a:hover {
            text-decoration: underline;
        }
        
        .home-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #718096 !important;
            font-size: 13px !important;
        }
        
        .home-link:hover {
            color: #667eea !important;
        }
        
        /* 忘記密碼連結 */
        .forgot-password {
            text-align: center;
            margin-top: 15px;
        }
        
        .forgot-password a {
            color: #9ca3af;
            font-size: 13px;
            text-decoration: none;
        }
        
        .forgot-password a:hover {
            color: #667eea;
            text-decoration: underline;
        }
        
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                margin: 10px;
            }
            
            .login-header {
                margin-top: 30px;
            }
            
            .login-header h2 {
                font-size: 24px;
            }
            
            .back-home-btn {
                top: 15px;
                left: 15px;
                width: 35px;
                height: 35px;
                font-size: 14px;
            }
        }
        
        /* Loading animation */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }
        
        .loading .login-btn {
            background: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- 返回首頁按鈕 -->
        <a href="index.php" class="back-home-btn" title="返回首頁">
            <i class="fas fa-home"></i>
        </a>
        
        <div class="login-header">
            <h2>使用者登入</h2>
            <p>請輸入您的帳號密碼</p>
        </div>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-error">
                <span class="alert-icon">❌</span>
                <span><?php echo htmlspecialchars($error_message); ?></span>
            </div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <span class="alert-icon">🎉</span>
                <span><?php echo htmlspecialchars($success_message); ?></span>
            </div>
        <?php endif; ?>

        <form method="post" id="loginForm">
            <div class="form-group">
                <label for="username">帳號</label>
                <input 
                    type="text" 
                    id="username"
                    name="username" 
                    placeholder="請輸入您的帳號" 
                    value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                    required
                >
            </div>
            
            <div class="form-group">
                <label for="password">密碼</label>
                <input 
                    type="password" 
                    id="password"
                    name="password" 
                    placeholder="請輸入您的密碼" 
                    required
                >
            </div>
            
            <button type="submit" class="login-btn" id="submitBtn">
                登入
            </button>
        </form>

        <!-- 忘記密碼連結 -->
        <div class="forgot-password">
            <a href="#" onclick="alert('請聯繫管理員重設密碼')">忘記密碼？</a>
        </div>

        <div class="form-footer">
            <a href="register.php">還沒有帳號？立即註冊</a>
            <a href="index.php" class="home-link">
                <i class="fas fa-arrow-left"></i>
                返回首頁
            </a>
        </div>
    </div>

    <script>
        // Form submission handling
        document.getElementById('loginForm').addEventListener('submit', function() {
            const container = document.querySelector('.login-container');
            const submitBtn = document.getElementById('submitBtn');
            
            container.classList.add('loading');
            submitBtn.textContent = '登入中...';
        });

        // Auto-hide success message and redirect
        <?php if (!empty($success_message)): ?>
            setTimeout(function() {
                const successAlert = document.querySelector('.alert-success');
                if (successAlert) {
                    successAlert.style.opacity = '0';
                    successAlert.style.transform = 'translateY(-10px)';
                }
            }, 1000);
        <?php endif; ?>

        // Enter key support for better UX
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                const form = document.getElementById('loginForm');
                const username = document.getElementById('username').value;
                const password = document.getElementById('password').value;
                
                if (username && password) {
                    form.submit();
                }
            }
        });
    </script>
</body>
</html>
