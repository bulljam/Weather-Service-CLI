<?php

function color(string $text, string $colorCode): string
{
    return "\033[{$colorCode}m{$text}\033[0m";
}