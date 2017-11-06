<?php

namespace App\Finance; 
/**
 * @author David <dyearwoodd@gmail.com>
 * 
 * This is a static class that contains a set of 
 * common financial operations. 
 */
class FinancialCalculator {
    
    /**
     * Calculates the total sales revenue earned.
     * 
     * @param Float, Float 
     * @return float 
     */   
    public static function salesRevenue($quantity, $price)
    {
        return $quantity * $price; 
    }
    
    /**
     * Calculates the total expense
     * 
     * @param Float, Float 
     * @return float 
     */
    public static function expense($quantity, $price)
    {
        return $quantity * $price; 
    }

}