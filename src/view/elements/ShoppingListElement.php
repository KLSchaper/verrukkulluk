<?php

namespace vrklk\view\elements;

class ShoppingListElement extends \vrklk\base\view\BaseElement
{
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
        foreach ($product_collections as $product_collection) {
            foreach ($product_collection as $product_id => $amount) {
                $product_data = $product_dao->getProductById($product_id);
                $product_data['amount'] = $amount;
                $this->products[$product_id] = $product_data;
            }
        }

        foreach ($user_adaptions as $product_id => $amount) {
            if (isset($this->products[$product_id])) {
                $this->products[$product_id]['amount'] += $amount;
                if ($this->products[$product_id]['amount'] <= 0) {
                    unset($this->products[$product_id]);
                }
            } else {
                $this->products[$product_id] = $product_dao->getProductById($product_id);
                $this->products[$product_id]['amount'] = $amount;
            }
        }
    }

    public function show()
    {
        echo <<<EOD
        <div class="cart-page">
            <h1 class="green-lily display-3 mt-2 mb-5">Boodschappen</h1>
            <div class="row overflow-auto" style="height: 800px">
        EOD . PHP_EOL;
        $total_price = 0;
        foreach ($this->products as $id => $product_data) {
            $total_price += $product_data['price'];
            echo <<<EOD
                    <div class="col-sm-2">
                        {$product_data['img']}
                    </div>
                    <div class="col-sm-6 mb-3">
                        <h3 class="green-lily">{$product_data['name']}</h3>
                        <p class="my-0">{$product_data['blurb']}</p>
                        <div class="d-flex align-items-center">
                            <div><h4 class="green-lily my-auto">Hoeveelheid per stuk: </h4></div>
                            <div><p class="my-auto ps-1">{$product_data['quantity']} {$product_data['measure']}</p></div>
                        </div>
                    </div>
                    <div class="col-sm-1 d-flex align-items-center">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                {$product_data['amount']}
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
                        <i class="fa-solid fa-trash-can red" id="thrashcan-{$id}"></i>
                    </div>
            EOD . PHP_EOL;
        }
        echo <<<EOD
            </div>
            <div class="row mt-5">
                <div class="col-sm-9">
                    <h1 class="green-lily">Totaal</h1>
                </div>
                <div class="col-sm-1 d-flex align-items-center">
                    <i class="fa-solid fa-euro-sign red ms-2 me-1"></i>{$total_price}
                </div>
                <div class="col-sm-1 d-flex align-items-center">
                    <i class="fa-solid fa-trash-can red" id="thrashcan-cart"></i>
                </div>
            </div>
        </div>
        EOD . PHP_EOL;
    }
}
