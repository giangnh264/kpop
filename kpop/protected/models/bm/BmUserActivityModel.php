<?php

Yii::import('application.models.db.UserActivityModel');

class BmUserActivityModel extends UserActivityModel
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public function add($params) {
		if(isset($params['user_id']) && $params['user_id']!=0){
			$logUser				= new BmUserActivityModel();
			$logUser->user_id	 	= isset($params['user_id'])? $params['user_id']: '0';
			$logUser->user_phone 	= $params["msisdn"];
			$logUser->activity	 	= $params["cmd"];
			$logUser->channel	 	= $params["source"];
			$logUser->obj1_id	 	= isset($params['obj1_id'])? $params['obj1_id']: '0';
			$logUser->obj1_name	 	= isset($params['obj1_name'])? $params['obj1_name']: '';
			$logUser->obj1_url_key  = isset($params['obj1_url_key'])? $params['obj1_url_key']: '';
			$logUser->obj2_id		= isset($params['obj2_id'])? $params['obj2_id']: '0';
			$logUser->obj2_name		= isset($params['obj2_name'])? $params['obj2_name']: '';
			$logUser->obj2_url_key  = isset($params['obj2_url_key'])? $params['obj2_url_key']: '';
			$logUser->loged_time	= $params['createdDatetime'];

			$logUser->save();
		}

	}

}