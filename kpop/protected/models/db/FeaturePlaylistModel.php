<?php
class FeaturePlaylistModel extends BaseFeaturePlaylistModel {

    const ACTIVE = 1;
    const DEATIVE = 0;

    /**
     * Returns the static model of the specified AR class.
     * @return FeaturePlaylist the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('playlist_id', $this->playlist_id);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('sorder', $this->sorder);
        $criteria->compare('status', $this->status);
        $criteria->order = "sorder ASC";
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']),
                    ),
                ));
    }

    

}