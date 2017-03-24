<?php

/**
 * Created by PhpStorm.
 * User: KOIGIANG
 * Date: 7/20/2016
 * Time: 11:43 AM
 */
class CommonCache extends Cache
{
    protected static $_instance = null;

    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct()
    {
        $config['type'] = 'common';
        parent::__construct($config);
    }

}