<?php
spl_autoload_register(function($classname) {
    $fns = str_replace('Plancke\\HypixelPHP\\', '/src/', $classname);
    $fns = str_replace("\\", "/", $fns);

    $filename = __DIR__ . $fns . '.php';

    require($filename);
});

?>
