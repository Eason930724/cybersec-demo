<?php
include 'connect.php';
session_start();

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    // Input validation
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error_message = "請填寫所有欄位";
    } elseif (strlen($username) < 3) {
        $error_message = "帳號長度至少需要3個字元";
    } elseif (strlen($password) < 6) {
        $error_message = "密碼長度至少需要6個字元";
    } elseif ($password !== $confirm_password) {
        $error_message = "密碼與確認密碼不一致";
    } else {
        // Check if username already exists
        $check_query = "SELECT username FROM users WHERE username = $1";
        $check_result = pg_query_params($conn, $check_query, array($username));
        
        if (pg_num_rows($check_result) > 0) {
            $error_message = "此帳號已被使用，請選擇其他帳號";
        } else {
            // Hash password and insert user
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username, password) VALUES ($1, $2)";
            $result = pg_query_params($conn, $query, array($username, $hashedPassword));
            
            if ($result) {
                $success_message = "註冊成功！正在跳轉至登入頁面...";
                echo "<script>
                    setTimeout(function() {
                        window.location.href = 'login.php';
                    }, 2000);
                </script>";
            } else {
                $error_message = "註冊失敗，請稍後再試：" . pg_last_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>使用者註冊</title>
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
        
        .register-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            position: relative;
            overflow: hidden;
        }
        
        .register-container::before {
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
        
        .register-header {
            text-align: center;
            margin-bottom: 30px;
            margin-top: 20px;
        }
        
        .register-header h2 {
            color: #333;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .register-header p {
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
        
        .password-strength {
            margin-top: 8px;
            font-size: 12px;
        }
        
        .strength-weak { color: #e53e3e; }
        .strength-medium { color: #dd6b20; }
        .strength-strong { color: #38a169; }
        
        .register-btn {
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
        
        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .register-btn:active {
            transform: translateY(0);
        }
        
        .register-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
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
        
        .requirements {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 13px;
        }
        
        .requirements h4 {
            color: #4a5568;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .requirements ul {
            list-style: none;
            padding: 0;
        }
        
        .requirements li {
            color: #718096;
            margin-bottom: 4px;
            padding-left: 20px;
            position: relative;
        }
        
        .requirements li::before {
            content: '•';
            position: absolute;
            left: 0;
            color: #cbd5e0;
        }
        
        @media (max-width: 480px) {
            .register-container {
                padding: 30px 20px;
                margin: 10px;
            }
            
            .register-header {
                margin-top: 30px;
            }
            
            .register-header h2 {
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
        
        .loading .register-btn {
            background: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- 返回首頁按鈕 -->
        <a href="index.php" class="back-home-btn" title="返回首頁">
            <i class="fas fa-home"></i>
        </a>
        
        <div class="register-header">
            <h2>使用者註冊</h2>
            <p>建立您的新帳號</p>
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

        <div class="requirements">
            <h4>帳號密碼要求：</h4>
            <ul>
                <li>帳號長度至少3個字元</li>
                <li>密碼長度至少6個字元</li>
                <li>密碼需包含英文字母和數字</li>
            </ul>
        </div>

        <form method="post" id="registerForm">
            <div class="form-group">
                <label for="username">帳號</label>
                <input 
                    type="text" 
                    id="username"
                    name="username" 
                    placeholder="請輸入您的帳號（至少3個字元）" 
                    value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                    required
                    minlength="3"
                >
            </div>

            <div class="form-group">
                <label for="password">密碼</label>
                <input 
                    type="password" 
                    id="password"
                    name="password" 
                    placeholder="請輸入您的密碼（至少6個字元）" 
                    required
                    minlength="6"
                >
                <div id="passwordStrength" class="password-strength"></div>
            </div>

            <div class="form-group">
                <label for="confirm_password">確認密碼</label>
                <input 
                    type="password" 
                    id="confirm_password"
                    name="confirm_password" 
                    placeholder="請再次輸入您的密碼" 
                    required
                >
                <div id="passwordMatch" class="password-strength"></div>
            </div>

            <button type="submit" class="register-btn" id="submitBtn">
                註冊帳號
            </button>
        </form>

        <div class="form-footer">
            <a href="login.php">已有帳號？立即登入</a>
            <a href="index.php" class="home-link">
                <i class="fas fa-arrow-left"></i>
                返回首頁
            </a>
        </div>
    </div>

    <script>
        // Password strength checker
        function checkPasswordStrength(password) {
            const strengthDiv = document.getElementById('passwordStrength');
            let strength = 0;
            let message = '';

            if (password.length >= 6) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            switch(strength) {
                case 0:
                case 1:
                    message = '密碼強度：弱';
                    strengthDiv.className = 'password-strength strength-weak';
                    break;
                case 2:
                case 3:
                    message = '密碼強度：中等';
                    strengthDiv.className = 'password-strength strength-medium';
                    break;
                case 4:
                case 5:
                    message = '密碼強度：強';
                    strengthDiv.className = 'password-strength strength-strong';
                    break;
            }

            strengthDiv.textContent = password.length > 0 ? message : '';
        }

        // Password match checker
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const matchDiv = document.getElementById('passwordMatch');

            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    matchDiv.textContent = '✓ 密碼一致';
                    matchDiv.className = 'password-strength strength-strong';
                } else {
                    matchDiv.textContent = '✗ 密碼不一致';
                    matchDiv.className = 'password-strength strength-weak';
                }
            } else {
                matchDiv.textContent = '';
            }
        }

        // Event listeners
        document.getElementById('password').addEventListener('input', function() {
            checkPasswordStrength(this.value);
            checkPasswordMatch();
        });

        document.getElementById('confirm_password').addEventListener('input', checkPasswordMatch);

        // Form submission handling
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('密碼與確認密碼不一致！');
                return;
            }

            const container = document.querySelector('.register-container');
            const submitBtn = document.getElementById('submitBtn');
            
            container.classList.add('loading');
            submitBtn.textContent = '註冊中...';
        });

        // Auto-hide success message and redirect
        <?php if (!empty($success_message)): ?>
            setTimeout(function() {
                const successAlert = document.querySelector('.alert-success');
                if (successAlert) {
                    successAlert.style.opacity = '0';
                    successAlert.style.transform = 'translateY(-10px)';
                }
            }, 1500);
        <?php endif; ?>
    </script>
</body>
</html>
