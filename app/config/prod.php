<?php

// Timezone.
date_default_timezone_set('Europe/Paris');

// Cache
$app['cache.path'] = __DIR__ . '/../cache';

// Twig cache
$app['twig.options.cache'] = $app['cache.path'] . '/twig';

// Doctrine (db)
/*$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'host'     => '127.0.0.1',
    'dbname'   => 'mderame_margo',
    'user'     => 'mderame_margo',
    'password' => 'Maxime09',
);*/
$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'host'     => 'localhost',
    'dbname'   => 'margo3',
    'user'     => 'root',
    'password' => 'mysql',
    'driverOptions' => array(
      1002 => 'SET NAMES utf8'
    )
);
