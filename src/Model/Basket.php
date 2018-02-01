<?php

namespace Vl\Basket\Model;

class Basket {
    
    private $items;
    private $customer;
    private $calc;
    
    public function __construct($customer, $calc){
        $this->items = [];
        $this->customer = $customer;
        $this->calc = $calc;        
    }
    
    public function addItem($basketItem){
        $this->items[] = $basketItem;
    }
    
    public function removeItem($basketItemId){
        $this->items = array_values(array_filter($this->items, function($item) use ($basketItemId) {
            return $item->getId() != $basketItemId;
        }));
    }
    
    public function getItems(){
        return $this->items;
    }
    
    public function clear(){
        $this->items = [];
    }    
    
    public function getTotal(){
        return $this->calc->getTotal($this->getItems(), $this->customer);
    }
    
}
