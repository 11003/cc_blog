<?php

return [
    [
        'httpInterceptors'   => [
            ['group' => 'admin', 'interceptor' => 'module\core\login\interceptors\XbAdminLoginInterceptors',],
        ],
        'actionInterceptors' => [
            ['group' => 'admin', 'url' => '/core/index/index', 'action' => 'CC\action\module\core\index\CoreIndexIndexAdminAction',],
            ['group' => 'admin,api', 'url' => '/core/upfile/index', 'action' => 'CC\action\module\core\upfile\CoreUpfileIndexAction',],
        ]
    ]
];
