<?php include 'db.php'; 

if(isset($_POST['update_branding'])) {
    $c_name = $_POST['company_name'];
    $wa = $_POST['whatsapp'];
    $tg = $_POST['telegram'];
    
    if(!empty($_FILES['logo']['name'])) {
        $target = "uploads/" . basename($_FILES['logo']['name']);
        move_uploaded_file($_FILES['logo']['tmp_name'], $target);
        $conn->query("UPDATE settings SET logo_path='".$_FILES['logo']['name']."' WHERE id=1");
    }
    
    $conn->query("UPDATE settings SET company_name='$c_name', whatsapp='$wa', telegram='$tg' WHERE id=1");
    echo "<p style='color:green'>Settings Updated!</p>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body { font-family: sans-serif; display: flex; padding: 30px; gap: 40px; background: #f0f2f5; }
        .card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 350px; }
        input { width: 90%; padding: 8px; margin: 10px 0; }
        #chat-admin { flex: 1; background: white; border-radius: 10px; display: flex; flex-direction: column; height: 600px; }
        #log { flex: 1; overflow-y: auto; padding: 20px; }
    </style>
</head>
<body>

<div class="card">
    <h2>Branding & Links</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Company Name (Bold Header):</label>
        <input type="text" name="company_name" required>
        <label>Upload Logo:</label>
        <input type="file" name="logo">
        <hr>
        <label>WhatsApp Number:</label>
        <input type="text" name="whatsapp">
        <label>Telegram Username:</label>
        <input type="text" name="telegram">
        <button type="submit" name="update_branding" style="width:100%; padding:10px; background:#28a745; color:white; border:none; cursor:pointer;">Save Changes</button>
    </form>
</div>

<div id="chat-admin">
    <h2 style="padding:10px;">Live Chat Support</h2>
    <div id="log"></div>
    <div style="padding:20px; border-top: 1px solid #eee;">
        <input type="text" id="adminIn" placeholder="Type reply...">
        <button onclick="reply()" style="padding:10px 20px;">Reply</button>
    </div>
</div>

<script>
    function load() {
        fetch('api.php?action=get').then(r => r.json()).then(data => {
            let h = '';
            data.forEach(m => h += `<div><b>${m.sender.toUpperCase()}:</b> ${m.message}</div>`);
            document.getElementById('log').innerHTML = h;
        });
    }
    function reply() {
        let t = document.getElementById('adminIn').value;
        fetch(`api.php?action=send&sender=admin&msg=${encodeURIComponent(t)}`).then(() => {
            document.getElementById('adminIn').value = '';
            load();
        });
    }
    setInterval(load, 2000);
    load();
</script>
</body>
</html>