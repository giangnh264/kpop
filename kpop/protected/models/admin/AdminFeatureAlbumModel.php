<?php

Yii::import('application.models.db.FeatureAlbumModel');

class AdminFeatureAlbumModel extends FeatureAlbumModel
{
	var $className = __CLASS__;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function relations()
	{
		return  CMap::mergeArray( parent::relations(),   array(
            'album'=>array(self::BELONGS_TO, 'AdminAlbumModel', 'album_id', 'select'=>'id, name'),
		));
	}

	public function addList($adminId,$albumMass)
	{
		$albumFeature = AdminFeatureAlbumModel::model()->findAll();
		$albumFeature =  CHtml::listData($albumFeature,'album_id','album_id');
		
		$c = new CDbCriteria();
		$c->condition = "status = ".AlbumModel::ACTIVE;
		$c->addInCondition("id", $albumMass);
		$c->addNotInCondition("id", $albumFeature);
		$albumAdding = AdminAlbumModel::model()->findAll($c);
		
		foreach($albumAdding as $album){
			$albumFeatureObj = new AdminFeatureAlbumModel();
			$albumFeatureObj->album_id = $album['id'];
			$albumFeatureObj->created_by = $adminId;
			$albumFeatureObj->created_time = date("Y-m-d H:i:s");
			$albumFeatureObj->sorder = 0;
			$albumFeatureObj->status = 1;
			$albumFeatureObj->save();
		}
		
		return count($albumAdding);
	}

}