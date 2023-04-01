<?php

declare(strict_types=1);

use JetBrains\PhpStorm\NoReturn;

if (!function_exists('dd')) {
    #[NoReturn] function dd(): void
    {
        foreach (func_get_args() as $arg) {
            var_dump_pretty($arg);
        }

        die();
    }
}

if (!function_exists('dump')) {
    #[NoReturn] function dump(): void
    {
        foreach (func_get_args() as $arg) {
            var_dump_pretty($arg);
        }
    }
}

function var_dump_pretty($args, $label = ''): void
{
    $debug = debug_backtrace();
    $execFile = strtolower($debug[1]['file']);

    $executionContext = strrchr($debug[1]['file'], 'framework');;
    if (str_contains($execFile, 'app')) {
        $executionContext = strrchr($debug[1]['file'], 'App');
    } else if (str_contains($execFile, 'core')) {
        $executionContext = strrchr($debug[1]['file'], 'Core');
    }

    $execFileLineNumber = $debug[1]['line'];

    ob_start();
    var_dump($args);
    $outputBuffer = ob_get_contents();
    ob_end_clean();

    $outputBuffer = preg_replace("/\r\n|\r/", "\n", $outputBuffer);
    $outputBuffer = str_replace("]=>\n", '] = ', $outputBuffer);
    $outputBuffer = preg_replace('/= {2,}/', '= ', $outputBuffer);
    $outputBuffer = preg_replace("/\[\"(.*?)\"\] = /i", "[$1] = ", $outputBuffer);
    $outputBuffer = preg_replace('/  /', "    ", $outputBuffer);
    $outputBuffer = preg_replace("/\"\"(.*?)\"/i", "\"$1\"", $outputBuffer);
    $outputBuffer = preg_replace("/(int|float)\(([0-9\.]+)\)/i", "$1() <span class=\"number\">$2</span>", $outputBuffer);

    // Syntax Highlighting of Strings. This seems cryptic, but it will also allow non-terminated strings to get parsed.
    $outputBuffer = preg_replace("/(\[[\w ]+\] = string\([0-9]+\) )\"(.*?)/sim", "$1<span class=\"string\">\"", $outputBuffer);
    $outputBuffer = preg_replace("/(\"\n{1,})( {0,}\})/sim", "$1</span>$2", $outputBuffer);
    $outputBuffer = preg_replace("/(\"\n{1,})( {0,}\[)/sim", "$1</span>$2", $outputBuffer);
    $outputBuffer = preg_replace("/(string\([0-9]+\) )\"(.*?)\"\n/sim", "$1<span class=\"string\">\"$2\"</span>\n", $outputBuffer);

    $regex = [
        // Numbers
        'numbers' => ['/(^|] = )(array|float|int|string|resource|object\(.*\)|\&amp;object\(.*\))\(([0-9\.]+)\)/i', '$1$2(<span class="number">$3</span>)'],
        // Keywords
        'null' => ['/(^|] = )(null)/i', '$1<span class="keyword">$2</span>'],
        'bool' => ['/(bool)\((true|false)\)/i', '$1(<span class="keyword">$2</span>)'],
        // Types
        'types' => ['/(of type )\((.*)\)/i', '$1(<span class="type">$2</span>)'],
        // Objects
        'object' => ['/(object|\&amp;object)\(([\w]+)\)/i', '$1(<span class="object">$2</span>)'],
        // Function
        'function' => ['/(^|] = )(array|string|int|float|bool|resource|object|\&amp;object)\(/i', '$1<span class="function">$2</span>('],
    ];

    foreach ($regex as $x) {
        $outputBuffer = preg_replace($x[0], $x[1], $outputBuffer);
    }

    $style = '
    /* outside div - it will float and match the screen */
    .var_dump_print {
        margin: 2px;
        padding: 2px;
        background-color: #000
        float: left;
        clear: both;
        width:100%;
    }
    /* font size and family */
    .var_dump_print pre {
        color: #fff;
        font-size: 9pt;
        font-family: "Courier New",Courier,Monaco,monospace;
        margin: 0px;
        padding-top: 5px;
        padding-bottom: 7px;
        padding-left: 9px;
        padding-right: 9px;
    }
    /* inside div */
    .var_dump_print div {
    width:100%;
        background-color: #000;
        float: left;
        clear: both;
    }
    /* syntax highlighting */
    .var_dump_print span.string {color: #32CD32;}
    .var_dump_print span.number {color: #ff0000;}
    .var_dump_print span.keyword {color: #007200;}
    .var_dump_print span.function {color: #00C0F0;}
    .var_dump_print span.object {color: #ac00ac;}
    .var_dump_print span.type {color: #0072c4;}
    ';

    $style = preg_replace("/ {2,}/", "", $style);
    $style = preg_replace("/\t|\r\n|\r|\n/", "", $style);
    $style = preg_replace("/\/\*.*?\*\//i", '', $style);
    $style = str_replace('}', '} ', $style);
    $style = str_replace(' {', '{', $style);
    $style = trim($style);

    $outputBuffer = trim($outputBuffer);
    $outputBuffer = preg_replace("/\n<\/span>/", "</span>\n", $outputBuffer);

    $line1 = $label ? "<strong>$label</strong> \n" : '';

    $out = "\n<!-- var_dump_print Begin -->\n" .
        "<style type=\"text/css\">" . $style . "</style>\n" .
        "<div class=\"var_dump_print\">
        <div>$line1</div>
        <div><pre>$executionContext : $execFileLineNumber \n$outputBuffer\n</pre></div></div>
        <div style=\"clear:both;\">&nbsp;</div>" .
        "\n<!-- var_dump_print End -->\n";

    echo $out;
}