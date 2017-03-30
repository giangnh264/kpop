<?php

Yii::import('application.models.db.UserActivityModel');

class AdminUserActivityModel extends UserActivityModel
{
    var $className = __CLASS__;
    public static $activities = array('login','subscribe','unsubscribe','play_song','download_song','add_to_favourite','share_song','play_album','subscribe_album','share_album','play_radio','play_video','download_video','play_playlist','create_playlist','add_to_playlist','share_playlist','subscribe_playlist','subscribe_artist','download_ringtone');
    //array(""=>"Tất cả","login"=>"Login","subscribe"=>"Subscribe");
    public static $channels = array("api","wap","web");
    ////array(""=>"Tất cả","web"=>"Web","wap"=>"Wap","api"=>"Api");


	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('user_phone',Formatter::formatPhone($this->user_phone),true);
		$criteria->compare('activity',$this->activity,true);
		$criteria->compare('channel',$this->channel,true);
		if($this->obj1_id){
			$criteria->compare('obj1_id',$this->obj1_id,true);
		}
		if($this->obj2_id){
			$criteria->compare('obj2_id',$this->obj2_id,true);
		}
		$criteria->compare('obj1_name',$this->obj1_name,true);
		$criteria->compare('obj1_url_key',$this->obj1_url_key,true);
		$criteria->compare('obj2_name',$this->obj2_name,true);
		$criteria->compare('obj2_url_key',$this->obj2_url_key,true);

        if (is_array($this->loged_time)){
            $criteria->addBetweenCondition('loged_time', $this->loged_time[0], $this->loged_time[1]);
        }
        else
            $criteria->compare('loged_time',$this->loged_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 'id DESC'),
            'pagination'=>array(
            				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}


    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


    public function rules(){
        $rules = parent::rules();
        $rules[] = array('user_id, activity, channel, loged_time', 'required','on'=>"filter");
        return $rules;
    }
}