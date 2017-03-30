<?php

Yii::import('application.models.db.PlaylistModel');

class AdminPlaylistModel extends PlaylistModel {

    var $className = __CLASS__;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function relations() {
        return CMap::mergeArray(parent::relations(), array(
                    'playliststatistic' => array(self::HAS_ONE, 'AdminPlaylistStatisticModel', 'playlist_id', 'joinType' => 'LEFT JOIN'),
                ));
    }

    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('url_key', $this->url_key, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('song_count', $this->song_count);
        $criteria->compare('artist_ids', $this->artist_ids, true);
        $criteria->compare('on_sidebar', $this->on_sidebar);
        $criteria->compare('suggest_1', $this->suggest_1);
        $criteria->compare('updated_time', $this->updated_time, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('ivr_order', $this->ivr_order);
        if (!empty($this->created_time)) {
            $criteria->addBetweenCondition('t.created_time', $this->created_time[0], $this->created_time[1]);
        }
        $joinWith = array();
        $joinWith[]='playliststatistic';
        $criteria->with = $joinWith;

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']),
                    ),
                ));
    }

}