<?php

class FavouriteVideoPlaylistModel extends BaseFavouriteVideoPlaylistModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FavouriteVideoPlaylist the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function relations() {
		return CMap::mergeArray(parent::relations(), array(
			"video_playlist" => array(self::BELONGS_TO, "VideoPlaylistModel", "video_playlist_id"),
		));
	}

	public function findAllByPhone($userphone, $limit, $offset) {
		$criteria = new CDbCriteria();
		$criteria->condition = "msisdn=:msisdn";
		$criteria->params = array(":msisdn" => $userphone);
		$criteria->limit = $limit;
		$criteria->offset = $offset;
		$criteria->order = "t.created_time DESC";
		$fvideos = $this->with("video_playlist")->findAll($criteria);
		$videos = array();
		foreach ($fvideos as $fvideo) {
			$videos[] = $fvideo->video_playlist;
		}
		return $videos;
	}

	public function countByPhone($userphone) {
		$criteria = new CDbCriteria();
		$criteria->condition = "msisdn=:user_msisdn";
		$criteria->params = array(":user_msisdn" => $userphone);
		$criteria->order = "t.created_time DESC";
		$count = $this->with("video_playlist")->count($criteria);
		return $count;
	}
}