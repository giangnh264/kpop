<?php
class UserModel extends BaseUserModel
{
	const ACTIVE = 1;
	const DEACTIVE = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, phone, created_time', 'required'),
			array('gender, status', 'numerical', 'integerOnly'=>true),
			array('username, fullname, address', 'length', 'max'=>160),
			array('password', 'length', 'max'=>128),
			array('phone', 'length', 'max'=>16),
                        array('username, phone', 'unique'),
			array('email', 'length', 'max'=>45),
			//array('username', 'username'),
			array('login_time, updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, fullname, phone, gender, address, login_time, created_time, updated_time, status, email', 'safe', 'on'=>'search'),
		);
	}
	
    public function validateEmail($attribute,$params){
        if (preg_match("/^[A-Za-z_][A-Za-z0-9_.]*[A-Za-z0-9_]@[A-Za-z0-9_]+([.][A-Za-z0-9_]+)*[.][A-Za-z]{2,4}$/", $this->email)) {
            return true;
        } else {
            $this->addError('email',Yii::t('web','Email không hợp lệ'));
            return false;
        }
    }
    public function username($attribute,$params){
        if (preg_match("/^[A-Za-z_]([A-Za-z0-9_.@]+){5,45}$/", $this->username)) {
            return true;
        }
        $this->addError('username',Yii::t('web','Username chỉ gồm các ký tự a-z0-9_.@, 6-45 ký tự'));
        return false;
    }
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'trial'=>array(self::HAS_ONE, 'UserSubscribeTrialModel', 'user_id', 'joinType'=>'INNER JOIN', 'select'=>'*'),
		);
	}


    public function getAvatarPath($id=null,$size=150,$isFolder = false)
	{
		if(!isset($id)) $id = $this->id;
		if($isFolder){
			$savePath = Common::storageSolutionEncode($id);	
		}else{
			$savePath = Common::storageSolutionEncode($id).$id.".jpg";
		}
		$savePath = Common::storageSolutionEncode($id).$id.".jpg";
		$path = Yii::app()->params['storage']['userDir'].DIRECTORY_SEPARATOR.$size.DIRECTORY_SEPARATOR.$savePath;
		return $path;
			
	}
	
	public function getAvatarUrl($id=null, $size="150")
	{
		if(!isset($id)) $id = $this->id;
		return $path = AvatarHelper::getAvatar("user", $id, $size);
	}
	
    
    /**
     *
     * Hàm này thực hiện encode 1 artist thành string để lưu trong trường artist_data trong DB
     * @return string : json encode data
     */
    public function encodeData()
    {
        $data = array(
            'name' => $this->id,
            'url_key' => $this->username,
        );
        
        return json_encode($data);
    }
    
    /**
     *
     * Hàm này thực hiện decode trường artist_data thành mảng, khóa là thuộc tính tương ứng của artist
     * @param string $data
     * @return array 
     */
    public function decodeData($data)
    {
        return json_decode($data, true);
    }
    
    /**
     *
     * Hàm này thực hiện tạo tài khoản user
     * @param string $username
     * @param string $password
     * @param string $msisdn
     * @param string $package_id
     * @param string $email
     * @param string $status
     * @return user object 
     */    
	function _createUser($username,$password,$msisdn,$package_id,$email=null,$status=0){
        $model = new self();
        $model->username=$username;
        $model->phone=$msisdn;
        $model->password=Common::endcoderPassword($password);
        $now = date('Y-m-d H:i:s');
        $model->created_time = $now;
        $model->updated_time = $now;
        $model->email = $email;
        $model->status=$status;
        $model->gender=0;
        $model->address='';
        if($model->save()){
            $package = PackageModel::model()->findByPk($package_id);
            $subscribe = new UserSubscribeModel();
            $subscribe->user_id = $model->id;
            $subscribe->package_id = $package->id;
            $subscribe->user_phone = $msisdn;
            $subscribe->created_time=$now;
            $subscribe->expired_time=date('Y-m-d H:i:s',time()+$package->duration*24*60*60);
            $subscribe->save();
        }
        return $model;
    }
    
    function createUserFromSMS($msisdn,$package)
    {
    	$password = rand(1000,9999);
		$user = $this->_createUser('chacha'.md5('chacha'.rand().time()),$password,$msisdn, $package);
		
        if(count($user->getErrors('phone'))>0){
            $msg =  Yii::t('web','Số điện thoại đã đăng ký. Soạn {commandcode} gửi {shortcode} để lấy lại mật khẩu'
            ,array(
                            	'{commandcode}'=>Yii::app()->params['account.reset.password.commandcode'],
                            	'{shortcode}'=>Yii::app()->params['account.reset.password.shortcode'],
            ));
            
            return array("errorCode"=>1,"msg"=>$msg);
        }elseif(count($user->getErrors()) > 0){
        	$msg = Yii::t('web','Hệ thống tạm thời gián đoạn. Xin vui lòng đăng ký lại sau. Xin cảm ơn'.var_export($user->getErrors()));
        	return array("errorCode"=>2,"msg"=>$msg);
        }else{
        	$msg = Yii::t('web',Yii::app()->params['smsTemplates']['password'],array('{PASSWORD}'=>$password));
        	return array("errorCode"=>0,"msg"=>$msg);
        }
    }
    
    function unsubscribe($msisdn)
    {
    	$package_code = Yii::app()->params['account.register.commandcode'];
		$package = PackageModel::model()->findByAttributes(array("sms_command_code"=>$package_code));
		
		$user = UserSubscribeModel::model()->findByAttributes(array("user_phone"=>$msisdn));
		if(empty($user)){
			$msg = $package_code = Yii::app()->params['smsTemplates']['notfound'];
			return array("errorCode"=>1,"msg"=>Yii::t('web',$msg));
		}else{
			$oldPackage = PackageModel::model()->findByPk($user->package_id)->name;		
			$user->package_id = $package->id;
			
			if($user->update()){
				$msg = Yii::t('web',Yii::app()->params['smsTemplates']['unsubscribe'],array('{PACKAGE}'=>$oldPackage));    		
	    		return array("errorCode"=>0,"msg"=>$msg);
	    	}else{
	    		return array("errorCode"=>1,"msg"=>Yii::t('web','Hệ thống tạm thời gián đoạn. Xin vui lòng thử lại sau. Xin cảm ơn'));
	    	}		
		}
    }
    
    function resetpassword($msisdn,$password=null)
    {
    	if(!isset($password) || $password==null){
    		$password = rand(1000,9999);
    	}    	
    	
    	$user = self::model()->findByAttributes(array("phone"=>$msisdn));
    	if(empty($user)){
    		$msg = $package_code = Yii::app()->params['smsTemplates']['notfound'];
    		return array("errorCode"=>0,"msg"=>$msg);
    	}else{
    	    $user->password = Common::endcoderPassword($password);
	    	if($user->update()){
                    $msg = Yii::t('web',Yii::app()->params ['subscribe'] ['success_password'], array( ":PHONE" => $msisdn, ":PASS" => $password  ));
	    		return array("errorCode"=>0,"msg"=>$msg);
	    	}else{
	    		return array("errorCode"=>1,"msg"=>Yii::t('web','Hệ thống tạm thời gián đoạn. Xin vui lòng đăng ký lại sau. Xin cảm ơn'));
	    	}    	
    	}
    }
    
    function updateInfo($id,$info=array())
    {
    	$userModel = self::model()->findByPk($id);
    	if(isset($info['full_name'])){
    		$userModel->fullname = $info['full_name'];
    	}
    	if(isset($info['gender'])){
    		$userModel->gender = $info['gender'];
    	}
    	if(isset($info['address'])){
    		$userModel->address = $info['address'];
    	}
    	if(isset($info['dob'])){
    		$userExtra = ApiUserExtraModel::model()->findByPk($id);
    		if(empty($userExtra)){
    			$userExtra = new ApiUserExtraModel();
    			$userExtra->user_id = $id;
    		}
    		$userExtra->birthday = $info['dob'];
    		$userExtra->save();
    	}
    	$userModel->save();
    }
    
    public function findByPrefix($prefix,$limit=6,$offset=0){
		$criteria = new CDbCriteria();
		$criteria->condition = "(username LIKE :query OR fullname LIKE :query) AND status=".self::ACTIVE;
		$criteria->params = array(":query"=>$prefix.'%');
		$criteria->offset=$offset;
		$criteria->limit=$limit;
		return self::model()->findAll($criteria);
	}
	
	// Check is trial mode
	public function isTrial($phone)
	{
		$c = new CDbCriteria();
		//$c->condition = "trial.user_phone=:UPHONE AND trial.created_time >= date_sub(now(), interval 72 hour)";
		$c->condition = "trial.user_phone=:UPHONE";
		$c->params = array(':UPHONE'=>$phone);		
		$data =  self::model()->with('trial')->find($c);
		return $data;
	}

	public function add($params) {
		$userModel = new self();
		
		$userModel->username 	= isset($params['username'])?$params['username']:'';
		$userModel->password 	= isset($params['password'])?$params['password']:'';
		$userModel->fullname 	= isset($params['fullname'])?$params['fullname']:'';
		$userModel->phone		= isset($params['msisdn'])?$params['msisdn']:'';
		$userModel->email		= isset($params['email'])?$params['email']:'';
		$userModel->gender 		= isset($params['gender'])?$params['gender']:'1';
		$userModel->address 		= isset($params['address'])?$params['address']:'';
		$userModel->suggested_list 		= isset($params['suggested_list'])?$params['suggested_list']:'';
		$userModel->created_time = date("Y-m-d H:i:s");
		$userModel->updated_time = date("Y-m-d H:i:s");
		$userModel->validate_phone = 1;
		$userModel->validate_phone_time = date("Y-m-d H:i:s");
		$userModel->status 		= isset($params['status'])?$params['status']:UserModel::ACTIVE;
		if(Formatter::isPhoneNumber($params['msisdn'])){
			$userModel->validate_phone = 1;
			$userModel->validate_phone_time = date("Y-m-d H:i:s");
		}
		
		
		$userModel->save();	
		return $userModel;
	}

    // update user information
    public function updateCustom($userId, $params){
        $userModel = UserModel::model()->findByPk($userId);
        foreach($params as $key => $val){
            $userModel->$key = $val;
        }
        $userModel->save(false);
        return $userModel;        
    }
    /**
     * author : longtv
     * @param string $phone
     */
    public function checkUserPhone($phone)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = "phone=:PHONE";
        $criteria->params = array(":PHONE"=>$phone);
        $result = self::model()->find($criteria);
        return $result;
    }	
    
    
    
    public function getThumbnailUrl($size,$user_id=null){
	    if(!$user_id)$user_id=$this->id;
	    $user = Yii::app()->user;
	    $thumb = AvatarHelper::getAvatar('user',$user_id, $size);
	    if((!$user->isGuest)&&$user->getId()==$user_id){
	        $thumb.='?'.$user->getState('avatar_updated','');    
	    }
		return $thumb;
	}    
	
	
	/*
	Them nguoi dung vao bang user, voi thong tin "suggested_list"
	*/
    public static function addUser($phone, $group_code = 'MIENTAY'){
		/* check if user exists in phone_book table */
		$exist = PhoneBookModel::model()->exists("phone = :P AND group_code = :GR",array(':P'=>$phone, ':GR' => $group_code ));
		if(!$exist)
			return false;
        //get suggest by code
		$suggestId = SuggestModel::getSuggestByCode($group_code);
        //sugget ko ton tai
		if(empty($suggestId))
			return false;

        $cri2 = new CDbCriteria;
        $cri2->condition = "phone = $phone";
        $user = UserModel::model()->findAll($cri2);
		//user da ton tai
        if (!empty($user[0])) {
			$user  = $user[0];
			var_dump('user exists');
			$suggested_list = trim($user->suggested_list);
			$arr = explode(',',$suggested_list);
			//sugget chua co trong suggested_list
			if(!in_array($suggestId, $arr))
			{
				if(count($arr) >= 1 && trim($arr[0]) != "")
					$suggested_list .= ",".$suggestId;
				else
					$suggested_list = $suggestId;
					
				$uId = $user->id;	
				$model = UserModel::model()->findByPk($uId);
				$model->suggested_list = $suggested_list;
				if($model->save())
					return true;
				return false;
			}
			//sugget da co trong suggested_list
			return true;
        }
		//user ko ton tai
        else{
			$userData = array();			
            $userData['suggested_list'] = $suggestId;
            $userData['email'] = "";
            $userData['fullname'] = $userData['username'] = Formatter::formatPhone($phone);
            $generatePass = VegaCommonFunctions::randomPassword();
            $userData['password'] = md5($generatePass);
            $userData['msisdn'] = Formatter::formatPhone($phone);
            $userModel = new UserModel;
            $createUser = $userModel->add($userData);
			if($createUser) 
				return true;
			return false;	
        }
    }
    
    public function activeUser($code,$phone='')
    {

    	if($phone!=''){
    		$crit = new CDbCriteria();
    		$crit->condition = "msisdn=:phone";
    		$crit->params = array(':phone'=>$phone);
    		$crit->order = "id DESC";
    		$crit->limit = 1;
    		$verify = UserVerifyModel::model()->find($crit);
    		$codeVerify = $verify?$verify->verify_code:'';
    		if($codeVerify!=$code){
    			$verify = false;
    		}
    	}else{
    		$verify = UserVerifyModel::model()->findByAttributes(array("verify_code"=>$code,"action"=>"register"));
    	}
    	if($verify){
            $phone = $verify->msisdn;
    		$user = self::model()->findByAttributes(array("phone"=>$phone));
    		if(empty($user)){
    			$user = new self();
    			$user->created_time = new CDbExpression("NOW()");
    		}
    		$meta = json_decode($verify->params);
    		$user->username =$meta->username;
    		$user->fullname =$meta->fullname;
    		$user->password =$meta->password;
    		$user->phone =$phone;
    		$user->updated_time = new CDbExpression("NOW()");
    		$user->validate_phone = 1;
    		$user->validate_phone_time = new CDbExpression("NOW()");
    		$user->status = 1;
    		if($user->isNewRecord){
    			$user->insert();
    		}else{
    			$user->update();
    		}
    		$verify->delete();
    		return $phone;
    	}else{
    		return false;
    	}
    }
    
    public function checkUsername($username)
    {
    	$userObj = self::model()->findByAttributes(array('username'=>$username));
    	if(!empty($userObj)){
    		$lastchar =  substr($username, -1);
    		$lastchar2 =  substr($username, -2, 1);
    
    		if(is_numeric($lastchar) && $lastchar2=="."){
    			// Neu ton tai 1 username dang uname.2 thi chuyen tiep sang uname.3
    			$fname = substr($username,0, -1).($lastchar+1);
    		}else{
    			$fname = $username.".2";
    		}
    		$username = $this->checkUsername($fname);
    	}
    	return $username;
    }  
}