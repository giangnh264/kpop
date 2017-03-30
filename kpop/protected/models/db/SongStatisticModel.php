<?php
class SongStatisticModel extends BaseSongStatisticModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SongStatistic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    /**
     * return primaryKey name
     */
    public function primaryKey() {
        return "song_id";
    }
	
	public function findAllByIds($ids){
		$criteria = new CDbCriteria();
		$criteria->addInCondition('song_id',$ids);
		return $this->findAll($criteria);
	}
		
}