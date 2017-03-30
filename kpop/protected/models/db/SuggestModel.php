<?php
class SuggestModel extends BaseSuggestModel
{
	const ACTIVE = 1;
    const EXPIRED = 0;
	const DELETE = 2;
	const PENDING = 3;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Suggest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/*
	param: $group_code of suggest such as MIENTAY, QUOCTE
	return: id of suggest
	
	*/
	public static function getSuggestByCode($group_code){
		$cri = new CDbCriteria;
        $cri->condition = "code = :C";
		$cri->params = array(':C' => $group_code);
        $suggests = self::model()->findAll($cri);        
		//sugget ko ton tai
        if (empty($suggests[0]))
			return null;		
        $suggest = $suggests[0];        
		return $suggest->id;
	}
	
	/*
	Return array('code' => 'id') of active suggest
	*/
	public static function getSuggestIdCodes(){
		$cri = new CDbCriteria;
        $cri->condition = "status = :ST";
		$cri->params = array(':ST' => SuggestModel::ACTIVE);
        $suggests = self::model()->findAll($cri);        
		$arr = array();
		foreach($suggests as $suggest){
			$arr[$suggest->code] = $suggest->id;
		}
		return $arr;
	}
	
	/**
	* Get User's Suggest id Array by Phone
	*/
	public static function getUserSuggestByPhone($msisdn){
		$suggestCodes = self::getSuggestIdCodes();
		$suggested_arr = array();
		foreach($suggestCodes as $code => $id ){
			$exist = PhoneBookModel::model()->exists("phone = :P AND group_code = :GR",array(':P'=>$msisdn, ':GR' => $code ));
			if($exist)
				$suggested_arr[] = $id;
		}
		return $suggested_arr;
	}
}