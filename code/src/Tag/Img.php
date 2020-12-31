<?php

namespace Heitor\Solid\Tag;

Class Img 
{
    public function render($src)
    {
        return '<img src="'. $src .'">';
    }
}