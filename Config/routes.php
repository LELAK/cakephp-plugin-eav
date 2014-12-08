<?php

// Route the api path
Router::connect('/api/:apiVersion/eav/:controller/:action/*', array(
    'prefix' => 'api',
    'plugin' => 'eav',
    'controller' => ':controller',
    'action' => ':action',
    'api' => true
));
