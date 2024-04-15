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
            $product_collections[] = $price_product_array['products']; // array moet laag dieper geïndexeerd worden?
        }
        echo "<pre>" . var_export($product_collections, true) . "</pre>";

        $this->products = [];
        foreach ($product_collections as $product_id => $amount) {
            $product_data = $product_dao->getProductById($product_id);
            $product_data['amount'] = $amount;
            $this->products[] = $product_data; // opslaan op id index, info moet ook naar view
        }

        foreach ($user_adaptions as $product_id => $amount) {
            if(isset($this->products[$product_id])) {
                echo "<pre>" . var_export($this->products, true) . "</pre>";
                echo "<pre>" . var_export($amount) . "</pre>";
                $this->products[$product_id] += $amount; // juiste value indexeren
            } else {
                $this->products[$product_id] = $amount; // juiste value indexeren
            }
        }
    }

    public function show()
    {
        // div:
            // h: "boodschappen" 
        echo <<<EOD
        <div class="cart-page">
            <h1 class="green-lily">Boodschappen</h1>
            <div class="row overflow-auto" style="height: 600px">
        EOD . PHP_EOL;
        $total_price = 0;
        foreach($this->products as $id => $product_data) {
            $total_price += $product_data['price'];
            echo <<<EOD
                    <div class="col-sm-2">
                        {$product_data['img']}
                    </div>
                    <div class="col-sm-6">
                        <h1 class="green-lily">{$product_data['name']}</h1>
                        <p>{$product_data['descr']}</p>
                    </div>
                    <div class="col-sm-1 d-flex align-items-center">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                {$product_data['quantity']}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">1</a></li>
                                <li><a class="dropdown-item" href="#">2</a></li>
                                <li><a class="dropdown-item" href="#">3</a></li>
                                <li><a class="dropdown-item" href="#">4</a></li>
                                <li><a class="dropdown-item" href="#">4</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-1 d-flex align-items-center">
                        <i class="fa-solid fa-euro-sign red ms-2 me-1"></i>{$product_data['price']}
                    </div>
                    <div class="col-sm-1 d-flex align-items-center">
                        <i class="fa-solid fa-trash-can" id="thrashcan-{$id}"></i>
                    </div>
            EOD . PHP_EOL;
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
        echo <<<EOD
                <div class="row">
                    <div class="col-sm-9">
                        <h1 class="green-lily">Totaal</h1>
                    </div>
                    <div class="col-sm-1 d-flex align-items-center">
                        <i class="fa-solid fa-euro-sign red ms-2 me-1"></i>{$total_price}
                    </div>
                    <div class="col-sm-1 d-flex align-items-center">
                        <i class="fa-solid fa-trash-can" id="thrashcan-cart"></i>
                    </div>
                </div>
            </div>
        </div>
        EOD . PHP_EOL;
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