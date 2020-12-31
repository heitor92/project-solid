<?php

namespace Heitor\Solid;

class Html
{
    public function img(string $src)
    {
        return '<img src="'. $src .'">';
    }
}