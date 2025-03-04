<?php

function printBanner(string $text): void
{
    $length = strlen($text) + 4;
    $border = str_repeat('*', $length);
    $padding = '* ' . str_pad($text, $length - 4, ' ', STR_PAD_BOTH) . ' *';

    if (php_sapi_name() === 'cli') {
        echo "\n$border\n";
        echo "* " . str_repeat(' ', $length - 4) . " *\n";
        echo "$padding\n";
        echo "* " . str_repeat(' ', $length - 4) . " *\n";
        echo "$border\n\n";
    } else {
        echo "<pre>$border\n";
        echo "* " . str_repeat(' ', $length - 4) . " *\n";
        echo "$padding\n";
        echo "* " . str_repeat(' ', $length - 4) . " *\n";
        echo "$border</pre>";
    }
}

function formatOutput(string $text): void
{
    if (php_sapi_name() === 'cli') {
        echo $text . "\n";
    } else {
        echo '<pre>' . nl2br(htmlspecialchars($text)) . '</pre>';
    }
}