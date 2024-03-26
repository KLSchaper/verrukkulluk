<?php
namespace vrklk\view;

class VPage extends \vrklk\base\view\HtmlDoc
{
//=============================================================================
// PUBLIC
//=============================================================================
    public function __construct(string $title)
    {
        parent::__construct($title, \Config::AUTHOR);
    }

    protected function showBodyContent(): void
    {
        echo '<h1>Class '.$this->title.'</h1>'.PHP_EOL;
        switch($this->title)
        {
            case 'Agenda':
                $function_calls = [
                    'getUpcomingEvents' => [
                        'amount'    =>  3,
                    ],
                ];
                $this->showData('AgendaDAO', $function_calls);
                break;
            case 'Favorite':
                $function_calls = [
                    'checkFavorite'      => [
                        'recipe_id' =>  1,
                        'user_id'   =>  1,
                    ],
                ];
                $this->showData('FavoritesDAO', $function_calls);
                break;
            case 'RecipeForm':
                $function_calls = [
                    'getFormInfo'       => [
                        'form_id'   =>  1,
                    ],
                    'getCuisineList'    => [],
                    'getRecipeTypes'    => [],
                ];
                $this->showData('RecipeFormDAO', $function_calls);
                break;
            case 'MeasureForm':
                $function_calls = [
                    'getFormInfo'       => [
                        'form_id'   =>  1,
                    ],
                    'getUnit'           => [
                        'ingredient_id' => 1,
                    ],
                ];
                $this->showData('MeasureFormDAO', $function_calls);
                break;
            case 'IngredientForm':
                $function_calls = [
                    'getFormInfo'       => [
                        'form_id'   =>  1,
                    ],
                    'getIngredientList' => [],
                    'getMeasures'       => [
                        'ingredient_id' => 4,
                    ],
                ];
                $this->showData('IngredientFormDAO', $function_calls);
                break;
            case 'DetailTabs':
                $function_calls = [
                    'getTabName'    => [],
                    'getTabContent' => [
                        'recipe_id' => 1,
                    ],
                ];
                $this->showData('CommentsTabDAO', $function_calls);
                $this->showData('IngredientsTabDAO', $function_calls);
                $this->showData('PrepStepsTabDAO', $function_calls);
                break;
            default:
                echo '<h1>404 pagina niet gevonden</h1>'.PHP_EOL;
        }
    }

    private function showData(string $class, array $function_calls) : void
    {
        $model_call = '\ManKind\ModelManager::get'.$class;
        $dao = $model_call();
        foreach($function_calls as $function => $parameters)
        {
            echo "<p>Testing {$class}::{$function}()</p>";
            $data = $dao->$function(...$parameters);
            echo '<pre>'.var_export($data, true).'</pre>';
        }
    }
}