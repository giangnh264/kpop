<?php

Yii::import('application.models.db.FeatureSongModel');

class AdminFeatureSongModel extends FeatureSongModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function relations()
    {
        return  CMap::mergeArray( parent::relations(),   array(
            'song'=>array(self::BELONGS_TO, 'AdminSongModel', 'song_id', 'select'=>'id, name,artist_name'),
        ));
    }
    
    public function addList($adminId, $listSong=array())
	{
		//get all song feature
		$songFeature = self::model()->findAll();
		$songFeature = CHtml::listData($songFeature,'song_id','song_id');
		
		$c = new CDbCriteria();
		$c->condition = "status = ".SongModel::ACTIVE;
		$c->addInCondition("id", $listSong);
		$c->addNotInCondition("id", $songFeature);
		$songAdding = AdminSongModel::model()->findAll($c);
		foreach($songAdding as $song){
				$model = new self();
				$model->song_id = $song->id;
				$model->created_by = $adminId;
				$model->created_time = date("Y-m-d H:i:s");
				$model->save();
		}
	}
	
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('song_id',$this->song_id);
        $criteria->compare('created_by',$this->created_by);
        $criteria->compare('created_time',$this->created_time,true);
        $criteria->compare('sorder',$this->sorder);
        $criteria->compare('status',$this->status);
        $criteria->order = 'sorder ASC';
        
        $criteria->join = "INNER JOIN song ON song.id = t.song_id";        
        $criteria->condition = "song.status = ".SongModel::ACTIVE;
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                                'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
                        ),
        ));
    }
    
}