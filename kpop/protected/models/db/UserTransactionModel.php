<?php
class UserTransactionModel extends BaseUserTransactionModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserTransaction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function add($params) {
		$transaction				= new self();
        $transaction->user_id		= isset($params['user_id'])? $params['user_id']: '0';
		$transaction->user_phone	= $params["msisdn"];
    	$transaction->price			= $params["price"];
    	$transaction->package_id	= isset($params['packageId'])? $params['packageId']: '0';
    	$transaction->transaction	= $params["cmd"];
    	$transaction->channel		= $params["source"];
    	$transaction->cp_id			= isset($params['cp_id'])? $params['cp_id']: '0';
    	$transaction->obj1_id		= isset($params['obj1_id'])? $params['obj1_id']: '0';
    	$transaction->obj1_name		= isset($params['obj1_name'])? $params['obj1_name']: '';
    	$transaction->obj1_url_key  = isset($params['obj1_url_key'])? $params['obj1_url_key']: '';
    	$transaction->obj2_id 		= isset($params['obj2_id'])? $params['obj2_id']: '0';
    	$transaction->obj2_name		= isset($params['obj2_name'])? $params['obj2_name']: '';
    	$transaction->sharing_rate	= isset($params['sharing_rate'])? $params['sharing_rate']: '0';
    	$transaction->created_time	= $params['createdDatetime'];
    	//$transaction->created_time	= new CDbExpression("NOW()");
        $transaction->return_code   = isset($params['return_code'])?$params['return_code']:'0';
        $transaction->genre_id      = isset($params['genre_id'])?$params['genre_id']:'0';
        $transaction->promotion     = isset($params['promotion'])?$params['promotion']:'0';
        $transaction->note          = $params['note'];
    	if(!$transaction->save(false)){
            return  $transaction->getErrors();
        }
		if($transaction->return_code == 0){
			if($transaction->transaction == 'play_song' || $transaction->transaction == 'play_video' || $transaction->transaction == 'subscribe' || $transaction->transaction == 'unsubscribe' ){
				$transaction_name = $transaction->transaction;
				if($transaction_name == 'subscribe'){
					if($transaction->obj1_name == 'A1'){
						$transaction_name = 'subscribe_a1';
					}
					if ($transaction->obj1_name == 'A7'){
                        $transaction_name = 'subscribe_a7';
                    }
				}
				$user_sub = UserSubscribeModel::model()->get($transaction->user_phone);
				if($user_sub || $transaction->transaction == 'subscribe' || $transaction->transaction == 'unsubscribe'){
					//log geaman
					try{
						$data = array(
							'msisdn' 		=> $transaction->user_phone,
							'user_id' 		=> $transaction->user_id,
							'source' 		=> $transaction->channel,
							'transaction' 	=> $transaction_name,
							'content_id' 	=> $transaction->obj1_id,
							'content_name'	=> $transaction->obj1_name,
							'log_point'		=> 1,
						);
						$paramsGM = array(
							"params" => $data
						);
//						$resGM = Yii::app()->gearman->client()->doBackground('doLogGami', json_encode($paramsGM));
					}catch (exception $ex){

					}
				}
			}

		}
		$logger = new MusicLogger(MusicLogger::INFO);
		$logger->generateLog($params);
        return true;
	}
	
	public function checkCharging24h($phone, $tophone, $objId, $type, $baseId=0) {
		$result = false;
		$criteria = new CDbCriteria;
		switch ($type)
		{
			case 'play_song' :
				$sql = "SELECT obj1_id
				FROM user_transaction
				WHERE user_phone='{$tophone}'
				AND transaction='{$type}'
				AND return_code='0'
				AND price>0
				AND obj1_id = '{$objId}'
				AND created_time  >= DATE_SUB(NOW(),INTERVAL 1 DAY)";
				$cmd = Yii::app()->db->createCommand($sql);
				$data = $cmd->queryAll();
				if(empty($data)){
				return false;
		}else{
		return true;
		}
	
		break;
		case 'download_song' :
		$sql = "SELECT obj1_id
		FROM user_transaction
		WHERE user_phone='{$tophone}'
		AND transaction='{$type}'
			AND return_code='0'
			AND price>0
			AND obj1_id = '{$objId}'
				AND created_time  >= DATE_SUB(NOW(),INTERVAL 1 DAY)";
				$cmd = Yii::app()->db->createCommand($sql);
				$data = $cmd->queryAll();
				if(empty($data)){
				return false;
		}else{
		return true;
		}
		break;
		default :
		$criteria->condition="user_phone=:PHONE AND obj1_id=:OBJ_ID AND transaction =:TRANSACTION AND return_code = '0' AND price>0";
		$criteria->addCondition("created_time  >= DATE_SUB(NOW(),INTERVAL 1 DAY)");
		$criteria->params=array(
		':PHONE'       => $tophone,
		':OBJ_ID'     => $objId,
		':TRANSACTION' => $type,
				);
				$trasaction = self::model()->find($criteria);
				if ($trasaction)
					$result = true;
				}
					return $result;
	}

	public function check_promotion_big($phone)
	{
		$sql = "SELECT * FROM user_transaction WHERE user_phone = '{$phone}' AND note like '%BIGTET_2016%' AND `transaction` = 'subscribe' AND return_code = 0 AND NOW() <= '2016-04-23 23:59:59'";
		$subscribe = Yii::app()->db->createCommand($sql)->queryAll();
		if(!empty($subscribe)){
			return false;
		}
		return true;
	}

    public function check_promotion_note($phone, $note)
    {
        $sql = "SELECT * FROM user_transaction WHERE user_phone = '{$phone}' AND note like '%{$note}%' AND `transaction` = 'subscribe' AND return_code = 0";
        $subscribe = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($subscribe)){
            return false;
        }
        return true;
    }
}