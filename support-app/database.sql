-- Database Name: support_system

CREATE TABLE IF NOT EXISTS settings (
    id INT PRIMARY KEY,
    whatsapp VARCHAR(20),
    telegram VARCHAR(50),
    company_name VARCHAR(100),
    logo_path VARCHAR(255)
);

INSERT INTO settings (id, whatsapp, telegram, company_name, logo_path) 
VALUES (1, '1234567890', 'your_username', 'My Company', 'logo.png')
ON DUPLICATE KEY UPDATE id=id;

CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender VARCHAR(10),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);