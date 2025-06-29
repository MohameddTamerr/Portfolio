# 🚀 Mohamed Tamer - Portfolio Website

A modern, responsive portfolio website showcasing my journey as a Cybersecurity & AI Engineer.

![Portfolio Preview](https://img.shields.io/badge/Status-Live-brightgreen)
![PHP](https://img.shields.io/badge/PHP-8.0+-blue)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?logo=javascript&logoColor=black)

## ✨ Features

- **🎨 Modern Cyber-themed Design** - Dark theme with neon accents and animated backgrounds
- **📱 Fully Responsive** - Optimized for all devices (mobile, tablet, desktop)
- **💌 Contact Form** - PHP-powered contact form with email functionality
- **🔒 Security-focused** - Input validation, sanitization, and rate limiting
- **⚡ Interactive Animations** - Smooth scrolling, typing effects, and particle animations
- **🎯 Professional Sections** - About, Skills, Projects, and Contact sections

## 🛠️ Technologies Used

- **Frontend:**
  - HTML5 & CSS3
  - JavaScript (ES6+)
  - Font Awesome Icons
  - Google Fonts (Orbitron, Rajdhani)
  - AOS (Animate On Scroll) Library

- **Backend:**
  - PHP 8.0+
  - Email functionality with PHPMailer integration

- **Design:**
  - Cyber-themed color scheme
  - Responsive grid layouts
  - CSS animations and transitions
  - Particle.js-inspired effects

## 📂 Project Structure

```
Portfolio/
├── portfolio.php          # Main portfolio file
├── image.png             # Profile picture
├── .gitignore           # Git ignore rules
└── README.md            # Project documentation
```

## 🚀 Getting Started

### Prerequisites
- Web server (Apache/Nginx)
- PHP 8.0 or higher
- Mail server configuration (for contact form)

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/YourUsername/portfolio.git
   cd portfolio
   ```

2. **Configure web server:**
   - Place files in your web server directory
   - Ensure PHP is enabled
   - Configure mail settings in `portfolio.php`

3. **Update contact email:**
   ```php
   $contact_email = "your-email@gmail.com";
   ```

4. **Access the website:**
   - Open `http://localhost/portfolio/portfolio.php` in your browser

## 🎨 Customization

### Colors
The color scheme can be modified in the CSS variables:
```css
:root {
    --primary-color: #00ff88;    /* Main green accent */
    --secondary-color: #0066ff;  /* Blue accent */
    --accent-color: #ff0066;     /* Pink accent */
    --bg-dark: #0a0a0a;         /* Dark background */
    --bg-darker: #050505;       /* Darker background */
}
```

### Content
- Update personal information in the HTML sections
- Modify skills and projects in their respective sections
- Replace `image.png` with your profile picture

## 📧 Contact Form Setup

The contact form requires mail server configuration. Update these settings:

```php
// In portfolio.php
$contact_email = "your-email@gmail.com";
```

For production, consider using:
- SMTP configuration
- Mail services like SendGrid or Mailgun
- Form validation services

## 🌟 Features Highlights

### Responsive Design
- Mobile-first approach
- Breakpoints: 360px, 480px, 768px, 1200px+
- Flexible grid layouts

### Security Features
- Input validation and sanitization
- Rate limiting (1 minute between submissions)
- XSS protection
- URL filtering in messages

### Performance
- Optimized CSS and JavaScript
- Efficient animations
- Lazy loading effects
- Minimal external dependencies

## 🔗 Social Links

- GitHub: [MohameddTamerr](https://github.com/MohameddTamerr)
- LinkedIn: [Mohamed Tamer](https://www.linkedin.com/in/mohamed-t-73960b2a7/)
- Codeforces: [tamourist](https://codeforces.com/profile/tamourist)

## 📱 Screenshots

### Desktop View
- Hero section with animated profile picture
- Skills showcase with cyber-themed cards
- Featured projects with interactive hover effects

### Mobile View
- Optimized navigation
- Responsive image scaling
- Touch-friendly interactions

## 🚀 Deployment

### GitHub Pages
1. Push to GitHub repository
2. Enable GitHub Pages in repository settings
3. Select source branch (main/master)

### Web Hosting
1. Upload files to hosting provider
2. Configure PHP and mail settings
3. Update domain DNS if needed

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

## 🙏 Acknowledgments

- Font Awesome for icons
- Google Fonts for typography
- AOS library for scroll animations
- Inspiration from modern web design trends

---

**⭐ Star this repository if you found it helpful!**

Made with ❤️ by [Mohamed Tamer](https://github.com/MohameddTamerr)
