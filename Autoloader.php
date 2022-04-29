<?php
/**
 * Mohammad Elmsalm
 **/
namespace Autoloader;
class Autoloader
{
    public function __construct($directories)
    {
        foreach ($directories as $directory) {
            $dir = dir($directory);

            while (($file = $dir->read()) !== false) {
                $pathInfo = pathinfo($directory . "\\" . $file);
                // printing Filesystem objects/functions with PHP
                if ($pathInfo["extension"] == "php") {
                    require_once $directory . "\\" . $file;
                }
            }
            $dir->close();
        }
    }
}