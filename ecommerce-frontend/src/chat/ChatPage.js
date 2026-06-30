import React, { useState } from "react";
import api from "../api";

const ChatPage = () => {
  const [input, setInput] = useState("");
  const [messages, setMessages] = useState([]);
  const [loading, setLoading] = useState(false);

  const sendMessage = async () => {
    if (!input.trim()) return;

    const userMsg = { role: "user", text: input };
    setMessages((prev) => [...prev, userMsg]);

    setInput("");
    setLoading(true);

    try {
      const res = await api.post("/chat", {
        message: userMsg.text,
      });

      const botMsg = {
        role: "bot",
        text: res.data.answer || "پاسخی دریافت نشد",
      };

      setMessages((prev) => [...prev, botMsg]);
    } catch (error) {
      setMessages((prev) => [
        ...prev,
        { role: "bot", text: "خطا در ارتباط با سرور" },
      ]);
    }

    setLoading(false);
  };

  return (
    <div style={{ padding: 20, maxWidth: 600, margin: "auto" }}>
      <h2>💬 چت هوشمند</h2>

      <div style={{ minHeight: 300, marginBottom: 20 }}>
        {messages.map((msg, i) => (
          <div
            key={i}
            style={{
              textAlign: msg.role === "user" ? "right" : "left",
              margin: "10px 0",
              padding: 10,
              background: msg.role === "user" ? "#d1e7ff" : "#eee",
              borderRadius: 10,
            }}
          >
            {msg.text}
          </div>
        ))}

        {loading && <p>⏳ در حال پاسخ...</p>}
      </div>

      <div style={{ display: "flex", gap: 10 }}>
        <input
          value={input}
          onChange={(e) => setInput(e.target.value)}
          placeholder="سوال بپرس..."
          style={{
            flex: 1,
            padding: 10,
            borderRadius: 8,
            border: "1px solid #ccc",
          }}
        />

        <button onClick={sendMessage}>
          ارسال
        </button>
      </div>
    </div>
  );
};

export default ChatPage;