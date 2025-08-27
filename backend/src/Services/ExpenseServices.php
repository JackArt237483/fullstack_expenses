<?php
 namespace App\Services;

 use App\Repositories\ExpenseRepository;

 class ExpenseServices{
    public function __construct(private ExpenseRepository $repo){}
     public function getAllExpense():array
     {
         return $this->repo->getAll();
     }
 }