<?php

namespace Heitor\Solid\Tag;

Class A
{
    public function render(string $href, string $ancor)
    {
        return '<a href="' . $href . '">' . $ancor . '</a>';
    }
}