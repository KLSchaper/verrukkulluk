<?php

namespace vrklk\view\elements\field_elements;

class CommentFieldElement extends \vrklk\view\elements\field_elements\BaseFieldElement {

    public function show() {
        echo $this->field_info['text'];
    }
}