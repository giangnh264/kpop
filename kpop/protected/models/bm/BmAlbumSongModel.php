<?php
class BmAlbumSongModel extends AlbumSongModel
{
    public static function model($className=__CLASS__) {
		return parent::model($className);
	}
    
	public function scopes() {
		return array(
			'published'=>array(
                'condition' => 't.status = '.self::ACTIVE
			),
        );
	}
}

?>
