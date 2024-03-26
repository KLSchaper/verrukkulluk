<?php
session_start();
include 'vendor/autoload.php';
include 'ManKind/web_bootstrap.php';

try
{   
    // \ManKind\tools\dev\Logger::_echo(\ManKind\cms\utils\HttpUtils::serverVar('REQUEST_URI'));
    \ManKind\ModelManager::registerModels(
        [
            'AgendaDAO' => 'vrklk\model\site\AgendaDAO',
            'FavoritesDAO' => 'vrklk\model\user\FavoritesDAO',
            'RecipeFormDAO' => 'vrklk\model\form\RecipeFormDAO',
            'MeasureFormDAO' => 'vrklk\model\form\MeasureFormDAO',
            'IngredientFormDAO' => 'vrklk\model\form\IngredientFormDAO',
        ]      
    );
    $maincontroller = new vrklk\controller\VController();
    $maincontroller->handleRequest();
            
}
catch (\Throwable $e)
{
    \ManKind\tools\dev\Logger::_error($e);
}
