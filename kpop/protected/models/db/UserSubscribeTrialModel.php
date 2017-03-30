<?php
class UserSubscribeTrialModel extends BaseUserSubscribeTrialModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserSubscribeTrial the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function createTrial($phone)
	{
		$c = new CDbCriteria();
		$c->condition = "phone=:PHONE";
		$c->params = array(":PHONE"=>$phone);
		$userObj = UserModel::model()->find($c);
		$userId = false;
		if(empty($userObj)){
			$username = 'chacha'.md5('chacha'.rand().time());
			$password = rand(1000,9999);
			
			$userModel = new UserModel();
			$userModel->username=$username;
			$userModel->phone=$phone;
			$userModel->password=Common::endcoderPassword($password);
			$userModel->created_time = date('Y-m-d H:i:s');
			$userModel->updated_time = date('Y-m-d H:i:s');
			$userModel->email = "";
			$userModel->status=UserModel::ACTIVE;
			$userModel->gender=0;
			$userModel->address='';
			if($userModel->save()){
				$userId = $userModel->id;
			}else{
				//echo "<pre>";print_r($userModel->getErrors());exit(); 
			}
		}else{
			$userId = $userObj->id;
			$password = null;
		}
		if($userId !== false){
			$trialModel = new self();
			$trialModel->user_id = $userId;
			$trialModel->user_phone = $phone;
			$trialModel->user_phone = $phone;
			$trialModel->package_id = -1;
			$trialModel->created_time = date('Y-m-d H:i:s');
			$trialModel->expired_time = date('Y-m-d H:i:s',(time()+3*24*60*60));
			$trialModel->updated_time = date('Y-m-d H:i:s');
			$trialModel->status = 1;
			$trialModel->save();
			$return = array('error_code'=>0,'password'=>$password,'expired_time'=>$trialModel->expired_time);
		}else{
			$return = array('error_code'=>1,);
		}
		return $return;
	}

}