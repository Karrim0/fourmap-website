
---

```md
# ⬡ FourMap — Digital Engineering Services Platform

<div align="center">

![PHP](https://img.shields.io/badge/PHP-8.0-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Apache](https://img.shields.io/badge/Apache-Server-D22128?style=for-the-badge&logo=apache&logoColor=white)
![Status](https://img.shields.io/badge/Status-Live-success?style=for-the-badge)

Production-ready full-stack engineering services platform built from scratch.

[🌐 Live Website](https://aaadosry.info/fourmap4/) • 
[📱 App Store](https://apps.apple.com/sa/app/id6756793950) • 
[▶️ Google Play](https://play.google.com/store/apps/details?id=com.four.map)

</div>

---

## 📌 Project Overview

**FourMap** is a digital engineering services platform serving clients in Saudi Arabia.  
The platform enables individuals and companies to request engineering services online without physical office visits.

The project was built entirely from scratch — including frontend, backend, database architecture, and a fully functional admin dashboard — without using any frameworks.

---

## 📊 Project Type

Client Project — Production Deployment  
Live on a real domain and connected to a mobile application.

---

## ✨ Core Features

- 🌐 Multi-page website (Home, About, Services, Contact, Consultation)
- 🎛️ Full Admin Dashboard for dynamic content management
- 🔤 Complete RTL Support (Arabic-first experience)
- 🌍 Multi-language system (Arabic / English toggle)
- 📱 Fully Responsive Design (Mobile / Tablet / Desktop)
- 💬 WhatsApp integration per service
- ⚡ Lazy Loading for image optimization
- 🔒 Secure database interaction using PDO Prepared Statements
- 🗂 Modular file structure for scalability

---

## 🛠 Tech Stack

| Technology | Usage |
|------------|--------|
| PHP 8 | Backend logic |
| MySQL + PDO | Database management |
| HTML5 | Structure |
| CSS3 (RTL Support) | Styling & layout |
| JavaScript | Interactivity |
| Apache | Server |

---

## 🧠 Technical Decisions

- Implemented PDO with prepared statements to prevent SQL injection.
- Structured layout using reusable components (header / footer includes).
- Built custom language switching system using separate language files.
- Designed modular admin panel architecture for easier scalability.
- Applied lazy loading strategy for performance optimization.
- Organized backend logic for maintainability and separation of concerns.

---

## 📁 Project Structure

```

fourmap-website/
│
├── index.php
├── about.php
├── services.php
├── contact.php
├── consultation.php
│
├── includes/
│   ├── header.php
│   ├── footer.php
│   ├── db.php
│   └── settings.php
│
├── admin/
│   ├── index.php
│   ├── services.php
│   └── settings.php
│
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
│
└── lang/
├── ar.php
└── en.php

````

---

## 🚀 Running Locally

```bash
# Clone repository
git clone https://github.com/karrim0/fourmap-website.git

# Move to htdocs (XAMPP example)
C:/xampp/htdocs/fourmap-website

# Import database file into phpMyAdmin

# Update database credentials in:
includes/db.php

# Open in browser
http://localhost/fourmap-website
````

---

## 🎨 Visual Identity

```css
--color-dark:   #1a1a1a;
--color-accent: #f5c518;
--font-main:    Cairo, sans-serif;
```

Minimal dark engineering theme with consistent accent highlights.

---

## 📱 Mobile Application

The website is connected to a live mobile application available on:

* App Store
* Google Play

Both platforms interact with the same backend infrastructure.

---

## 👨‍💻 Developed By

Karim Mohamed
Frontend / Full Stack Developer

Portfolio: [https://kaghim.vercel.app/](https://kaghim.vercel.app/)
GitHub: [https://github.com/karrim0](https://github.com/karrim0)

---

⭐ If you find this project interesting, feel free to star the repository.

```

---

# 🔥 كده بقى:

- احترافي
- إنجليزي بالكامل (مهم لسوق بره)
- فيه Architecture تفكير
- فيه Production context
- شكله Mid-level مش Junior

---

لو عايز أظبط لك README بنفس المستوى لمشروع تاني (portfolio أو expatriates)  
نرفعه بنفس الاحتراف 👌
```
