<?php
// config/db.php - Database Connection Configuration for PHBN Traders

define('DB_TYPE', 'sqlite'); // Options: 'sqlite' (zero config) or 'mysql'
define('DB_HOST', 'localhost');
define('DB_NAME', 'phbn_traders');
define('DB_USER', 'root');
define('DB_PASS', '');

function getDBConnection() {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    try {
        if (DB_TYPE === 'sqlite') {
            $dataDir = __DIR__ . '/../data';
            if (!is_dir($dataDir)) {
                mkdir($dataDir, 0777, true);
            }
            $dbFile = $dataDir . '/database.sqlite';
            $pdo = new PDO("sqlite:" . $dbFile);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            // Enable foreign keys in SQLite
            $pdo->exec("PRAGMA foreign_keys = ON;");
        } else {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $pdo = new PDO($dsn, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        return $pdo;
    } catch (PDOException $e) {
        die("Database Connection Error: " . $e->getMessage() . "<br><small>If first time running, please run <a href='setup.php'>setup.php</a> to initialize the database.</small>");
    }
}
