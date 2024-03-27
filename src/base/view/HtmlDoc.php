<?php

namespace vrklk\base\view;

class HtmlDoc
{
    protected $title;
    protected $author;

    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function __construct(string $title, string $author)
    {
        $this->title = $title;
        $this->author = $author;
    }

    public function show(): void
    {
        $this->beginDoc();
        $this->beginHead();
        $this->showHeadContent();
        $this->endHead();
        $this->beginBody();
        $this->showBodyContent();
        $this->endBody();
        $this->endDoc();
    }

    //=========================================================================
    // PROTECTED
    //=========================================================================
    protected function beginDoc(): void
    {
        echo '<!DOCTYPE html>' . PHP_EOL . '<html>';
    }

    protected function showHeadContent(): void
    {
        if ($this->title)
            echo '<title>' . $this->title . '</title>' . PHP_EOL;
        if ($this->author)
            echo '<meta name="author" content="' . $this->author . '" />'
                . PHP_EOL;
    }

    protected function showBodyContent(): void
    {
        echo '<h1>' . $this->title . '</h1>' . PHP_EOL;
    }

    //=========================================================================
    // PRIVATE
    //=========================================================================
    private function beginHead(): void
    {
        echo '<head>' . PHP_EOL;
    }

    private function endHead(): void
    {
        echo '</head>' . PHP_EOL;
    }

    private function beginBody(): void
    {
        echo '<body>' . PHP_EOL;
    }

    private function endBody(): void
    {
        echo '</body>' . PHP_EOL;
    }

    private function endDoc(): void
    {
        echo '</html>' . PHP_EOL;
    }
}
