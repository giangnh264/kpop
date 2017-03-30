<?php

Yii::import('application.models.db.MgChannelSongModel');

class AdminMgChannelSongModel extends MgChannelSongModel {

    var $className = __CLASS__;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function addList($channel_Id, $listsong = array()) {
        //get all song channel
        $SongInChannel = self::model()->findAllByAttributes(array('channel_id'=>$channel_Id));
        $SongInChannel = CHtml::listData($SongInChannel, 'song_id', 'song_id');
        $c = new CDbCriteria();
        #$c->condition = "status = " . SongModel::ACTIVE;
        $c->addInCondition("id", $listsong);
        $c->addNotInCondition("id", $SongInChannel);
        $songAdding = AdminSongModel::model()->findAll($c);
        foreach ($songAdding as $song) {
            $model = new self();
            $model->channel_id = $channel_Id;
            $model->song_id = $song->id;
            $model->song_code = $song->code;
            $model->sorder = 0;
            $model->save();
        }
    }

    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('channel_id', $this->channel_id);
        $criteria->compare('song_id', $this->song_id, true);
        $criteria->compare('song_code', $this->song_code, true);
        //$criteria->compare('sorder',$this->sorder);
        $criteria->order = "sorder ASC";

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']),
                    ),
                ));
    }

}