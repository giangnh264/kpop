<?php

Yii::import('application.models.db.CollectionItemModel');

class AdminCollectionItemModel extends CollectionItemModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function addList($userId, $collect_id, $listId=array(),$type = NULL)
	{
		//get all collection item
        $cri = new CDbCriteria();
        $cri->condition = "collect_id = $collect_id";
        $item = self::model()->findAll($cri);
        $item = CHtml::listData($item,'item_id','item_id');

        $c = new CDbCriteria();
        
        if($type == "song")
            $c->condition = "status = ".SongModel::ACTIVE;
        if($type == "video")
            $c->condition = "status = ".VideoModel::ACTIVE;
        if($type == "album")
            $c->condition = "status = ".AlbumModel::ACTIVE;
        if($type == "playlist")
            $c->condition = "status = ".PlaylistModel::ACTIVE;
        if($type == "rbt")
            $c->condition = "deleted = 0";
        if($type == "video_playlist")
            $c->condition = "status = ".VideoPlaylistModel::ACTIVE;
        
        $c->addInCondition("id", $listId);
        $c->addNotInCondition("id", $item);
        if($type == "song")
            $songAdding = AdminSongModel::model()->findAll($c);
        if($type == "video")
            $songAdding = AdminVideoModel::model()->findAll($c);
        if($type == "album")
            $songAdding = AdminAlbumModel::model()->findAll($c);
        if($type == "playlist")
            $songAdding = AdminPlaylistModel::model()->findAll($c);
        if($type == "rbt")
            $songAdding = AdminRbtModel::model()->findAll($c);
        if($type == "video_playlist")
            $songAdding = AdminVideoPlaylistModel::model()->findAll($c);
        foreach($songAdding as $song){
            $model = new self();
            $model->collect_id = $collect_id;
            $model->item_name = $song->name;
            $model->item_id = $song->id;
            $model->created_by = $userId;
            $model->created_time = date("Y-m-d H:i:s");
            $model->save();
        }
    }
    
    
    public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('collect_id',$this->collect_id);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('item_name',$this->item_name,true);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_time',$this->created_time,true);
        

        /* Order by Suggest id */
        $id = Yii::app()->request->getParam('suggest',null);        
        if(isset($id)){
            $suggest = "suggest_".$id;
            $collect = AdminCollectionModel::model()->findByPk($this->collect_id);
            $type = $collect->type;
            $criteria->join = "INNER JOIN $type ON t.item_id = $type.id ";            
            $criteria->order = "$type.$suggest DESC, sorder ASC, id DESC";
        }
        else
            $criteria->order = "sorder ASC, id DESC";
        
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}