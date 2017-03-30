<?php
class RbtArtistModel extends BaseRbtArtistModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RbtArtist the static model class
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
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('artist_song_id',$this->artist_song_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('sorder',$this->sorder);
		$criteria->order = "sorder ASC, id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}