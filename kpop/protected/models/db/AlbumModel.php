<?php
class AlbumModel extends BaseAlbumModel {

    const ALL = -1;
    const DEACTIVE = 0;
    const ACTIVE = 1;
    const DELETED = 1;


    public function scopes() {
        return array(
            "published" => array(
                "condition" => "`t`.`status` = " . self::ACTIVE,
            ),
            'available' => array(
                "condition" => "t.status = " . self::ACTIVE." OR t.status=".self::DEACTIVE,
            )
        );
    }
    /**
     * Returns the static model of the specified AR class.
     * @return Album the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            "album_statistic" => array(self::HAS_ONE, "AlbumStatisticModel", "album_id", "alias" => 'as', "joinType" => "LEFT JOIN",), //, "group"=>"as.album_id"
            "album_featured" => array(self::HAS_ONE, "FeatureAlbumModel", "album_id", "alias" => 'af', "joinType" => "INNER JOIN", "condition" => 'af.status=' . FeatureAlbumModel::ACTIVE),
			"album_artist"=>array(self::HAS_MANY, 'AlbumArtistModel', 'album_id', 'joinType'=>'INNER JOIN'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('url_key', $this->url_key, true);
        $criteria->compare('genre_id', $this->genre_id);
        $criteria->compare('artist_id', $this->artist_id, true);
        $criteria->compare('artist_name', $this->artist_name, true);
        $criteria->compare('song_count', $this->song_count);
        $criteria->compare('publisher', $this->publisher, true);
        $criteria->compare('published_date', $this->published_date, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('approved_by', $this->approved_by);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('cp_id', $this->cp_id);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_time', $this->updated_time, true);
        $criteria->compare('sorder', $this->sorder);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => array('defaultOrder' => 'sorder ASC '),
                    'pagination' => array(
                        'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']),
                    ),
                ));
    }

    public function getAvatarPath($id = null, $size = 's4', $isFolder = false) {
        if (!isset($id))
            $id = $this->id;
        if ($isFolder) {
            $savePath = Common::storageSolutionEncode($id);
        } else {
            $savePath = Common::storageSolutionEncode($id) . $id . ".jpg";
        }
//        $savePath = Common::storageSolutionEncode($id) . $id . ".jpg";
        $path = Yii::app()->params['storage']['albumDir'] . DS . $size . DS . $savePath;
        return $path;
    }

    public function getAvatarUrl($id = null, $size = "150", $cacheBrowser = false) {
        if (!isset($id))
            $id = $this->id;

        // browser cache
        if ($cacheBrowser) {
            $version = isset($this->updated_time) ? $this->updated_time : 0;
        }
        else
            $version = time();

        $path = AvatarHelper::getAvatar("album", $id, $size);
        return $path . "?v=" . $version;
    }

    /**
     *
     * Hàm này thực hiện encode 1 album thành string để lưu trong trường album_data trong DB
     * @return string : json encode data
     */
    public function encodeData() {
        $data = array(
            'id' => $this->id,
            'name' => $this->name,
            'url_key' => $this->url_key,
                //'played_count'	=> $this->played_count,
        );

        return json_encode($data);
    }

    /**
     *
     * Hàm này thực hiện decode trường album_data thành mảng, khóa là thuộc tính tương ứng của album
     * @param string $data
     * @return array
     */
    public function decodeData($data) {
        return json_decode($data, true);
    }

    public function findAllByIds($ids) {
        $criteria = new CDbCriteria();
        $criteria->addInCondition("id", $ids);
        return $this->findAll($criteria);
    }

    public static function getFeature($limit, $offset = 0) {
        $c = new CDbCriteria();
        $c->select = "t.id,t.name,t.artist_id,t.artist_name, t.song_count, t.new_release, t.exclusive, t.url_key";
        $c->join = "INNER JOIN feature_album f ON f.album_id = t.id";
        $c->condition = "t.status=:ASTATUS AND f.status=:FSTATUS";
        $c->params = array(":FSTATUS" => FeatureAlbumModel::ACTIVE, ":ASTATUS" => self::ACTIVE);
        $c->order = "f.sorder ASC";
        $c->limit = $limit;
        $c->offset = $offset;
        $c = AlbumModel::applySuggestCriteria("AlbumModel", $c);
        return self::model()->findAll($c);
    }

    public static function getTotalFeature() {
        $c = new CDbCriteria();
        $c->select = "t.id,t.name,t.artist_id,t.artist_name, t.song_count";
        $c->join = "INNER JOIN feature_album f ON f.album_id = t.id";
        $c->condition = "t.status=:ASTATUS AND f.status=:FSTATUS";
        $c->params = array(":FSTATUS" => FeatureAlbumModel::ACTIVE, ":ASTATUS" => self::ACTIVE);
        $c->order = "f.sorder ASC";
        return self::model()->count($c);
    }

    public function getAudioFilePath($id = 0, $format = "mp3") {
        if (!$id)
            $id = $this->id;

        $path = Yii::app()->params['storage']['albumDir'] . "/songs/" . Common::storageSolutionEncode($id);
        if (!file_exists($path)) {
            mkdir($path, true);
            chmod($path, 0775);
        }
        return $path . $id . "." . $format;
    }

    /**
     * function getAlbumAudioUrl
     */
    public function getAudioFileUrl($id = 0, $format = "mp3") {
        if (!$id)
            $id = $this->id;

        switch ($format) {
            case "3gp":
                $severStreaming = Yii::app()->params['storage']['albumUrl3Gp'];
                break;
            case "mp3":
            default:
                $severStreaming = Yii::app()->params['storage']['albumUrlMp3'];
                break;
        }

        $path = Common::storageSolutionEncode($id) . $id . "." . $format;
        return $severStreaming . "songs/" . $path;
    }

    public function mergeSongFiles() {
        Yii::log("Merge songs file of album #" . $this->id, "trace");

        $criteria = new CDbCriteria();
        $criteria->select = "t.id";
        $criteria->join = "INNER JOIN album_song t2 ON t.id=t2.song_id";
        $criteria->condition = "t2.album_id=" . $this->id . " AND t.status=" . SongModel::ACTIVE;
        $criteria->order = "t2.sorder, t2.id";
        if ($songs = SongModel::model()->findAll($criteria)) {
            $cmd = "vnplaylist " . $this->getAudioFilePath($this->id, "3gp") . " " . $this->getAudioFilePath($this->id, "mp3");
            foreach ($songs as $song) {
                $cmd .= " " . $song->getAudioFilePath($song->id, 1);
            }

            Yii::log($cmd, "trace");
            exec($cmd);
            $this->merge_status = 1;
            $this->update();
        }
    }
    public function getCountFav($albumId=null)
    {
        if(empty($albumId)) $albumId = $this->id;
        $c = new CDbCriteria();
        $c->condition = "album_id=:ID";
        $c->params = array(":ID"=>$albumId);
        return FavouriteAlbumModel::model()->count($c);
    }

}