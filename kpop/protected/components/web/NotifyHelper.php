<?php
class NotifyHelper{
    public static function notify($activity,$type,$user_id=null,$name=null){
        if(!$user_id){
            $user_id=Yii::app()->user->getId();
            $name = Yii::app()->user->getState('fullname');
        }
        $fans = WebUserFriendModel::model()->findFanIdsByUser($user_id);
        if(count($fans)>0){
            $notify = Yii::app()->notify->load();
            $msg = $activity->getAttributes();
            unset($msg['user_id']);
            unset($msg['user_phone']);
            unset($msg['obj1_url_key']);
            unset($msg['obj2_url_key']);
            unset($msg['channel']);            
            $notify->broadcast($user_id,$name,$fans,$msg,$type);
            $notify->close();
        }
    }
    public static function send($activity,$to){
        $user_id=Yii::app()->user->getId();
        $name = Yii::app()->user->getState('fullname');
        $notify = Yii::app()->notify->load();
        $msg = $activity->getAttributes();
        unset($msg['user_id']);
        unset($msg['user_phone']);
        unset($msg['obj1_url_key']);
        unset($msg['obj2_url_key']);
        unset($msg['channel']);
        $rs = $notify->broadcast($user_id,$name,$to->id,$msg,'gift');
        $notify->close();
        return $rs;
    }
}
