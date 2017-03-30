<?php
class VideoExtraModel extends BaseVideoExtraModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VideoExtra the static model class
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