<?php

namespace Vl\Basket\Model;

class GreaterTotalCalc extends BaseTotalCalc {
    
    protected function total($basketItems, $customer){
        return $this->getCurrentTotal() > 20 ? 0.9 * $this->getCurrentTotal():$this->getCurrentTotal();
    }
    
}
