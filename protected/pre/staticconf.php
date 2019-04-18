<?php

$_path = __DIR__.'/../../';

$config = 'conf.php';

return array_merge_recursive(include $_path.$config, [
    'auto_import'     => [],
    'params'          => []
]);
