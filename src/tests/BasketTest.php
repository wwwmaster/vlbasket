<?php

use PHPUnit\Framework\TestCase;
use Vl\Basket\Model;


class BasketTest extends TestCase{
    
    protected $customer;
    protected $totalcalc;
    protected $item1;
    protected $item2;
    
    private function isBasketItemsArraysEqual($array1, $array2){
        if (count($array1) != count($array2)){
            return false;
        }
        
        if (count($array1)  == 0){
            return true;
        }
        
        function sortById($a, $b){
            return $a->getId() > $b->getId();            
        }
        
        $a1sorted = array_sort($array1, 'sortById');        
        $a2sorted = array_sort($array2, 'sortById');
        
        $result = true;
        
        for ($i = 0; $i <count($a1sorted); $i++){
            if ($a1sorted[$i] != $a2sorted[$i]){
                $result = false;
                break;
            }
        }
        
        return $result;
    }
    
    public function setUp(){
        $this->customer = $this->getMockBuilder(Model\CustomerInterface::class)
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->disableArgumentCloning()
                ->getMockForAbstractClass();
                
        
        $this->totalcalc = $this->getMockBuilder(Model\BaseTotalCalc::class)
                ->disableOriginalConstructor()
                ->setMethods(['getTotal'])
                ->disableOriginalClone()
                ->disableArgumentCloning()
                ->getMockForAbstractClass();
        
        $this->totalcalc->method('getTotal')->willReturn(1);
        
        $this->item1 = $this->getMockBuilder(Model\BasketItemInterface::class)
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->disableArgumentCloning()
                ->getMockForAbstractClass();
        
        $this->item1->method('getId')->willReturn(1);
        
        $this->item2 = $this->getMockBuilder(Model\BasketItemInterface::class)
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->disableArgumentCloning()
                ->getMockForAbstractClass();
        
        $this->item2->method('getId')->willReturn(2);
    }
           
    public function testBasketAddItem(){        
        $basket = new Model\Basket($this->customer, $this->totalcalc);  
        
        $this->assertEmpty($basket->getItems());        
        
        $basket->addItem($this->item1);
        
        $this->assertTrue(count($basket->getItems()) == 1);        
    }
    
    public function testBasketRemoveItem(){        
        
        $basket = new Model\Basket($this->customer, $this->totalcalc);              
        
        $basket->addItem($this->item1);
        $basket->addItem($this->item2);
        
        $this->assertTrue(count($basket->getItems()) == 2);
        
        $basket->removeItem(1);
        
        $this->assertTrue(count($basket->getItems()) == 1);
        
        $items = $basket->getItems();
        
        $this->assertEquals(2, $items[0]->getId());
    }
    
    public function testBasketClear(){
        $basket = new Model\Basket($this->customer, $this->totalcalc);              
        
        $basket->addItem($this->item1);
        $basket->addItem($this->item2);
        
        $this->assertTrue(count($basket->getItems()) == 2);
        
        $basket->clear();
        
        $this->assertTrue(count($basket->getItems()) == 0);
    }
    
    public function testBasketGetItems(){
        $basket = new Model\Basket($this->customer, $this->totalcalc);              
        
        $basket->addItem($this->item1);
        $basket->addItem($this->item2);
        
        $this->assertTrue($this->isBasketItemsArraysEqual([$this->item1, $this->item2], $basket->getItems()));
        
    }
    
    public function testBasketGetTotal(){
        $basket = new Model\Basket($this->customer, $this->totalcalc);
        
        $this->assertEquals(1, $basket->getTotal());
    }
    
    public function testBasketRealGetTotal(){
        $bogofCalc = new Model\BogofTotalCalc();
        $greaterCalc = new Model\GreaterTotalCalc();
        $loyaltyCalc = new Model\LoyaltyTotalCalc();
               
        $bogofCalc->setNextCalc($greaterCalc)->setNextCalc($loyaltyCalc);
        
        $this->customer->method('hasLoyalty')->willReturn(true);
        
        $basket = new Model\Basket($this->customer, $bogofCalc);
        
        $this->item1->method('getPrice')->willReturn(100);
        $this->item2->method('getPrice')->willReturn(100);
        
        $item3 = $this->getMockBuilder(Model\BasketItemInterface::class)
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->disableArgumentCloning()
                ->getMockForAbstractClass();
        
        $item3->method('getBogof')->willReturn([$this->item1]);
        $item3->method('getPrice')->willReturn(100);
        
        $basket->addItem($this->item1);
        $basket->addItem($this->item2);
        $basket->addItem($item3);
        
        $this->assertEquals(200.0*0.9*0.98, $basket->getTotal());
        
    }
    
}
