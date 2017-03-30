<?php
class SongExtraModel extends BaseSongExtraModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SongExtra the static model class
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
}