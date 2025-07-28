<?php

namespace App\Models;
use App\Services\DataBase;

class Category {
    public static function all():array {
        $pdo = DataBase::Connection();
        $stmt = $pdo->query('SELECT * FROM categories ORDER BY name DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}