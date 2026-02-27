# 🔗 PHP URL Shortener (Core PHP MVC)

A simple URL Shortener built with **Core PHP** using a custom **MVC architecture** and custom **Router**.

This project was built without any frameworks (no Laravel, no Symfony) to demonstrate backend fundamentals including:

- Custom Routing
- MVC Structure
- PDO Database Connection
- URL Validation
- Random Short Code Generation
- Click Tracking
- REST-style API Endpoints

---

## 🚀 Features

- ✅ Shorten long URLs
- ✅ Redirect using short code
- ✅ Click tracking
- ✅ URL validation
- ✅ Unique short code generation
- ✅ Stats endpoint
- ✅ Custom MVC architecture
- ✅ No framework used

---

## 🛠 Technologies Used

- PHP 8+
- MySQL
- PDO
- Apache (XAMPP)
- REST-style routing
- Custom MVC implementation

---

## 🗄 Database Schema

Create the following table:

```sql
CREATE TABLE short_links (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    original_url TEXT NOT NULL,
    short_code VARCHAR(10) NOT NULL UNIQUE,
    clicks INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

## 🏗 Project Structure
