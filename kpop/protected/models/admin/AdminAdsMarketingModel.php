<?php

Yii::import('application.models.db.AdsMarketingModel');

class AdminAdsMarketingModel extends AdsMarketingModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function defaultScope()
    {
    	return array('condition'=>'status<>2');
    }
    public function rules()
    {
    	return CMap::mergeArray(parent::rules(),
    			array(
    					array('url_key', 'checkUnique'),
    			)
    	);
    }
    public function checkUnique()
    {
    	if($this->id>0){
    		$sql = "select count(*) as total from ads_marketing where url_key=:url_key and id<>:id";
    		$cmd = Yii::app()->db->createCommand($sql);
    		$cmd->bindParam(':url_key', $this->url_key, PDO::PARAM_STR);
    		$cmd->bindParam(':id', $this->id, PDO::PARAM_INT);
    		$c = $cmd->queryScalar();
    	}else{
    		$sql = "select count(*) as total from ads_marketing where url_key=:url_key";
    		$cmd = Yii::app()->db->createCommand($sql);
    		$cmd->bindParam(':url_key', $this->url_key, PDO::PARAM_STR);
    		$c = $cmd->queryScalar();
    	}
    	if($c) {
    		$this->addError('url_key','Url Key Đã tồn tại |'.$this->url_key);
    	}
    }
    public function checkUniqueCode()
    {
    	if($this->id>0){
    		$sql = "select count(*) as total from ads_marketing where code=:code and id<>:id";
    		$cmd = Yii::app()->db->createCommand($sql);
    		$cmd->bindParam(':code', $this->code, PDO::PARAM_STR);
    		$cmd->bindParam(':id', $this->id, PDO::PARAM_INT);
    		$c = $cmd->queryScalar();
    	}else{
    		$sql = "select count(*) as total from ads_marketing where code=:code";
    		$cmd = Yii::app()->db->createCommand($sql);
    		$cmd->bindParam(':code', $this->code, PDO::PARAM_STR);
    		$c = $cmd->queryScalar();
    	}
    	if($c) {
    		$this->addError('code','Mã Đã tồn tại |'.$this->code);
    	}
    }
    
    public function attributeLabels()
    {
    	return array(
    			'action'=>'Hành động',
    			'package_id'=>'Gói cước',
    			'short_link'=>'URL thu gọn',
    			'dest_link'=>'URL nội dung',
    			'description'=>'Mô tả',
    			'name'=>'Tên nội dung',
    			'code'=>'Mã',
    			'status'=>'Trạng thái'
    	);
    }
    public function search()
    {
    	// Warning: Please modify the following code to remove attributes that
    	// should not be searched.
    
    	$criteria=new CDbCriteria;
    
    	$criteria->compare('id',$this->id);
    	$criteria->compare('name',$this->name,true);
    	$criteria->compare('url_key',$this->url_key,true);
    	$criteria->compare('code',$this->code,true);
    	$criteria->compare('action',$this->action,true);
    	$criteria->compare('domain',$this->domain,true);
    	$criteria->compare('short_link',$this->short_link,true);
    	$criteria->compare('dest_link',$this->dest_link,true);
    	$criteria->compare('package_id',$this->package_id);
    	$criteria->compare('description',$this->description,true);
    	$criteria->compare('created_datetime',$this->created_datetime,true);
    	$criteria->compare('status',$this->status);
    	$criteria->order = 'id desc';
    	return new CActiveDataProvider($this, array(
    			'criteria'=>$criteria,
    			'pagination'=>array(
    					'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
    			),
    	));
    }
}