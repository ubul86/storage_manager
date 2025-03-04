<?php

function printBanner(string $text): void
{
    $length = strlen($text) + 4;
    $border = str_repeat('*', $length);
    $padding = '* ' . str_pad($text, $length - 4, ' ', STR_PAD_BOTH) . ' *';

    echo "<pre>$border\n* " . str_repeat(' ', $length - 4) . " *\n$padding\n* " . str_repeat(' ', $length - 4) . " *\n$border</pre>";
}
