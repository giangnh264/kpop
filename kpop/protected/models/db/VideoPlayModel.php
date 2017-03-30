<?php
class VideoPlayModel extends BaseVideoPlayModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VideoPlay the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    /**
     *
     * return primaryKey name
     */
    public function primaryKey()
    {
        return "id";
    }
}