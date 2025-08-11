<?php
try {
    $pdo = new PDO("pgsql:host=127.0.0.1;port=5432;dbname=chileghuri", "postgres", "your_postgres_password");
    echo "✅ PostgreSQL connected successfully!";
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
