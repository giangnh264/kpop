<?php

Yii::import('application.models.db.VideoCopyrightModel');

class AdminVideoCopyrightModel extends VideoCopyrightModel
{
    var $className = __CLASS__;
    public $pageSize = 30;
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('video_id',$this->video_id,true);
        $criteria->compare('copryright_id',$this->copryright_id);
        $criteria->compare('type',$this->type);
        $criteria->compare('from_date',$this->from_date,true);
        $criteria->compare('due_date',$this->due_date,true);
        $criteria->compare('sorder',$this->sorder,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=> $this->pageSize
            ),
        ));
    }
}