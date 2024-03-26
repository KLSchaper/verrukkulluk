<?php
/*
 * INTERFACES FOR MODEL-VIEW INTERACTIONS
 */

// These interfaces will likely all be implemented by one SiteDAO class
interface iMenuDAO
{
    public function getMenuItems(bool $logged_user) : array;
}

interface iLogElementDAO
{
    public function getLogElementTitle(bool $logged_user) : string;
    public function getLogElementContent(bool $logged_user) : array;
}

interface iFooterDAO
{
    public function getFooterTitle() : string;
    public function getContactInfo() : array;
}

interface iDetailTabDAO
{
    public function getDetailTabNames() : array;
}

// These interfaces will be implemented by the relevant DAO interacting with DB
interface iAgendaDAO
{
    public function getUpcomingEvents(int $amount): array;
}

interface iGetRecipeDAO
{
    public function getPageRecipes( // naar controller? toch 3 losse functies?
        int $amount,
        int $page_number,
        string $selection='home', // alternatives: 'favorites' or 'search'
        string $criterium=NULL // alternatives: user_id or query
    ) : array;
    public function getRecipeDetails(int $recipe_id) : array;
    // includes rating, price, calories, cuisine name, and author name
}

interface iRecipeTabDAO
{
    public function getTabName() : string;
    public function getTabContent(int $recipe_id) : array;
}

interface iFormDAO
{
    public function getFormInfo(int $form_id) : array;
}

interface iRecipeFormDAO
{
    public function getCuisineList() : array;
    public function getRecipeTypes() : array;
}

interface iIngredientFormDAO
{
    public function getIngredientList() : array;
    public function getMeasures(int $ingredient_id) : array;
}

interface iMeasureFormDAO
{
    public function getUnit(int $ingredient_id) : string;
}

interface iFavoritesDAO
{
    public function checkFavorite(int $recipe_id, int $user_id) : bool;
}

interface iProductsDAO
{
    public function getIngredientProduct(
        int $ingredient_id,
        float $quantity,
        string $select_on = 'price'
    ) : array;
    public function getProductById(int $product_id) : array;
}

/*
 * INTERFACES TO STORE DATA IN DB
 */

interface iAddUser
{
    public function registerUser(
        string $name,
        string $email,
        string $password,
        string $img
    ) : int | false;
}

interface iAddRecipe
{
    public function storeRecipe(
        string $name,
        string $img,
        string $blurb,
        int $people,
        int $cuisine_id,
        string $type,
        string $descr
    ) : int | false;
    public function storeRecipeIngredient(
        int $recipe_id,
        int $ingredient_id,
        float $quantity,
        int $measure_id
    ) : bool;
    public function storeRecipeStep(
        int $recipe_id,
        int $number,
        string $descr
    ) : bool;
}

interface iAddComment
{
    public function addComment(
        int $recipe_id,
        int $user_id,
        string $text
    ) : int | false;
}

interface iAddMeasure
{
    public function addMeasure(
        int $ingredient_id,
        string $name,
        string $category,
        float $quantity
    ) : int | false;
}



/*
 * OLD INTERFACES FIRST MODEL ANALYSIS
 * for reference
 */


interface AgendaIF
{
    public function getUpcomingEvents(int $amount): array;
}

interface UserIF
{
    public function getUserByEmail(string $email) : int | false;
    public function matchPassword(int $user_id, string $password) : bool;
    public function getUserName(int $user_id) : string | false;
    public function getUserPFP(int $user_id) : string | false;
    public function registerUser(
        string $name,
        string $email,
        string $password,
        string $img
    ) : int | false;
}

interface ShoppingListIF
{
    public function addRecipeToList(int $recipe_id) : void;
    public function updateListProduct(int $product_id, int $new_amount) : void;
    public function deleteListProduct(int $product_id) : void;
    public function getShoppingList() : array;
    public function clearShoppingList() : void;
}

interface RecipeIF
{
    public function getHomeRecipes(int $amount, int $page) : array;
    public function getRecipeDetails(int $recipe_id) : array;
    public function getRecipePrice(int $recipe_id) : float;
    public function getRecipeCalories(int $recipe_id) : float;
    public function getCuisineName(int $cuisine_id) : string;
    public function getIngredients(int $recipe_id) : array;
    public function getPrepSteps(int $recipe_id) : array;
    public function storeRecipe(
        string $name,
        string $img,
        string $blurb,
        int $people,
        int $cuisine_id,
        string $type,
        string $descr
    ) : int | false;
    public function storeRecipeIngredient(
        int $recipe_id,
        int $ingredient_id,
        float $quantity,
        int $measure_id
    ) : bool;
    public function storeRecipeStep(
        int $recipe_id,
        int $number,
        string $descr
    ) : bool;
    public function searchRecipes(
        int $amount,
        int $page,
        string $search_query
    ) : array;
}

interface FavoritesIF
{
    public function addFavorite(int $recipe_id, int $user_id) : void;
    public function removeFavorite(
        int $recipe_id,
        int $user_id
    ) : void;
    public function getFavoriteRecipes(
        int $user_id,
        int $amount,
        int $page
    ) : array;
    public function checkFavorite(int $recipe_id, int $user_id) : bool;
}

interface RatingIF
{
    public function getRating(int $recipe_id) : int;
    public function addRating(
        int $recipe_id,
        int $user_id,
        int $rating
    ) : void;
}

interface CommentsIF
{
    public function getRecipeComments(int $recipe_id) : array;
    public function addComment(
        int $recipe_id,
        int $user_id,
        string $text
    ) : int | false;
}

interface MeasureProductsIF
{
    public function getIngredientProduct(
        int $ingredient_id,
        float $quantity,
        int $measure_id,
        string $select_on = 'price'
    ) : array;
    public function getProductById(int $product_id) : array;
    public function getMeasureById(int $measure_id) : array;
    public function addMeasure(
        int $ingredient_id,
        string $name,
        string $category,
        float $quantity
    ) : int | false;
}

// very generic attempt, never used
interface iModelView
{
    public function getRowById(string $table, int $id) : array;
    // SELECT * FROM $table WHERE id=$id
    public function getRowsById(string $table, string $fkey, int $id) : array;
    // SELECT * FROM $table WHERE $fkey=$id
    public function getColumnValueById(string $table, string $column, int $id) : array;
    // SELECT $column FROM $table WHERE id=$id
}