<?php
session_start();
include 'vendor/autoload.php';
include 'ManKind/web_bootstrap.php';

try {
    \ManKind\ModelManager::registerModels(
        [
            'SiteDAO'           => 'vrklk\model\site\SiteDAO',
            'AgendaDAO'         => 'vrklk\model\site\AgendaDAO',
            'FavoritesDAO'      => 'vrklk\model\user\FavoritesDAO',
            'RecipeFormDAO'     => 'vrklk\model\form\RecipeFormDAO',
            'MeasureFormDAO'    => 'vrklk\model\form\MeasureFormDAO',
            'IngredientFormDAO' => 'vrklk\model\form\IngredientFormDAO',
            'CommentsTabDAO'    => 'vrklk\model\recipe\CommentsTabDAO',
            'IngredientsTabDAO' => 'vrklk\model\recipe\IngredientsTabDAO',
            'PrepStepsTabDAO'   => 'vrklk\model\recipe\PrepStepsTabDAO',
            'ProductDAO'        => 'vrklk\model\recipe\ProductDAO',
            'RecipeDAO'         => 'vrklk\model\recipe\RecipeDAO',
            'UsersDAO'           => 'vrklk\model\user\UsersDAO',
            'FormDAO'           => 'vrklk\model\form\FormDAO',
        ]
    );
    $maincontroller = new vrklk\controller\VController();
    $maincontroller->handleRequest();
} catch (\Throwable $e) {
    \ManKind\tools\dev\Logger::_error($e);
}
