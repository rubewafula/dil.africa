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
class CartItem {
    //put your code here
    
    private $product_price_id;
    private $quantity;
    private $seller;
    private $product_image;
    private $product_name;
    private $unit_price;
    private $subtotal;
    private $session_id;
        
    public function __construct($product_price_id, $quantity, $seller, 
            $product_image, $product_name, $unit_price, $subtotal, $session_id) {
        
        $this->product_price_id = $product_price_id;
        $this->quantity = $quantity;
        $this->seller = $seller;
        $this->product_image = $product_image;
        $this->product_name = $product_name;
        $this->unit_price = $unit_price;
        $this->subtotal = $subtotal;
        $this->session_id = $session_id;
    }

    public function getProductPriceId(){
        
        return $this->product_price_id;
    }
    
    public function getQuantity(){
        
        return $this->quantity;
    }
    
    public function getSeller(){
        
        return $this->seller;
    }
    
    public function getProductImage(){
        
        return $this->product_image;
    }
    
    public function getProductName(){
        
        return $this->product_name;
    }
    
    public function getUnitPrice(){
        
        return $this->unit_price;
    }
    
    public function getSubtotal(){
        
        return $this->subtotal;
    }
    
    public function getSessionId(){
        
        return $this->session_id;
    }
}