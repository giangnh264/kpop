<?php

class TextLinkModel extends BaseTextLinkModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TextLink the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function checkTextlink($controller){
		$cr = new CDbCriteria();
		$cr->condition = "position LIKE :POSITION AND status = :STATUS AND start_time <= :TIME_NOW AND end_time >= :TIME_NOW";
		$cr->params = array(":POSITION"=>"%" . $controller . "%", ":TIME_NOW" =>  date("Y-m-d H:i:s"),"STATUS"=>1);
		$cr->limit = 1;
		$cr->order = 'RAND()';
		$res = self::model()->findAll($cr);
		return $res;
	}
}