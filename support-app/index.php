<?php include 'db.php'; 
$res = $conn->query("SELECT * FROM settings WHERE id=1");
$settings = $res->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: sans-serif; margin: 0; background: #f4f7f6; }
        header { 
            background: #fff; padding: 15px; display: flex; align-items: center; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); gap: 10px;
        }
        header img { height: 40px; }
        header h1 { font-size: 22px; margin: 0; font-weight: bold; }
        
        /* Floating Buttons */
        .fab-container { position: fixed; bottom: 20px; right: 20px; display: flex; flex-direction: column; gap: 10px; }
        .fab { width: 55px; height: 55px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; font-size: 24px; box-shadow: 0 4px 10px rgba(0,0,0,0.3); }
        .whatsapp { background: #25D366; } .telegram { background: #0088cc; } .live-chat { background: #007bff; cursor: pointer; }

        /* Chat Window */
        #chat-window { display: none; position: fixed; bottom: 90px; right: 20px; width: 320px; height: 450px; background: white; border-radius: 12px; box-shadow: 0 5px 25px rgba(0,0,0,0.2); flex-direction: column; overflow: hidden; }
        .chat-header { background: #007bff; color: white; padding: 15px; font-weight: bold; }
        #messages { flex: 1; padding: 15px; overflow-y: auto; background: #f9f9f9; display: flex; flex-direction: column; gap: 8px; }
        .msg { padding: 8px 12px; border-radius: 15px; max-width: 75%; font-size: 14px; }
        .user { align-self: flex-end; background: #007bff; color: white; }
        .admin { align-self: flex-start; background: #e4e6eb; color: black; }
        .chat-input { display: flex; padding: 10px; border-top: 1px solid #eee; }
        .chat-input input { flex: 1; border: 1px solid #ddd; padding: 8px; border-radius: 20px; outline: none; }
    </style>
</head>
<body>

<header>
    <?php if($settings['logo_path']): ?>
        <img src="uploads/<?php echo $settings['logo_path']; ?>" alt="Logo">
    <?php endif; ?>
    <h1><?php echo $settings['company_name']; ?></h1>
</header>

<div class="fab-container">
    <a href="https://wa.me/<?php echo $settings['whatsapp']; ?>" class="fab whatsapp"><i class="fab fa-whatsapp"></i></a>
    <a href="https://t.me/<?php echo $settings['telegram']; ?>" class="fab telegram"><i class="fab fa-telegram-plane"></i></a>
    <div class="fab live-chat" onclick="toggleChat()"><i class="fas fa-comment-dots"></i></div>
</div>

<div id="chat-window">
    <div class="chat-header">Support Chat <span style="float:right; cursor:pointer" onclick="toggleChat()">×</span></div>
    <div id="messages"></div>
    <div class="chat-input">
        <input type="text" id="userInput" placeholder="Type a message...">
        <button onclick="sendMsg()" style="border:none; background:none; color:#007bff; font-weight:bold; margin-left:5px;">Send</button>
    </div>
</div>

<script>
    function toggleChat() { 
        const win = document.getElementById('chat-window');
        win.style.display = (win.style.display === 'flex') ? 'none' : 'flex';
    }
    function load() {
        fetch('api.php?action=get').then(r => r.json()).then(data => {
            let h = '';
            data.forEach(m => h += `<div class="msg ${m.sender}">${m.message}</div>`);
            document.getElementById('messages').innerHTML = h;
            const msgDiv = document.getElementById('messages');
            msgDiv.scrollTop = msgDiv.scrollHeight;
        });
    }
    function sendMsg() {
        let text = document.getElementById('userInput').value;
        if(!text) return;
        fetch(`api.php?action=send&sender=user&msg=${encodeURIComponent(text)}`).then(() => {
            document.getElementById('userInput').value = '';
            load();
        });
    }
    setInterval(load, 2000);
    load();
</script>
</body>
</html>