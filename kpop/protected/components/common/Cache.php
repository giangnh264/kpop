<?php
abstract class Cache{
    protected $cache;
    private $expired_time = 150;

    /*
     * @params int $time
     */
    public function setExpiredTime($time){
        $this->expired_time = $time;
    }

    /*
     * @return int
     */
    public function getExpiredTime(){
        return $this->expired_time;
    }

    public function __construct($config = array())
    {
        if(empty($config['type'])){
            return false;
        }
        $redis_type = 'redis_' . $config['type'];
        $this->cache = Yii::app()->$redis_type;
    }



    public function has($key){
        if(!isset($key) && empty($key)){
            return false;
        }
        return $this->cache->has($key);
    }

    public function get($key){
        return $this->cache->get($key);
    }

    public function set($key, $value){
        if(!isset($key) && empty($key)){
            throw new Exception('key must be set');
        }
        $this->cache->set($key, $value, $this->getExpiredTime());
    }

    public function rememberForever($key, Closure $callback){
        if(!isset($key) && empty($key)){
            throw new Exception('key must be set');
        }
        $this->cache->rememberForever($key, $callback !== null ? $callback : function(){});
    }

    public function remmeber($key, Closure $callback){
        if(!isset($key) && empty($key)){
            throw new Exception('key must be set');
        }
        $this->cache->remember($key, $this->getExpiredTime(), $callback !== null ? $callback : function(){});
    }

    public function remove($key){
        if(!isset($key) && empty($key)){
            throw new Exception('key must be set');
        }
        if(is_array($key) && !empty($key)) {
            foreach($key as $tmp_key) {
                $this->cache->forget($tmp_key);
            }
        }else{
            $this->cache->forget($key);
        }
    }

    public function flush(){
        $this->cache->flush();
    }

    public function del($key){
        if(!isset($key) && empty($key)){
            throw new Exception('key must be set');
        }
        $this->cache->del($key);
    }
}