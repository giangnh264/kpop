<?php
class LogDetectMsisdnModel extends BaseLogDetectMsisdnModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LogDetectMsisdn the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     *
     * @param string $phone
     * @param string $loginIp
     * @param string $deviceId
     * @param string $channel
     * @param integer $status
     * @param integer $detectType
     */
    public function logDetect($phone, $loginIp, $deviceId, $channel, $status, $detectType, $os = '', $user_agent='', $package_id=0, $event='', $referral='', $uri='')
    {
    	if(strlen($user_agent)>255) $user_agent = substr($user_agent, 0, 255);
    	if(strlen($referral)>255) $referral = substr($referral, 0, 255);
    	if(strlen($uri)>255) $uri = substr($uri, 0, 255);
        $logMsisdn = new LogDetectMsisdnModel();
        $logMsisdn->phone = $phone;
        $logMsisdn->login_ip = $loginIp;
        $logMsisdn->device_id = isset($deviceId)?$deviceId:"NULL";
        $logMsisdn->channel = $channel;
        $logMsisdn->loged_time = new CDbExpression("NOW()");
        $logMsisdn->status = $status;
        $logMsisdn->detect_type = $detectType;
        $logMsisdn->os = strtoupper($os);
        $logMsisdn->user_agent = $user_agent;
        $logMsisdn->package_id = $package_id;
        $logMsisdn->event = $event;
        $logMsisdn->referral = $referral;
        $logMsisdn->uri= $uri;

        $ret = $logMsisdn->save();
        if(!$ret){
        	Yii::log(CVarDumper::dumpAsString($logMsisdn->getErrors()), "error");
        }
        //log
        $logger = new MusicLogger(MusicLogger::INFO);
        $params = array();
        $params['channel'] = $channel;
        $params['network_type'] = Yii::app()->user->getState('is3G')?'3g':'wifi';
        $params['user_id'] = !empty($phone)?$phone:"NA";
        $params['package_id'] = !empty($package_id)?$package_id:"0";
        $params['package_name']="NA";
        if($package_id>0){
            $package = PackageModel::model()->findByPk($package_id);
            if($package){
                $params['package_name'] = $package->name;
            }
        }
        $params['ip'] = $loginIp;
        $params['source'] = $event;
        $params['os'] = $os;
        $params['user_agent'] = $user_agent;
        $params['url'] = $uri;
        $params['referer'] = $referral ;
        $strLog = implode('|',$params);
        $strLog = $strLog . '|';
        $logger->logVisit($strLog);
        if(!$ret){
            Yii::log(CVarDumper::dumpAsString($logMsisdn->getErrors()), "error");
        }
    }
}
