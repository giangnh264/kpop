<?php

Yii::import('application.models.db.FavouritePlaylistModel');

class AdminFavouritePlaylistModel extends FavouritePlaylistModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
	public function relations()
	{
		return  CMap::mergeArray( parent::relations(),   array(
            'user'=>array(self::BELONGS_TO, 'AdminUserModel', 'user_id', 'select'=>'id, username','joinType'=>'INNER JOIN'),
		));
	}    
}