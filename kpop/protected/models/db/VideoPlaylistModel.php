<?php

class VideoPlaylistModel extends BaseVideoPlaylistModel
{
    const ALL = -1;
    const DEACTIVE = 0;
    const ACTIVE = 1;

    /**
     * Returns the static model of the specified AR class.
     * @return VideoPlaylist the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            "video_playlist_artist"=>array(self::HAS_MANY, 'VideoPlaylistArtistModel', 'video_playlist_id', 'joinType'=>'INNER JOIN'),
            'video_playlist_videos'  => array(self::HAS_MANY, 'VideoPlaylistVideoModel', 'video_playlist_id', 'joinType'=>'INNER JOIN','order'=>'sorder ASC'),
        );
    }
    public function scopes()
    {
        return array(
            "published" => array(
                "condition" => "`t`.`status` = " . self::ACTIVE,
            ),
        );
    }
    
    public function quantities($limit, $offset) {
        $this->getDbCriteria()->mergeWith(array(
            "limit" => $limit,
            "offset" => $offset,
        ));
        return $this;
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
        $path = Yii::app()->params['storage']['videoPlaylistDir'] . DS . $size . DS . $savePath;
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

        $path = AvatarHelper::getAvatar("videoPlaylist", $id, $size);
        return $path . "?v=" . $version;
    }
    
    public function findAllByIds($ids) {
        $criteria = new CDbCriteria();
        $criteria->addInCondition("id", $ids);
        return $this->findAll($criteria);
    }
    
    public function getList($genreId=0, $limit=10, $offset=0){
        $genreIds[] = $genreId;
        $criteria = new CDbCriteria;
        $criteria->condition = "parent_id = :parent_id";
        $criteria->params = array(":parent_id" => $genreId);
        $results = GenreModel::model()->findAll($criteria);
        if ($results) {
            foreach ($results as $result) {
                $genreIds[] = $result['id'];
            }
        }

        $c = new CDbCriteria();
        if($genreId == 0)
            $c->condition = "video_count > 0";
        else{
            $c->addCondition("video_count > 0");
            $c->addInCondition("genre_id", $genreIds);
        }
        $c->order = "id DESC";
        $videoPlaylists = self::model()->quantities($limit, $offset)->findAll($c);
        return $videoPlaylists;
    }

    public function getVideoRelate($id,$genreId=0, $limit=10, $offset=0){
        $genreIds[] = $genreId;
        $criteria = new CDbCriteria;
        $criteria->condition = "parent_id = :parent_id";
        $criteria->params = array(":parent_id" => $genreId);
        $results = GenreModel::model()->findAll($criteria);
        if ($results) {
            foreach ($results as $result) {
                $genreIds[] = $result['id'];
            }
        }

        $c = new CDbCriteria();
        $c->condition ='id != :ID AND video_count > 0';
        if($genreId != 0)
            $c->addInCondition("genre_id", $genreIds);
        $c->params = array(':ID'=>$id);
        $c->order = "id DESC";
        $videoPlaylists = self::model()->quantities($limit, $offset)->findAll($c);
        return $videoPlaylists;
    }


    public function countAll($genreId=0){
        $c = new CDbCriteria();
        if($genreId == 0)
            $c->condition = "video_count > 0";
        else{
            $c->condition = "video_count > 0 AND genre_id=:genreId";
            $c->params = array(":genreId" => $genreId);
        }
        return self::model()->count($c);
    }
    
   /**
     * Update data from search result
     * @param sorlItem[] $docs
     */
    public static function updateResultFromSearch($items) {
    	if(empty($items)) return $items;
        $ids = array();
        $data = array();
        foreach($items as $item) {
            $ids[] = $item['id'];
            $data[$item['id']] = $item;
        }

        $criteria = new CDbCriteria();
        $criteria->addInCondition('id',$ids);
        $items = self::model()->findAll($criteria);

        // get more info
        foreach($items as $item) {
            $data[$item->id]['url_key'] = $item->url_key;
            $data[$item->id]['song_count'] = $item->song_count;
            $data[$item->id]['video_count'] = $item->video_count;
            $data[$item->id]['album_count'] = $item->album_count;
            $data[$item->id]['status'] = $item->status;
            $data[$item->id]['description'] = $item->description;
        }

        // sort order by score DESC, length name ASC
        $return = array();
        foreach($data as $item) {
            $return[] = $item;
            $scoreArr[] = $item['score'];
            $lenNameArr[] = mb_strlen($item['name']);
        }

        array_multisort($scoreArr, SORT_DESC, $lenNameArr, SORT_ASC, $return);
        return $return;
    }

    public function getCountFav($video_playlist_id=null)
    {
        if($this) $video_id = $this->id;
        $c = new CDbCriteria();
        $c->condition = "video_playlist_id=:ID";
        $c->params = array(":ID"=>$video_playlist_id);
        return FavouriteVideoPlaylistModel::model()->count($c);
    }

    public function getFavoriteVideoPlaylist($msisdn, $limit = 10, $offset = 0){
        $videos	= array();
        $cr	= new CDbCriteria();
        $cr->join = "INNER JOIN favourite_video_playlist t2 ON t.id = t2.video_playlist_id";
        $cr->condition	= "t2.msisdn=:msisdn";
        $cr->params		= array(":msisdn"=>$msisdn);
        $cr->order = "t2.id DESC";
        $videos	= VideoPlaylistModel::model()->published()->quantities($limit, $offset)->findAll($cr);
        return $videos;
    }
}