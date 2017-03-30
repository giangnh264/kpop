<?php
class CollectionModel extends BaseCollectionModel
{
    // items list mode
    const MODE_MANUAL = 0;
    const MODE_AUTO = 1;
    const ACTIVE = 1;
	const INACTIVE = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Collection the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Lay danh sach cac item cua collection
     * @param INT $page
     * @param INT $limit
     * @return \CActiveDataProvider
     */
    public function getItems($page=1, $limit=0, $filter_sync_status = '',$count = false) {
        if(!$limit) $limit = Yii::app()->params['pageSize'];
        if($this->mode == self::MODE_AUTO) return $this->_getItemsAuto($page, $limit, null, $filter_sync_status,$count);

        else return $this->_getItemsManual($page, $limit, $filter_sync_status,$count);
    }

    public function getItemsByDistrict($page=1, $limit=0, $district = '',$count = false) {
    	if(!$limit) $limit = Yii::app()->params['pageSize'];
    	if($this->mode == self::MODE_AUTO) return $this->_getItemsAutoByDistrict($page, $limit, $district, $count);

    	else return $this->_getItemsManualByDistrict($page, $limit, $district, $count);
    }
    /**
     * Ham lay ra danh sach cac item cua collection co type=MANUAL
     * @param INT $page
     * @param INT $limit
     * @return \CActiveDataProvider
     */
    private function _getItemsManual($page, $limit, $filter_sync_status='',$count = false) {
        $itemModelClass = $this->_getItemModelName();

        $criteria = new CDbCriteria;
        $criteria->alias = "t";
        $criteria->select = "t.*";
        $criteria->join = "INNER JOIN collection_item t2 ON t.id=t2.item_id";
        $criteria->condition = "t.status=".$itemModelClass::ACTIVE." AND t2.collect_id=:COLLECT_ID";
        $criteria->params = array(":COLLECT_ID" => $this->id);
        $criteria->order = "t2.sorder ASC, t2.id DESC";
        $criteria->group = "t2.id";
        /*join with static table*/
		$type = $this->type;
        $criteria = $this->joinStatistic($criteria,$type);

        $criteria = $itemModelClass::applySuggestCriteria($itemModelClass, $criteria);

        if($count)
            return $itemModelClass::model()->cache(Yii::app()->params['cacheTime'])->count($criteria);
        $criteria->offset = ($page-1)*$limit;
        $criteria->limit = $limit;

        $cache_code = "COLLECTION_ITEMS_{$this->id}_page_{$page}_limit_{$limit}";
        $result = Yii::app()->cache->get($cache_code);
        if(false===$result){
        	$result = $itemModelClass::model()->findAll($criteria);
        	Yii::app()->cache->set($cache_code,$result,Yii::app()->params['cacheTime']);
        }

        return $result;
    }

    private function _getItemsManualByDistrict($page, $limit, $district='',$count = false) {
        $key_cache = "COLLECTION_ITEMS_{$this->id}_GET_DISTRICT_{$page}_limit_{$limit}_district_{$district}";
        $result = Common::getCache($key_cache);
        if($result === false){
            $genreIds = array();
            switch ($district) {
                case 'VN':
                    $genreVNparent = Yii::app()->params['VNGenreParent'];
                    $genreIds[] = $genreVNparent;
                    $criteria = new CDbCriteria;
                    $criteria->condition = "parent_id = ".$genreVNparent;
                    $results = GenreModel::model()->findAll($criteria);
                    if ($results) {
                        foreach ($results as $result) {
                            $genreIds[] = $result['id'];
                        }
                    }
                    break;
                case 'AUMY':
                    $genreAUMYparent = Yii::app()->params['QTEGenreParent'];
                    $genreIds[] = $genreAUMYparent;
                    $criteria = new CDbCriteria;
                    $criteria->condition = "parent_id = ".$genreAUMYparent;
                    $results = GenreModel::model()->findAll($criteria);
                    if ($results) {
                        foreach ($results as $result) {
                            $genreIds[] = $result['id'];
                        }
                    }
                    break;
                case 'CHAUA':
                    $genreIds = yii::app()->params['CHAUAGenre'];
                    break;
            }

            $itemModelClass = $this->_getItemModelName();
            $criteria = new CDbCriteria;
            $criteria->alias = "t";
            $criteria->select = "t.*";
            $criteria->join = "INNER JOIN collection_item t2 ON t.id=t2.item_id";
            //$criteria->condition = "t.status=".$itemModelClass::ACTIVE." AND t2.collect_id=:COLLECT_ID AND t.genre_id IN (" . mysql_real_escape_string($genreIds) .") ";
            $criteria->condition = "t.status=".$itemModelClass::ACTIVE." AND t2.collect_id=:COLLECT_ID ";
            $criteria->params = array(":COLLECT_ID" => $this->id);
            if (!empty($genreIds)) {
                $criteria->addInCondition("t.genre_id", $genreIds);
            }
            $criteria->order = "t2.sorder ASC, t2.id DESC";
            $criteria->group = "t2.id";
            /*join with static table*/
            $type = $this->type;
            $criteria = $this->joinStatistic($criteria,$type);
            $criteria = $itemModelClass::applySuggestCriteria($itemModelClass, $criteria);
            if($count)
                return $itemModelClass::model()->cache(Yii::app()->params['cacheTime'])->count($criteria);
            $criteria->offset = ($page-1)*$limit;
            $criteria->limit = $limit;

            $cache_code = "COLLECTION_ITEMS_{$this->id}_page_{$page}_limit_{$limit}_district_{$district}";
            $result = $itemModelClass::model()->findAll($criteria);
            Common::setCache($key_cache,$result);
        }
    	return $result;
    }

    /**
     * Ham lay ra danh sach cac item cua collection co mode=AUTO
     * @param INT $page
     * @param INT $limit
     * @param string $filter_sync_status: = '' thì ko filter những item mà sync_status != 1, = 'filter_sync_status' thì chỉ lấy item mà sync_status = 1
     * @param boolean $count: = false thì query rồi trả về kết quả, = true thì chỉ trả về số lượng
     * @param boolean $isAdmin: = false thì dùng hàm findAll trả về list đối tượng, = true thì trả về CActiveDataProvider (dùng để rend dữ liệu ra grid trong phần biên tập bộ sưu tập)
     * @return \CActiveDataProvider
     */
    public function _getItemsAuto($page, $limit, $suggest = null, $filter_sync_status = '',$count = false, $isAdmin = false) {
        $itemModelClass = $this->_getItemModelName();

        $criteria = new CDbCriteria();
        $queryTemplate = array(
            "WHERE" => "condition",
            "ORDER BY" => "order",
        );

        $params = $this->sql_query?json_decode($this->sql_query):array();
        if($params) {
            foreach ($params as $param => $value) {
                $param = strtoupper($param);
                if (isset($queryTemplate[$param])) {
                    if (isset($suggest) && $queryTemplate[$param] == "order") {
                        $value = "suggest_$suggest DESC," . $value;
                    }
                    $criteria->{$queryTemplate[$param]} = $value;
                }
            }
        }
        if($criteria->condition != "")
        {
            $criteria->condition .= " AND status=".$itemModelClass::ACTIVE;
        }
        else
        {
            $criteria->condition = "status=".$itemModelClass::ACTIVE;
        }
		$criteria->group = "t.id";
        if($filter_sync_status == 'filter_sync_status')
            $criteria->addCondition("sync_status=".$itemModelClass::ACTIVE);
        /*join with static table*/
		$type = $this->type;
        $criteria = $this->joinStatistic($criteria,$type);

        $criteria = $itemModelClass::applySuggestCriteria($itemModelClass, $criteria);
        if($isAdmin){
            if($limit) $pagination['pageSize'] = $limit;
            if($page) $pagination['currentPage'] = $page-1;

            return new CActiveDataProvider($itemModelClass, array(
                'criteria'=>$criteria,
                'pagination'=>$pagination,
            ));
        }

        if($count)
            return $itemModelClass::model()->cache(Yii::app()->params['cacheTime'])->count($criteria);
        $criteria->offset = ($page-1)*$limit;
        $criteria->limit = $limit;
        return $itemModelClass::model()->cache(Yii::app()->params['cacheTime'])->findAll($criteria);
    }

    public function _getItemsAutoByDistrict($page, $limit, $district = '',$count = false) {
    	$itemModelClass = $this->_getItemModelName();

    	$criteria = new CDbCriteria();
    	$queryTemplate = array(
    			"WHERE" => "condition",
    			"ORDER BY" => "order",
    	);

    	$params = $this->sql_query?json_decode($this->sql_query):array();
        if($params) {
            foreach ($params as $param => $value) {
                $param = strtoupper($param);
                if (isset($queryTemplate[$param])) {
                    $criteria->{$queryTemplate[$param]} = $value;
                }
            }
        }

    	$genreIds = array();
    	switch ($district) {
    		case 'VN':
                $genreVNparent = Yii::app()->params['VNGenreParent'];
    			$genreIds[] = $genreVNparent;
    			$criteriaVN = new CDbCriteria;
    			$criteriaVN->condition = "parent_id = ".$genreVNparent;
    			$results = GenreModel::model()->findAll($criteriaVN);
    			if ($results) {
    				foreach ($results as $result) {
    					$genreIds[] = $result['id'];
    				}
    			}
    			break;
    		case 'AUMY':
                $genreAUMYparent = Yii::app()->params['QTEGenreParent'];
    			$genreIds = Yii::app()->params['QTEGenre'];
    			$criteriaAUMY = new CDbCriteria;
    			$criteriaAUMY->condition = "parent_id = ".$genreAUMYparent;
    			$results = GenreModel::model()->findAll($criteriaAUMY);
    			if ($results) {
    				foreach ($results as $result) {
    					$genreIds[] = $result['id'];
    				}
    			}
    			break;
    		case 'CHAUA':
    			$genreIds = Yii::app()->params['CAGenreParent'];
    			break;
    	}
    	if($criteria->condition != "") {
    		$criteria->condition .= " AND status=".$itemModelClass::ACTIVE ;
    		$criteria->addInCondition("genre_id", $genreIds);
    	} else {
    		$criteria->condition = "status=".$itemModelClass::ACTIVE;
    		$criteria->addInCondition("genre_id", $genreIds);
    	}
    	//$criteria->params = array('GENRE_IDS' => $genreIds);
    	$criteria->group = "t.id";

    	/*join with static table*/
    	$type = $this->type;
    	$criteria = $this->joinStatistic($criteria,$type);

    	$criteria = $itemModelClass::applySuggestCriteria($itemModelClass, $criteria);

    	if($count)
    		return $itemModelClass::model()->cache(Yii::app()->params['cacheTime'])->count($criteria);
    	$criteria->offset = ($page-1)*$limit;
    	$criteria->limit = $limit;
    	return $itemModelClass::model()->cache(Yii::app()->params['cacheTime'])->findAll($criteria);
    }

    /**
     * Lay ten model dua theo type
     * @return string
     */
    public function _getItemModelName($type_ = NULL) {
        $type = ($type_)? $type_ : $this->type;
        switch ($type) {
            case "video":
                $itemModelName = "VideoModel";
                break;
            case "album":
                $itemModelName = "AlbumModel";
                break;
            case "playlist":
                $itemModelName = "PlaylistModel";
                break;
            case "rbt":
                $itemModelName = "RbtModel";
                break;
            case "rt":
                $itemModelName = "RingtoneModel";
                break;
            case "video_playlist":
              	$itemModelName = "VideoPlaylistModel";
               	break;
            default:
                $itemModelName = "SongModel";
                break;

        }
        return $itemModelName;
    }
	/*join with static table*/
    public function joinStatistic($criteria,$type){
		 switch ($type) {
            case "video":
                $criteria->with = "video_statistic";
                break;
            case "album":
                $criteria->with = "album_statistic";
                break;
            case "playlist":
                $criteria->with = "playlist_statistic";
                break;
            case "rbt":
                $criteria->with = "rbt_statistic";
                break;
            case "rt":
                $criteria->with = "ringtone_statistic";
                break;
            case "video_playlist":
              	//$criteria->with = "ringtone_statistic";
               	break;
            default:
                $criteria->with = "song_statistic";
                break;

        }
        return $criteria;
	}
    /**
     * Lay danh sach mode
     * @return type
     */
    public static function getModeArray() {
        return array(
            self::MODE_MANUAL     => Yii::t("admin", "Manual"),
            self::MODE_AUTO   => Yii::t("admin", "Auto"),
        );
    }

    /**
     * Get mode label from it's mode
     * @return string
     */
    public function getModeLabel() {
        $modeArray = $this->getModeArray();
        return $modeArray[$this->mode];
    }


    /**
     * Lay danh sach type: song, video, album, playlist
     * @return array
     */
    public static function getTypeArray() {
        return array(
            'song'  => Yii::t('admin', 'Bài hát'),
            'video' => Yii::t('admin', "Video"),
            'album' => Yii::t('admin', "Album"),
            'playlist' => Yii::t('admin', 'Playlist'),
            'rbt' => Yii::t('admin', 'Nhạc chờ'),
            'rt' => Yii::t('admin', 'Nhạc chuông'),
        	'video_playlist' => Yii::t('admin', 'Live show'),
        );
    }

    /**
     * Get type label from it's type
     * @return string
     */
    public function getTypeLabel() {
        $typeArray = $this->getTypeArray();
        return $typeArray[$this->type];
    }

    public function search($custom_field = null)
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
        $domain = Yii::app()->request->getParam('domain','');
        if(empty($domain)){
            $criteria->addCondition("code NOT LIKE '%mientay%' AND code NOT LIKE '%quocte%' ");
        }
		$criteria->compare('name',$this->name,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('mode',$this->mode);
		$criteria->compare('sql_query',$this->sql_query,true);
		$criteria->compare('web_home_page',$this->web_home_page);
		$criteria->compare('cc_type',$this->cc_type);
        if($custom_field){
            $criteria->addCondition("$custom_field > 0");
            $criteria->order = " $custom_field ASC ";
        }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}

	public function getCollectionByType($type, $ccType, $ccGenre, $week) {
		$collection = array();
		$cr = new CDbCriteria();

		if ($week > 1) {
			$cr->condition = "type=:type AND cc_type=:cc_type AND cc_genre = :cc_genre AND cc_week_num = :cc_week_num";
			$cr->params = array(":type" => $type, ":cc_type" => $ccType, ":cc_genre" => $ccGenre, ":cc_week_num" => $week);
		} else {
			$cr->condition = "type=:type AND cc_type=:cc_type AND cc_genre = :cc_genre";
			$cr->params = array(":type" => $type, ":cc_type" => $ccType, ":cc_genre" => $ccGenre);
		}
		$cr->order = 'cc_week_begin DESC';
		$cr->limit = 1;
    		$collection = CollectionModel::model()->findAll($cr);
		return $collection;
	}

	public function getWeeksForChart($type, $ccType, $ccGenre, $week) {
		$weeks = array();
		$cr = new CDbCriteria();

		if ($week > 1) {
			$cr->condition = "type=:type AND cc_type=:cc_type AND cc_genre = :cc_genre AND cc_week_num = :cc_week_num
								AND (cc_week_begin > date_sub(cc_week_begin, INTERVAL -5 week) or cc_week_end < date_sub(cc_week_begin, INTERVAL -5 week))";
			$cr->params = array(":type" => $type, ":cc_type" => $ccType, ":cc_genre" => $ccGenre, ":cc_week_num" => $week);
		} else {
			$cr->condition = "type=:type AND cc_type=:cc_type AND cc_genre = :cc_genre";
			$cr->params = array(":type" => $type, ":cc_type" => $ccType, ":cc_genre" => $ccGenre);
		}

		$cr->order = 'cc_week_begin DESC';
		$cr->limit = 10;

		$weeks = CollectionModel::model()->findAll($cr);
		return $weeks;
	}
        
        public function _getItemsManualClient($offset, $limit, $count = false) {
        $itemModelClass = $this->_getItemModelName();
        $criteria = new CDbCriteria;
        $criteria->alias = "t";
        $criteria->select = "t.*";
        $criteria->join = "INNER JOIN collection_item t2 ON t.id=t2.item_id";
        $criteria->condition = "t.status=".$itemModelClass::ACTIVE." AND t2.collect_id=:COLLECT_ID";
        $criteria->params = array(":COLLECT_ID" => $this->id);
        $criteria->order = "t2.sorder ASC, t2.id DESC";
        $criteria->group = "t2.id";
        /*join with static table*/
	$type = $this->type;
        $criteria = $this->joinStatistic($criteria,$type);
        $criteria = $itemModelClass::applySuggestCriteria($itemModelClass, $criteria);
        if($count)
            return $itemModelClass::model()->cache(Yii::app()->params['cacheTime'])->count($criteria);
        $criteria->offset = $offset;
        $criteria->limit = $limit;
        $cache_code = "COLLECTION_ITEMS_{$this->id}_page_{$offset}_limit_{$limit}";
        $result = Yii::app()->cache->get($cache_code);
        if(false===$result){
        	$result = $itemModelClass::model()->findAll($criteria);
        	Yii::app()->cache->set($cache_code,$result,Yii::app()->params['cacheTime']);
        }        
        return $result;
    }
    
     /**
     * Ham lay ra danh sach cac item cua collection co mode=AUTO CHO client
     * @param INT $page
     * @param INT $limit
     * @param string $filter_sync_status: = '' thì ko filter những item mà sync_status != 1, = 'filter_sync_status' thì chỉ lấy item mà sync_status = 1
     * @param boolean $count: = false thì query rồi trả về kết quả, = true thì chỉ trả về số lượng
     * @param boolean $isAdmin: = false thì dùng hàm findAll trả về list đối tượng, = true thì trả về CActiveDataProvider (dùng để rend dữ liệu ra grid trong phần biên tập bộ sưu tập)
     * @return \CActiveDataProvider
     */
    public function _getItemsAutoClient($offset, $limit,$count = false) {
        $itemModelClass = $this->_getItemModelName();
        
        $criteria = new CDbCriteria();
        $queryTemplate = array(
            "WHERE" => "condition",
            "ORDER BY" => "order",
        );
        $params = $this->sql_query?json_decode($this->sql_query):array();
        foreach($params as $param => $value) {
            $param = strtoupper($param);
            if(isset($queryTemplate[$param]))
            {
                $criteria->{$queryTemplate[$param]} = $value;
            }
        }
        if($criteria->condition != "")
        {
            $criteria->condition .= " AND status=".$itemModelClass::ACTIVE;
        }
        else
        {
            $criteria->condition = "status=".$itemModelClass::ACTIVE;
        }
		$criteria->group = "t.id";
        /*join with static table*/
		$type = $this->type;
        $criteria = $this->joinStatistic($criteria,$type);
        $criteria = $itemModelClass::applySuggestCriteria($itemModelClass, $criteria);
        if($count)
            return $itemModelClass::model()->cache(Yii::app()->params['cacheTime'])->count($criteria);
        $criteria->offset = $offset;
        $criteria->limit = $limit;
        return $itemModelClass::model()->cache(Yii::app()->params['cacheTime'])->findAll($criteria);
    }
}