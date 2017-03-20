<?php

class RedisBase extends Cache{

    public function __construct(array $config)
    {
        parent::__construct($config);
    }
}