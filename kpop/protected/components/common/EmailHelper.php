<?php
class EmailHelper
{
	public static function send($code,$emailTo,$params=array())
	{	
		$emailModel = EmailTemplateModel::model()->find("code=:CODE",array(":CODE"=>$code));
		$saveParams = array();
		foreach ($params as $key=>$val){
			$saveParams["{{".$key."}}"]=$val;
		}
		
		$emailQueue = new EmailQueueModel();
		$emailQueue->template_id = $emailModel->id;
		$emailQueue->to = $emailTo;
		$emailQueue->params = json_encode($saveParams);
		$result = $emailQueue->save();
		if(!$result){
			return $emailQueue->getErrors();
		}
		return true;
	}
	
	public static function sentMail($id, $templateId, $to, $params = array())
	{		
		$emailModel = EmailTemplateModel::model()->findByPk($templateId);
		
		if(!empty($emailModel)){			
			$message = new YiiMailMessage;
			$message->setBody(strtr($emailModel->body,$params), 'text/html');
			$message->subject = strtr($emailModel->subject,$params);
			$message->addTo($to);			
			$message->from = (isset($emailModel->from) && $emailModel->from!="")?$emailModel->from:"admin@chacha.vn";			
			
			if(Yii::app()->mail->send($message)){
				$emailQueue = EmailQueueModel::model()->findByPk($id);
				$emailQueue->status = 1;
				$emailQueue->save();
				return true;
			}
		}
		return false;
	}
	
	public static function isEmailAddress($email){
        //$pattern = "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/";
        $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
        if(preg_match($pattern, $email)){
            return true;
        }
        return false;
    }
}