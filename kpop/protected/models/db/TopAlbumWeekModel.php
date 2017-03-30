<?php
class TopAlbumWeekModel extends BaseTopAlbumWeekModel
{
	const ACTIVE = 1;
	const DECTIVE = 0;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return TopAlbumWeek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getThumbnailUrl($size, $album_id=null){
		if($this->id)
		{
			return $this->getAvatarUrl($this->id, $size, true);
		}
		return parent::getAvatarUrl($album_id, $size, true);
	}
}