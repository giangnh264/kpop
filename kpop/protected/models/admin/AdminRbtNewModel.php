<?php

Yii::import('application.models.db.RbtNewModel');

class AdminRbtNewModel extends RbtNewModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
      public function relations()
    {
        return  CMap::mergeArray( parent::relations(),   array(
            'rbt'=>array(self::BELONGS_TO, 'AdminRbtModel', 'rbt_id', 'select'=>'id, name,artist_name'),
        ));
    }
    public function addList($adminId, $listRbt=array())
	{
		//get all rbt feature
		$rbtNew = self::model()->findAll();
		$rbtNew = CHtml::listData($rbtNew,'rbt_id','rbt_id');
		
		$c = new CDbCriteria();
		$c->condition = "status = ".RbtModel::ACTIVE;
		$c->addInCondition("id", $listRbt);
		$c->addNotInCondition("id", $rbtNew);
		$rbtAdding = AdminRbtModel::model()->findAll($c);
		foreach($rbtAdding as $rbt){
				$model = new self();
				$model->rbt_id = $rbt->id;
				$model->created_by = $adminId;
				$model->created_time = date("Y-m-d H:i:s");
				$model->save();
		}
	}
        
        public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('rbt_id',$this->rbt_id);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('status',$this->status);
		$criteria->compare('new',$this->new);
              
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	} 
}