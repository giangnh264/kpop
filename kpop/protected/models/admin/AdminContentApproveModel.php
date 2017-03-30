<?php

Yii::import('application.models.db.ContentApproveModel');

class AdminContentApproveModel extends ContentApproveModel
{
    var $className = __CLASS__;
	protected $_search_time = '';
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function relations()
    {
    	return array(
    			'song'=>array(self::BELONGS_TO, 'AdminSongModel', 'content_id'),
    			'video'=>array(self::BELONGS_TO, 'AdminVideoModel', 'content_id'),
    	);
    }
	public function attributeLabels()
    {
    	return array(
			'created_time' => Yii::t('app', 'Thời gian sửa'),
    		'status'=>Yii::t('app', 'Trạng thái'),
    		'content_type'=>Yii::t('app', 'Kiểu nội dung'),
    		'content_id'=>Yii::t('app', 'Nội dung'),
    		'admin_name'=>Yii::t('app', 'Tài khoản sửa'),
    		'approved_id'=>Yii::t('app', 'Tài khoản duyệt')
    		);
    }
    public static function LockContent($data, $action, $contentType='song', $contentId)
    {
    	//delete content 
    	$criteria = new CDbCriteria;
    	$criteria->condition = "content_id=:ctid AND content_type=:cttype AND status=0";
    	$criteria->params = array(':ctid'=>$contentId, ':cttype'=>$contentType);
    	$dataApp = self::model()->find($criteria);
    	if($dataApp) $dataApp->delete();
    	//
    	if($contentType=='song'){
    		$approvedContentTime = AdminSongModel::model()->findByPk($contentId)->updated_time;
    	}else{
    		$approvedContentTime = AdminVideoModel::model()->findByPk($contentId)->updated_time;
    	}
    	$model = new self();
    	$model->content_type = $contentType;
    	$model->content_id   = $contentId;
    	$model->admin_id     = Yii::app()->user->id;
    	$model->admin_name   = Yii::app()->user->name;
    	$model->data_change  = CJSON::encode($data);
    	$model->action	     = $action;
    	$model->created_time = date('Y-m-d H:i:s');
    	$model->approved_content_time = $approvedContentTime;
    	return $model->save();
    }
    public function search()
    {
    	// Warning: Please modify the following code to remove attributes that
    	// should not be searched.
    
    	$criteria=new CDbCriteria;
    
    	$criteria->compare('id',$this->id);
    	$criteria->compare('content_type',$this->content_type,true);
    	$criteria->compare('content_id',$this->content_id);
    	$criteria->compare('admin_id',$this->admin_id);
    	$criteria->compare('admin_name',$this->admin_name,true);
    	$criteria->compare('approved_id',$this->approved_id);
    	$criteria->compare('action',$this->action,true);
    	$criteria->compare('data_change',$this->data_change,true);
    	$criteria->compare('status',$this->status);
    	$criteria->compare('created_time',$this->created_time,true);
    	
    	if(!empty($this->_search_time)){
    		$criteria->addCondition("created_time >= '{$this->_search_time['from']}' AND created_time <= '{$this->_search_time['to']}'");
    	}
    	$criteria->order = "status asc, id desc";
    	return new CActiveDataProvider($this, array(
    			'criteria'=>$criteria,
    			'pagination'=>array(
    					'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
    			),
    	));
    }
}