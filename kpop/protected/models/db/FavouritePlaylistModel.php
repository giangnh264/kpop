<?php
class FavouritePlaylistModel extends BaseFavouritePlaylistModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FavouritePlaylist the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations(){
		return CMap::mergeArray(parent::relations(), array(
			'playlist'				=> array(self::BELONGS_TO, 'PlaylistModel', 'playlist_id','condition'=>'playlist.status='.PlaylistModel::ACTIVE,'joinType'=>'JOIN'),			
			'playlist_statistic'	=> array(self::BELONGS_TO, 'PlaylistStatisticModel', 'playlist_id'),			
		));
	}
        
	public function quantities($limit = 10, $offset = 0){
		$this->getDbCriteria()->mergeWith(
			array(
				'limit'		=> $limit,
				'offset'	=> $offset
			)
		);
		return $this;
	}
        
	public function findAllUserFavPlaylist($user_id, $limit = 10, $offset = 0) {
        $arFavPlaylist = array();
        $cr = new CDbCriteria();
        $cr->condition = "t.user_id=:user_id";
        $cr->params = array(":user_id" => $user_id);

        $arFavPlaylist = $this->with('playlist', 'playlist_statistic')->quantities($limit, $offset)->findAll($cr);

        return $arFavPlaylist;
    }
}