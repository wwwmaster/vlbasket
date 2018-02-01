# vlbasket
Simple package for basic shoping basket structure

# How to use package?
1. Your product entity/model should implement Vl/Basket/Model/BasketItemInterface
2. Your customer entity/model should implement Vl/Basket/Model/CustomerInterface
3. Create TotalCalc chain of instances and put it to Basket constructor
