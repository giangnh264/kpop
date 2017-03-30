<?php
class SongFreeModel extends BaseSongFreeModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SongFree the static model class
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
			'song'=>array(self::BELONGS_TO, 'SongModel', 'song_id','condition'=>'song.status = 1'),		
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
		$criteria->compare('song_id',$this->song_id);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('list_id',$this->list_id);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('is_hot',$this->is_hot);
		$criteria->compare('is_new',$this->is_new);
		$criteria->compare('created_time',$this->created_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 't.sorder ASC'),
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}