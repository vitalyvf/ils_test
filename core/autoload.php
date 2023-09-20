<?php

require __DIR__ . '/functions.php';

$load_from = [
    '/Shipping/',
    '/Shipping/Services/'
];

foreach ($load_from as $dir) {
    $require_files = array_diff(scandir(__DIR__  . $dir), ['..', '.']);
    if (!empty($require_files)) {
        foreach ($require_files as $filename) {
            $file_extension = pathinfo(__DIR__ . $dir . $filename, PATHINFO_EXTENSION);
            if (is_file(__DIR__ . $dir . $filename) && $file_extension == 'php') {
                require __DIR__ . $dir . $filename;
            }
        }

    }
}
?>