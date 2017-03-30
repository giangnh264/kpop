<?php
class TopVideoWeekModel extends BaseTopVideoWeekModel
{
	const ACTIVE = 1;
	const DECTIVE = 0;	
	/**
	 * Returns the static model of the specified AR class.
	 * @return TopVideoWeek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	public function getAvatarUrl($id=null, $size="150", $cacheBrowser = false)
    {
    	if(!isset($id)) $id = $this->id;
    
    	// browser cache
    	if($cacheBrowser)
    	{
    		$version = isset($this->updated_time) ? $this->updated_time:0;
    	}
    	else $version = time();
    
    	$path = AvatarHelper::getAvatar("video", $id, $size);
    	return $path."?v=".$version;
    }


}