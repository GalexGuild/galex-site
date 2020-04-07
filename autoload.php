<?php
spl_autoload_register(function ($classname) {
    /* Directories we have to look in for our classes */
    $dirs = [
        ROOT . '/plugins/',
        ROOT . '/'
    ];

    foreach ($dirs as $dir) {
        $filename = $dir . str_replace('\\', '/', $classname) .'.php';

        if (file_exists($filename)) {
            require($filename);

            break;
        }
    }
});
?>
