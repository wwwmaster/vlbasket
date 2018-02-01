<?php

namespace Vl\Basket\Model;

class LoyaltyTotalCalc extends BaseTotalCalc{
    protected function total($basketItems, $customer){
        return $customer->hasLoyalty() ? 0.98 * $this->getCurrentTotal() : $this->getCurrentTotal();
    }
}
