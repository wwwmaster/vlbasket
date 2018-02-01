<?php

namespace Vl\Basket\Model;

abstract class BaseTotalCalc {
    private $nextCalc = null;
    private $currentTotal;
    
    protected function getCurrentTotal(){
        return $this->currentTotal;
    }
    
    protected function setCurrentTotal($currentTotal){
        $this->currentTotal = $currentTotal;
    }

    abstract protected function total($basketItems, $customer);
    
    public function getTotal($basketItems, $customer){
        if ($this->nextCalc){
            $this->nextCalc->setCurrentTotal($this->total($basketItems, $customer));
            return $this->nextCalc->getTotal($basketItems, $customer);
        }else{
            return $this->total($basketItems, $customer);
        }
    }
    
    public function __construct() {        
        $this->currentTotal = 0;
    }
        
    public function setNextCalc($calc){
        if ($calc instanceof BaseTotalCalc){
            $this->nextCalc = $calc;
            return $this->nextCalc;
        }else{
            throw new \Exception('Wrong instance type! Calc parameter should be instance of BaseTotalCalc');
        }
    }    
}
