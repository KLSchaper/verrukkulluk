<?php

namespace vrklk\view;

class VPage extends \vrklk\base\view\HtmlDoc
{
    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function __construct(string $title)
    {
        parent::__construct($title, \Config::AUTHOR);
    }

    //=========================================================================
    // PROTECTED
    //=========================================================================
    protected function showHeadContent(): void
    {
        echo <<<EOD
        <title>$this->title</title>
        <meta name="author" content="$this->author">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="./assets/css/custom.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        EOD;
    }

    protected function showBodyContent(): void
    {
        switch ($this->title) {
            case 'Site':
                echo '<h1>Class ' . $this->title . '</h1>' . PHP_EOL;
                $function_calls = [
                    'getDetailMenuItems'    => [],
                    'getFooterTitle'        => [],
                    'getContactInfo'        => [],
                    'getLoginTitle'         => [
                        'logged_user'   => true,
                    ],
                    'getLoginContent'       => [
                        'logged_user'   => true,
                    ],
                    'getMenuItems'          => [
                        'logged_user'   => true,
                    ],
                ];
                $this->showData('SiteDAO', $function_calls);
                break;
            case 'Agenda':
                echo '<h1>Class ' . $this->title . '</h1>' . PHP_EOL;
                $function_calls = [
                    'getUpcomingEvents'     => [
                        'amount'        => 3,
                    ],
                ];
                $this->showData('AgendaDAO', $function_calls);
                break;
            case 'Favorite':
                echo '<h1>Class ' . $this->title . '</h1>' . PHP_EOL;
                $function_calls = [
                    'checkFavorite'         => [
                        'recipe_id'     => 1,
                        'user_id'       => 1,
                    ],
                ];
                $this->showData('FavoritesDAO', $function_calls);
                break;
            case 'RecipeForm':
                echo '<h1>Class ' . $this->title . '</h1>' . PHP_EOL;
                $function_calls = [
                    'getFormInfo'           => [
                        'form_id'       => 1,
                    ],
                    'getCuisineList'    => [],
                    'getRecipeTypes'    => [],
                ];
                $this->showData('RecipeFormDAO', $function_calls);
                break;
            case 'MeasureForm':
                echo '<h1>Class ' . $this->title . '</h1>' . PHP_EOL;
                $function_calls = [
                    'getFormInfo'           => [
                        'form_id'       => 1,
                    ],
                    'getUnit'               => [
                        'ingredient_id' => 1,
                    ],
                ];
                $this->showData('MeasureFormDAO', $function_calls);
                break;
            case 'IngredientForm':
                echo '<h1>Class ' . $this->title . '</h1>' . PHP_EOL;
                $function_calls = [
                    'getFormInfo'           => [
                        'form_id'       => 1,
                    ],
                    'getIngredientList'     => [],
                    'getMeasures'       => [
                        'ingredient_id' => 4,
                    ],
                ];
                $this->showData('IngredientFormDAO', $function_calls);
                break;
            case 'DetailTabs':
                echo '<h1>Class ' . $this->title . '</h1>' . PHP_EOL;
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
            case 'Product':
                echo '<h1>Class ' . $this->title . '</h1>' . PHP_EOL;
                $function_calls = [
                    'getIngredientProduct'  => [
                        'ingredient_id' => 1,
                        'quantity'      => 1,
                    ],
                    'getProductById'        => [
                        'product_id'    => 1
                    ],
                ];
                $this->showData('ProductDAO', $function_calls);
                break;
            case 'Recipe':
                echo '<h1>Class ' . $this->title . '</h1>' . PHP_EOL;
                $function_calls = [
                    'getHomeRecipes'        => [
                        'amount'        => 4,
                        'page_number'   => 1,
                    ],
                    'getTotalHomeRecipes'   => [],
                    'getFavoriteRecipes'    => [
                        'amount'        => 4,
                        'page_number'   => 1,
                        'user_id'       => 1,
                    ],
                    'getTotalFavoriteRecipes'   =>
                    [
                        'user_id'       => 1,
                    ],
                    'getSearchRecipes'      => [
                        'amount'        => 4,
                        'page_number'   => 1,
                        'search_query'  => 'uovo',
                    ],
                    'getTotalSearchRecipes' => [
                        'search_query'  => 'uovo',
                    ],
                    'getRecipeDetails'      => [
                        'recipe_id'     => 1,
                    ],
                ];
                $this->showData('RecipeDAO', $function_calls);
                break;
            case 'Page':
                $user_id = 1;
                $page_number = 1;
                $recipes_per_page = 4;
                $recipe_ids = \ManKind\ModelManager::getRecipeDAO()->getHomeRecipes($recipes_per_page, $page_number);
                $total_pages = ceil(\ManKind\ModelManager::getRecipeDAO()->getTotalHomeRecipes() / $recipes_per_page);
                $header = new \vrklk\view\elements\HeaderElement([
                    new \vrklk\view\elements\SlideshowElement(),
                    new \vrklk\view\elements\MenuElement($user_id),
                ]);
                $header->show();
                $content = new \vrklk\view\elements\BodyElement(
                    [
                        new \vrklk\view\elements\AgendaElement(),
                        new \vrklk\view\elements\LogElement($user_id)
                    ],
                    new \vrklk\view\elements\RecipePageElement($recipe_ids, $page_number, $total_pages),
                );
                $content->show();
                $footer = new \vrklk\view\elements\FooterElement();
                $footer->show();
                break;
            
            // for the temporary form test
            case 'TestForm':
                $test_form = new \vrklk\view\elements\FormElement(1, ['form_values' => [], 'form_errors' => []]);
                $test_form->show();
                break;
            
            default:
                echo '<h1>404 pagina niet gevonden</h1>' . PHP_EOL;
        }
    }

    //=========================================================================
    // PRIVATE
    //=========================================================================
    private function showData(string $class, array $function_calls): void
    {
        $model_call = '\ManKind\ModelManager::get' . $class;
        $dao = $model_call();
        foreach ($function_calls as $function => $parameters) {
            echo "<p>Testing {$class}::{$function}()</p>";
            $data = $dao->$function(...$parameters);
            echo '<pre>' . var_export($data, true) . '</pre>';
        }
    }
}
