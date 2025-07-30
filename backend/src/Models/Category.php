<?php

namespace App\Models;
use App\Services\DataBase;
use PDO;

class Category {
    public static function all():array {
        $pdo = DataBase::Connection();
        $stmt = $pdo->query('SELECT * FROM categories ORDER BY text DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}