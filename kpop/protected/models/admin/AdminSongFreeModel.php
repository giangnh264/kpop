<?php

Yii::import('application.models.db.SongFreeModel');

class AdminSongFreeModel extends SongFreeModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.song_id',$this->song_id);
		$criteria->compare('t.created_time',$this->created_time,true);
		$criteria->with = array('song');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 't.sorder ASC'),
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
        
        public function addList($adminId, $listSong=array())
	{
		//get all song feature
		$songFree = self::model()->findAll();
		$songFree = CHtml::listData($songFree,'song_id','song_id');
		
		$c = new CDbCriteria();
		$c->condition = "status = ".SongModel::ACTIVE." AND sync_status = ".SongModel::ACTIVE;
		$c->addInCondition("id", $listSong);
		$c->addNotInCondition("id", $songFree);
		$songAdding = AdminSongModel::model()->findAll($c);
		foreach($songAdding as $song){
				$model = new self();
				$model->song_id = $song->id;
				$model->created_by = $adminId;
				$model->created_time = date("Y-m-d H:i:s");
				$model->save();
		}
	}
	    
}