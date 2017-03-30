<?php

Yii::import('application.models.db.FeatureVideoModel');

class AdminFeatureVideoModel extends FeatureVideoModel
{
	var $className = __CLASS__;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
    public function relations()
    {
        return  CMap::mergeArray( parent::relations(),   array(
            'video'=>array(self::BELONGS_TO, 'AdminVideoModel', 'video_id', 'select'=>'id, name, cp_id, artist_name'),
        ));
    }
    	
    public function addList($adminId, $listVideo=array())
	{
		//GET ALL VIDEO FEATURE
		$videoFeature = self::model()->findAll();
		$videoFeature = CHtml::listData($videoFeature,'video_id','video_id');
		
		$c = new CDbCriteria();
		$c->condition = "status = ".VideoModel::ACTIVE;
		$c->addInCondition("id", $listVideo);
		$c->addNotInCondition("id", $videoFeature);
		$videoAdding = AdminVideoModel::model()->findAll($c);
		foreach($videoAdding as $video){
				$model = new self();
				$model->video_id = $video->id;
				$model->created_by = $adminId;
				$model->created_time = date("Y-m-d H:i:s");
				$model->save();
		}
	}
		
	
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('video_id',$this->video_id);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('status',$this->status);
		$criteria->order = 'sorder ASC';
		
		$criteria->join = "INNER JOIN video ON video.id = t.video_id";        
        $criteria->condition = "video.status =".VideoModel::ACTIVE;
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                                'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
                        ),
		));
	}
}