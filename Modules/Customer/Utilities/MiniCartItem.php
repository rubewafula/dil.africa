<?php

namespace Modules\Customer\Utilities;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utilities
 *
 * @author antonio
 */
class MiniCartItem {
    //put your code here
    
    private $product_price_id;
    private $quantity;
        
    public function __construct($product_price_id, $quantity) {
        
        $this->product_price_id = $product_price_id;
        $this->quantity = $quantity;
    }

    public function getProductPriceId(){
        
        return $this->product_price_id;
    }
    
    public function getQuantity(){
        
        return $this->quantity;
    }
    
    public function setProductPriceId($product_price_id){
        
        $this->product_price_id = $product_price_id;
    }
    
    public function setQuantity($quantity){
        
        $this->quantity = $quantity;
    }
    
}