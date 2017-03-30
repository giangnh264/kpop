<?php

class FreeContentOnDayModel extends BaseFreeContentOnDayModel {

    /**
     * Returns the static model of the specified AR class.
     * @return FreeContentOnDay the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function Check_Free_On_Day() {
        $ip = $_SERVER['REMOTE_ADDR'];
        $cr = new CDbCriteria();
        $cr->condition = 'ip = :IP AND date = :DATE';
        $cr->params = array(":IP" => $ip, ":DATE" => date("Y-m-d"));
        $count = self::model()->count($cr);
        return $count;
    }

    public function add($params = array()) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $free_content_on_day = new FreeContentOnDayModel();
        $free_content_on_day->content_id = $params['content_id'];
        $free_content_on_day->ip = $ip;
        $free_content_on_day->msisdn = "";
        $free_content_on_day->type = $params['type'];
        $free_content_on_day->date = date("Y-m-d");
        $ret = $free_content_on_day->save();
        return $free_content_on_day;
    }

}
