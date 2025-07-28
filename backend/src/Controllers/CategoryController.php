<?php
 namespace App\Controllers;


use App\Models\Category;

class CategoryController
{
    public function index()
    {
        return json_encode(Category::all());
    }
}