<?php

namespace vrklk\model\interfaces;

interface iFormDAO
{
    public function getFormInfo(int $form_id): array;
}
