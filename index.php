<?php include 'db.php'; 
// Fetching settings for WhatsApp, Telegram, Company Name, and Logo
$res = $conn->query("SELECT * FROM settings WHERE id=1");
$settings = $res->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Support</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background: #f4f7f6; color: #333; }
        
        /* Header Branding */
        header { 
            background: #ffffff; 
            padding: 15px 20px; 
            display: flex; 
            align-items: center; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
            gap: 15px;
        }
        header img { height: 45px; width: auto; border-radius: 5px; }
        header h1 { font-size: 24px; margin: 0; font-weight: 800; color: #222; text-transform: uppercase; }

        /* Main Content Area */
        .content { padding: 40px 20px; text-align: center; }
        .content p { font-size: 18px; color: #666; }

        /* Support Buttons Container */
        .support-links {
            position: fixed;
            bottom: 30px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            z-index: 1000;
        }

        /* Floating Action Buttons */
        .fab {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 28px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .fab:hover { transform: scale(1.1); box-shadow: 0 6px 20px rgba(0,0,0,0.4); }

        .whatsapp { background: #25D366; }
        .telegram { background: #0088cc; }

        /* Tooltip text labels (optional) */
        .fab::after {
            content: attr(data-label);
            position: absolute;
            right: 75px;
            background: #333;
            color: #fff;
            padding: 5px 12px;
            border-radius: 5px;
            font-size: 13px;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
            white-space: nowrap;
        }
        .fab:hover::after { opacity: 1; }
    </style>
</head>
<body>

<header>
    <?php if(!empty($settings['logo_path'])): ?>
        <img src="uploads/<?php echo $settings['logo_path']; ?>" alt="Company Logo">
    <?php endif; ?>
    <h1><?php echo $settings['company_name']; ?></h1>
</header>

<div class="content">
    <h2>How can we help you?</h2>
    <p>Click on one of the icons below to start a conversation with our support team.</p>
</div>

<!-- Support Buttons -->
<div class="support-links">
    <!-- WhatsApp Link -->
    <a href="https://wa.me/<?php echo $settings['whatsapp']; ?>" 
       class="fab whatsapp" 
       target="_blank" 
       data-label="WhatsApp Us">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Telegram Link -->
    <a href="https://t.me/<?php echo $settings['telegram']; ?>" 
       class="fab telegram" 
       target="_blank" 
       data-label="Telegram Us">
        <i class="fab fa-telegram-plane"></i>
    </a>
</div>

</body>
</html>
