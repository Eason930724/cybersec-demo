<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>資安互動闖關平台</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            font-family: "Inter", sans-serif;
            background-color: #f0f0f0; /* 淺色背景 */
        }
        /* 主要區塊的自訂顏色 */
        .concept-block-bg {
            background-color: #8C9F4E; /* 橄欖綠 */
        }
        /* 載入中動畫 */
        .loading-spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 4px solid #fff;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        /* 聊天訊息樣式 */
        .chat-message {
            margin-bottom: 8px;
            padding: 6px 10px;
            border-radius: 8px;
            word-wrap: break-word;
            max-width: 90%;
        }
        .chat-user {
            background-color: #4A5568; /* 使用者訊息背景 */
            text-align: right;
            margin-left: auto;
        }
        .chat-ai {
            background-color: #6B7280; /* AI 訊息背景 */
            text-align: left;
            margin-right: auto;
        }
        
        /* 懸浮 AI 助理樣式 */
        #floating-ai-assistant {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            transition: all 0.3s ease-in-out;
        }
        #ai-assistant-content {
            display: none; /* 預設隱藏 */
            width: 300px;
            max-height: 400px;
        }
        #floating-ai-assistant.expanded #ai-assistant-content {
            display: flex; /* 展開時顯示 */
            flex-direction: column;
        }
        #ai-assistant-toggle-button {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: background-color 0.3s ease;
            background-color: #2563eb; /* 藍色 */
        }
        #ai-assistant-toggle-button:hover {
            background-color: #1d4ed8;
        }

        /* 選擇題樣式 */
        .choice-label {
            display: block;
            background-color: rgba(255,255,255,0.1);
            padding: 0.75rem;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .choice-label:hover {
            background-color: rgba(255,255,255,0.2);
        }
        .choice-label input {
            margin-right: 0.75rem;
        }

        /* 填充題輸入框樣式 */
        #fill-in-blank-input {
            background-color: #f0f0f0;
            color: #1f2937;
            border: 2px solid transparent;
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
            margin: 0 0.25rem;
            width: 120px;
        }
        #fill-in-blank-input:focus {
            outline: none;
            border-color: #60a5fa;
        }

        /* 圖片上傳按鈕樣式 */
        #image-upload-label {
            background-color: #4f46e5;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            display: inline-block;
            text-align: center;
        }
        #image-upload-label:hover {
            background-color: #4338ca;
        }
        #image-preview {
            max-width: 100%;
            margin-top: 1rem;
            border-radius: 0.5rem;
            border: 2px dashed rgba(255,255,255,0.3);
        }

        /* 自訂訊息提示框 */
        #custom-alert {
            position: fixed;
            top: -100px; /* 初始位置在螢幕外 */
            left: 50%;
            transform: translateX(-50%);
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            color: white;
            z-index: 2000;
            transition: top 0.5s ease-in-out;
            font-weight: bold;
        }
        #custom-alert.success {
            background-color: #22c55e; /* 綠色 */
        }
        #custom-alert.error {
            background-color: #ef4444; /* 紅色 */
        }
        #custom-alert.info {
            background-color: #3b82f6; /* 藍色 */
        }
        #custom-alert.show {
            top: 20px; /* 顯示時的位置 */
        }

    </style>
</head>
<body class="min-h-screen flex flex-col bg-gray-100">
    <header class="bg-gray-800 text-white p-4 shadow-md">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
            
            <div class="relative inline-block text-left" id="course-menu-container">
                <button type="button" class="concept-block-bg text-white p-3 rounded-lg w-full md:w-auto text-center md:text-left cursor-pointer flex items-center justify-center" id="course-menu-button">
                    課程項目選單
                    <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div id="course-dropdown" class="origin-top-left absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-10">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="course-menu-button">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" data-unit-id="unit1">單元一：網路釣魚防範</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" data-unit-id="unit2">單元二：惡意軟體識別</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" data-unit-id="unit3">單元三：強化密碼安全</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" data-unit-id="unit4">單元四：社交工程陷阱</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" data-unit-id="unit5">單元五：保護個人資料</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" data-unit-id="unit6">單元六：公用 Wi-Fi 安全</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" data-unit-id="unit7">單元七：行動裝置安全</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" data-unit-id="unit8">單元八：雲端儲存風險</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" data-unit-id="unit9">單元九：物聯網(IoT)安全</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" data-unit-id="unit10">單元十：安全總複習</a>
                    </div>
                </div>
            </div>

            <div class="flex-grow text-center text-lg font-semibold">
                資安互動闖關平台
            </div>
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4 w-full md:w-auto">
                <div id="countdown-timer-display" class="concept-block-bg text-white p-3 rounded-lg text-center flex-grow w-32">
                    倒數計時器
                </div>
                <div class="concept-block-bg text-white p-3 rounded-lg text-center flex-grow">
                    帳戶
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto p-4 flex-grow grid grid-cols-1 lg:grid-cols-2 gap-4">
        <section class="flex flex-col space-y-4">
            <div id="course-content-area" class="concept-block-bg text-white p-6 rounded-lg shadow-lg flex flex-col justify-center min-h-[300px]">
                <h2 class="text-2xl font-bold text-center">課程內容</h2>
                <p class="text-center mt-2">點擊左上角選單以選擇單元。</p>
            </div>
            <div id="submission-area" class="concept-block-bg text-white p-6 rounded-lg shadow-lg">
                 <h2 class="text-xl font-bold mb-2 text-center">題目與作答</h2>
                 <div id="question-area" class="mb-4 p-3 bg-gray-700 rounded-md text-sm min-h-[60px]">
                     <p class="font-bold mb-1">題目：</p>
                     <p id="question-text">請從左上角的「課程項目選單」選擇一個單元以開始作答。</p>
                 </div>
                 <h3 class="text-lg font-semibold mb-2">您的答案：</h3>
                 <div id="answer-format-container" class="min-h-[100px]">
                    <div id="short-answer-format" class="hidden">
                        <textarea id="submission-input-short" class="w-full p-2 rounded-md text-gray-800 h-24 resize-none" placeholder="請在此輸入您的答案..."></textarea>
                    </div>
                    <div id="multiple-choice-format" class="hidden space-y-2">
                    </div>
                    <div id="fill-in-blank-format" class="hidden items-center text-lg">
                    </div>
                    <div id="image-upload-format" class="hidden">
                        <input type="file" id="submission-input-image" class="hidden" accept="image/*">
                        <label for="submission-input-image" id="image-upload-label">選擇圖片</label>
                        <span id="image-filename" class="ml-3 text-sm">尚未選擇檔案</span>
                        <img id="image-preview" class="hidden">
                    </div>
                 </div>
                 <button id="submit-answer-button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg mt-4">
                     提交答案
                 </button>
            </div>
        </section>

        <section class="flex flex-col space-y-4">
            <div id="vm-section" class="concept-block-bg text-white p-6 rounded-lg shadow-lg flex flex-col flex-grow">
                <div id="vm-off-state">
                    <h2 class="text-2xl font-bold border-b border-gray-400 pb-2 mb-4">任務：駭入你的第一台機器</h2>
                    <p class="mb-4 text-gray-200">在本次任務中，我們為您準備了一個名為 "Fakebank" 的應用程式，您可以安全地對其進行駭客攻擊練習。</p>
                    <p class="text-gray-200">要開始此任務，請點擊下方的「啟動靶機」按鈕。</p>
                    <button id="start-machine-button" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg mt-6 text-lg">
                        ▶ 啟動靶機
                    </button>
                </div>

                <div id="vm-on-state" class="hidden">
                    <div class="bg-red-700 text-white font-bold p-3 rounded-t-lg -m-6 mb-6">
                        目標靶機資訊
                    </div>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-bold text-gray-300">TITLE</h3>
                            <p class="text-lg">目標靶機：Fakebank v1.0</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-300">TARGET IP ADDRESS</h3>
                            <div class="flex items-center space-x-2 bg-gray-900 p-2 rounded-md">
                                <p id="target-ip" class="text-lg text-green-400 flex-grow">?.?.?.?</p>
                                <button id="copy-ip-button" title="複製IP位址">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-300">EXPIRES</h3>
                            <p id="machine-countdown" class="text-lg">--:--</p>
                        </div>
                    </div>
                    <div class="mt-6 flex space-x-4">
                        <button id="add-hour-button" class="flex-grow bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">延長一小時</button>
                        <button id="terminate-machine-button" class="flex-grow bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">終止靶機</button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-white p-4 mt-4 shadow-inner">
        <div class="container mx-auto text-center text-lg font-semibold">
            資安互動闖關
        </div>
    </footer>

    <div id="floating-ai-assistant" class="concept-block-bg text-white p-3 rounded-lg shadow-lg">
        <div id="ai-assistant-toggle-button" title="開啟/關閉AI助理">
            🤖
        </div>
        <div id="ai-assistant-content" class="mt-2">
            <h2 class="text-xl font-bold mb-2 text-center">AI助理</h2>
            <div id="ai-response" class="flex-grow p-3 bg-gray-700 rounded-md text-sm overflow-y-auto h-48 mb-2">
                <div class="chat-message chat-ai">請在下方提出問題。</div>
            </div>
            <textarea id="ai-assistant-input" class="w-full p-2 rounded-md text-gray-800 mb-2 h-16 resize-none" placeholder="輸入您的問題..."></textarea>
            <button id="ask-ai-button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center justify-center">
                <span id="ask-ai-text">✨ 詢問AI助理</span>
                <div id="ask-ai-loading" class="loading-spinner hidden ml-2"></div>
            </button>
        </div>
    </div>
    
    <div id="custom-alert"></div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const questions = {
                unit1: {
                    type: 'multiple_choice',
                    question: "以下何者是釣魚郵件最典型的特徵？",
                    options: ["寄件者是您認識的朋友", "信件主旨非常緊急，要求您立即採取行動", "信件內容有拼寫或語法錯誤", "以上皆是"],
                    correctAnswer: 3,
                    timeLimit: 60
                },
                unit2: {
                    type: 'short_answer',
                    question: "什麼是勒索軟體 (Ransomware)？如果您的電腦感染了勒索軟體，您應該支付贖金嗎？請說明您的理由。",
                    timeLimit: 180
                },
                unit3: {
                    type: 'fill_in_blank',
                    question_parts: ["一個安全的密碼通常建議包含大寫字母、小寫字母、數字和", "。"],
                    correctAnswer: "特殊符號",
                    timeLimit: 90
                },
                unit4: {
                    type: 'short_answer',
                    question: "社交工程 (Social Engineering) 是什麼意思？駭客可能會如何利用社交媒體平台（如 Facebook 或 Instagram）進行社交工程攻擊？",
                    timeLimit: 180
                },
                unit5: {
                    type: 'multiple_choice',
                    question: "在不同網站使用相同的密碼，會導致哪種主要的資安風險？",
                    options: ["撞庫攻擊 (Credential Stuffing)", "阻斷服務攻擊 (DoS)", "SQL 資料隱碼攻擊 (SQL Injection)", "跨站腳本攻擊 (XSS)"],
                    correctAnswer: 0,
                    timeLimit: 60
                },
                unit6: {
                    type: 'short_answer',
                    question: "當您在咖啡廳或機場使用公用 Wi-Fi 時，存在哪些潛在的安全風險？您會採取哪些措施來保護您的網路活動？",
                    timeLimit: 120
                },
                unit7: {
                    type: 'image_upload',
                    question: "假設您正在對一個可疑程式進行逆向分析。請上傳您使用除錯器 (Debugger) 找到關鍵判斷式（例如，檢查註冊碼是否正確）的畫面截圖。",
                    timeLimit: 300
                },
                unit8: {
                    type: 'short_answer',
                    question: "將檔案儲存在雲端（例如 Google Drive, Dropbox）和儲存在您自己的電腦硬碟中，各有哪些主要的資安優缺點？",
                    timeLimit: 120
                },
                unit9: {
                    type: 'fill_in_blank',
                    question_parts: ["為了保護您的智慧音箱不被竊聽，最簡單直接的方法之一就是定期檢查並更新其", "。"],
                    correctAnswer: "韌體",
                    timeLimit: 90
                },
                unit10: {
                    type: 'short_answer',
                    question: "綜合所有單元，請分享三個您認為最重要的個人資訊安全習慣，並簡要說明原因。",
                    timeLimit: 240
                }
            };

            let currentQuestion = null;
            let aiAssistantChatHistory = [];
            let quizCountdownInterval = null;
            let quizTimeRemaining = 0;
            // NEW: 虛擬機計時器變數
            let machineCountdownInterval = null;
            let machineTimeRemaining = 0;

            const askAiButton = document.getElementById('ask-ai-button');
            if(askAiButton) {
                askAiButton.addEventListener('click', async () => {
                    const inputElement = document.getElementById('ai-assistant-input');
                    const askAiText = document.getElementById('ask-ai-text');
                    const askAiLoading = document.getElementById('ask-ai-loading');
                    const prompt = inputElement.value.trim();
                    if (!prompt) return displayChatMessage('ai', "請輸入您的問題。");
                    displayChatMessage('user', prompt);
                    aiAssistantChatHistory.push({ role: "user", parts: [{ text: prompt }] });
                    inputElement.value = '';
                    askAiText.classList.add('hidden');
                    askAiLoading.classList.remove('hidden');
                    askAiButton.disabled = true;
                    try {
                        const payload = { contents: aiAssistantChatHistory };
                        const apiKey = "";
                        const apiUrl = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${apiKey}`;
                        const response = await fetch(apiUrl, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) });
                        if (!response.ok) throw new Error(`API 呼叫失敗，狀態碼: ${response.status}`);
                        const result = await response.json();
                        if (result.candidates && result.candidates.length > 0) {
                            const text = result.candidates[0].content.parts[0].text;
                            displayChatMessage('ai', text);
                            aiAssistantChatHistory.push({ role: "model", parts: [{ text: text }] });
                        } else {
                            displayChatMessage('ai', "抱歉，AI 未能生成回應。");
                        }
                    } catch (error) {
                        console.error("呼叫 AI 助理時發生錯誤:", error);
                        displayChatMessage('ai', "抱歉，連線時發生錯誤，請稍後再試。");
                    } finally {
                        askAiText.classList.remove('hidden');
                        askAiLoading.classList.add('hidden');
                        askAiButton.disabled = false;
                    }
                });
            }

            function displayChatMessage(sender, message) {
                const responseElement = document.getElementById('ai-response');
                const messageDiv = document.createElement('div');
                messageDiv.classList.add('chat-message', sender === 'user' ? 'chat-user' : 'chat-ai');
                messageDiv.innerText = message;
                responseElement.appendChild(messageDiv);
                responseElement.scrollTop = responseElement.scrollHeight;
            }
            
            function toggleFloatingWindow(buttonId, windowId) {
                const toggleButton = document.getElementById(buttonId);
                const windowElement = document.getElementById(windowId);
                if(toggleButton && windowElement) {
                    toggleButton.addEventListener('click', () => {
                        windowElement.classList.toggle('expanded');
                    });
                }
            }
            
            toggleFloatingWindow('ai-assistant-toggle-button', 'floating-ai-assistant');
            
            const submitAnswerButton = document.getElementById('submit-answer-button');
            if(submitAnswerButton) submitAnswerButton.addEventListener('click', checkAnswer);

            const courseMenuButton = document.getElementById('course-menu-button');
            const courseDropdown = document.getElementById('course-dropdown');
            if(courseMenuButton && courseDropdown) {
                courseMenuButton.addEventListener('click', (event) => {
                    event.stopPropagation();
                    courseDropdown.classList.toggle('hidden');
                });
            }

            const courseLinks = document.querySelectorAll('#course-dropdown a');
            courseLinks.forEach(link => {
                link.addEventListener('click', (event) => {
                    event.preventDefault();
                    const unitId = link.dataset.unitId;
                    updateQuestionDisplay(unitId);
                    courseDropdown.classList.add('hidden');
                });
            });

            document.addEventListener('click', (event) => {
                const courseMenuContainer = document.getElementById('course-menu-container');
                if (courseDropdown && !courseDropdown.classList.contains('hidden')) {
                    if (!courseMenuContainer.contains(event.target)) courseDropdown.classList.add('hidden');
                }
            });

            function updateQuestionDisplay(unitId) {
                currentQuestion = questions[unitId];
                if (!currentQuestion) return;
                const questionTextElement = document.getElementById('question-text');
                const courseContentArea = document.getElementById('course-content-area');
                document.getElementById('short-answer-format').classList.add('hidden');
                document.getElementById('multiple-choice-format').classList.add('hidden');
                document.getElementById('fill-in-blank-format').classList.add('hidden');
                document.getElementById('image-upload-format').classList.add('hidden');
                const unitTitle = document.querySelector(`[data-unit-id="${unitId}"]`).textContent;
                courseContentArea.querySelector('h2').textContent = unitTitle;
                courseContentArea.querySelector('p').textContent = "請閱讀下方題目，並在作答區塊提交您的答案。";
                document.getElementById('submit-answer-button').disabled = false;
                startQuizTimer(currentQuestion.timeLimit);
                switch (currentQuestion.type) {
                    case 'short_answer':
                        questionTextElement.textContent = currentQuestion.question;
                        document.getElementById('short-answer-format').classList.remove('hidden');
                        document.getElementById('submission-input-short').value = '';
                        break;
                    case 'multiple_choice':
                        questionTextElement.textContent = currentQuestion.question;
                        const mcContainer = document.getElementById('multiple-choice-format');
                        mcContainer.innerHTML = '';
                        currentQuestion.options.forEach((option, index) => {
                            const label = document.createElement('label');
                            label.className = 'choice-label';
                            label.innerHTML = `<input type="radio" name="mc-option" value="${index}"> ${option}`;
                            mcContainer.appendChild(label);
                        });
                        mcContainer.classList.remove('hidden');
                        break;
                    case 'fill_in_blank':
                        questionTextElement.textContent = "請完成以下句子：";
                        const fibContainer = document.getElementById('fill-in-blank-format');
                        fibContainer.innerHTML = '';
                        fibContainer.appendChild(document.createTextNode(currentQuestion.question_parts[0]));
                        const input = document.createElement('input');
                        input.type = 'text';
                        input.id = 'fill-in-blank-input';
                        fibContainer.appendChild(input);
                        fibContainer.appendChild(document.createTextNode(currentQuestion.question_parts[1]));
                        fibContainer.classList.remove('hidden');
                        break;
                    case 'image_upload':
                        questionTextElement.textContent = currentQuestion.question;
                        const iuContainer = document.getElementById('image-upload-format');
                        iuContainer.classList.remove('hidden');
                        document.getElementById('submission-input-image').value = '';
                        document.getElementById('image-filename').textContent = '尚未選擇檔案';
                        document.getElementById('image-preview').classList.add('hidden');
                        break;
                }
            }
            
            const imageInput = document.getElementById('submission-input-image');
            if(imageInput) {
                imageInput.addEventListener('change', (event) => {
                    const file = event.target.files[0];
                    if (file) {
                        document.getElementById('image-filename').textContent = file.name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const preview = document.getElementById('image-preview');
                            preview.src = e.target.result;
                            preview.classList.remove('hidden');
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }

            function checkAnswer() {
                if (!currentQuestion) return showCustomAlert("請先選擇一個單元！", "error");
                if (quizTimeRemaining <= 0) return showCustomAlert("時間已到，無法提交答案！", "error");
                let isCorrect = false;
                let userAnswer;
                switch (currentQuestion.type) {
                    case 'short_answer':
                        if (document.getElementById('submission-input-short').value.trim()) showCustomAlert("您的簡答已提交！", "success");
                        else showCustomAlert("請輸入您的答案！", "error");
                        return;
                    case 'multiple_choice':
                        const selectedOption = document.querySelector('input[name="mc-option"]:checked');
                        if (selectedOption) {
                            isCorrect = (parseInt(selectedOption.value, 10) === currentQuestion.correctAnswer);
                        } else return showCustomAlert("請選擇一個選項！", "error");
                        break;
                    case 'fill_in_blank':
                        userAnswer = document.getElementById('fill-in-blank-input').value.trim();
                        if(userAnswer) isCorrect = (userAnswer.toLowerCase() === currentQuestion.correctAnswer.toLowerCase());
                        else return showCustomAlert("請填寫答案！", "error");
                        break;
                    case 'image_upload':
                        if (document.getElementById('submission-input-image').files.length > 0) {
                            showCustomAlert("圖片已提交，模擬分析中...", "info");
                            setTimeout(() => {
                                const randomSuccess = Math.random() > 0.5;
                                showCustomAlert(randomSuccess ? "分析完成：操作正確！" : "分析完成：操作有誤！", randomSuccess ? "success" : "error");
                            }, 1500);
                        } else showCustomAlert("請選擇要上傳的圖片！", "error");
                        return;
                }
                showCustomAlert(isCorrect ? "恭喜你，答對了！" : "可惜，答錯了，再試一次吧！", isCorrect ? "success" : "error");
            }

            function showCustomAlert(message, type) {
                const alertBox = document.getElementById('custom-alert');
                alertBox.textContent = message;
                alertBox.className = type;
                alertBox.classList.add('show');
                setTimeout(() => alertBox.classList.remove('show'), 3000);
            }

            function startQuizTimer(duration) {
                clearInterval(quizCountdownInterval);
                quizTimeRemaining = duration;
                const timerDisplay = document.getElementById('countdown-timer-display');
                timerDisplay.textContent = formatTime(quizTimeRemaining);
                quizCountdownInterval = setInterval(() => {
                    quizTimeRemaining--;
                    timerDisplay.textContent = formatTime(quizTimeRemaining);
                    if (quizTimeRemaining <= 0) {
                        clearInterval(quizCountdownInterval);
                        timerDisplay.textContent = "時間到！";
                        showCustomAlert("時間到，無法再作答！", "error");
                        document.getElementById('submit-answer-button').disabled = true;
                    }
                }, 1000);
            }

            function formatTime(seconds) {
                if (seconds < 0) seconds = 0;
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = seconds % 60;
                return `${String(minutes).padStart(2, '0')}:${String(remainingSeconds).padStart(2, '0')}`;
            }

            // NEW: 虛擬機相關邏輯
            const vmOffState = document.getElementById('vm-off-state');
            const vmOnState = document.getElementById('vm-on-state');
            const startMachineButton = document.getElementById('start-machine-button');
            const terminateMachineButton = document.getElementById('terminate-machine-button');
            const addHourButton = document.getElementById('add-hour-button');
            const copyIpButton = document.getElementById('copy-ip-button');
            const targetIpDisplay = document.getElementById('target-ip');

            startMachineButton.addEventListener('click', () => {
                vmOffState.classList.add('hidden');
                vmOnState.classList.remove('hidden');
                // 生成隨機 IP
                const randomIp = `10.10.${Math.floor(Math.random() * 255)}.${Math.floor(Math.random() * 255)}`;
                targetIpDisplay.textContent = randomIp;
                startMachineTimer(3600); // 啟動1小時倒數
            });

            terminateMachineButton.addEventListener('click', () => {
                vmOnState.classList.add('hidden');
                vmOffState.classList.remove('hidden');
                clearInterval(machineCountdownInterval); // 停止計時
                document.getElementById('machine-countdown').textContent = '--:--';
            });

            addHourButton.addEventListener('click', () => {
                machineTimeRemaining += 3600;
                showCustomAlert("已成功延長一小時！", "success");
            });
            
            copyIpButton.addEventListener('click', () => {
                navigator.clipboard.writeText(targetIpDisplay.textContent).then(() => {
                    showCustomAlert("IP 位址已複製！", "success");
                }, () => {
                    showCustomAlert("複製失敗！", "error");
                });
            });

            function startMachineTimer(duration) {
                clearInterval(machineCountdownInterval);
                machineTimeRemaining = duration;
                const timerDisplay = document.getElementById('machine-countdown');
                
                const update = () => {
                    const hours = Math.floor(machineTimeRemaining / 3600);
                    const minutes = Math.floor((machineTimeRemaining % 3600) / 60);
                    const seconds = machineTimeRemaining % 60;
                    timerDisplay.textContent = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                };

                update(); // 立即更新一次

                machineCountdownInterval = setInterval(() => {
                    machineTimeRemaining--;
                    update();
                    if (machineTimeRemaining <= 0) {
                        clearInterval(machineCountdownInterval);
                        showCustomAlert("靶機時間已到期並自動終止！", "error");
                        terminateMachineButton.click();
                    }
                }, 1000);
            }
        });
    </script>
</body>
</html>
