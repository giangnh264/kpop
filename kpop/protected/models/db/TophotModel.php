<?php

class TophotModel extends BaseTophotModel
{
	public $treeItemsSource = '';
	/**
	 * Returns the static model of the specified AR class.
	 * @return Tophot the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getItemsByType($type='album')
	{
		$key = '_CACHE_TOPHOT_'.$type;
		$items = Yii::app()->cache->get($key);
		if($items===false){
			$sql = "SELECT c1.tophot_slot_id, c2.id, c2.name, c1.show_number
					FROM tophot_items c1
					LEFT JOIN album c2 ON c1.content_id=c2.id
					WHERE c1.content_type=:content_type
					ORDER BY c1.tophot_slot_id ASC";
			$command = Yii::app()->db->createCommand($sql);
			$command->bindParam(':content_type', $type, pdo::PARAM_STR);
			$results = $command->queryAll();
			$items = array();
			foreach ($results as $key => $value){
				$items[$value['tophot_slot_id']][$value['id']] = $value['show_number'];
			}
			if($items) {
				Yii::app()->cache->set($key, $items, 21600);
			}
		}
		Yii::app()->session['items_source'] = $items;
		return $items;
	}
	public function getItemsShow()
	{
		$items = Yii::app()->session['items'];
		//echo '<pre>';print_r($items);
		if(empty($items)){
			$items = $this->getItemsByType();
			Yii::app()->session['items'] = $items;
		}
		$result = array();
		foreach ($items as $key => $item){
			$result[$key] = $this->getItemBySlot($key);
		}
		$this->updateShowNumber($result);
		return $result;
	}
	public function getItemBySlot($slotId)
	{
		$items = Yii::app()->session['items'];
		$arg = $items[$slotId];
		//echo '<pre>';print_r($arg);
		foreach ($arg as $key => $value){
			if($value>0){
				return $key;
			}
		}
	}
	private function resetSlotItems($slotId)
	{
		$items = Yii::app()->session['items'];
		$itemsSource = Yii::app()->session['items_source'];
		$items[$slotId] = $itemsSource[$slotId];
		//Yii::app()->session['items']=$items;
		return $items;
	}
	private function updateShowNumber($arg)
	{
		$items = Yii::app()->session['items'];
		$itemsSource = Yii::app()->session['items_source'];
		foreach ($arg as $key => $value){
			if(isset($items[$key][$value])){
				$items[$key][$value] -=1; 
				//echo 'update: '.$key.' | '.$value.'| '.$items[$key][$value].'<br />';
			}
			if(max($items[$key])==0){
				$items[$key] = $itemsSource[$key];
			}
		}
		Yii::app()->session['items'] = $items;
	}
}