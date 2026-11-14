<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قريباً — CRM</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f172a;
            font-family: 'Segoe UI', system-ui, sans-serif;
            color: #f1f5f9;
        }

        .container {
            text-align: center;
            padding: 2rem;
        }

        .badge {
            display: inline-block;
            background: #1e3a5f;
            color: #60a5fa;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            padding: 0.35rem 1rem;
            border-radius: 999px;
            margin-bottom: 2rem;
            border: 1px solid #1d4ed8;
        }

        h1 {
            font-size: clamp(2.5rem, 6vw, 4rem);
            font-weight: 700;
            background: linear-gradient(135deg, #60a5fa, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        p {
            color: #94a3b8;
            font-size: 1.1rem;
            max-width: 400px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .dots {
            margin-top: 3rem;
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #3b82f6;
            animation: pulse 1.5s ease-in-out infinite;
        }

        .dot:nth-child(2) { animation-delay: 0.3s; }
        .dot:nth-child(3) { animation-delay: 0.6s; }

        @keyframes pulse {
            0%, 100% { opacity: 0.3; transform: scale(0.8); }
            50% { opacity: 1; transform: scale(1.2); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="badge">CRM PLATFORM</div>
        <h1>قريباً</h1>
        <p>نعمل على بناء منصة CRM متكاملة لإدارة علاقات عملائك بكل سهولة واحترافية.</p>
        <div class="dots">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>
</body>
</html>
