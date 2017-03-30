<?php

Yii::import('application.models.db.LogActionModel');

class AdminLogActionModel extends LogActionModel
{
    var $className = __CLASS__;
	protected $_cskh=false;
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function search()
    {
    	$criteria=new CDbCriteria;
    
    	$criteria->compare('adminName',$this->adminName,true);
    	$criteria->compare('controller',$this->controller,true);
    	$criteria->compare('action',$this->action,true);
    	$criteria->compare('params',$this->params,true);
    	$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('msisdn',$this->msisdn,true);
		$criteria->order = "id DESC";
		if ($this->_cskh) {
			$sql = "SELECT * FROM `admin_access_assignments` where itemname like '%cskh%'";
			$command = Yii::app()->db->createCommand($sql);
			$data = $command->queryAll();
			$ids = array();
			foreach($data as $item){
				$ids[] = $item['userid'];
			}
			$ids = implode(',', $ids);
			$criteria->addCondition("adminId IN ($ids)");
		}else{
			$criteria->compare('adminId',$this->adminId);

		}
    	return new CActiveDataProvider($this, array(
    			'criteria'=>$criteria,
    			'pagination'=>array(
    					'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
    			),
    	));
    }

	public function getList(){
		$sql = 'SELECT DISTINCT (action) FROM log_action';
		$data= Yii::app()->db->createCommand($sql)->queryAll();
		return $data;
	}

	public function getListCSKH(){
		$sql = 'SELECT DISTINCT (action) FROM log_action WHERE controller = "customer" ';
		$data= Yii::app()->db->createCommand($sql)->queryAll();
		return $data;
	}
}