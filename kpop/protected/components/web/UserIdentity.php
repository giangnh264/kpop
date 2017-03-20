<?php
class UserIdentity extends CUserIdentity
{
	const ERROR_NO_VALID_PHONE=10;
	const ERROR_LIMITED_LOGIN = 403;
    private $_id;
    public $new;
    public $auto=false;

    public function authenticate()
    {
    	$phone = Formatter::formatPhone($this->username);
    	$user=WebUserModel::model()->findByPhone($phone);
    	
    	$keySession = session_id();
    	$numberFailLogin = isset(Yii::app()->session[$keySession])?Yii::app()->session[$keySession]:0;
    	if($numberFailLogin>=Yii::app()->params['login']['limit_block']){
    		$this->errorCode = self::ERROR_LIMITED_LOGIN;
    		return !$this->errorCode;
    		Yii::app()->end();
    	}
        if($user===null){
        	$numberFailLogin +=1;
	        $this->errorCode=self::ERROR_USERNAME_INVALID;
        }
        else if($user->password!==($this->auto?$this->password:UserIdentity::encodePassword($this->password)))
        {
        	$numberFailLogin +=1;
	        $this->errorCode=self::ERROR_PASSWORD_INVALID;
        }
        else if($user->validate_phone != 1){
        	$numberFailLogin +=1;
        	$this->errorCode=self::ERROR_NO_VALID_PHONE;
        }else
        {
            $userSub = UserSubscribeModel::model()->get($user->phone);
            if($userSub && !empty($userSub->package_id)){
                $package = PackageModel::model()->findByPk($userSub->package_id)->code;
            }else{
                $package="";
            }
            $this->_id=$user->id;
            $this->setState('lastLoginTime', $user->login_time);
            $this->setState('fullname', $user->fullname);
            $this->setState('username', $user->username);
            $this->setState('email', $user->email);
            $this->setState('phone', $user->phone);
            $this->setState('new', !$user->login_time);
            $this->setState('userSub', $userSub);
            $this->setState('packageCode', $package);
            $this->errorCode=self::ERROR_NONE;
            $user->login_time = date('Y-m-d H:i:s');
            $user->save();
        }
        Yii::app()->session[$keySession] = $numberFailLogin;
        if($numberFailLogin==Yii::app()->params['login']['limit_block']){
        	Yii::app()->session[$keySession.'_time'] = time();
        }
        return !$this->errorCode;
    }

    public function authnopass()
    {
    	$phone = Formatter::formatPhone($this->username);
    	$user=WebUserModel::model()->findByPhone($phone);

    	$this->_id=$user->id;
    	$this->setState('lastLoginTime', $user->login_time);
    	$this->setState('fullname', $user->fullname);
    	$this->setState('username', $user->username);
    	$this->setState('email', $user->email);
    	$this->setState('phone', $user->phone);
    	$this->setState('new', !$user->login_time);
    	$this->errorCode=self::ERROR_NONE;
    	$user->login_time = date('Y-m-d H:i:s');
    	$user->save();
    	/* $activity = new WebUserActivityModel();
    	$activity->fromLogin($user->id,$user->phone);
    	$activity->save(); */
    	return !$this->errorCode;
    }

    public static function encodePassword($password){
    	//return $password;
        return Common::endcoderPassword($password);
    }

    public function getId()
    {
        return $this->_id;
    }

    /**
     *
     * get random password string
     * @param int $length
     * @return string
     */
    public static function randomPassword($length=6) {
        $str = "0123456789abcdefghijklmopqrstuxyz";
        $min = 0;
        $max = strlen($str)-1;
        $password = "";
        for($i=0; $i<$length; $i++)
        {
            $char = $str[mt_rand($min, $max)];
            $password .= $char;
        }

        return $password;
    }

}