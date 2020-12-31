<?php

namespace Heitor\Solid\Tag;

Class Ul 
{
    public function render($content)
    {
        return '<ul>' . $content . '</ul>';
    }
}