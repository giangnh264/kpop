<?php

class SmsMoConfirmModel extends BaseSmsMoConfirmModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SmsMoConfirm the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function check_confirm($msisdn, $content){
        $content = trim($content);
        $content = str_replace(" ", "", $content);
        $content = strtoupper($content);
        switch($content) {
            case "YA1":
                $commandCode = "A1";
                break;
            case "YA7":
                $commandCode = "A7";
                break;
            case "YA30":
                $commandCode = "A30";
                break;
            default:
                $commandCode = $content;
                break;
        }
        $now = time();
        $begin_time= date('Y-m-d H:i:s', $now - (60 * 30));
        $sql = "SELECT id FROM sms_mo_confirm WHERE msisdn = '{$msisdn}' AND content = '{$commandCode}' AND created_time >= '{$begin_time}' AND confirm_status = 0 ORDER BY id DESC LIMIT 1";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        if($data) {
            //update data
            $id = $data[0]['id'];
            $sql = "UPDATE sms_mo_confirm SET confirm_status = 1 WHERE id = $id";
            Yii::app()->db->createCommand($sql)->execute();
            return true;
        }
        else return false;
    }
}