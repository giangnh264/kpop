<?php

Yii::import('application.models.db.AlbumSongModel');

class AdminAlbumSongModel extends AlbumSongModel
{
	var $className = __CLASS__;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function relations()
	{
		return  CMap::mergeArray( parent::relations(),   array(
		));
	}
    public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('song_id',$this->song_id);
		$criteria->compare('album_id',$this->album_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('sorder',$this->sorder);
        $criteria->order = "sorder ASC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}