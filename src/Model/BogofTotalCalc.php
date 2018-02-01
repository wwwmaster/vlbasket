<?php

namespace Vl\Basket\Model;

class BogofTotalCalc extends BaseTotalCalc{
    
    protected function total($basketItems, $customer){
        
        $total = 0; 
        
        $ids = array_map(function($item){ return $item->getId(); }, $basketItems);
                
        foreach ($basketItems as $item){
           
            $bogofs = $item->getBogof();
            
            $bogofids = is_array($bogofs) ? array_map(function($item){ return $item->getId(); }, $item->getBogof()) : null;
        
            if (!($bogofids && array_intersect($bogofids, $ids))){
                $total += $item->getPrice();
            }       
            
        }
        
        return $total;
    }
    
}
