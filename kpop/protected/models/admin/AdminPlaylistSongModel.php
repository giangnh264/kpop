<?php

Yii::import('application.models.db.PlaylistSongModel');

class AdminPlaylistSongModel extends PlaylistSongModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
	public function relations()
	{
		return  CMap::mergeArray( parent::relations(),   array(
            'song'=>array(self::BELONGS_TO, 'AdminSongModel', 'song_id', 'select'=>'id, name','joinType'=>'INNER JOIN'),
		));
	}
}