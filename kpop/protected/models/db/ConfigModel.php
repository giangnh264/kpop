<?php

class ConfigModel extends BaseConfigModel {

    /**
     * Returns the static model of the specified AR class.
     * @return Config the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * get config value by 'name'/ 'channel'
     * @param type $name
     * @return null
     */
    public static function getConfig($name = '', $channel = '') {
        $key_cache = $name .'_'.$channel;
        $data = Common::getCache($key_cache);
        if($data === false){
            $cr = new CDbCriteria();
            if($name){
                $cr->condition = 'name = :name';
                $cr->params = array(':name' => $name);
                $search = self::model()->findAll($cr);
                if (!empty($search)) {
                    $searchText = $search[0];
                    $text = $searchText->value;
                    return $text;
                }
                $return = null;
            }
            if($channel){
                $cr->condition = "channel=:CHANNEL OR channel = 'all'";
                $cr->params = array(":CHANNEL"=>$channel);
                $search = ConfigModel::model()->findAll($cr);
                if (!empty($search)) {
                    $res = array();
                    foreach($search as $result){
                        $res[$result->name] = array('value' => $result->value, 'type' => $result->type);
                    }


                    $return = $res;
                }
                $return = null;
            }
            $return = null;
            Common::setCache($key_cache,$res);
            return $return;
        }else{
            return $data;
        }

    }
}