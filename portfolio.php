<?php
$message_sent = false;
$error_message = '';

// Configuration
$contact_email = "mohamedtamerr01@gmail.com"; 
$max_message_length = 5000;
$min_name_length = 2;
$max_name_length = 100;

if ($_POST && isset($_POST['contact_submit'])) {

    session_start();
    $current_time = time();
    $last_submission = isset($_SESSION['last_contact_submission']) ? $_SESSION['last_contact_submission'] : 0;
    
    if ($current_time - $last_submission < 60) { 
        $error_message = "Please wait before sending another message.";
    } else {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $subject = trim($_POST['subject']);
        $message = trim($_POST['message']);
        
        
        if (empty($name) || empty($email) || empty($subject) || empty($message)) {
            $error_message = "Please fill in all fields.";
        } elseif (strlen($name) < $min_name_length || strlen($name) > $max_name_length) {
            $error_message = "Name must be between {$min_name_length} and {$max_name_length} characters.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Please enter a valid email address.";
        } elseif (strlen($subject) < 5 || strlen($subject) > 200) {
            $error_message = "Subject must be between 5 and 200 characters.";
        } elseif (strlen($message) > $max_message_length) {
            $error_message = "Message is too long. Maximum {$max_message_length} characters allowed.";
        } elseif (preg_match('/(http|www|\.com|\.org|\.net)/i', $message)) {
            $error_message = "URLs are not allowed in messages for security reasons.";
        } else {
            
            $name = htmlspecialchars($name);
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $subject = htmlspecialchars($subject);
            $message = htmlspecialchars($message);
            
            
            $to = $contact_email;
            $email_subject = "Portfolio Contact: " . $subject;
            
            
            $email_body = "New contact form submission from your portfolio website:\n\n";
            $email_body .= "==========================================\n";
            $email_body .= "Name: " . $name . "\n";
            $email_body .= "Email: " . $email . "\n";
            $email_body .= "Subject: " . $subject . "\n";
            $email_body .= "Date: " . date('Y-m-d H:i:s') . "\n";
            $email_body .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . "\n";
            $email_body .= "==========================================\n\n";
            $email_body .= "Message:\n" . $message . "\n\n";
            $email_body .= "==========================================\n";
            $email_body .= "This message was sent from your portfolio contact form.";
            
            
            $headers = "From: Portfolio Contact Form <no-reply@yourdomain.com>\r\n";
            $headers .= "Reply-To: " . $email . "\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
            
            
            if (mail($to, $email_subject, $email_body, $headers)) {
                $message_sent = true;
                $_SESSION['last_contact_submission'] = $current_time;
                
                
                $_POST = array();
            } else {
                $error_message = "Sorry, there was an error sending your message. Please try again later or contact me directly at " . $contact_email;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="Mohamed Tamer - Cybersecurity & AI Engineer Portfolio">
    <title>Mohamed Tamer | Cybersecurity & AI Engineer</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <style>
        :root {
            --primary-color: #00ff88;
            --secondary-color: #0066ff;
            --accent-color: #ff0066;
            --bg-dark: #0a0a0a;
            --bg-darker: #050505;
            --text-light: #ffffff;
            --text-gray: #b0b0b0;
            --gradient-cyber: linear-gradient(135deg, #00ff88, #0066ff);
            --gradient-ai: linear-gradient(135deg, #ff0066, #9933ff);
            --gradient-dark: linear-gradient(135deg, #1a1a1a, #2d2d2d);
            --neon-glow: 0 0 20px rgba(0, 255, 136, 0.5);
            --neon-glow-blue: 0 0 20px rgba(0, 102, 255, 0.5);
            --neon-glow-pink: 0 0 20px rgba(255, 0, 102, 0.5);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Rajdhani', sans-serif;
            background: var(--bg-dark);
            color: var(--text-light);
            overflow-x: hidden;
            scroll-behavior: smooth;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        
        html, body {
            max-width: 100vw;
            overflow-x: hidden;
        }

        
        .btn, .nav-link, .social-link, .project-link {
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        
        .cyber-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: var(--bg-darker);
            overflow: hidden;
        }

        .cyber-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(0, 255, 136, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(0, 102, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 0, 102, 0.1) 0%, transparent 50%);
            animation: bgShift 10s ease-in-out infinite alternate;
        }

        @keyframes bgShift {
            0% { transform: scale(1) rotate(0deg); }
            100% { transform: scale(1.1) rotate(2deg); }
        }

        
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: var(--primary-color);
            border-radius: 50%;
            opacity: 0.7;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) translateX(0px); opacity: 0.7; }
            50% { transform: translateY(-20px) translateX(10px); opacity: 1; }
        }
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 20px 0;
            background: rgba(5, 5, 5, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 255, 136, 0.2);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            padding: 15px 0;
            background: rgba(5, 5, 5, 0.98);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-family: 'Orbitron', monospace;
            font-size: 1.8rem;
            font-weight: 900;
            background: var(--gradient-cyber);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 40px;
        }

        .nav-link {
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gradient-cyber);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link:hover {
            color: var(--primary-color);
            text-shadow: var(--neon-glow);
        }

        
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: visible;
            padding: 80px 0 80px;
            margin-top: 0;
        }

        .hero-content {
            text-align: center;
            max-width: 900px;
            padding: 0 50px;
            z-index: 2;
            overflow: visible;
            position: relative;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            background: var(--gradient-cyber);
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--bg-dark);
            margin-bottom: 20px;
            animation: badgePulse 2s ease-in-out infinite;
        }

        @keyframes badgePulse {
            0%, 100% { transform: scale(1); box-shadow: 0 0 20px rgba(0, 255, 136, 0.5); }
            50% { transform: scale(1.05); box-shadow: 0 0 30px rgba(0, 255, 136, 0.8); }
        }


        .profile-picture {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 15px 0;
            position: relative;
            z-index: 3;
            padding: 10px 0;
        }

        .profile-image {
            position: relative;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            overflow: hidden;
            background: var(--gradient-cyber);
            padding: 4px;
            animation: profileFloat 3s ease-in-out infinite;
        }

        .profile-image img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--bg-dark);
            transition: all 0.3s ease;
        }

        .profile-placeholder {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: var(--gradient-dark);
            border: 3px solid var(--bg-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .profile-initials {
            font-family: 'Orbitron', monospace;
            font-size: 3rem;
            font-weight: 900;
            background: var(--gradient-cyber);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 20px rgba(0, 255, 136, 0.5);
        }

        .profile-image:hover .profile-placeholder {
            transform: scale(1.05);
            box-shadow: inset 0 0 30px rgba(0, 255, 136, 0.2);
        }

        .profile-image:hover .profile-initials {
            text-shadow: 0 0 30px rgba(0, 255, 136, 0.8);
        }

        .profile-image:hover img {
            transform: scale(1.05);
        }

        @keyframes profileFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }

        .hero-title {
            font-family: 'Orbitron', monospace;
            font-size: 4rem;
            font-weight: 900;
            margin-bottom: 15px;
            background: var(--gradient-cyber);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 30px rgba(0, 255, 136, 0.5);
            animation: titleGlow 2s ease-in-out infinite alternate;
        }

        @keyframes titleGlow {
            0% { text-shadow: 0 0 30px rgba(0, 255, 136, 0.5); }
            100% { text-shadow: 0 0 50px rgba(0, 255, 136, 0.8); }
        }

        .hero-subtitle {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: var(--text-gray);
            font-weight: 400;
        }

        .value-proposition {
            font-size: 1.3rem;
            margin-bottom: 30px;
            padding: 15px 25px;
            background: rgba(255, 0, 102, 0.1);
            border: 1px solid rgba(255, 0, 102, 0.3);
            border-radius: 10px;
            display: inline-block;
        }

        .highlight {
            color: var(--accent-color);
            font-weight: 700;
            text-shadow: 0 0 10px rgba(255, 0, 102, 0.5);
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin: 30px 0;
            flex-wrap: wrap;
        }

        .hero-stat {
            text-align: center;
            padding: 20px;
            background: var(--gradient-dark);
            border-radius: 15px;
            border: 1px solid rgba(0, 255, 136, 0.2);
            min-width: 120px;
            transition: all 0.3s ease;
        }

        .hero-stat:hover {
            transform: translateY(-5px);
            box-shadow: var(--neon-glow);
        }

        .stat-value {
            display: block;
            font-family: 'Orbitron', monospace;
            font-size: 2rem;
            font-weight: 900;
            color: var(--primary-color);
            line-height: 1;
        }

        .stat-desc {
            font-size: 0.9rem;
            color: var(--text-gray);
            margin-top: 5px;
        }

        .typing-text {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 30px;
            min-height: 60px;
        }

        .cyber-text {
            color: var(--primary-color);
            text-shadow: var(--neon-glow);
        }

        .ai-text {
            background: var(--gradient-ai);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .cta-buttons {
            display: flex;
            gap: 25px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .trust-indicators {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .trust-item {
            color: var(--primary-color);
            font-size: 1rem;
            font-weight: 500;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: var(--gradient-cyber);
            color: var(--bg-dark);
            box-shadow: var(--neon-glow);
            position: relative;
        }

        .btn-secondary {
            background: transparent;
            color: var(--text-light);
            border: 2px solid var(--primary-color);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 255, 136, 0.3);
        }

        .btn-secondary:hover {
            background: var(--gradient-cyber);
            color: var(--bg-dark);
        }

        .btn-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--accent-color);
            color: white;
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 20px;
            font-weight: 700;
        }

        .pulse-effect {
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { box-shadow: var(--neon-glow); }
            50% { box-shadow: 0 0 30px rgba(0, 255, 136, 0.8), 0 0 60px rgba(0, 255, 136, 0.4); }
        }

        /* Section Styles */
        .section {
            padding: 100px 0;
            position: relative;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 50px;
        }

        .section-title {
            font-family: 'Orbitron', monospace;
            font-size: 3rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 60px;
            background: var(--gradient-cyber);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* About Section */
        .value-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 80px;
        }

        .value-card {
            background: var(--gradient-dark);
            padding: 40px 30px;
            border-radius: 20px;
            border: 1px solid rgba(0, 255, 136, 0.2);
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .value-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--gradient-cyber);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .value-card:hover::before {
            transform: scaleX(1);
        }

        .value-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary-color);
            box-shadow: var(--neon-glow);
        }

        .value-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-cyber);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: var(--bg-dark);
        }

        .value-card h3 {
            font-family: 'Orbitron', monospace;
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .value-stat {
            font-family: 'Orbitron', monospace;
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--accent-color);
            margin-bottom: 15px;
            text-shadow: 0 0 10px rgba(255, 0, 102, 0.5);
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: start;
        }

        .about-content h3 {
            font-size: 2.2rem;
            margin-bottom: 25px;
            color: var(--primary-color);
            font-family: 'Orbitron', monospace;
        }

        .lead-text {
            font-size: 1.3rem;
            line-height: 1.6;
            color: var(--text-light);
            margin-bottom: 30px;
            font-weight: 500;
        }

        .business-benefits {
            margin: 30px 0;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(0, 255, 136, 0.05);
            border-radius: 10px;
            border-left: 3px solid var(--primary-color);
            font-size: 1.1rem;
        }

        .benefit-item i {
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .credentials {
            margin-top: 40px;
        }

        .credentials h4 {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-size: 1.2rem;
        }

        .cert-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .cert-badge {
            padding: 8px 15px;
            background: var(--gradient-ai);
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            color: white;
        }

        .about-content p {
            font-size: 1.2rem;
            line-height: 1.8;
            color: var(--text-gray);
            margin-bottom: 20px;
        }

        .cyber-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 25px;
            margin-top: 40px;
        }

        .stat-item {
            text-align: center;
            padding: 25px 20px;
            background: var(--gradient-dark);
            border-radius: 15px;
            border: 1px solid rgba(0, 255, 136, 0.2);
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            border-color: var(--primary-color);
            box-shadow: var(--neon-glow);
            transform: translateY(-5px);
        }

        .stat-number {
            font-family: 'Orbitron', monospace;
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--primary-color);
            display: block;
            line-height: 1;
        }

        .stat-label {
            font-size: 1rem;
            color: var(--text-gray);
            margin-top: 10px;
        }

        .testimonial-preview {
            grid-column: span 2;
            background: var(--gradient-ai);
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            margin-top: 20px;
        }

        .testimonial-text {
            font-style: italic;
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: white;
        }

        .testimonial-author {
            font-weight: 600;
            color: rgba(255, 255, 255, 0.8);
        }

        /* Skills Section */
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
        }

        .skill-category {
            background: var(--gradient-dark);
            padding: 40px;
            border-radius: 20px;
            border: 1px solid rgba(0, 255, 136, 0.2);
            transition: all 0.3s ease;
        }

        .skill-category:hover {
            border-color: var(--primary-color);
            box-shadow: var(--neon-glow);
            transform: translateY(-10px);
        }

        .skill-category h3 {
            font-family: 'Orbitron', monospace;
            font-size: 1.5rem;
            margin-bottom: 30px;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .skill-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(0, 255, 136, 0.05);
            border-radius: 10px;
            border-left: 3px solid var(--primary-color);
        }

        .skill-name {
            font-size: 1.1rem;
            font-weight: 500;
        }

        .skill-level {
            font-family: 'Orbitron', monospace;
            font-weight: 700;
            color: var(--primary-color);
        }

        /* Projects Section */
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 40px;
        }

        .project-card {
            background: var(--gradient-dark);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(0, 255, 136, 0.2);
            transition: all 0.3s ease;
            position: relative;
        }

        .featured-project {
            border: 2px solid var(--accent-color);
            box-shadow: 0 0 30px rgba(255, 0, 102, 0.3);
        }

        .project-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--gradient-ai);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            z-index: 2;
        }

        .project-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-cyber);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .project-card:hover::before {
            transform: scaleX(1);
        }

        .project-card:hover {
            border-color: var(--primary-color);
            box-shadow: var(--neon-glow);
            transform: translateY(-10px);
        }

        .project-image {
            height: 250px;
            background: var(--gradient-cyber);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: var(--bg-dark);
            position: relative;
            overflow: hidden;
        }

        .project-content {
            padding: 30px;
        }

        .project-title {
            font-family: 'Orbitron', monospace;
            font-size: 1.4rem;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .project-impact {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .impact-item {
            background: rgba(0, 255, 136, 0.1);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid rgba(0, 255, 136, 0.2);
        }

        .impact-value {
            display: block;
            font-family: 'Orbitron', monospace;
            font-size: 1.8rem;
            font-weight: 900;
            color: var(--accent-color);
            line-height: 1;
        }

        .impact-label {
            font-size: 0.9rem;
            color: var(--text-gray);
            margin-top: 5px;
        }

        .project-description {
            color: var(--text-gray);
            line-height: 1.6;
            margin-bottom: 25px;
            font-size: 1.1rem;
        }

        .business-results {
            margin-bottom: 25px;
        }

        .result-item {
            color: var(--primary-color);
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .project-tech {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 25px;
        }

        .tech-tag {
            padding: 6px 15px;
            background: rgba(0, 255, 136, 0.1);
            border: 1px solid rgba(0, 255, 136, 0.3);
            border-radius: 20px;
            font-size: 0.9rem;
            color: var(--primary-color);
        }

        .tech-tag.premium {
            background: var(--gradient-ai);
            border: 1px solid var(--accent-color);
            color: white;
        }

        .project-links {
            display: flex;
            gap: 15px;
        }

        .project-link {
            padding: 12px 25px;
            background: transparent;
            border: 1px solid var(--primary-color);
            border-radius: 25px;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .project-link:hover {
            background: var(--primary-color);
            color: var(--bg-dark);
        }

        .project-link.primary {
            background: var(--gradient-cyber);
            color: var(--bg-dark);
            border-color: transparent;
        }

        .project-link.primary:hover {
            background: var(--gradient-ai);
        }

        /* Contact Section */
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: start;
        }

        .contact-info h3 {
            font-family: 'Orbitron', monospace;
            font-size: 2rem;
            margin-bottom: 30px;
            color: var(--primary-color);
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            padding: 20px;
            background: var(--gradient-dark);
            border-radius: 15px;
            border: 1px solid rgba(0, 255, 136, 0.2);
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            border-color: var(--primary-color);
            box-shadow: var(--neon-glow);
        }

        .contact-icon {
            font-size: 1.5rem;
            color: var(--primary-color);
            width: 40px;
            text-align: center;
        }

        .contact-form {
            background: var(--gradient-dark);
            padding: 40px;
            border-radius: 20px;
            border: 1px solid rgba(0, 255, 136, 0.2);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-input {
            width: 100%;
            padding: 15px;
            background: rgba(0, 255, 136, 0.05);
            border: 1px solid rgba(0, 255, 136, 0.3);
            border-radius: 10px;
            color: var(--text-light);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 255, 136, 0.1);
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        /* Footer */
        .footer {
            background: var(--bg-darker);
            padding: 50px 0;
            border-top: 1px solid rgba(0, 255, 136, 0.2);
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 30px;
        }

        .social-links {
            display: flex;
            gap: 20px;
        }

        .social-link {
            width: 50px;
            height: 50px;
            background: var(--gradient-dark);
            border: 1px solid rgba(0, 255, 136, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 1.2rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            border-color: var(--primary-color);
            box-shadow: var(--neon-glow);
            transform: translateY(-3px);
        }

        /* Custom Codeforces Icon */
        .codeforces-icon {
            font-family: 'Orbitron', monospace;
            font-weight: 900;
            font-size: 1rem;
            background: linear-gradient(135deg, #1f8ac0, #4fc3f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 10px rgba(31, 138, 192, 0.5);
            letter-spacing: -1px;
            transition: all 0.3s ease;
        }

        .social-link:hover .codeforces-icon {
            background: linear-gradient(135deg, #00ff88, #4fc3f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 15px rgba(0, 255, 136, 0.8);
            transform: scale(1.1);
        }

        /* Responsive Design - Mobile First Approach */
        @media (max-width: 1200px) {
            .container {
                padding: 0 30px;
            }
            
            .projects-grid {
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                gap: 30px;
            }
        }

        @media (max-width: 768px) {
            /* Navigation */
            .navbar {
                padding: 12px 0;
                position: fixed;
                backdrop-filter: blur(15px);
            }
            
            .nav-container {
                padding: 0 20px;
                flex-direction: column;
                gap: 12px;
            }

            .nav-menu {
                gap: 15px;
                justify-content: center;
                flex-wrap: wrap;
            }

            .nav-link {
                font-size: 0.95rem;
                padding: 8px 12px;
            }

            /* Hero Section */
            .hero {
                padding: 80px 0 40px;
                min-height: 90vh;
            }

            .hero-content {
                padding: 0 20px;
                max-width: 100%;
            }

            .hero-badge {
                padding: 8px 15px;
                font-size: 0.8rem;
                margin-bottom: 15px;
            }

            .profile-image {
                width: 140px;
                height: 140px;
                padding: 3px;
            }

            .profile-initials {
                font-size: 2rem;
            }

            .hero-title {
                font-size: 2.2rem;
                line-height: 1.1;
                margin-bottom: 10px;
            }

            .hero-subtitle {
                font-size: 1.1rem;
                margin-bottom: 15px;
            }

            .value-proposition {
                font-size: 1rem;
                padding: 10px 18px;
                margin-bottom: 20px;
                text-align: center;
            }

            .typing-text {
                font-size: 1.2rem;
                margin-bottom: 25px;
                min-height: 45px;
                text-align: center;
            }

            .hero-stats {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 12px;
                margin: 25px auto;
                max-width: 350px;
            }

            .hero-stat {
                padding: 12px 8px;
                min-width: auto;
            }

            .stat-value {
                font-size: 1.4rem;
            }

            .stat-desc {
                font-size: 0.7rem;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
                gap: 12px;
                margin: 25px 0;
            }

            .btn {
                width: 90%;
                max-width: 280px;
                padding: 12px 20px;
                font-size: 1rem;
            }

            .trust-indicators {
                flex-direction: column;
                gap: 8px;
                text-align: center;
                margin-top: 20px;
            }

            .trust-item {
                font-size: 0.9rem;
            }

            /* Sections */
            .section {
                padding: 50px 0;
            }

            .container {
                padding: 0 20px;
            }

            .section-title {
                font-size: 2rem;
                margin-bottom: 30px;
                text-align: center;
            }

            /* About Section */
            .value-grid {
                grid-template-columns: 1fr;
                gap: 20px;
                margin-bottom: 40px;
            }

            .value-card {
                padding: 25px 20px;
                text-align: center;
            }

            .value-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
                margin: 0 auto 15px;
            }

            .value-card h3 {
                font-size: 1.3rem;
                margin-bottom: 10px;
            }

            .value-stat {
                font-size: 1.8rem;
                margin-bottom: 12px;
            }

            .about-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .about-content h3 {
                font-size: 1.8rem;
                margin-bottom: 20px;
                text-align: center;
            }

            .lead-text {
                font-size: 1.1rem;
                text-align: center;
                margin-bottom: 25px;
            }

            .business-benefits {
                margin: 25px 0;
            }

            .benefit-item {
                padding: 12px;
                font-size: 0.95rem;
                margin-bottom: 12px;
                flex-direction: column;
                text-align: center;
                gap: 8px;
            }

            .cyber-stats {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .testimonial-preview {
                grid-column: span 2;
                padding: 20px;
                margin-top: 20px;
            }

            /* Skills Section */
            .skills-grid {
                grid-template-columns: 1fr;
                gap: 25px;
            }

            .skill-category {
                padding: 25px 20px;
            }

            .skill-category h3 {
                font-size: 1.3rem;
                margin-bottom: 20px;
                justify-content: center;
            }

            .skill-item {
                padding: 12px;
                flex-direction: column;
                text-align: center;
                gap: 5px;
                margin-bottom: 12px;
            }

            /* Projects Section */
            .projects-grid {
                grid-template-columns: 1fr;
                gap: 25px;
            }

            .project-card {
                margin-bottom: 20px;
            }

            .project-content {
                padding: 20px;
            }

            .project-title {
                font-size: 1.2rem;
                margin-bottom: 15px;
                text-align: center;
            }

            .project-impact {
                grid-template-columns: 1fr;
                gap: 10px;
                margin-bottom: 15px;
            }

            .project-description {
                font-size: 0.95rem;
                line-height: 1.5;
                margin-bottom: 15px;
                text-align: center;
            }

            .project-tech {
                gap: 8px;
                margin-bottom: 20px;
                justify-content: center;
            }

            .tech-tag {
                padding: 5px 10px;
                font-size: 0.8rem;
            }

            .project-links {
                gap: 10px;
                flex-direction: column;
            }

            .project-link {
                padding: 10px 20px;
                font-size: 0.9rem;
                text-align: center;
            }

            /* Contact Section */
            .contact-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .contact-info h3 {
                font-size: 1.6rem;
                margin-bottom: 20px;
                text-align: center;
            }

            .contact-item {
                padding: 15px;
                flex-direction: row;
                text-align: left;
                gap: 15px;
                align-items: flex-start;
            }

            .contact-form {
                padding: 25px 20px;
            }

            .form-input {
                padding: 14px;
                font-size: 16px; /* Prevents zoom on iOS */
            }

            .form-group {
                margin-bottom: 20px;
            }

            /* Footer */
            .footer {
                padding: 30px 0;
            }

            .footer-content {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .social-links {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            /* Navigation */
            .nav-container {
                padding: 0 15px;
            }

            .navbar {
                padding: 10px 0;
            }

            .nav-menu {
                gap: 12px;
            }

            .nav-link {
                font-size: 0.9rem;
                padding: 6px 10px;
            }

            /* Hero Section */
            .hero {
                padding: 70px 0 30px;
                min-height: 85vh;
            }

            .hero-content {
                padding: 0 15px;
            }

            .hero-badge {
                padding: 6px 12px;
                font-size: 0.75rem;
                margin-bottom: 12px;
            }

            .hero-badge span {
                display: none;
            }

            .hero-badge::after {
                content: "Cybersecurity & AI";
            }

            .profile-image {
                width: 120px;
                height: 120px;
                padding: 2px;
            }

            .profile-initials {
                font-size: 2rem;
            }

            .hero-title {
                font-size: 1.8rem;
                margin-bottom: 8px;
            }

            .hero-subtitle {
                font-size: 0.9rem;
                margin-bottom: 12px;
            }

            .value-proposition {
                font-size: 0.9rem;
                padding: 8px 15px;
                margin-bottom: 15px;
            }

            .typing-text {
                font-size: 1rem;
                margin-bottom: 20px;
                min-height: 35px;
            }

            .hero-stats {
                grid-template-columns: 1fr;
                gap: 10px;
                max-width: 220px;
                margin: 20px auto;
            }

            .hero-stat {
                padding: 10px;
            }

            .stat-value {
                font-size: 1.2rem;
            }

            .stat-desc {
                font-size: 0.65rem;
            }

            .cta-buttons {
                gap: 10px;
                margin: 20px 0;
            }

            .btn {
                width: 95%;
                max-width: 250px;
                padding: 10px 18px;
                font-size: 0.9rem;
            }

            .trust-indicators {
                gap: 6px;
                margin-top: 15px;
            }

            .trust-item {
                font-size: 0.8rem;
            }

            /* Sections */
            .section {
                padding: 40px 0;
            }

            .container {
                padding: 0 15px;
            }

            .section-title {
                font-size: 1.6rem;
                margin-bottom: 25px;
            }

            /* About Section */
            .value-card {
                padding: 20px 15px;
            }

            .value-icon {
                width: 50px;
                height: 50px;
                font-size: 1.3rem;
                margin-bottom: 12px;
            }

            .value-card h3 {
                font-size: 1.1rem;
                margin-bottom: 8px;
            }

            .value-stat {
                font-size: 1.5rem;
                margin-bottom: 10px;
            }

            .about-content h3 {
                font-size: 1.5rem;
                margin-bottom: 15px;
            }

            .lead-text {
                font-size: 1rem;
                margin-bottom: 20px;
            }

            .business-benefits {
                margin: 25px 0;
            }

            .benefit-item {
                padding: 10px;
                font-size: 0.9rem;
                margin-bottom: 10px;
            }

            .cyber-stats {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .stat-item {
                padding: 12px;
            }

            .stat-number {
                font-size: 1.6rem;
            }

            .stat-label {
                font-size: 0.8rem;
            }

            .testimonial-preview {
                grid-column: span 1;
                padding: 15px;
                margin-top: 15px;
            }

            .testimonial-text {
                font-size: 0.9rem;
                margin-bottom: 8px;
            }

            .testimonial-author {
                font-size: 0.8rem;
            }

            /* Skills Section */
            .skill-category {
                padding: 20px 15px;
            }

            .skill-category h3 {
                font-size: 1.1rem;
                margin-bottom: 15px;
            }

            .skill-item {
                padding: 10px;
                margin-bottom: 10px;
            }

            .skill-name {
                font-size: 0.9rem;
            }

            .skill-level {
                font-size: 0.8rem;
            }

            /* Projects Section */
            .project-content {
                padding: 15px;
            }

            .project-title {
                font-size: 1.1rem;
                margin-bottom: 12px;
            }

            .project-description {
                font-size: 0.9rem;
                margin-bottom: 12px;
            }

            .impact-value {
                font-size: 1.2rem;
            }

            .impact-label {
                font-size: 0.75rem;
            }

            .result-item {
                font-size: 0.85rem;
                margin-bottom: 4px;
            }

            .tech-tag {
                padding: 4px 8px;
                font-size: 0.75rem;
            }

            .project-link {
                padding: 8px 15px;
                font-size: 0.8rem;
            }

            /* Contact Section */
            .contact-info h3 {
                font-size: 1.4rem;
                margin-bottom: 15px;
            }

            .contact-item {
                padding: 12px;
                gap: 12px;
            }

            .contact-icon {
                font-size: 1.2rem;
                width: 30px;
            }

            .contact-form {
                padding: 20px 15px;
            }

            .form-input {
                padding: 12px;
            }

            .form-group {
                margin-bottom: 15px;
            }

            /* Footer */
            .footer {
                padding: 25px 0;
            }

            .social-links {
                justify-content: center;
            }
        }

        @media (max-width: 360px) {
            .hero-title {
                font-size: 1.6rem;
            }

            .hero-subtitle {
                font-size: 0.9rem;
            }

            .typing-text {
                font-size: 0.9rem;
            }

            .section-title {
                font-size: 1.4rem;
            }

            .value-card,
            .skill-category,
            .project-content,
            .contact-form {
                padding: 15px 10px;
            }

            .btn {
                padding: 8px 15px;
                font-size: 0.85rem;
            }

            .project-link {
                padding: 6px 12px;
                font-size: 0.75rem;
            }

            .container {
                padding: 0 10px;
            }
        }

        /* Landscape orientation on mobile */
        @media (max-height: 500px) and (orientation: landscape) {
            .hero {
                padding: 60px 0 20px;
                min-height: 100vh;
            }

            .hero-stats {
                grid-template-columns: repeat(3, 1fr);
                max-width: 400px;
            }

            .section {
                padding: 30px 0;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        /* Scroll animations */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .animate-on-scroll.animated {
            opacity: 1;
            transform: translateY(0);
        }

        /* Desktop/Laptop Responsive Styles */
        @media (min-width: 769px) {
            .hero {
                min-height: 100vh;
                padding: 100px 0 100px;
                overflow: visible;
            }

            .hero-content {
                padding: 50px;
                overflow: visible;
            }

            .profile-picture {
                margin: 20px 0;
                position: relative;
                z-index: 10;
                padding: 15px 0;
            }

            .profile-image {
                width: 200px;
                height: 200px;
                position: relative;
                margin: 0 auto;
            }
        }

        @media (min-width: 1200px) {
            .hero {
                padding: 120px 0 120px;
            }

            .hero-content {
                padding: 60px;
                max-width: 1000px;
            }

            .profile-picture {
                margin: 25px 0;
                padding: 20px 0;
            }

            .profile-image {
                width: 220px;
                height: 220px;
            }
        }
    </style>
</head>

<body>
    <!-- Animated Background -->
    <div class="cyber-bg"></div>
    <div class="particles" id="particles"></div>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="#home" class="logo">MT</a>
            <ul class="nav-menu">
                <li><a href="#home" class="nav-link">Home</a></li>
                <li><a href="#about" class="nav-link">About</a></li>
                <li><a href="#skills" class="nav-link">Skills</a></li>
                <li><a href="#projects" class="nav-link">Projects</a></li>
                <li><a href="#contact" class="nav-link">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <div class="hero-badge fade-in-up">
                <i class="fas fa-graduation-cap"></i>
                <span>Passionate Cybersecurity & AI Engineer</span>
            </div>
            
            <!-- Profile Picture -->
            <div class="profile-picture fade-in-up">
                <div class="profile-image">
                  <img src="image.png" alt="Mohamed Tamer" id="profileImg">
                </div>
            </div>
            
            <h1 class="hero-title fade-in-up">Mohamed Tamer</h1>
            <p class="hero-subtitle fade-in-up">Cybersecurity & AI Engineer</p>
            <div class="value-proposition fade-in-up">
                <span class="highlight">Building secure digital solutions</span> with cutting-edge AI technology
            </div>
            <div class="typing-text fade-in-up">
                <span id="typed-text"></span>
                <span class="cursor">|</span>
            </div>
            <div class="hero-stats fade-in-up">
                <div class="hero-stat">
                    <span class="stat-value">3+</span>
                    <span class="stat-desc">Years Learning</span>
                </div>
                <div class="hero-stat">
                    <span class="stat-value">15+</span>
                    <span class="stat-desc">Projects Built</span>
                </div>
                <div class="hero-stat">
                    <span class="stat-value">100%</span>
                    <span class="stat-desc">Dedication</span>
                </div>
            </div>
            <div class="cta-buttons fade-in-up">
                <a href="#projects" class="btn btn-primary pulse-effect">
                    <i class="fas fa-code"></i>
                    View My Projects
                </a>
                <a href="#contact" class="btn btn-secondary">
                    <i class="fas fa-envelope"></i>
                    Let's Connect
                </a>
            </div>
            <div class="trust-indicators fade-in-up">
                <span class="trust-item">✓ Passionate Learner</span>
                <span class="trust-item">✓ Problem Solver</span>
                <span class="trust-item">✓ Team Player</span>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section" id="about">
        <div class="container">
            <h2 class="section-title animate-on-scroll">About Me</h2>
            <div class="value-grid">
                <div class="value-card animate-on-scroll">
                    <div class="value-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>Passionate Learning</h3>
                    <div class="value-stat">Always Growing</div>
                    <p>Constantly learning new technologies and staying updated with the latest cybersecurity threats and AI innovations.</p>
                </div>
                <div class="value-card animate-on-scroll">
                    <div class="value-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3>Creative Solutions</h3>
                    <div class="value-stat">Innovative Thinking</div>
                    <p>Approaching security challenges with fresh perspectives and creative problem-solving techniques.</p>
                </div>
                <div class="value-card animate-on-scroll">
                    <div class="value-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3>Team Collaboration</h3>
                    <div class="value-stat">Great Communication</div>
                    <p>Working effectively with teams and communicating complex technical concepts in simple terms.</p>
                </div>
            </div>
            
            <div class="about-grid">
                <div class="about-content animate-on-scroll">
                    <h3>My Journey in Cybersecurity & AI</h3>
                    <p class="lead-text">
                        As an enthusiastic Cybersecurity and AI Engineer, I'm passionate about building secure, intelligent systems 
                        that protect digital assets and automate complex processes.
                    </p>
                    <div class="business-benefits">
                        <div class="benefit-item">
                            <i class="fas fa-shield-alt"></i>
                            <strong>Security-First Mindset</strong> in every project I build
                        </div>
                        <div class="benefit-item">
                            <i class="fas fa-robot"></i>
                            <strong>AI Integration</strong> to enhance system capabilities
                        </div>
                        <div class="benefit-item">
                            <i class="fas fa-code"></i>
                            <strong>Clean, Efficient Code</strong> following best practices
                        </div>
                        <div class="benefit-item">
                            <i class="fas fa-users"></i>
                            <strong>User-Focused Design</strong> for better experiences
                        </div>
                    </div>
                    <div class="credentials">
                        <h4>Learning & Certifications</h4>
                        <div class="cert-badges">
                            <span class="cert-badge">Python Developer</span>
                            <span class="cert-badge">Web Security</span>
                            <span class="cert-badge">ML Enthusiast</span>
                            <span class="cert-badge">Problem Solver</span>
                        </div>
                    </div>
                </div>
                <div class="cyber-stats animate-on-scroll">
                    <div class="stat-item">
                        <span class="stat-number">15+</span>
                        <span class="stat-label">Projects Completed</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">3+</span>
                        <span class="stat-label">Years Learning</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">100%</span>
                        <span class="stat-label">Commitment</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">Passion</span>
                    </div>
                    <div class="testimonial-preview">
                        <div class="testimonial-text">
                            "Mohamed brings fresh ideas and strong technical skills to every project. His dedication to learning and improving is remarkable."
                        </div>
                        <div class="testimonial-author">- Project Collaborator</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section class="section" id="skills">
        <div class="container">
            <h2 class="section-title animate-on-scroll">Skills & Expertise</h2>
            <div class="skills-grid">
                <div class="skill-category animate-on-scroll">
                    <h3>
                        <i class="fas fa-shield-alt"></i>
                        Cybersecurity
                    </h3>
                    <div class="skill-item">
                        <span class="skill-name">Network Security Basics</span>
                        <span class="skill-level">Learning</span>
                    </div>
                    <div class="skill-item">
                        <span class="skill-name">Web Application Security</span>
                        <span class="skill-level">Intermediate</span>
                    </div>
                    <div class="skill-item">
                        <span class="skill-name">Security Tools (Nmap, Wireshark)</span>
                        <span class="skill-level">Beginner</span>
                    </div>
                    <div class="skill-item">
                        <span class="skill-name">Ethical Hacking Concepts</span>
                        <span class="skill-level">Learning</span>
                    </div>
                    <div class="skill-item">
                        <span class="skill-name">Security Best Practices</span>
                        <span class="skill-level">Intermediate</span>
                    </div>
                </div>

                <div class="skill-category animate-on-scroll">
                    <h3>
                        <i class="fas fa-brain"></i>
                        Artificial Intelligence
                    </h3>
                    <div class="skill-item">
                        <span class="skill-name">Machine Learning Basics</span>
                        <span class="skill-level">Learning</span>
                    </div>
                    <div class="skill-item">
                        <span class="skill-name">Python for AI</span>
                        <span class="skill-level">Intermediate</span>
                    </div>
                    <div class="skill-item">
                        <span class="skill-name">Data Analysis</span>
                        <span class="skill-level">Beginner</span>
                    </div>
                    <div class="skill-item">
                        <span class="skill-name">TensorFlow Basics</span>
                        <span class="skill-level">Learning</span>
                    </div>
                    <div class="skill-item">
                        <span class="skill-name">AI Security Applications</span>
                        <span class="skill-level">Beginner</span>
                    </div>
                </div>

                <div class="skill-category animate-on-scroll">
                    <h3>
                        <i class="fas fa-code"></i>
                        Programming
                    </h3>
                    <div class="skill-item">
                        <span class="skill-name">Python</span>
                        <span class="skill-level">Intermediate</span>
                    </div>
                    <div class="skill-item">
                        <span class="skill-name">JavaScript</span>
                        <span class="skill-level">Intermediate</span>
                    </div>
                    <div class="skill-item">
                        <span class="skill-name">HTML/CSS</span>
                        <span class="skill-level">Good</span>
                    </div>
                    <div class="skill-item">
                        <span class="skill-name">SQL</span>
                        <span class="skill-level">Beginner</span>
                    </div>
                    <div class="skill-item">
                        <span class="skill-name">Git/GitHub</span>
                        <span class="skill-level">Intermediate</span>
                    </div>
                </div>

                <div class="skill-category animate-on-scroll">
                    <h3>
                        <i class="fas fa-tools"></i>
                        Tools & Frameworks
                    </h3>
                    <div class="skill-item">
                        <span class="skill-name">VS Code</span>
                        <span class="skill-level">Good</span>
                    </div>
                    <div class="skill-item">
                        <span class="skill-name">Linux Basics</span>
                        <span class="skill-level">Learning</span>
                    </div>
                    <div class="skill-item">
                        <span class="skill-name">Virtual Machines</span>
                        <span class="skill-level">Beginner</span>
                    </div>
                    <div class="skill-item">
                        <span class="skill-name">Jupyter Notebooks</span>
                        <span class="skill-level">Intermediate</span>
                    </div>
                    <div class="skill-item">
                        <span class="skill-name">Web Development Tools</span>
                        <span class="skill-level">Intermediate</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section class="section" id="projects">
        <div class="container">
            <h2 class="section-title animate-on-scroll">Featured Projects</h2>
            <div class="projects-grid">
                <div class="project-card animate-on-scroll featured-project">
                    <div class="project-badge">🏆 FEATURED PROJECT</div>
                    <div class="project-image">
                        <i class="fas fa-shield-virus"></i>
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Easy Organizer Security Integration</h3>
                        <div class="project-impact">
                            <div class="impact-item">
                                <span class="impact-value">100%</span>
                                <span class="impact-label">Security Coverage</span>
                            </div>
                            <div class="impact-item">
                                <span class="impact-value">15+</span>
                                <span class="impact-label">Features Added</span>
                            </div>
                        </div>
                        <p class="project-description">
                            Developed a comprehensive security layer for the Easy Organizer website, implementing 
                            user authentication, input validation, and basic threat detection. Added secure file 
                            upload functionality and created an admin dashboard for monitoring user activities.
                        </p>
                        <div class="business-results">
                            <div class="result-item">✓ User authentication & authorization</div>
                            <div class="result-item">✓ Input validation & sanitization</div>
                            <div class="result-item">✓ Secure file upload system</div>
                            <div class="result-item">✓ Activity logging & monitoring</div>
                        </div>
                        <div class="project-tech">
                            <span class="tech-tag premium">PHP Security</span>
                            <span class="tech-tag premium">MySQL</span>
                            <span class="tech-tag premium">JavaScript</span>
                            <span class="tech-tag premium">HTML/CSS</span>
                        </div>
                        <div class="project-links">
                            <a href="#" class="project-link primary">View Code</a>
                            <a href="#contact" class="project-link">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="project-card animate-on-scroll">
                    <div class="project-image">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">AI-Powered Threat Detection</h3>
                        <p class="project-description">
                            Advanced machine learning system that analyzes network traffic patterns to identify 
                            and predict cybersecurity threats. Features behavioral analysis, anomaly detection, 
                            and automated response mechanisms with 99.8% accuracy rate.
                        </p>
                        <div class="project-tech">
                            <span class="tech-tag">TensorFlow</span>
                            <span class="tech-tag">Deep Learning</span>
                            <span class="tech-tag">Network Analysis</span>
                            <span class="tech-tag">Real-time Processing</span>
                        </div>
                        <div class="project-links">
                            <a href="#" class="project-link">View Code</a>
                            <a href="#" class="project-link">Documentation</a>
                        </div>
                    </div>
                </div>

                <div class="project-card animate-on-scroll">
                    <div class="project-image">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Penetration Testing Suite</h3>
                        <p class="project-description">
                            Comprehensive penetration testing framework with automated vulnerability scanning, 
                            exploit development tools, and detailed reporting system. Designed for enterprise 
                            security assessments and compliance auditing.
                        </p>
                        <div class="project-tech">
                            <span class="tech-tag">Kali Linux</span>
                            <span class="tech-tag">Metasploit</span>
                            <span class="tech-tag">Custom Scripts</span>
                            <span class="tech-tag">Automation</span>
                        </div>
                        <div class="project-links">
                            <a href="#" class="project-link">View Tools</a>
                            <a href="#" class="project-link">Case Studies</a>
                        </div>
                    </div>
                </div>

                <div class="project-card animate-on-scroll">
                    <div class="project-image">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Intelligent SIEM System</h3>
                        <p class="project-description">
                            AI-enhanced Security Information and Event Management (SIEM) system with predictive 
                            analytics, automated correlation of security events, and intelligent alerting to 
                            reduce false positives by 85%.
                        </p>
                        <div class="project-tech">
                            <span class="tech-tag">Elasticsearch</span>
                            <span class="tech-tag">AI Analytics</span>
                            <span class="tech-tag">Real-time Processing</span>
                            <span class="tech-tag">Dashboard</span>
                        </div>
                        <div class="project-links">
                            <a href="#" class="project-link">Live Demo</a>
                            <a href="#" class="project-link">Architecture</a>
                        </div>
                    </div>
                </div>

                <div class="project-card animate-on-scroll">
                    <div class="project-image">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Blockchain Security Audit</h3>
                        <p class="project-description">
                            Smart contract security auditing tool using static analysis and fuzzing techniques. 
                            Automated detection of common vulnerabilities in blockchain applications with 
                            detailed remediation recommendations.
                        </p>
                        <div class="project-tech">
                            <span class="tech-tag">Solidity</span>
                            <span class="tech-tag">Smart Contracts</span>
                            <span class="tech-tag">Security Audit</span>
                            <span class="tech-tag">Blockchain</span>
                        </div>
                        <div class="project-links">
                            <a href="#" class="project-link">Audit Reports</a>
                            <a href="#" class="project-link">Methodology</a>
                        </div>
                    </div>
                </div>

                <div class="project-card animate-on-scroll">
                    <div class="project-image">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Data Science Security Analytics</h3>
                        <p class="project-description">
                            Machine learning-driven security analytics platform that processes large datasets 
                            to identify patterns, anomalies, and potential security threats in real-time.
                        </p>
                        <div class="project-tech">
                            <span class="tech-tag">Python</span>
                            <span class="tech-tag">Data Science</span>
                            <span class="tech-tag">Security Analytics</span>
                            <span class="tech-tag">Visualization</span>
                        </div>
                        <div class="project-links">
                            <a href="#" class="project-link">Dashboard</a>
                            <a href="#" class="project-link">Analytics</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section" id="contact">
        <div class="container">
            <h2 class="section-title animate-on-scroll">Let's Connect</h2>
            <div class="contact-grid">
                <div class="contact-info animate-on-scroll">
                    <h3>Ready to Collaborate?</h3>
                    <p style="color: var(--text-gray); margin-bottom: 30px; line-height: 1.6;">
                        I'm always excited to work on new projects and learn from experienced professionals. 
                        Whether you have a project idea, want to collaborate, or just want to chat about cybersecurity and AI!
                    </p>
                    
                    <div class="contact-item">
                        <i class="fas fa-envelope contact-icon"></i>
                        <div>
                            <h4>Email</h4>
                            <p>mohamedtamerr01@gmail.com</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <i class="fas fa-phone contact-icon"></i>
                        <div>
                            <h4>Let's Talk</h4>
                            <p>Always available for exciting opportunities</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt contact-icon"></i>
                        <div>
                            <h4>Location</h4>
                            <p>Available for remote collaboration</p>
                        </div>
                    </div>
                </div>
                
                <form class="contact-form animate-on-scroll" id="contactForm" method="POST" action="">
                    <?php if ($message_sent): ?>
                    <div class="success-message" style="background: rgba(0, 255, 136, 0.1); border: 1px solid var(--primary-color); padding: 15px; border-radius: 10px; margin-bottom: 20px; color: var(--primary-color); text-align: center;">
                        <i class="fas fa-check-circle"></i> Your message has been sent successfully! I'll get back to you soon.
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($error_message)): ?>
                    <div class="error-message" style="background: rgba(255, 0, 102, 0.1); border: 1px solid var(--accent-color); padding: 15px; border-radius: 10px; margin-bottom: 20px; color: var(--accent-color); text-align: center;">
                        <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error_message); ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <input type="text" name="name" class="form-input" placeholder="Your Name" required 
                               value="<?php echo isset($_POST['name']) && !$message_sent ? htmlspecialchars($_POST['name']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-input" placeholder="Your Email" required 
                               value="<?php echo isset($_POST['email']) && !$message_sent ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" name="subject" class="form-input" placeholder="Subject" required 
                               value="<?php echo isset($_POST['subject']) && !$message_sent ? htmlspecialchars($_POST['subject']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <textarea name="message" class="form-input form-textarea" placeholder="Your Message" required><?php echo isset($_POST['message']) && !$message_sent ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                    </div>
                    <button type="submit" name="contact_submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fas fa-paper-plane"></i>
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <p style="color: var(--text-gray);">
                    © 2024 Mohamed Tamer. Building the future of cybersecurity & AI.
                </p>
                <div class="social-links">
                    <a href="https://github.com/MohameddTamerr" class="social-link" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/mohamed-t-73960b2a7/" class="social-link" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="https://codeforces.com/profile/tamourist" class="social-link" target="_blank" rel="noopener noreferrer">
                        <span class="codeforces-icon">CF</span>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Typing Effect
        const texts = [
            "Securing Digital Assets 🔐",
            "Building AI Solutions 🤖", 
            "Learning Every Day 📚",
            "Protecting Data Privacy 🛡️",
            "Creating Safe Systems 🔒"
        ];
        
        let textIndex = 0;
        let charIndex = 0;
        let isDeleting = false;
        const typingSpeed = 100;
        const deletingSpeed = 50;
        const pauseTime = 2000;

        function typeWriter() {
            const currentText = texts[textIndex];
            const typedTextElement = document.getElementById('typed-text');
            
            if (isDeleting) {
                typedTextElement.textContent = currentText.substring(0, charIndex - 1);
                charIndex--;
            } else {
                typedTextElement.textContent = currentText.substring(0, charIndex + 1);
                charIndex++;
            }

            if (!isDeleting && charIndex === currentText.length) {
                setTimeout(() => isDeleting = true, pauseTime);
                setTimeout(typeWriter, pauseTime);
            } else if (isDeleting && charIndex === 0) {
                isDeleting = false;
                textIndex = (textIndex + 1) % texts.length;
                setTimeout(typeWriter, 500);
            } else {
                setTimeout(typeWriter, isDeleting ? deletingSpeed : typingSpeed);
            }
        }

        // Start typing effect
        typeWriter();

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Create floating particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 50;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Random position
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                
                // Random animation delay
                particle.style.animationDelay = Math.random() * 6 + 's';
                
                particlesContainer.appendChild(particle);
            }
        }

        // Initialize particles
        createParticles();

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Animate elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                }
            });
        }, observerOptions);

        // Observe all animate-on-scroll elements
        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });

        // Contact form submission - now handled by PHP
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            // Allow form to submit normally to PHP backend
            // Add loading state to button
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            submitBtn.disabled = true;
            
            // Reset button after 5 seconds (in case of slow response)
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 5000);
        });

        // Add some interactive effects
        document.querySelectorAll('.project-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-10px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Add cyber-style cursor effect
        const cursorElement = document.createElement('div');
        cursorElement.style.cssText = `
            position: fixed;
            width: 20px;
            height: 20px;
            background: radial-gradient(circle, var(--primary-color), transparent);
            border-radius: 50%;
            pointer-events: none;
            z-index: 9999;
            opacity: 0.7;
            transition: all 0.1s ease;
        `;
        document.body.appendChild(cursorElement);

        document.addEventListener('mousemove', (e) => {
            cursorElement.style.left = e.clientX - 10 + 'px';
            cursorElement.style.top = e.clientY - 10 + 'px';
        });
    </script>
</body>
</html>