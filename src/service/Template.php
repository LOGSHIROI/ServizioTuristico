<?php
namespace service;

class Template
{
    public static function render($file, $data = null) {
        $path_to_file = __DIR__ . "\\..\\view\\" . $file . '.php';
        $GLOBALS["TEMPLATE_DATA"] = $data;
        include $path_to_file;
    }
}
