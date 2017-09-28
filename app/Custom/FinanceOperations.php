<?php 
namespace App\Custom\FinanceOperations; 

trait FinanceOperations 
{
    function hasEnough($income, $cost) 
    {
        return ($income >= $cost) ? true: false ;
    }
    
    function totalRevenue($quantity, $price) 
    {
        return $quantity * $price;
    }
    
    function totalCost($quantity, $price)
    {
        return $quantity * $price;
    }
    function withdraw($income, $amount) 
    {
        return $income - $amount;
    }
    
    function deposit($income, $amount) 
    {
        return $income + $amount;
    }
}