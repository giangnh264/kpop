<?php
return array(
    'components' => array(
        'redis_html' => array(
            'class' => 'ext.redis.CRedisCache',
            'servers' => array(
                array(
                    'host' => '127.0.0.1',
                    'port' => 6379,
                    'database' => 10,
                    'hashKey' => false,
                    'keyPrefix' => '',
                ),
            ),
        ),
        'redis_common' => array(
            'class' => 'ext.redis.CRedisCache',
            'servers' => array(
                array(
                    'host' => '127.0.0.1',
                    'port' => 6379,
                    'database' => 14,
                    'hashKey' => false,
                    'keyPrefix' => '',
                ),
            ),
        ),
    ),
);
