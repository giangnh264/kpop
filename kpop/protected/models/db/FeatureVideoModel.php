<?php
class FeatureVideoModel extends BaseFeatureVideoModel
{
	const ACTIVE = 1;
	const DEACTIVE = 0;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return FeatureVideo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
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
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                                'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
                        ),
		));
	}
}