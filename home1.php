<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>概念網頁</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: "Inter", sans-serif;
            background-color: #f0f0f0; /* Light background */
        }
        /* Custom color for the main blocks, similar to the concept image */
        .concept-block-bg {
            background-color: #8C9F4E; /* A shade of olive green */
        }
        .loading-spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 4px solid #fff;
            width: 24px;
            height: 24px;
            -webkit-animation: spin 1s linear infinite; /* Safari */
            animation: spin 1s linear infinite;
        }
        /* Safari */
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .chat-message {
            margin-bottom: 8px;
            padding: 6px 10px;
            border-radius: 8px;
            word-wrap: break-word;
        }
        .chat-user {
            background-color: #4A5568; /* Gray-700 for user */
            text-align: right;
            margin-left: auto;
        }
        .chat-ai {
            background-color: #6B7280; /* Gray-600 for AI */
            text-align: left;
            margin-right: auto;
        }

        /* Floating AI Assistant specific styles */
        #floating-ai-assistant {
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 1000; /* Ensure it's above other content */
            transition: all 0.3s ease-in-out;
        }

        #ai-assistant-content {
            display: none; /* Initially hidden */
            width: 300px; /* Fixed width for the chat window */
            max-height: 400px; /* Max height for the chat window */
            overflow: hidden; /* Hide overflow when collapsed */
        }

        #floating-ai-assistant.expanded #ai-assistant-content {
            display: flex; /* Show when expanded */
            flex-direction: column;
        }

        #ai-assistant-toggle-button {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #2563eb; /* Blue-600 */
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: background-color 0.3s ease;
        }

        #ai-assistant-toggle-button:hover {
            background-color: #1d4ed8; /* Blue-700 */
        }

        /* VM specific styles */
        #vm-section #vm-content {
            display: none; /* Initially hidden */
        }
        #vm-section.expanded #vm-toggle-button {
            display: none; /* Hide toggle button when expanded */
        }
        #vm-section.expanded #vm-content {
            display: flex; /* Show content when expanded */
            flex-direction: column; /* Ensure content stacks vertically */
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <header class="bg-gray-800 text-white p-4 shadow-md">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
            <div class="concept-block-bg text-white p-3 rounded-lg w-full md:w-auto text-center md:text-left">
                課程項目選單
            </div>
            <div class="flex-grow text-center text-lg font-semibold">
                資安互動闖關平台
            </div>
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4 w-full md:w-auto">
                <div class="concept-block-bg text-white p-3 rounded-lg text-center flex-grow">
                    倒數計時器
                </div>
                <div class="concept-block-bg text-white p-3 rounded-lg text-center flex-grow">
                    帳戶
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto p-4 flex-grow grid grid-cols-1 lg:grid-cols-2 gap-4">
        <section class="lg:col-span-1 flex flex-col space-y-4">
            <div class="concept-block-bg text-white p-6 rounded-lg shadow-lg flex items-center justify-center min-h-[300px]">
                <h2 class="text-2xl font-bold">課程內容</h2>
            </div>
        </section>

        <section id="vm-section" class="concept-block-bg text-white p-6 rounded-lg shadow-lg flex flex-col items-center justify-center min-h-[200px] lg:min-h-0">
            <div id="vm-toggle-button" class="cursor-pointer p-4 rounded-lg bg-blue-600 hover:bg-blue-700 transition flex flex-col items-center justify-center w-full h-full">
                <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l3 3a1 1 0 001.414-1.414L11 9.586V6z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-lg font-bold mt-2">點擊啟動虛擬機</p>
            </div>

            <div id="vm-content" class="flex-col items-center justify-center w-full h-full">
                <svg class="w-16 h-16 mb-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l3 3a1 1 0 001.414-1.414L11 9.586V6z" clip-rule="evenodd"></path>
                </svg>
                <h2 class="text-2xl font-bold text-center">虛擬機</h2>
                <p class="text-sm mt-2 text-center">您的學習環境已準備就緒！</p>
                <button class="mt-4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg">
                    啟動
                </button>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-white p-4 mt-4 shadow-inner">
        <div class="container mx-auto text-center text-lg font-semibold">
            資安互動闖關
        </div>
    </footer>

    <div id="floating-ai-assistant" class="concept-block-bg text-white p-3 rounded-lg shadow-lg">
        <div id="ai-assistant-toggle-button">
            🤖
        </div>

        <div id="ai-assistant-content" class="mt-2">
            <h2 class="text-xl font-bold mb-2 text-center">AI助理</h2>
            <div id="ai-response" class="flex-grow p-3 bg-gray-700 rounded-md text-sm overflow-y-auto max-h-64 mb-2">
                <div class="chat-message chat-ai">AI的回應將顯示在這裡。</div>
            </div>
            <textarea id="ai-assistant-input" class="w-full p-2 rounded-md text-gray-800 mb-2 h-16 resize-none" placeholder="輸入您的問題..."></textarea>
            <button id="ask-ai-button" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center justify-center">
                <span id="ask-ai-text">✨ 詢問AI助理</span>
                <div id="ask-ai-loading" class="loading-spinner hidden ml-2"></div>
            </button>
        </div>
    </div>

    <script>
        // Global chat history for AI Assistant
        let aiAssistantChatHistory = [];

        // Function to display messages in the AI Assistant chat
        function displayChatMessage(sender, message) {
            const responseElement = document.getElementById('ai-response');
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('chat-message');
            if (sender === 'user') {
                messageDiv.classList.add('chat-user');
            } else {
                messageDiv.classList.add('chat-ai');
            }
            messageDiv.innerText = message;
            responseElement.appendChild(messageDiv);
            // Scroll to the bottom of the chat
            responseElement.scrollTop = responseElement.scrollHeight;
        }

        // AI Assistant functionality
        document.getElementById('ask-ai-button').addEventListener('click', async () => {
            const inputElement = document.getElementById('ai-assistant-input');
            const askAiText = document.getElementById('ask-ai-text');
            const askAiLoading = document.getElementById('ask-ai-loading');

            const prompt = inputElement.value.trim();
            if (!prompt) {
                displayChatMessage('ai', "請輸入您的問題。");
                return;
            }

            // Display user's message
            displayChatMessage('user', prompt);
            inputElement.value = ''; // Clear input

            askAiText.classList.add('hidden');
            askAiLoading.classList.remove('hidden');
            document.getElementById('ask-ai-button').disabled = true;

            // Add user's message to chat history
            aiAssistantChatHistory.push({ role: "user", parts: [{ text: prompt }] });

              try {
                const payload = { contents: aiAssistantChatHistory };
                const apiKey = "AIzaSyCJIr0VOZOwV_A3xM2wPt6TdRVzeRA7MfA"; // Leave this as-is; Canvas will provide the key at runtime.
                const apiUrl = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${apiKey}`;

                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(`API 呼叫失敗: 狀態 ${response.status}, 錯誤: ${JSON.stringify(errorData)}`);
                }

                const result = await response.json();

                if (result.candidates && result.candidates.length > 0 &&
                    result.candidates[0].content && result.candidates[0].content.parts &&
                    result.candidates[0].content.parts.length > 0) {
                    const text = result.candidates[0].content.parts[0].text;
                    displayChatMessage('ai', text);
                    // Add AI's response to chat history
                    aiAssistantChatHistory.push({ role: "model", parts: [{ text: text }] });
                } else {
                    displayChatMessage('ai', "抱歉，AI未能生成回應。");
                    console.error("Unexpected API response structure:", result);
                }
            } catch (error) {
                displayChatMessage('ai', "發生錯誤，請稍後再試。");
                console.error("Error calling AI Assistant via proxy:", error);
            } finally {
                askAiText.classList.remove('hidden');
                askAiLoading.classList.add('hidden');
                document.getElementById('ask-ai-button').disabled = false;
            }
        });

        // Toggle Floating AI Assistant visibility
        document.getElementById('ai-assistant-toggle-button').addEventListener('click', () => {
            const floatingAssistant = document.getElementById('floating-ai-assistant');
            floatingAssistant.classList.toggle('expanded');
        });

        // Toggle VM visibility (in-place)
        document.getElementById('vm-toggle-button').addEventListener('click', () => {
            const vmSection = document.getElementById('vm-section');
            vmSection.classList.add('expanded'); // Add expanded class to show content
        });
    </script>
</body>
</html>
