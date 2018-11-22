<?php

namespace App\View;

/**
 * Interface TemplateInterface
 * @package App\View
 */
interface TemplateInterface
{
    /**
     * @param array $vars
     * @return string
     */
    public function getView(array $vars): string;
}
