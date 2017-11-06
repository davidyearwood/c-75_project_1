<?php 

namespace App\Finance; 

use Illuminate\Database\Eloquent\Model;

/**
 * @author David <dyearwoodd@gmail.com>
 * 
 * Updates financial account state. 
 *  
 */
class FinancialAccount {

    protected $account;
    protected $id;
    
    public function __construct($account) 
    {
        $this->account = $account; 
    }
    
    /**
     * Deducts money from the account
     * 
     * @param Float  
     * @return Float  
     */   
    public function withdraw($amount)
    {
        if (!$this->hasEnough($amount)) {
            return -1;  
        }
        
        $this->update($this->account->cash - $amount);
    
        return $amount; 
    }

    /**
     * Adds money to the account
     * 
     * @param Float
     * @return void 
     */     
    public function deposit($amount) 
    {
        if ($amount < 0) {
            return false; 
        }
        
        $this->update($this->account->cash + $amount);
    
        return true; 
    }

    /**
     * Checks to see if there is enough money
     * 
     * @param Float 
     * @return boolean 
     */   
    public function hasEnough($amount) 
    {
        return $amount <= $this->account->cash; 
    }
    
    /**
     * Updates user account
     * 
     * @param Float, Float  
     * @return float 
     */     
    private function update($newAmount) 
    {
        $this->account->cash = $newAmount;
        $this->account->save();
    }
    
}