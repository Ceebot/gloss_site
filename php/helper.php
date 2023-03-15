<?php

function vueTag($classname, $props = [])
{
    return "<div class='" . $classname . "' data-vue='" . json_encode($props) . "'></div>";
}

function limitSymbol($string, $countSymbol)
{
    if (strlen($string) > $countSymbol) {
        $string = substr($string, 0, $countSymbol);
        $string = rtrim($string, "!,.-");
        $string = substr($string, 0, strrpos($string, ' '));
        return $string . ' ...';
    } else return $string;
}
