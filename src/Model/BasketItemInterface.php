<?php

namespace Vl\Basket\Model;

interface BasketItemInterface {

    public function getId();
    public function getPrice();
    public function getDescription();    
    public function setQuantity($quantity);
    public function getQuantity();
    public function getBogof(); //Return list of products that it is free when ordered with one of them  
    
}
