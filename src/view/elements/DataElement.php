<?php

namespace vrklk\view\elements;

class DataElement extends \vrklk\base\view\BaseElement
{
    private $title;
    private $function_calls;

    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function __construct(string $title, array $function_calls) {
        $this->title = $title;
        $this->function_calls = $function_calls;
    }
    
    public function show()
    {
        echo '<h1>Class ' . $this->title . '</h1>' . PHP_EOL;
        switch ($this->title) {
            case 'DetailTabs':
                $this->showData('CommentsTabDAO');
                $this->showData('IngredientsTabDAO');
                $this->showData('PrepStepsTabDAO');
                break;
            default:
                $dao = $this->title . 'DAO';
                $this->showData($dao);
                break;
        }
    }

    //=========================================================================
    // PRIVATE
    //=========================================================================
    private function showData(string $class): void
    {
        $model_call = '\ManKind\ModelManager::get' . $class;
        $dao = $model_call();
        foreach ($this->function_calls as $function => $parameters) {
            echo "<p>Testing {$class}::{$function}()</p>";
            $data = $dao->$function(...$parameters);
            echo '<pre>' . var_export($data, true) . '</pre>';
        }
    }
}
