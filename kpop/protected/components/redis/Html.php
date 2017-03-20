<?php

/**
 * Created by PhpStorm.
 * User: KOIGIANG
 * Date: 7/20/2016
 * Time: 11:43 AM
 */
class Html extends RedisBase
{
    static $instance;
    /**
     * @param array $config
     * @return static
     */
    public static function getInstance($config = [])
    {
        if (!static::$instance) {
            static::$instance = new static($config);
        }
        return static::$instance;
    }

    public function __construct(array $config)
    {
        $this->type = 'html';
        parent::__construct($config);
    }

}