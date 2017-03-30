<?php
class FeatureRingtoneModel extends BaseFeatureRingtoneModel
{
    const ALL = -1;
    const ACTIVE = 1;
	/**
	 * Returns the static model of the specified AR class.
	 * @return FeatureRingtone the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'rt'=>array(self::HAS_ONE, 'RingtoneModel', 'id', 'select'=>'id, name,artist_name,cp_id,category_id'),                           
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;               
		$criteria->compare('id',$this->id);
		$criteria->compare('rt_id',$this->rt_id);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('status',$this->status);
		$criteria->compare('featured',$this->featured);
        $criteria->with = array('rt');                
        $criteria->order = "t.id desc";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}