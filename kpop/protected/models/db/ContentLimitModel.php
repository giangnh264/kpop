<?php

class ContentLimitModel extends BaseContentLimitModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ContentLimit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    public static function checkPermisionList($objIds, $objType, $userType, $channel = "ALL")
    {
        /*if(!is_array($objIds)){
            $objIds = array($objIds);
        }
        $idIn = implode(',', $objIds);*/
        $c = new CDbCriteria();
        $c->addInCondition("content_id", $objIds);
        $condition = "content_type=:TYPE AND begin_time<=NOW() AND end_time >=NOW()";
        $condition .= " AND apply LIKE :APPLY_USER";
        $condition .= " AND (channel LIKE :CHANNEL OR channel LIKE '%ALL%')";
        $c->condition = $condition;
        $c->params = array(
            ":TYPE"=>$objType,
            ":CHANNEL"=>"%".$channel."%",
            ":APPLY_USER"=>"%$userType%",
        );

        $listLimitContent = self::model()->findAll($c);
        if($listLimitContent){
            $idLimit = array();
            foreach($listLimitContent as $item){
                $idLimit[]=$item->content_id;
            }
            return $idLimit;
        }
        return false;
    }
	public static function checkPermision($objId, $objType, $userType, $channel = "ALL")
	{
		$c = new CDbCriteria();
		$condition = "content_id=:OBJID AND content_type=:TYPE AND begin_time<=NOW() AND end_time >=NOW()";
		$condition .= " AND apply LIKE :APPLY_USER";
		$condition .= " AND (channel LIKE :CHANNEL OR channel LIKE '%ALL%')";
		$c->condition = $condition;
		
		$c->params = array(
				":OBJID"=>$objId,
				":TYPE"=>$objType,
				":CHANNEL"=>"%".$channel."%",
				":APPLY_USER"=>"%$userType%",
		);
		
		$checkPer = self::model()->findAll($c);
		if(!empty($checkPer)){
			return false;
		}
		return true;
	}
	
	public static function getPermision($objId, $objType, $userType, $channel = "ALL")
	{
		$c = new CDbCriteria();
		$condition = "content_id=:OBJID AND content_type=:TYPE AND begin_time<=NOW() AND end_time >=NOW()";
		$condition .= " AND apply LIKE :APPLY_USER";
		$condition .= " AND (channel LIKE :CHANNEL OR channel LIKE '%ALL%')";
		$c->condition = $condition;
	
		$c->params = array(
				":OBJID"=>$objId,
				":TYPE"=>$objType,
				":CHANNEL"=>"%".$channel."%",
				":APPLY_USER"=>"%$userType%",
		);
	
		$oneRow = self::model()->find($c);
		
		return $oneRow;
	}

	public function getIdByType($type,$channel,$userType){
		$c = new CDbCriteria();
		$condition = "content_type=:TYPE AND begin_time<=NOW() AND end_time >=NOW()";
		$condition .= " AND apply LIKE :APPLY_USER";
		$condition .= " AND (channel LIKE :CHANNEL OR channel LIKE '%ALL%')";
		$c->condition = $condition;
		$c->params = array(
			":TYPE"=>$type,
			":CHANNEL"=>"%".$channel."%",
			":APPLY_USER"=>"%$userType%",
		);
		$res = self::model()->findAll($c);
		$list = CHtml::listData($res, 'content_id', 'content_id');
		return $list;
	}
}