<?php
//Yii::import("application.vendors.fundial.*");
Yii::import("application.vendors.fundial_vascmd.*");
Yii::import("application.vendors.fundial_8xxx.*");

class Ringbacktone
{
	public function download($params=array())
	{
		$log = new KLogger('setupSongAsRingtune_DownloadRbt', KLogger::INFO);
		$logTrans = array();
		$logTrans['msisdn'] = $params['msisdn'];
		
		/*if(!$fund->isLogin()){
			return array('errorCode'=>401,'message'=>'Số điện thoại chưa đăng ký dịch vụ ringtunes');
		}*/
		
		$content = RbtModel::model()->findByAttributes(array('code'=>$params['itemCode']));
		if(empty($content)){
			return  array('errorCode'=>1,'message'=>'Ringbacktone not found');
		}
		else
		{
			$contentId = $content->content_id;
			if($params['msisdn'] == $params['to_phone']){
                $add8x = Fundial8xxx::getInstance()->buySong($params['msisdn'], $params['itemCode']);
                $error = $add8x->ERR_CODE;
				$msg = $add8x->ERR_DESC;
				$logTrans['cmd'] = 'download_rbt'; 
				$log->LogInfo("8xxxx| $error | $msg",false);
			}else{
                $fund = FundialUtil::getInstance($params['msisdn']);
				$add = $fund->addGiftToPlaylist($contentId, $params['to_phone']);				
				$error = $add["SUBSCRIBER"]["ERROR"]["value"];
				$msg  = $add["SUBSCRIBER"]["ERROR_DESC"]["value"];
				$logTrans['cmd'] = 'send_rbt';
				$log->LogInfo("$error | $msg",false);
			}
			 
			if($error == "0"||$error == 0 ){
				$rbt = RbtModel::model()->getByCode($params['itemCode']);
				
				//Log to rbt_download
				$rbtDL = new RbtDownloadModel();
				$rbtDL->user_id = 0;
				$rbtDL->rbt_id = $rbt->id;
				$rbtDL->rbt_code = $params['itemCode'];
				$rbtDL->from_phone = $params['msisdn'];
				$rbtDL->to_phone = $params['to_phone'];
				$rbtDL->price = $rbt->price;
				$rbtDL->amount = 1;
				$rbtDL->message = "";
				$rbtDL->channel = $params['channel'];
				$rbtDL->download_datetime = new CDbExpression("NOW()");
				$rbtDL->save();

				//Log to rbt_statistic
				$rbtSTT = RbtStatisticModel::model()->findByPk($rbt->id);
				if(empty($rbtSTT)){
					$rbtSTT = new RbtStatisticModel();
					$rbtSTT->rbt_id = $rbt->id;
					$rbtSTT->downloaded_count = 1;
				}else{
					$rbtSTT->downloaded_count = $rbtSTT->downloaded_count + 1;
				}
				$rbtSTT->save();
			}
			
			//Log to transaction
			$logTrans['price'] = $rbt->price;
			$logTrans['source'] = $params['channel'];
			$logTrans['obj1_id'] = $params['itemCode'];
			$logTrans['obj1_name'] = $rbt->name;
			$logTrans['obj2_name'] = $params['to_phone'];
			$logTrans['createdDatetime'] = new CDbExpression("NOW()");
			$logTrans['return_code'] = $error;
			$logTrans['price'] = $content->price;
			
			BmUserTransactionModel::model()->add($logTrans);
			$log->LogInfo("End | $error | $msg",false);
			return  array('errorCode'=>$error,'message'=>$msg);
		}
	}
}