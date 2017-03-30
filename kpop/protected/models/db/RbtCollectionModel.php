<?php
class RbtCollectionModel extends BaseRbtCollectionModel
{
	const ACTIVE = 1;
	const DEACTIVE = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @return RbtCollection the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rbt_collection';
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('descripton',$this->descripton,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->order = "sorder ASC, id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}