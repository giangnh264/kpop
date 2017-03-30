<?php
class VideoStatisticModel extends BaseVideoStatisticModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VideoStatistic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    /**
     * return primaryKey name
     */
    public function primaryKey() {
        return "video_id";
    }
}