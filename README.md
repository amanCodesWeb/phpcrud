# 🐘 PHP CRUD — Beginner's Tutorial

A **simple, secure PHP CRUD application** built for beginners to learn how databases work with PHP.

## 📋 What is CRUD?

CRUD stands for the **four basic operations** on data:

| Operation | SQL       | What it does                        | In this app           |
|-----------|-----------|-------------------------------------|-----------------------|
| **C**reate | `INSERT` | Add a new record                    | The form on index.php |
| **R**ead   | `SELECT` | View/show records                   | The table on index.php|
| **U**pdate | `UPDATE` | Edit an existing record             | update.php page       |
| **D**elete | `DELETE` | Remove a record                     | Delete button on table|

## 🚀 Quick Start (5 minutes)

### What you need
- A local server: **XAMPP** (Windows), **MAMP** (Mac), or **LAMP** (Linux)
- A browser (Chrome, Firefox, etc.)
- A text editor (VS Code, Sublime Text, Notepad++)

### Step 1: Install XAMPP
1. Download [XAMPP](https://www.apachefriends.org/) for your OS
2. Install it (default settings are fine)
3. Open the **XAMPP Control Panel**
4. Click **Start** next to **Apache** (the web server)
5. Click **Start** next to **MySQL** (the database)

### Step 2: Place the project files
Copy this **entire project folder** into your web server's document root:

| OS      | Path (usually)                     |
|---------|------------------------------------|
| Windows | `C:\xampp\htdocs\phpcrud\`         |
| Mac     | `/Applications/MAMP/htdocs/phpcrud/`|
| Linux   | `/var/www/html/phpcrud/`           |

### Step 3: Import the database
1. Open your browser and go to **http://localhost/phpmyadmin/**
2. Click the **Import** tab at the top
3. Click **Choose File** and select `sql/database.sql` from this project
4. Scroll down and click **Go**

Or use the MySQL command line:
```bash
mysql -u root -p < sql/database.sql
```

### Step 4: Configure the connection

Open **`config.php`** in your text editor and update these lines:

```php
define('DB_HOST', 'localhost');     // Usually: localhost
define('DB_USER', 'root');          // Usually: root
define('DB_PASS', '');              // XAMPP default: '' (empty). Set your MySQL password here.
define('DB_NAME', 'phpcrud_demo');  // Must match the database you imported
```

> ⚠️ **XAMPP users:** The default MySQL password is **empty** (blank). Set `DB_PASS` to `''`.

### Step 5: Open the app
Open your browser and go to:

**http://localhost/phpcrud/index.php**

You should see the app with 3 sample records already loaded!

> 🔄 If you see errors, double-check:
> - Apache and MySQL are running (green "Running" in XAMPP)
> - The folder name matches the URL path
> - config.php has the correct DB_NAME and DB_PASS

## 📁 File Structure

```
phpcrud/
├── index.php         # Main page: view, add, and delete records
├── update.php        # Edit an existing record
├── config.php        # Database connection + helper functions
├── main.php          # (old version — kept for reference)
├── sameInLaravel.php # (Laravel version — not functional here)
├── sql/
│   └── database.sql  # Database schema + sample data
├── .htaccess         # Security settings
└── README.md         # This file
```

## 🔒 Security Features

This app protects against common web attacks:

| Attack           | How we prevent it                     |
|------------------|---------------------------------------|
| **SQL Injection** | All queries use **prepared statements** via `safeQuery()` |
| **XSS**          | All output is wrapped in `htmlspecialchars()` |
| **CSRF**         | Delete and Edit use POST (not GET links) with confirmation |
| **Invalid input** | Server-side validation checks all fields |

## 🧠 How the code works

### index.php does three things at once
The PHP at the **top** handles form submissions (insert, delete). Then the **HTML** at the bottom displays the page. This is the standard PHP pattern — code executes top-to-bottom.

### config.php is the brain
It connects to the database once, and every other file includes it. The `safeQuery()` function handles ALL database operations securely.

### Database queries use prepared statements
Instead of putting variables directly into SQL (which is dangerous):
```php
// ❌ BAD — SQL injection vulnerable
$sql = "SELECT * FROM users WHERE id = $_GET[id]";

// ✅ GOOD — prepared statement
$stmt = safeQuery("SELECT * FROM users WHERE id = ?", 'i', [$id]);
```

## 🎯 Practice exercises

Once the app works, try these to learn more:

1. **Add a "phone" field** — add a column to the database, add an input in the form, and update the queries
2. **Add a search bar** — add a search form that filters records by name
3. **Sort the table** — click column headers to sort by name or email
4. **Add user registration** — add a password field and login page

## 🐛 Troubleshooting

| Problem                      | Likely fix                      |
|------------------------------|---------------------------------|
| "Database Connection Failed" | MySQL isn't running, or config.php has wrong credentials |
| Blank page                   | Check PHP error logs (`xampp/apache/logs/`) |
| "Table doesn't exist"        | You forgot to run `sql/database.sql` |
| 404 error                    | You're not in the right folder — check the URL |
| Form doesn't add records     | Make sure the form fields aren't empty (validation) |

## 📚 Learn more

- [PHP Manual — MySQLi](https://www.php.net/manual/en/book.mysqli.php)
- [W3Schools PHP Tutorial](https://www.w3schools.com/php/)
- [Bootstrap 5 Docs](https://getbootstrap.com/docs/5.3/getting-started/introduction/)
