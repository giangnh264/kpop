<?php

class SongCopyrightModel extends BaseSongCopyrightModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SongCopyright the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    public function relations() {
        return CMap::mergeArray(parent::relations(), array(
                    'copyr' => array(self::BELONGS_TO, 'AdminCopyrightModel', 'copryright_id'),
                    'song' => array(self::BELONGS_TO, 'AdminSongModel', 'song_id'),
                ));
    }
}