<?php

namespace vrklk\view\elements;

class ShoppingListElement extends \vrklk\base\view\BaseElement
{
    // This element needs the array of user_adaptions, which is in the form of an array of product_id => amount.

    private array $products;

    public function __construct(array $shopping_list_array, array $user_adaptions)
    {
        $product_dao = \ManKind\ModelManager::getProductDAO();
        
        $product_collections = [];

        foreach ($shopping_list_array as $ingredient_id => $quantity) {
            $price_product_array = $product_dao->getIngredientProduct($ingredient_id, $quantity);
            $product_collections[] = $price_product_array['products'];
        }

        $this->products = [];
        foreach ($product_collections as $product_id => $amount) {
            $product_data = $product_dao->getProductById($product_id);
            $product_data['amount'] = $amount;
            $this->products[] = $product_data;
        }

        foreach ($user_adaptions as $product_id => $amount) {
            if(isset($this->products[$product_id])) {
                $this->products[$product_id] += $amount;
            } else {
                $this->products[$product_id] = $amount;
            }
        }
    }

    public function show()
    {
        // div:
            // h: "boodschappen"
        foreach($this->products as $product_data) {
            //div: 1
                //img: product image (from product_data['img'])
            //div: 2
                //h: product name (from product_data['name'])
                //p: product description (from product_data['descr'])
            //div: 3
                // dropdown: amount (from product_data['amount'])
            //div: 4
                // img: euro symbol
                // p: product price (from product_data['price'])
            //div: 5
                // img: trashbin (also trigger for delete function)
        }
        //div
            //div: 1
                // h: "Totaal"
            //div: 2
                // img: euro image
                // p: total price (calculated from adding up all other prices)
            //div: 3
                // img: trashbin (also trigger for delete all function) 
    }
}