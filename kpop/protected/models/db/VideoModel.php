<?php
class VideoModel extends BaseVideoModel {
    const ALL = -1;
    const ACTIVE = 1;
    const DEACTIVE = 0;
    const DELETED = 2;
    public $played_count;
    /**
     * Returns the static model of the specified AR class.
     * @return Video the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function scopes() {
        return array(
            'published' => array(
                'condition' => '`t`.`status` = ' . self::ACTIVE
            ),
            'available' => array(
                "condition" => "t.status = " . self::ACTIVE." OR t.status=".self::DEACTIVE,
            )
        );
    }
    /**
     * overwrite rules function
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, name', 'required'),
			array('code, genre_id, created_by, approved_by, updated_by, cp_id, duration, max_bitrate, suggest_1, suggest_2, is_new, is_exclusive, sorder, status, sync_status, custom_rank, onlyone', 'numerical', 'integerOnly'=>true),
			array('allow_download, download_price, listen_price', 'numerical'),
			array('old_id, song_id, composer_id', 'length', 'max'=>10),
			array('name, artist_name, url_key, owner, source, source_link, national, source_path, profile_ids', 'length', 'max'=>255),
			array('language, copyright', 'length', 'max'=>45),
			array('created_time, updated_time, active_fromtime, active_totime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, old_id, code, name, url_key, song_id, genre_id, composer_id, artist_name, owner, source, source_link, national, language, created_by, approved_by, updated_by, cp_id, source_path, download_price, listen_price, duration, max_bitrate, profile_ids, suggest_1, suggest_2, is_new, is_exclusive, created_time, updated_time, copyright, active_fromtime, active_totime, sorder, status, sync_status, custom_rank', 'safe', 'on'=>'search'),
		);
	}

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'video_statistic' => array(self::HAS_ONE, 'VideoStatisticModel', 'video_id', 'alias' => 'ss', 'joinType'=>'LEFT JOIN'),
            'feature_video' => array(self::HAS_ONE, "FeatureVideoModel", "video_id", 'joinType' => 'INNER JOIN', 'alias' => 'fs', "condition" => "fs.status=" . FeatureVideoModel::ACTIVE),
        	'video_artist'=>array(self::HAS_MANY, 'VideoArtistModel', 'video_id', 'joinType'=>'INNER JOIN'),
            'video_extra' => array(self::HAS_ONE, 'VideoExtraModel', "video_id"),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->order = "id DESC ";

        $criteria->compare('id', $this->id);
        $criteria->compare('old_id', $this->old_id, true);
        $criteria->compare('code', $this->code);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('url_key', $this->url_key, true);
        $criteria->compare('duration', $this->duration);
        $criteria->compare('song_id', $this->song_id, true);
        $criteria->compare('genre_id', $this->genre_id);
        $criteria->compare('composer_id', $this->composer_id, true);
        $criteria->compare('artist_name', $this->artist_name, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('approved_by', $this->approved_by);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('cp_id', $this->cp_id);
        $criteria->compare('source_path', $this->source_path, true);
        $criteria->compare('download_price', $this->download_price);
        $criteria->compare('listen_price', $this->listen_price);
        $criteria->compare('profile_ids', $this->profile_ids, true);
        $criteria->compare('max_bitrate', $this->max_bitrate);
        //$criteria->compare('created_time',$this->created_time,true);
        $criteria->compare('updated_time', $this->updated_time, true);
        $criteria->compare('sorder', $this->sorder);
        $criteria->compare('status', $this->status);
        $criteria->compare('sync_status', $this->sync_status);
        $criteria->compare('is_new', $this->is_new);
        $criteria->compare('is_exclusive', $this->is_exclusive);
        if (!empty($this->created_time)) {
            $criteria->addBetweenCondition('created_time', $this->created_time[0], $this->created_time[1]);
        }

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']),
                    ),
                ));
    }

    public function getVideoOriginPath($id = null, $isFullPath = true) {
        if (!isset($id))
            $id = $this->id;
        $savePath = Common::storageSolutionEncode($id) . $id . ".mp4";
        if ($isFullPath){
            $path = Yii::app()->params['storage']['videoDir'] . DS . "origin" . DS . $savePath;
        }
        else{
            $path = $savePath;
        }
        
        $path = str_replace("/", DS, $path);
        $path = str_replace(DS.DS, DS, $path);
        return $path;
    }

    public function getVideoOriginUrl($id = null) {
        if (!isset($id))
            $id = $this->id;
        $savePath = Common::storageSolutionEncode($id) . $id . ".mp4";
        //$path = Yii::app()->params['storage']['videoUrl']."origin/".$savePath;

        return "http://audio.chacha.vn:81/videos/origin/".$savePath;
        $path = Common::genLinkStream("/videos/origin/" . $savePath);
        $domain = str_replace("videos/", "", Yii::app()->params['storage']['videoUrl']);
        return $domain . $path;
    }

    public function getAvatarPath($id = null, $size = "s0", $isFolder = false) {
        if (!isset($id))
            $id = $this->id;
        if ($isFolder) {
            $savePath = Common::storageSolutionEncode($id);
        } else {
            $savePath = Common::storageSolutionEncode($id) . $id . ".jpg";
        }
        $path = Yii::app()->params['storage']['videoDir'] . DS . "img" . DS . $size . DS . $savePath;
        return $path;
    }

    public function getAvatarUrl($id = null, $size = "150") {
        if (!isset($id))
            $id = $this->id;
        $path = AvatarHelper::getAvatar("video", $id, $size);
        return $path . "?v=" . time();
    }

    public function getAvatarListPath($id = null) {
        if (!isset($id))
            $id = $this->id;
        $savePath = Common::storageSolutionEncode($id);
        $path = Yii::app()->params['storage']['videoDir'] . DS . "images" . DS . $savePath. $id.DS ;
        return $path;
    }

    public function getAvatarListUrl($id = null) {
        if (!isset($id))
            $id = $this->id;
        $savePath = Common::storageSolutionEncode($id);
        $path = Yii::app()->params['storage']['videoImageUrl'] . "/output/" . $savePath . "thumbs/";
        return $path;
    }

    /**
     *
     * get audio file path
     * @param INT $id : id video
     * @param INT $profileId : video profile id (mac dinh la profile tren web)
     * @return string : duong dan tuyet doi toi file audio
     */
    public function getVideoFilePath($id = 0, $profileId = 1) {
        if (!$id)
            $id = $this->id;

        $profile = Common::getVideoProfile($profileId);
        $path = Common::storageSolutionEncode($id, false) . $id . "." . $profile['format'];

        $mediaPath = Common::getMediaPath($id,'video');
        if($mediaPath){
        	$mediaPath = $mediaPath."/";
        }
        $path = Yii::app()->params['storage']['baseStorage']. $mediaPath. "videos/".$profile['name']."/" . $path;
        $path = str_replace("\\", "/", $path);
        return $path;
    }

    /**
     *
     * get audio file url
     * @param INT $id : id video
     * @param INT $profileId : video profile id (mac dinh la profile tren web)
     * @return string : URL tuyet doi toi file audio
     */
    public function getVideoFileUrl($id = 0, $deviceId = "", $protocol = false, $isWap = false, $videoProfile='') {

        if (!$id)
            $id = $this->id;
        $profileList = $this->getVideoProfileIdSuport($deviceId, $protocol, $isWap);
        if($videoProfile!=''){
            $videoProfileId = explode(',', $videoProfile);
            $profileList = array_intersect($profileList, $videoProfileId);
            $profileList = array_values($profileList);
        }
        //$profileId = (!empty($profileList))?$profileList[count($profileList)-1]:6;
        if (!empty($profileList) && $protocol != "http") {
            $profileId = $profileList[count($profileList) - 1];
            $protocol = false;
        } else {
            if ($protocol == 'rtsp') {
                // Mac dinh cho cac url tra ve tren wap
                //$profileId = 3;
                $mobileProfile = Yii::app()->params['video.profile.default']['rtsp_3gp'];
                $profileId = $mobileProfile[0];
            } else {
                // Mac dinh cho cac url tra ve tren web
                //$profileId = 6;
                $webProfile = Yii::app()->params['video.profile.default']['web'];
                $profileId = $webProfile[0];
                if ($isWap && !empty($profileList)) {
                    $profileId = $profileList[count($profileList) - 1];
                } else if ($isWap && empty($profileList)) {
                    $mobileProfile = Yii::app()->params['video.profile.default']['rtsp_3gp'];
                    $profileId = $mobileProfile[0];
                }
            }
        }

        $profile = Common::getVideoProfile($profileId);

        if ($protocol) {
            $protocol = $protocol . "://";
        } elseif ($profile['http_support']) {
            $protocol = "http://";
        } elseif ($profile['rtsp_support']) {
            $protocol = "rtsp://";
        } elseif ($profile['rtmp_support']) {
            $protocol = "rtmp://";
        } else {
            $protocol = "http://";
        }

        $path = Common::storageSolutionEncode($id) . $id . "." . $profile['format'];
        $severStreaming = Yii::app()->params['storage']['videoUrl'];
        if ($protocol == "rtsp://") {
            $severStreaming = Yii::app()->params['storage']['videoUrlRTSP'];
        }
        $severStreaming = str_replace("http://", "", $severStreaming);
        $severStreaming = str_replace("https://", "", $severStreaming);
        $mediaPath = Common::getMediaPath($id,'video');
        if($mediaPath){
            $mediaPath = $mediaPath."/";
        }
       /* if ($protocol == "http://") {
            // Ma hoa link
            $urlParse = parse_url($protocol.$severStreaming);
            $domain = $urlParse['host'];
            $relativePath = $urlParse['path'].$mediaPath."videos/". $profile["name"]."/" . $path;
            $path = Common::genLinkStream($domain,$relativePath);
            return $protocol .$path;
        }*/
        return $protocol . $severStreaming. $mediaPath . "videos/".  $profile["name"]."/" . $path;
    }

    public function getVideoFileUrlByProfile($id = 0, $profileId = 1, $protocol = false) {
        if (!$id)
            $id = $this->id;
        $profile = Common::getVideoProfile($profileId);
        if ($protocol) {
            $protocol = $protocol . "://";
        } elseif ($profile['http_support']) {
            $protocol = "http://";
        } elseif ($profile['rtsp_support']) {
            $protocol = "rtsp://";
        } elseif ($profile['rtmp_support']) {
            $protocol = "rtmp://";
        } else {
            $protocol = "http://";
        }

        $path = Common::storageSolutionEncode($id) . $id. "." . $profile['format'];
        $severStreaming = Yii::app()->params['storage']['videoUrl'];
        if ($protocol == "rtsp://") {
            $severStreaming = Yii::app()->params['storage']['videoUrlRTSP'];
        }
        $severStreaming = str_replace("http://", "", $severStreaming);
        $severStreaming = str_replace("https://", "", $severStreaming);
        $mediaPath = Common::getMediaPath($id,'video');
        if($mediaPath){
        	$mediaPath = $mediaPath."/";
        }

        return $protocol . $severStreaming. $mediaPath . "videos/". $profile["name"]."/" . $path;

    }

    public function getVideoProfileIdSuport($deviceId, $protocol = false, $isWap = false) {
        if ($deviceId == "")
            return null;
        $clientDevice = strtoupper($deviceId);
        $osDevice = strtoupper(Yii::app()->session['deviceOS']);

        if (strpos($clientDevice, "ANDROID") !== false || strpos($osDevice, "ANDROID") !== false) {
            $androidProfile = Yii::app()->params['video.profile.default']['android'];
			$androidProfile = array_reverse($androidProfile);
            return $androidProfile;
            //$androidProfile = Yii::app()->params['video.profile.default']['rtsp_3gp'];
            //return array($androidProfile[0]);
        }
        if (strrpos($clientDevice, "IOS") !== false || strrpos($clientDevice, "IPHONE") !== false || strrpos($clientDevice, "WINDOW") !== false || strpos($osDevice, "WINDOW") !== false) {
            $iosProfile = Yii::app()->params['video.profile.default']['iphone'];
            $iosProfile = array_reverse($iosProfile);
            return $iosProfile;
            //return Yii::app()->params['video.profile.default']['iphone'];
            //return array(1,2,3,4,5,6,7,8,9);
        }

        $c = new CDbCriteria();
        $c->condition = "device_id=:DID";
        $c->params = array(":DID" => $deviceId);
        $profile = DeviceModel::model()->findByAttributes(array('device_id' => $deviceId));
        if (!empty($profile) && $profile->video_profile_ids != "") {
            $profileList = $profile->video_profile_ids;
            $profileList = explode(",", $profileList);
            if (!empty($profileList))
                return $profileList;
        }
        if ($protocol && !$isWap) {
            $c = new CDbCriteria();
            switch (strtoupper($protocol)) {
                case "HTTP":
                    $c->condition = "http_support=1";
                    break;
                case "RTSP":
                    $c->condition = "rtsp_support=1";
                    break;
                case "RTMP":
                    $c->condition = "rtmp_support=1";
                    break;
            }
            $profile = VideoProfileModel::model()->findAll($c);
            $data = array();
            if (!empty($profile)) {
                foreach ($profile as $p) {
                    $data[] = $p->profile_id;
                }
            }

            return $data;
        }
        return array();
    }

    /**
     *
     * Hàm này thực hiện encode 1 video thành string để lưu trong trường video_data trong DB
     * @return string : json encode data
     */
    public function encodeData() {
        $data = array(
            'id' => $this->id,
            'name' => $this->name,
            'url_key' => $this->url_key,
            'duration' => $this->duration,
        );

        return json_encode($data);
    }

    /**
     *
     * Hàm này thực hiện decode trường video_data thành mảng, khóa là thuộc tính tương ứng của video
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

    public function getFeature($limit, $offset = 0) {
        $videos = MainContentModel::getListByCollection('VIDEO_HOT', 1, $limit);
		return $videos;
    }

    public function getCountVideoFeature($artistId=null) {
        $c = new CDbCriteria();
        $c->join = "INNER JOIN feature_video AS fv ON fv.video_id = t.id";
        $c->condition = "t.status=" . self::ACTIVE . " AND fv.status=" . FeatureSongModel::ACTIVE;
        if ($artistId) {
            $c->addColumnCondition("t.artist_id=" . $artistId);
        }
        return self::model()->count($c);
    }

    public function getVideoFeature($artistId=null, $limit=10, $offset=0) {
        $c = new CDbCriteria();
        $c->condition = "t.status=" . self::ACTIVE;
        if ($artistId) {
            $c->addColumnCondition("t.video_id=" . $artistId);
        }
        $c->group = 't.id';
        //$c->order = "fv.sorder ASC";
        $c->limit = $limit;
        $c->offset = $offset;

        return self::model()->with("video_statistic", "feature_video")->findAll($c);
    }


    public function getPlayUrl($video_id = null, $profileids = "") {
        $webProfile = Yii::app()->params['video.profile.default']['web'];
        $hq = $webProfile[count($webProfile) - 1];
        $profileids = explode(",", $profileids);

        if (!empty($profileids) && in_array($hq, $profileids)) {
            $profileId = $hq;
        } else {
            $profileId = $webProfile[0];
        }
        return self::model()->getVideoFileUrlByProfile($video_id ? $video_id : $this->id, $profileId, 'http');
    }

    public function getDownloadUrl($id = 0, $deviceId = "", $protocol = false, $isWap = false) {
    	$url = $this->getVideoFileUrl($id,$deviceId,$protocol,$isWap);
    	$videoDomain = Yii::app()->params['storage']['videoUrl'];
    	$songDomain = Yii::app()->params['storage']['songUrl'];

    	$url = str_replace($videoDomain, $songDomain, $url);
    	return $url."?d=1";
    }
    public function getCountFav($video_id=null)
    {
        if($this) $video_id = $this->id;
        $c = new CDbCriteria();
        $c->condition = "video_id=:ID";
        $c->params = array(":ID"=>$video_id);
        return FavouriteVideoModel::model()->count($c);
    }
    public function isHD($videoProfile='')
    {
    	$profile = explode(',', $videoProfile);
    	if(in_array(9, $profile)){
    		return true;
    	}
    	return false;
    }

    public function getNiceDownloadUrl($id = 0, $deviceId = "", $protocol = false, $isWap = false, $url_key) {
        $url = $this->getVideoFileUrl($id,$deviceId,$protocol,$isWap);
        $url = substr($url, 0,-4);
        $url_key = trim($url_key);
        $url_key = trim($url_key,"-");
        $firstKey = substr($url_key,0,1);
        $sufix = "d";
        $url_key = ucfirst($url_key);
        $url = str_replace("streaming","download",$url);
        $url .="/$sufix/$url_key.mp4?title=". $url_key .".mp4";
        return $url;
    }

    /**
     * create object for player
     * @param $id
     * @return string
     */
    public function builDataPlayerVideo($id, VideoModel $video=null, $profileId = null)
    {
        if(empty($video)){
            $videoId = $id;
            $video = VideoModel::model()->findByPk($videoId);
        }else{
            $videoId = $video->id;
        }
        if(empty($profileId)) {
            $profiles = explode(",", $video->profile_ids);
            $webVideoProfile = Yii::app()->params["video.profile.default"]["web"];
            $profiles = array_intersect($profiles, $webVideoProfile);
            $videoProfile = VideoProfileModel::model()->getProfileByIds($profiles);
        }else{
            $videoProfile = VideoProfileModel::model()->findAll('profile_id=:profileId', array(':profileId'=>$profileId));
        }
        if($videoProfile){
            $i=0;
            $setDefault = false;
            foreach($videoProfile as $profile){
//                $url = Utils::getCdnLink($video->cmc_id, array('profile_name'=>$profile->profile_name,'format'=>$profile->format), 'video');
//                $url = Utils::getEncryptLink($url,'.mp4');
                $url = self::model()->getVideoFileUrlByProfile($id, $profile->id);
//                $url = 'http://streaming.amusic.vn/amusic/videos/HTTP_240p/3/27342/27342.mp4';
                $data[$i] = array(
                    'file'=>$url,
                    'label'=>$profile->quality_name,
                );
                if(!$setDefault && ($profile->quality_name=='480p' || $profile->quality_name=='360p')){
                    $data[$i]['default'] = 'true';
                    $setDefault=true;
                }
                $i++;
            }
            //echo '<pre>';print_r($data);exit;
            return json_encode($data);
        }
        return '';
    }



}
