<?php
class PlaylistModel extends BasePlaylistModel {

    const ACTIVE = 1;
    const DEACTIVE = 0;

    /**
     * Returns the static model of the specified AR class.
     * @return Playlist the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }


    /**
     * Lay danh sach bai hat HOT
     * @param INT $page
     * @param INT $limit
     * @return \CActiveDataProvider
     */
    public static function getListHot($page=1, $limit=0) {
        return self::getListByCollection('PLAYLIST_HOT', $page, $limit);
    }

    public function scopes() {
        return array(
            'published' => array(
                'condition' => '`t`.`status` = ' . self::ACTIVE,
            ),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'playlist_statistic' => array(self::HAS_ONE, "PlaylistStatisticModel", "playlist_id", 'alias' => 'ps', 'joinType' => 'LEFT JOIN'),
        );
    }

    public function quantities($limit, $offset) {
        $this->getDbCriteria()->mergeWith(array(
            'limit' => $limit,
            'offset' => $offset,
        ));
        return $this;
    }

    public function getAvatarPath($id = null, $size = 150, $isFolder = false) {
        if (!isset($id))
            $id = $this->id;
        if ($isFolder) {
            $savePath = Common::storageSolutionEncode($id);
        } else {
            $savePath = Common::storageSolutionEncode($id) . $id . ".jpg";
        }
        $savePath = Common::storageSolutionEncode($id) . $id . ".jpg";
        $path = Yii::app()->params['storage']['playListDir'] . DS . $size . DS . $savePath;
        return $path;
    }

    public function getAvatarUrl($id = null, $size = "150") {
        if (!isset($id))
            $id = $this->id;
        $path = AvatarHelper::getAvatar("playlist", $id, $size);
        return $path . "?v=" . time();
    }

    /**
     *
     * Hàm này thực hiện encode 1 playlist thành string để lưu trong trường playlist_data trong DB
     * @return string : json encode data
     */
    public function encodeData() {
        $data = array(
            'id' => $this->id,
            'name' => $this->name,
            'url_key' => $this->url_key,
        );

        return json_encode($data);
    }

    /**
     *
     * Hàm này thực hiện decode trường playlist_data thành mảng, khóa là thuộc tính tương ứng của playlist
     * @param string $data
     * @return array
     */
    public function decodeData($data) {
        return json_decode($data, true);
    }

    public function findAllByIds($ids) {
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', $ids);
        return $this->findAll($criteria);
    }

    public function getPlaylist($limit = 10, $offset = 0) {
        $arPlaylists = array();
        $cr = new CDbCriteria();
        //$cr->join 	= "LEFT JOIN playlist_statistic ps ON `t`.id = ps.playlist_id";
        $cr->select = "`t`.*";
        $cr->condition = "`t`.status = 1";
        $cr->order = "ps.played_count DESC";
        $arPlaylists = PlaylistModel::model()->quantities($limit, $offset)->with('playlist_statistic')->findAll($cr);

        return $arPlaylists;
    }

    public function findAllOnSlideBar($user_id, $offset = 0, $limit = 5) {
        $cr = new CDbCriteria();
        $cr->condition = "user_id=:user_id AND on_sidebar=1 AND status=" . self::ACTIVE;
        $cr->params = array(":user_id" => $user_id);
        $cr->order = 'updated_time DESC';
        $cr->offset = $offset;
        $cr->limit = $limit;
        return PlaylistModel::model()->published()->findAll($cr);
    }

    public function getSongs($playlistid) {
        $songs = array();
        $cr = new CDbCriteria();
        $cr->join = "INNER JOIN playlist_song ps ON t.id = ps.song_id";
        $cr->condition = "ps.playlist_id=:playlist_id AND t.status=:status";
        $cr->params = array(":playlist_id" => $playlistid, ":status" => self::ACTIVE);
        $cr->order = "ps.sorder ASC, ps.id DESC";
        $songs = SongModel::model()->with('song_statistic')->findAll($cr);
        return $songs;
    }

    public function getHotPlaylist($limit, $offset) {
        $arPlaylistHot = array();
        $cr = new CDbCriteria();
        $cr->join = "LEFT JOIN playlist_statistic ps ON t.id = ps.playlist_id";
        $cr->select = "t.*";
        $cr->order = "ps.played_count DESC";

        $arPlaylistHot = PlaylistModel::model()->published()->quantities($limit, $offset)->findAll($cr);

        return $arPlaylistHot;
    }

}