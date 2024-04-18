<?php

namespace vrklk\model\site;

class TestDAO extends \vrklk\base\model\BaseDAO
{
    //=========================================================================
    // PUBLIC
    //=========================================================================
    public static function getTestTitle(string $test_page): string
    {
        switch ($test_page) {
            case 'site_test':
                return 'Site';
            case 'agenda_test':
                return 'Agenda';
            case 'favorite_test':
                return 'Favorites';
            case 'recipeform_test':
                return 'RecipeForm';
            case 'measureform_test':
                return 'MeasureForm';
            case 'ingredientform_test':
                return 'IngredientForm';
            case 'detailtabs_test':
                return 'DetailTabs';
            case 'product_test':
                return 'Product';
            case 'recipe_test':
                return 'Recipe';
            default:
                return '';
        }
    }

    public static function getTestFunctions(string $test_page): array
    {
        switch ($test_page) {
            case 'site_test':
                return [
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
            case 'agenda_test':
                return [
                    'getUpcomingEvents'     => [
                        'amount'        => 3,
                    ],
                ];
            case 'favorite_test':
                return [
                    'checkFavorite'         => [
                        'recipe_id'     => 1,
                        'user_id'       => 1,
                    ],
                ];
            case 'recipeform_test':
                return [
                    'getFormInfo'           => [
                        'form_id'       => 1,
                    ],
                    'getCuisineList'    => [],
                    'getRecipeTypes'    => [],
                ];
            case 'measureform_test':
                return [
                    'getFormInfo'           => [
                        'form_id'       => 1,
                    ],
                    'getUnit'               => [
                        'ingredient_id' => 1,
                    ],
                ];
            case 'ingredientform_test':
                return [
                    'getFormInfo'           => [
                        'form_id'       => 1,
                    ],
                    'getIngredientList'     => [],
                    'getMeasures'       => [
                        'ingredient_id' => 4,
                    ],
                ];
            case 'detailtabs_test':
                return [
                    'getTabName'    => [],
                    'getTabContent' => [
                        'recipe_id' => 1,
                    ],
                ];
            case 'product_test':
                return [
                    'getIngredientProduct'  => [
                        'ingredient_id' => 1,
                        'quantity'      => 1,
                    ],
                    'getProductById'        => [
                        'product_id'    => 1
                    ],
                ];
            case 'recipe_test':
                return [
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
                    'getRecipeIngredients'  => [
                        'recipe_id'     => 1,
                    ],
                    'getRecipeDetails'      => [
                        'recipe_id'     => 1,
                    ],
                ];
            default:
                return [];
        }
    }
}
