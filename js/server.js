// server.js
const express = require('express');
const axios = require('axios');
const cors = require('cors');
require('dotenv').config(); // 用於安全地加載環境變數

const app = express();
const port = process.env.PORT || 3000; // 從環境變數獲取埠號，默認為 3000

// 允許來自你的前端網域的跨域請求
// 如果你的前端網頁運行在 http://localhost:8000 (例如，使用 Live Server)，請將 origin 設定為該網域
const corsOptions = {
  origin: 'http://localhost:5500', // 請替換為你前端網頁實際運行的網域
  optionsSuccessStatus: 200 // For legacy browser support
};
app.use(cors(corsOptions)); // 啟用 CORS

app.use(express.json()); // 啟用解析 JSON 請求體

// AI 助理的 API 路由
app.post('/api/gemini-chat', async (req, res) => {
    try {
        const aiAssistantChatHistory = req.body.contents;
        // 從環境變數中獲取 API 金鑰，確保安全
        const apiKey = process.env.GEMINI_API_KEY; 
        if (!apiKey) {
            console.error("GEMINI_API_KEY is not set in environment variables.");
            return res.status(500).json({ error: "伺服器配置錯誤：API 金鑰缺失" });
        }

        const apiUrl = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${apiKey}`;

        const response = await axios.post(apiUrl, {
            contents: aiAssistantChatHistory
        });

        res.json(response.data); // 將 Gemini API 的回應轉發給前端
    } catch (error) {
        console.error('呼叫 Gemini API 失敗:', error.response ? error.response.data : error.message);
        res.status(500).json({ 
            error: '無法從 AI 助理獲取回應', 
            details: error.response ? error.response.data : error.message 
        });
    }
});

app.listen(port, () => {
    console.log(`後端伺服器運行在 http://localhost:${port}`);
});
