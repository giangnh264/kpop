<?php
class SongModel extends BaseSongModel
{
	const ALL = -1;
	const ACTIVE = 1;
	const DEACTIVE = 0;
    const DELETED = 2;
	public $played_count;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Song the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * overwrite rules function
     * @return array rules
     */
	public function rules()
	{
        return array(
			array('code, name', 'required'),
			array('import_id, code, base_id, duration, max_bitrate, created_by, approved_by, updated_by, cp_id, has_rbt, suggest_1, suggest_2, custom_rank, sorder, status, sync_status, genre_id_2, lossless, onlyone, quality', 'numerical', 'integerOnly'=>true),
			array('allow_download, download_price, listen_price', 'numerical'),
			array('old_id, composer_id, quality', 'length', 'max'=>10),
			array('name, url_key, artist_name, owner, source, source_link, national, profile_ids, source_path', 'length', 'max'=>255),
			array('language, copyright', 'length', 'max'=>45),
			array('created_time, updated_time, active_fromtime, active_totime', 'safe'),
        	array('cmc_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, old_id, import_id, code, base_id, name, url_key, composer_id, artist_name, owner, source, source_link, national, language, duration, max_bitrate, profile_ids, created_by, approved_by, updated_by, cp_id, source_path, download_price, listen_price, has_rbt, suggest_1, suggest_2, created_time, updated_time, copyright, active_fromtime, active_totime, custom_rank, sorder, status, sync_status, genre_id_2, quality', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			"song_statistic"	=> array(self::HAS_ONE, "SongStatisticModel", "song_id", 'alias'=>'ss', 'joinType'=>'LEFT JOIN'),
			"feature_song"	=> array(self::HAS_ONE, "FeatureSongModel", "song_id", 'joinType'=>'INNER JOIN', 'alias'=>'fs', "condition"=>"fs.status=".FeatureSongModel::ACTIVE),
			'song_artist'=>array(self::HAS_MANY, 'SongArtistModel', 'song_id', 'joinType'=>'INNER JOIN'),
		);
	}


	public function getSongOriginPath($id = null, $isFullPath = true)
	{
		if(!isset($id)) $id = $this->id;
		$savePath = Common::storageSolutionEncode($id).$id.".mp3";
		if($isFullPath){
			$path = Yii::app()->params['storage']['baseStorage'].DS."songs/origin".DS.$savePath;
		}else{
			$path = $savePath;
		}
		$path = str_replace("/", DS, $path);
		$path = str_replace(DS.DS, DS, $path);
		return $path;
			
	}

    public function getIvrSongPath($id = null, $isFullPath = true) {
        if (!isset($id)) {
            $id = $this->id;
        }
        $savePath = Common::storageSolutionEncode($id) . $id . ".alaw";
        if ($isFullPath) {
            $mediaPath = Common::getMediaPath($id,'song');
	        if($mediaPath){
	        	$mediaPath = $mediaPath."/";
	        }

            $path = Yii::app()->params['storage']['baseStorage'] . $mediaPath . "songs/alaw" . DS . $savePath;
            $path = str_replace("\\", "/", $path);

            return $path;
        }
        else
            return $savePath;
    }

	public function getSongOriginUrl($id = null)
	{
		if(!isset($id)) $id = $this->id;
		$savePath = Common::storageSolutionEncode($id).$id.".mp3";

		$path = Yii::app()->params['storage']['songUrl']."songs/origin/".$savePath;
		return $path;
	}

    /**
     *
     * get audio file path
     * @param INT $id : id bai hat
     * @param INT $profileId : song profile id (mac dinh la profile tren web)
     * @return string : duong dan tuyet doi toi file audio
     */
    public function getAudioFilePath($id = 0, $profileId = 1) {
        if (!$id)
            $id = $this->id;

        $profile = Common::getSongProfile($profileId);
        $path = Common::storageSolutionEncode($id, false) . $id . "." . $profile['format'];
        $mediaPath = Common::getMediaPath($id,'song');
        if($mediaPath){
        	$mediaPath = $mediaPath."/";
        }
        $returnPath =  Yii::app()->params['storage']['baseStorage'].$mediaPath ."songs/".$profile['name']."/" . $path;
        $returnPath = str_replace("\\", "/", $returnPath);
        return $returnPath;
    }
    /**
     *
     * get audio file path song hight quality
     * @param INT $id : id bai hat
     * @param INT $profileId : song profile id (mac dinh la profile tren web)
     * @return string : duong dan tuyet doi toi file audio
     */
    public function getAudio2QualityFilePath($id = 0, $type='flac') {
        if (!$id)
            $id = $this->id;
        $type = ($type=='')?'flac':$type;
        $path = Common::storageSolutionEncode($id, false) . $id . '.' .$type;
        $mediaPath = Common::getMediaPath($id,'song');
        if($mediaPath){
        	$mediaPath = $mediaPath."/";
        }
        $returnPath =  Yii::app()->params['storage']['baseStorage'].$mediaPath ."songs/output/hq/". $path;
        $returnPath = str_replace("\\", DS, $returnPath);
        $returnPath = str_replace("/", DS, $returnPath);
        return $returnPath;
    }
	public function getAudio2QualityFileUrl($id = 0, $type='flac')
	{
		if (!$id)
			$id = $this->id;
		$type = ($type=='')?'flac':$type;
		$protocol = 'http://';
		$path = Common::storageSolutionEncode($id, false) . $id . '.' .$type;
		$path = str_replace('\\', '/', $path);
		$severStreaming = Yii::app()->params['storage']['songUrl'];
		$severStreaming = str_replace("http://", "", $severStreaming);
		
		$mediaPath = Common::getMediaPath($id,'song');
		if($mediaPath){
			$mediaPath = $mediaPath."/";
		}
		return $protocol . $severStreaming .$mediaPath. "songs/output/hq/" . $path;
	}
	public function getAudio2QualityFileUrlDownload($id=0, $type='flac', $action='download')
	{
		$url = $this->getAudio2QualityFileUrl($id, $type);
		if($action=='download'){
			return $url.'?d=1';
		}
		return $url;
	}
    /**
     *
     * get audio file url
     * @param INT $id : id bai hat
     * @param INT $profileId : song profile id (mac dinh la profile tren web)
     * @param string $deviceProfile: neu != null thi lay luon tham so truyen vao
     * @return string : URL tuyet doi toi file audio
     */
    public function getAudioFileUrl($id = 0, $deviceId = "", $protocol = false, $songProfiles = "1,2,3", $deviceProfile = null) {
    	if (!$id)
            $id = $this->id;
        $deviceProfile = isset($deviceProfile)?$deviceProfile:$this->getSongProfileIdSuport($deviceId, $protocol);
        $songProfile = explode(",", $songProfiles);
        $profileList = array_intersect($deviceProfile, $songProfile);

        //$profileId = (!empty($profileList))?$profileList[count($profileList)-1]:1;
        if (!empty($profileList) && $protocol != "http") {
        //if (!empty($profileList)) {
            if (strtoupper($protocol) == 'RTSP') {
                $profileId = $profileList[0];
            } else {
                $profileId = $profileList[count($profileList) - 1];
            }
            $protocol = false;
        } else {
            if ($protocol == 'rtsp') {
                $profileId = 3; // Mac dinh cho cac url tra ve tren wap
            } else {
                $profileId = 1; // Mac dinh cho cac url tra ve tren web
            }
        }
        $profile = Common::getSongProfile($profileId);

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
        $severStreaming = Yii::app()->params['storage']['songUrl'];
        if ($protocol == "rtsp://") {
            $severStreaming = Yii::app()->params['storage']['songUrlRTSP'];
        }
        $severStreaming = str_replace("http://", "", $severStreaming);
        $severStreaming = str_replace("https://", "", $severStreaming);

        $mediaPath = Common::getMediaPath($id,'song');
        if($mediaPath){
        	$mediaPath = $mediaPath."/";
        }
        return $protocol . $severStreaming .$mediaPath. "songs/".$profile['name']."/" . $path;

    }


    /**
     *
     * get audio file url download
     * @param INT $id : id bai hat
     * @param INT $profileId : song profile id (mac dinh la profile tren web)
     * @param string $deviceProfile: neu != null thi lay luon tham so truyen vao
     * @return string : URL tuyet doi toi file audio
     */
    public function getAudioFileUrlDownload($id = 0, $deviceId = "", $protocol = false, $songProfiles = "1,2,3", $deviceProfile = null,$songname = null) {
        if (!$id)
            $id = $this->id;
        $deviceProfile = isset($deviceProfile)?$deviceProfile:$this->getSongProfileIdSuport($deviceId, $protocol);
        $songProfile = explode(",", $songProfiles);
        $profileList = array_intersect($deviceProfile, $songProfile);

        //$profileId = (!empty($profileList))?$profileList[count($profileList)-1]:1;
        if (!empty($profileList) && $protocol != "http") {
            //if (!empty($profileList)) {
            if (strtoupper($protocol) == 'RTSP') {
                $profileId = $profileList[0];
            } else {
                $profileId = $profileList[count($profileList) - 1];
            }
            $protocol = false;
        } else {
            if ($protocol == 'rtsp') {
                $profileId = 3; // Mac dinh cho cac url tra ve tren wap
            } else {
                $profileId = 1; // Mac dinh cho cac url tra ve tren web
            }
        }
        $profile = Common::getSongProfile($profileId);

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

        $path = Common::storageSolutionEncode($id) . $id."/d" . "/" . $songname. "." . $profile['format'];
        $severStreaming = Yii::app()->params['storage']['songUrlDownload'];
        if ($protocol == "rtsp://") {
            $severStreaming = Yii::app()->params['storage']['songUrlRTSPDownload'];
        }
        $severStreaming = str_replace("http://", "", $severStreaming);
        $severStreaming = str_replace("https://", "", $severStreaming);

        $mediaPath = Common::getMediaPath($id,'song');
        if($mediaPath){
            $mediaPath = $mediaPath."/";
        }
        return $protocol . $severStreaming .$mediaPath. "songs/".$profile['name']."/" . $path;

    }

    public function getAudioFileUrlByProfile($id = 0, $profileId = 1, $protocol = false) {
        if (!$id)
            $id = $this->id;
        $profile = Common::getSongProfile($profileId);

        $severStreaming = Yii::app()->params['storage']['songUrl'];
        if ($protocol) {
            $protocol = $protocol . "://";
        } elseif ($profile['http_support']) {
            $protocol = "http://";
        } elseif ($profile['rtsp_support']) {
            $protocol = "rtsp://";
            $severStreaming = Yii::app()->params['storage']['songUrlRTSP'];
        } elseif ($profile['rtmp_support']) {
            $protocol = "rtmp://";
            $severStreaming = Yii::app()->params['storage']['songUrlRTSP'];
        } else {
            $protocol = "http://";
        }

        $path = Common::storageSolutionEncode($id) . $id . "." . $profile['format'];

        $severStreaming = str_replace("http://", "", $severStreaming);
        $severStreaming = str_replace("https://", "", $severStreaming);
        $mediaPath = Common::getMediaPath($id,'song');
        if($mediaPath){
            $mediaPath = $mediaPath."/";
        }
        return $protocol . $severStreaming .$mediaPath. "songs/".$profile['name']."/" . $path;
    }

    public function getSongProfileIdSuport($deviceId, $protocol = false) {
        if ($deviceId == "")
            return array();
        $clientDevice = strtoupper($deviceId);
        if (strpos($clientDevice, "ANDROID") !== false) {
            return array(1);
        }
        if (strrpos($clientDevice, "IPHONE") !== false) {
            return array(2);
        }

        $c = new CDbCriteria();
        $c->condition = "device_id=:DID";
        $c->params = array(":DID" => $deviceId);
        $profile = DeviceModel::model()->findByAttributes(array('device_id' => $deviceId));
        if (!empty($profile)) {
            $profileList = $profile->song_profile_ids;
            $profileList = explode(",", $profileList);
            if (!empty($profileList))
                return $profileList;
        }
        if ($protocol) {
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
            $profile = SongProfileModel::model()->findAll($c);
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
     * Hàm này thực hiện encode 1 bài hát thành string để lưu trong trường song_data trong DB
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

    public function getAvatarUrl($id = null, $size = "150", $cacheBrowser = false) {
        if (!isset($id))
            $id = $this->id;

        // browser cache
        if ($cacheBrowser) {
            $version = isset($this->updated_time) ? $this->updated_time : 0;
        } else {
            $version = time();
        }

        $path = AvatarHelper::getAvatar("song", $id, $size);
        return $path . "?v=" . $version;
    }

    /**
     *
     * Hàm này thực hiện decode trường song_data thành mảng, khóa là thuộc tính tương ứng của song
     * @param string $data
     * @return array
     */
    public function decodeData($data) {
        return json_decode($data, true);
    }

    public function findAllByIds($ids){
		$criteria = new CDbCriteria();
		$criteria->addInCondition('id',$ids);
		return $this->findAll($criteria);
	}

	public function getCountSongFeature($artistId=null)
	{
		$c = new CDbCriteria();
		$c->join = "INNER JOIN feature_song AS fs ON fs.song_id = t.id";
		$c->condition = "t.status=".self::ACTIVE ." AND fs.status=".FeatureSongModel::ACTIVE;
		if($artistId){
			$c->addColumnCondition("t.artist_id=".$artistId);
		}
		return self::model()->count($c);
	}

	public function getSongFeature($artistId=null,$limit=10,$offset=0)
	{
		$c = new CDbCriteria();
		$c->condition = "t.status=".self::ACTIVE;
		if($artistId){
			$c->addColumnCondition("t.artist_id=".$artistId);
		}
		$c->group = 't.id';
		$c->order = "fs.sorder ASC";
		$c->limit = $limit;
		$c->offset = $offset;
        $c = self::applySuggestCriteria(__CLASS__, $c);

		return self::model()->with("song_statistic","feature_song")->findAll($c);
	}

	public function getCountFav($songId=null)
	{
		if($this) $songId = $this->id;
		$c = new CDbCriteria();
		$c->condition = "song_id=:ID";
		$c->params = array(":ID"=>$songId);
		return FavouriteSongModel::model()->count($c);
	}
	public function isHQ($songProfile='')
	{
		$profile = explode(',', $songProfile);
		if(in_array(4, $profile)){
			return true;
		}
		return false;
	}

    public function getUrlByProfile($song_id,$profileId,$url_key,$artist_name,$type='play'){
        $url =  self::getAudioFileUrlByProfile($song_id ? $song_id : $this->id, $profileId, 'http');
        $url = substr($url, 0,-4);
        $url_key = trim($url_key);
        $url_key = trim($url_key,"-");
        $artist_name = trim($artist_name);
        $firstKey = substr($url_key,0,1);
        if($type=="download"){
            $sufix = "d";
            $url_key = ucfirst($url_key);
            $url = str_replace("streaming","download",$url);
        }else{
            $sufix = "s";
        }
        $url .="/$sufix/$url_key - ".Common::strNormal($artist_name).".mp3?$sufix=1";
        return $url;
    }

}