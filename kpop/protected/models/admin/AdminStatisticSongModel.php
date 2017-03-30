<?php

Yii::import('application.models.db.StatisticSongModel');

class AdminStatisticSongModel extends StatisticSongModel
{
	var $className = __CLASS__;
	var $period;
	var $sum_played_count;
	var $sum_downloaded_count;
	var $sum_revenue;
	var $name;
	public $size_export_list = null;
	public function getContentReport($period = ReportController::PERIOD_DAY){
		$criteria=new CDbCriteria;

		if ($this->genre_id){
			//  echo $this->genre_id;
			$criteria->join = " INNER JOIN genre ON genre.id = t.genre_id AND (genre.parent_id=".$this->genre_id." OR genre.id =".$this->genre_id.") ";
			//$criteria->compare('genre_id',$this->genre_id);
		}

		if (is_array($this->date)){
			$criteria->addBetweenCondition('date', $this->date[0], $this->date[1]);
		}
		else
		$criteria->compare('date',$this->date);
		$criteria->compare('cp_id',$this->cp_id);
		$criteria->compare('artist_id',$this->artist_id);

		switch ($period){
			case ReportController::PERIOD_WEEK:
				$criteria->select = "CONCAT(WEEK(date),'_',YEAR(date)) as period, SUM(revenue) AS sum_revenue, SUM(played_count) as sum_played_count, SUM(downloaded_count) as sum_downloaded_count";
				$criteria->group= "CONCAT('".Yii::t('admin',"Tuần ")."',WEEK(date),'_',YEAR(date))";
				break;
			case ReportController::PERIOD_MONTH:
				$criteria->select = "CONCAT(month(date),'/',year(date)) as period, SUM(revenue) AS sum_revenue, SUM(played_count) as sum_played_count, SUM(downloaded_count) as sum_downloaded_count";
				$criteria->group = "CONCAT(month(date),'/',year(date))";
				break;
			case ReportController::PERIOD_DAY:
			default:
				$criteria->select = "date as period,SUM(revenue) AS sum_revenue, SUM(played_count) as sum_played_count, SUM(downloaded_count) as sum_downloaded_count";
				$criteria->group = "date";
		}

		$results = self::model()->findAll($criteria);
		$output = "";
		$total = 0;
		foreach ($results as $result){
			$total += $result->sum_played_count+$result->sum_downloaded_count;
			$output .= $result->period.";".$result->sum_played_count.";".$result->sum_downloaded_count.";".($result->sum_played_count+$result->sum_downloaded_count)."\\n";
		}

		return array("content"=>($output=="")?";;;":$output,"total"=>$total);
	}

	public function getContentRecords($period = ReportController::PERIOD_DAY){
		$criteria=new CDbCriteria;

		if ($this->genre_id){
			//  echo $this->genre_id;
			$criteria->join = " INNER JOIN genre ON genre.id = t.genre_id AND (genre.parent_id=".$this->genre_id." OR genre.id =".$this->genre_id.") ";
			//$criteria->compare('genre_id',$this->genre_id);
		}
		$criteria->join .= " INNER JOIN song on song.id = t.song_id ";

		if (is_array($this->date)){
			$criteria->addBetweenCondition('date', $this->date[0], $this->date[1]);
		}
		else
		$criteria->compare('date',$this->date);
		$criteria->compare('cp_id',$this->cp_id);
		$criteria->compare('t.artist_id',$this->artist_id,false);

		$criteria->select = "song.name AS name,SUM(downloaded_count) as sum_downloaded_count, SUM(played_count) AS sum_played_count";
		$criteria->group  = "song_id";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
		),
		));
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function relations()
	{
		return  CMap::mergeArray( parent::relations(),   array(
            'genre'=>array(self::BELONGS_TO, 'AdminGenreModel', 'genre_id', 'select'=>'id, name'),
            'cp'=>array(self::BELONGS_TO, 'AdminCpModel', 'cp_id', 'select'=>'id, name', 'joinType'=>'LEFT JOIN'),
            'artist'=>array(self::BELONGS_TO, 'AdminArtistModel', 'artist_id', 'select'=>'id, name', 'joinType'=>'LEFT JOIN'),
		));
	}

	public function searchGlobal($genre_id = null, $owner = null)
	{
		$where  = $this->_buildCondition();

		// check the loai nay La the loai Cha hay the loai con
		$add_where = "";
		if($genre_id){
			$genreModel = GenreModel::model()->findByPk($genre_id);
			// the loai cha
			if($genreModel->parent_id == 0){
				$criteria = new CDbCriteria;
				$criteria->condition = "parent_id = $genre_id AND status = ". SongModel::ACTIVE;
				$childGenres = GenreModel::model()->findAll($criteria);
				$genre_ids = array();
				$genre_ids[] = $genre_id;
				foreach($childGenres as $childGenre)
				$genre_ids[] = $childGenre->id;
				$genre_ids = implode(',',$genre_ids);
				$add_where .= " AND sc.genre_id IN ($genre_ids)";
			}
			else
			$add_where .= " AND sc.genre_id = $genre_id";
		}else{
			/* $criteria = new CDbCriteria;
			$criteria->condition = "parent_id = 0 AND status = ". SongModel::ACTIVE;
			$childGenres = GenreModel::model()->findAll($criteria);
			$genre_ids = array();
			foreach ($childGenres as $child){
				$criteria1 = new CDbCriteria;
				$criteria1->condition = "parent_id = $child->id AND status = ". SongModel::ACTIVE;
				$childGenres = GenreModel::model()->findAll($criteria1);
				$genre_ids[] = $child->id;
				foreach($childGenres as $childGenre)
				$genre_ids[] = $childGenre->id;
			}
			$genre_ids = implode(',',$genre_ids);
			$add_where .= " AND sc.genre_id IN ($genre_ids)"; */
		}

		$add_where1 = "";
		if($owner){
			$add_where1 .= " and son.owner = '$owner'";
		}


		//        $finalWhere = empty($add_where)?" WHERE $where ":" INNER JOIN song_genre sc ON sc.song_id = statistic_song.song_id WHERE $where $add_where";

		if(empty($add_where)){
			$finalWhere = " WHERE $where ";
			if(!empty($owner)){
				$finalWhere = " INNER JOIN song son ON son.id = statistic_song.song_id WHERE $where $add_where1";
			}
		}
		else{
			$finalWhere = " INNER JOIN song_genre sc ON sc.song_id = statistic_song.song_id WHERE $where $add_where";
			if(!empty($owner)){
				$finalWhere = " INNER JOIN song son ON son.id = statistic_song.song_id INNER JOIN song_genre sc ON sc.song_id = statistic_song.song_id WHERE $where $add_where $add_where1";
			}
		}

		$sql = "
			SELECT
                date,
                SUM(played_count) AS played_count,
                SUM(played_count_web) AS played_count_web,
                SUM(played_count_wap) AS played_count_wap,
                SUM(played_count_api_ios) AS played_count_api_ios,
                SUM(played_count_api_android) AS played_count_api_android,
                SUM(downloaded_count) AS downloaded_count,
                SUM(downloaded_count_web) AS downloaded_count_web,
                SUM(downloaded_count_wap) AS downloaded_count_wap,
                SUM(downloaded_count_api_ios) AS downloaded_count_api_ios,
                SUM(downloaded_count_api_android) AS downloaded_count_api_android,
                SUM(revenue_play_wap) AS revenue_play_wap,
                SUM(revenue_play_api_ios) AS revenue_play_api_ios,
                SUM(revenue_play_api_android) AS revenue_play_api_android,
                SUM(revenue_download_web) AS revenue_download_web,
                SUM(revenue_download_wap) AS revenue_download_wap,
                SUM(revenue_download_api_ios) AS revenue_download_api_ios,
                SUM(revenue_download_android) AS revenue_download_android
            FROM statistic_song
            $finalWhere
            GROUP BY date
            ORDER BY date DESC
		";
            $data = Yii::app()->db->createCommand($sql)->queryAll();
            return $data;
	}

	public function searchCopyrightCP($ccp_id = null, $date = null, $copyrightType = 0) {
		$where = "TRUE ";
		$criteria = new CDbCriteria;
		$criteria->condition = "parent_id = 0 AND status = " . SongModel::ACTIVE;
		if (is_array($this->date)) {
			$where .= " AND statistic_song.date >= '" . $date['from'] . "' AND statistic_song.date <= '" . $date['to'] . "' ";
		} else {
			$where .= " AND statistic_song.date = '" . $date . "' ";
		}
		$finalWhere = " WHERE $where ";
		$finalWhere .= " AND copyright.ccp=" . $ccp_id . " AND copyright.type=" . $copyrightType;
		$finalWhere .= " AND (scp.assign_cp_id=copyright.id || scp.assign_cp_id=0) ";
		$sql = "
            SELECT
                date,
                SUM(played_count-play_not_free) AS played_count,
                SUM(revenue_play) AS revenue_played,
                SUM(downloaded_count-download_not_free) AS downloaded_count,
                SUM(revenue_download) AS revenue_download,
                SUM(played_count_A1) AS played_count_A1,
                SUM(played_count_A7) AS played_count_A7,
                SUM(downloaded_count_A1) AS downloaded_count_A1,
                SUM(downloaded_count_A7) AS downloaded_count_A7

            FROM statistic_song
            INNER JOIN song_copyright scp ON statistic_song.song_id = scp.song_id
            INNER JOIN copyright ON copyright.id = scp.copryright_id
            $finalWhere
            GROUP BY date
            ORDER BY date DESC
        ";
		$data = Yii::app()->db->createCommand($sql)->queryAll();
		$data_video = AdminStatisticVideoModel::model()->getVideoStatistic($ccp_id, $date, $copyrightType); //print_r($data_video);die;

		$time = $date;
		$timeFrom = date('Y-m-d', strtotime($time['from']));
		$timeTo = date('Y-m-d', strtotime($time['to']));
		$timeLabel = array();
		while ($timeFrom <= $timeTo) {
			$timeLabel[] = $timeFrom;
			$timeFrom = date('Y-m-d', strtotime(date("Y-m-d", strtotime($timeFrom)) . "+1 day"));
		}
		/*
        foreach ($timeLabel as $key => $time) {
            foreach ($data as $key2 => $value) {
                if ($value['date'] == $time) {
                    $timeLabel[$key] = $value;
                }
            }
            foreach ($data_video as $key_video => $video) {
                if ($video['date'] == $time) {
                    $orgSong = $timeLabel[$key];
                    $timeLabel[$key] = array_merge($orgSong, $video);
                }
            }
        }
         *
         */
		$dataSong = array();
		$dataVideo = array();
		foreach ($data as $key2 => $value) {
			$dataSong[$value['date']] = $value;
		}
		foreach ($data_video as $key_video => $video) {
			$dataVideo[$video['date']] = $video;
		}
		$dataMerge = array();
		foreach ($timeLabel as $key => $time) {
			if (!isset($dataSong[$time])) {
				$sArr = array(
					'date' => $time,
					'played_count' => 0,
					'revenue_played' => 0,
					'downloaded_count' => 0,
					'revenue_download' => 0
				);
			} else {
				$sArr = $dataSong[$time];
			}
			if (!isset($dataVideo[$time])) {
				$vArr = array(
					'date' => $time,
					'played_count_video' => 0,
					'revenue_played_video' => 0,
					'downloaded_count_video' => 0,
					'revenue_download_video' => 0
				);
			} else {
				$vArr = $dataVideo[$time];
			}
			$dataMerge[$key] = array_merge($sArr, $vArr);
		}
		$timeLabel = $dataMerge;
		foreach ($timeLabel as $key => $value) {
			if (!is_array($value)) {
				$timeLabel[$key] = array(
					'date' => $value,
					'played_count' => 0,
					'revenue_played' => 0,
					'downloaded_count' => 0,
					'revenue_download' => 0,
					'played_count_A1' => 0,
					'played_count_A7' => 0,
					'played_count_video_A1' => 0,
					'played_count_video_A7' => 0,
					'played_count_video' => 0,
					'revenue_played_video' => 0,
					'downloaded_count_video' => 0,
					'revenue_download_video' => 0
				);
			}
		}

		$dataTotalDownload = $this->getTotalStatisticSongByTimeRange($date);
		$dataTotalDownload_video = AdminStatisticVideoModel::model()->getTotalStatisticVideoByTimeRange($date);
		$userInTotal = AdminStatisticSubscribeModel::model()->getTotalStatisticSubscribeByTimeRange($date);

		$datas = array();
		foreach ($timeLabel as $key => $value) {
			$datas[$key] = $value;

			//$dataTotalDownload
			foreach ($dataTotalDownload as $key1 => $value1) {
				if ($value1['date'] == $value['date']) {
					$datas[$key]['total_download'] = $value1['total_download'];
					$datas[$key]['total_download_free'] = $value1['total_download_free'];
					$datas[$key]['total_listen'] = $value1['total_listen'];
					$datas[$key]['total_listen_free'] = $value1['total_listen_free'];
					$datas[$key]['total_listen_A1'] = $value1['total_listen_A1'];
					$datas[$key]['total_listen_A7'] = $value1['total_listen_A7'];

					$datas[$key]['total_download_A1'] = $value1['total_download_A1'];
					$datas[$key]['total_download_A7'] = $value1['total_download_A7'];
				}
			}

			//$userInTotal
			$datas[$key]['user_incurred_charge'] = 0;
			foreach ($userInTotal as $key2 => $value2) {
				if ($value2['date'] == $value['date']) {
					$user_incurred_charge = $value2['total_user_use_service'];
					$datas[$key]['user_incurred_charge'] = ($user_incurred_charge > 0) ? $user_incurred_charge : 0;
				}
			}

			//$dataTotalDownload_video
			foreach ($dataTotalDownload_video as $key3 => $value3) {
				if ($value3['date'] == $value['date']) {
					$datas[$key]['total_download_video'] = $value3['total_download_video'];
					$datas[$key]['total_download_free_video'] = $value3['total_download_free_video'];
					$datas[$key]['total_listen_video'] = $value3['total_listen_video'];
					$datas[$key]['total_listen_free_video'] = $value3['total_listen_free_video'];

					$datas[$key]['total_download_video_A1'] = $value3['total_download_video_A1'];
					$datas[$key]['total_download_video_A7'] = $value3['total_download_video_A7'];
					$datas[$key]['total_listen_video_A1'] = $value3['total_listen_video_A1'];
					$datas[$key]['total_listen_video_A7'] = $value3['total_listen_video_A7'];
				}
			}
		}
		return $datas;
	}

	/**
	 * get by artist, composer
	 * @param string $ccp_id
	 * @param string $date
	 * @param number $copyrightType
	 * @return Ambigous <multitype:Ambigous <string, multitype:number string , unknown> , number>
	 */
	public function searchRevenueCPArtist($time, $artist = 0,$composer=0, $cp=0)
	{
		$where = "TRUE ";
		$where .= " AND ss.date >= '".$time['from']. "' AND ss.date <= '".$time['to']."' ";
		$query = " WHERE $where ";
		if($artist>0){
			$query .=" AND ss.artist_id=$artist ";
		}
		if($composer>0){
			$query .=" AND s.composer_id=$composer";
		}
		if($cp>0){
			$query .=" AND ss.cp_id=$cp";
		}
		$sql = "
			SELECT
           		ss.date,
                SUM(ss.played_count-ss.play_not_free) AS played_count,
                SUM(ss.revenue_play) AS revenue_played,
                SUM(ss.downloaded_count-ss.download_not_free) AS downloaded_count,
                SUM(ss.revenue_download) AS revenue_download
            FROM statistic_song ss
            LEFT JOIN song s ON ss.song_id = s.id
            $query
            GROUP BY date
            ORDER BY date DESC
			";
            $data = Yii::app()->db->createCommand($sql)->queryAll();
            	$timeFrom = date('Y-m-d', strtotime($time['from']));
            	$timeTo = date('Y-m-d', strtotime($time['to']));
            	$timeLabel = array();
            	/* while ($timeFrom<=$timeTo){
            		$timeLabel[] = $timeFrom;
            		$timeFrom = date('Y-m-d', strtotime(date("Y-m-d", strtotime($timeFrom)) . "+1 day"));
            	} */
            	while ($timeFrom<=$timeTo){
            		$timeLabel[] = $timeTo;
            		$timeTo = date('Y-m-d', strtotime(date("Y-m-d", strtotime($timeTo)) . "-1 day"));
            	}
            	//echo '<pre>';print_r($timeLabel);die('aa');
            	foreach ($timeLabel as $key => $time){
            		//
            		foreach ($data as $key2 => $value){
            			if($value['date']==$time){
            				$timeLabel[$key] = $value;
            			}
            		}
            	}
            	foreach ($timeLabel as  $key => $value)
            	{
            		if(!is_array($value)){
            			$timeLabel[$key] = array(
            					'date' => $value,
            					'played_count' => 0,
            					'revenue_played' => 0,
            					'downloaded_count' => 0,
            					'revenue_download' => 0
            			);
            		}
            	}

            $datas = array();
            foreach ($timeLabel as  $key => $value)
            {
            	$datas[$key]= $value;
            	$datas[$key]['total_download'] = $this->getTotalDownloadByTime($value['date']);
            	$datas[$key]['total_download_free'] = $datas[$key]['total_download'] -  ceil($this->getTotalRevDownloadByTime($value['date'])/2000);
            	$datas[$key]['total_listen'] = $this->getTotalListenByTime($value['date']);
            	$datas[$key]['total_listen_free'] = $datas[$key]['total_listen'] - ceil($this->getTotalRevListenByTime($value['date'])/1000);
            	$userInTotal = AdminStatisticSubscribeModel::model()->findByAttributes(array('date'=>$value['date']));
				$user_incurred_charge = ($userInTotal)?$userInTotal->total_user_use_service:0;
            	$datas[$key]['user_incurred_charge'] = ($user_incurred_charge>0)?$user_incurred_charge:0;
            }
            //echo '<pre>';print_r($datas);die();
            return $datas;
	}
	/*
	 * Reports CCP Retail
	 * */
	public function searchCCPRetail($ccp_id = null,$date =null, $copyrightType=0)
	{
            $where = "TRUE ";
            if($ccp_id){
                /* if($copyrightType==0){
                        //TQ
                        $where .= " AND ccp_id = ".$ccp_id;
                }else{
                        //QLQ
                        $where .= " AND ccpr_id = ".$ccp_id;
                } */

                $where .= " AND copyright.ccp=".mysql_escape_string($ccp_id)." AND copyright.type=".$copyrightType;                
            }
            if(is_array($this->date)){
                    $where .= " AND ss.date >= '".$date['from']. "' AND ss.date <= '".$date['to']."' ";
            }else{
                    $where .= " AND ss.date = '" .$date ."' ";
            }
            $finalWhere = " WHERE $where  AND (scp.assign_cp_id=copyright.id || scp.assign_cp_id=0) ";
            $VNgenre = $this->getGenreParentList(Yii::app()->params['VNGenre']);
            $sql = "
                    SELECT date,
                            SUM(ss.revenue_play)/1000 as played_count_nofree ,
                            ceil(SUM(ss.revenue_download)/2000) as downloaded_count_nofree,
                            (CASE WHEN genre_id IN ($VNgenre)
                                    THEN SUM(revenue_download) ELSE SUM(revenue_download) END)
                                            AS total_revenue_download,
                            (CASE WHEN genre_id IN ($VNgenre)
                                    THEN SUM(revenue_play)  ELSE SUM(revenue_play) END)
                                            AS total_revenue_play
                            FROM statistic_song as ss
                            INNER JOIN song_copyright scp ON ss.song_id = scp.song_id
                            INNER JOIN copyright ON copyright.id = scp.copryright_id
                            $finalWhere
                            GROUP BY ss.date
                            ORDER BY ss.date DESC

                    ";
            $data = Yii::app()->db->createCommand($sql)->queryAll();
            
            $data_video = AdminStatisticVideoModel::model()->getVideoCCPRetail($ccp_id,$date, $copyrightType); //print_r($data_video);die;
            
            if(count($data) <= 0 && count($data_video) <= 0)
                return array();
            
            $time = $date;
            $timeFrom = date('Y-m-d', strtotime($time['from']));
            $timeTo = date('Y-m-d', strtotime($time['to']));
            $timeLabel = array();
            while ($timeFrom<=$timeTo){
                    $timeLabel[] = $timeFrom;
                    $timeFrom = date('Y-m-d', strtotime(date("Y-m-d", strtotime($timeFrom)) . "+1 day"));
            }
            foreach ($timeLabel as $key => $time){
                //
                foreach ($data as $key2 => $value){
                        if($value['date']==$time){
                                $timeLabel[$key] = $value;
                        }
                }
                foreach ($data_video as $key_video => $video){
                        if($video['date']==$time){
                                $timeLabel[$key] = $video;
                        }
                }
            }
            
            foreach ($timeLabel as  $key => $value)
            {
                    if(!is_array($value)){
                            $timeLabel[$key] = array(
                                            'date' => $value,
                                            'played_count_nofree' => 0,
                                            'downloaded_count_nofree' => 0,
                                            'total_revenue_download' => 0,
                                            'total_revenue_play' => 0,
                                            'played_count_nofree_video' => 0,
                                            'downloaded_count_nofree_video' => 0,
                                            'total_revenue_download_video' => 0,
                                            'total_revenue_play_video' => 0,
                            );
                    }
            }            
            return $timeLabel;
	}
	/*
	 * Doanh thu le ca sy
	 * */
	public function revenueRetailArtist($artist,$composer, $cp, $date)
	{
		$where = "TRUE ";
		$where .= " AND ss.date >= '".$date['from']. "' AND ss.date <= '".$date['to']."' ";
		
		$query = " WHERE $where ";
		
		if($artist>0){
			$query .=" AND ss.artist_id=$artist ";
		}
		if($cp>0){
			$query .=" AND ss.cp_id=$cp";
		}
		if($composer>0){
			$query =" LEFT JOIN song s ON ss.song_id = s.id ".$query." AND s.composer_id=$composer";
		}
		
		$VNgenre = $this->getGenreParentList(Yii::app()->params['VNGenre']);
		
		$sql = "
			SELECT ss.date,
				SUM(ss.revenue_play)/1000 as played_count_nofree ,
				ceil(SUM(ss.revenue_download)/2000) as downloaded_count_nofree,
				(CASE WHEN ss.genre_id IN ($VNgenre)
					THEN SUM(ss.revenue_download) ELSE SUM(ss.revenue_download) END)
				 		AS total_revenue_download,
				(CASE WHEN ss.genre_id IN ($VNgenre)
					THEN SUM(ss.revenue_play)  ELSE SUM(ss.revenue_play) END)
						AS total_revenue_play
				FROM statistic_song as ss
				$query
				GROUP BY ss.date
				ORDER BY ss.date DESC

			";
				$data = Yii::app()->db->createCommand($sql)->queryAll();
				return $data;
	}
	/**
	 * Reports CCP song Detail
	 */
	public function SearchCCPSongDetail($ccp_id=0, $copyrightType=0)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('song_id',$this->song_id);
		$criteria->compare('artist_id',$this->artist_id);
		//$criteria->compare('ccp_id',$this->ccp_id);
		//$criteria->compare('ccpr_id',$this->ccpr_id);



		if(is_array($this->date)){
			$criteria->addBetweenCondition('date',$this->date['from'],$this->date['to']);
		}else{
			$criteria->compare('date',$this->date);
		}
		$criteria->group = "t.song_id";

		$criteria->select = "
				song_id,song_name, genre_id,cp_id,artist_id,
				SUM(played_count) AS played_count,
				SUM(downloaded_count) AS downloaded_count,
                SUM(revenue_play) AS revenue_play,
                SUM(revenue_download) AS revenue_download,
                 SUM(played_count_A1) AS played_count_A1,
                SUM(played_count_A7) AS played_count_A7,
                SUM(downloaded_count_A1) AS downloaded_count_A1,
                SUM(downloaded_count_A7) AS downloaded_count_A7,
				revenue_play + revenue_download AS total_revenue,
				SUM(play_not_free) as play_not_free,
				SUM(download_not_free) as download_not_free
				";

		$criteria->join = "INNER JOIN song_copyright scp ON t.song_id = scp.song_id
                           INNER JOIN copyright ON copyright.id = scp.copryright_id";
		$criteria->addCondition("copyright.ccp=".mysql_escape_string($ccp_id));
        $criteria->addCondition("copyright.type=".$copyrightType);
        $criteria->addCondition("(scp.assign_cp_id=copyright.id OR scp.assign_cp_id=0)");

		if(!$this->song_name){
			$criteria->addCondition("song_name <> ''");
		}
		else{
			$criteria->addCondition("song_name like '%$this->song_name%'");
		}

		$joinWith[] = 'artist';
		//$joinWith[] = 'cp';
		$criteria->with = $joinWith;
		$criteria->order = "played_count desc, downloaded_count desc";
		if($this->size_export_list>0){
			$pageSize = $this->size_export_list;
		}else{
			$pageSize = Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']);
		}
		$db = new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> $pageSize,
		),
		));
		$db->setTotalItemCount(count(self::model()->findAll($criteria)));
		return $db;
	}
	/**
	 * doanh thu chi tiet ca sy
	 */
	public function SearchRevenueSongDetailArtist($song_name, $artist, $composer, $cp, $time)
	{
		$criteria=new CDbCriteria;

		$criteria->compare('artist_id',$artist);
		$criteria->compare('cp_id',$cp);

		$criteria->addBetweenCondition('date',$time['from'],$time['to']);
		
		$criteria->group = "t.song_id";

		$criteria->select = "
				song_id,song_name, genre_id,cp_id,artist_id,
				SUM(played_count) AS played_count,
				SUM(downloaded_count) AS downloaded_count,
                SUM(revenue_play) AS revenue_play,
                SUM(revenue_download) AS revenue_download,
				revenue_play + revenue_download AS total_revenue,
				SUM(play_not_free) as play_not_free,
				SUM(download_not_free) as download_not_free
				";
		if($composer>0){
			$criteria->join = "LEFT JOIN song s ON t.song_id = s.id";
			$criteria->addCondition("s.composer_id=".$composer);
		}
		
		if(!empty($song_name)){
			$criteria->addCondition("song_name like '%$song_name%'");
		}

		$joinWith[] = 'artist';
		$joinWith[] = 'cp';
		$criteria->with = $joinWith;
		$criteria->order = "played_count desc, downloaded_count desc";
		if($this->size_export_list>0){
			$pageSize = $this->size_export_list;
		}else{
			$pageSize = Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']);
		}
		$db = new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> $pageSize,
		),
		));
		$db->setTotalItemCount(count(self::model()->findAll($criteria)));
		return $db;
	}

	public function getGenreParentList($genre_id = null)
	{
		$genre_root = '('.implode(',',$genre_id).')';
		$sql = "
			SELECT id
			FROM genre
            WHERE parent_id IN $genre_root
			";
		$data = Yii::app()->db->createCommand($sql)->queryAll();
		$list = '';
		foreach ($data as $val)
		{
			$list = $list.','.$val['id'];
		}
		return substr($list,1);
	}
	public function SearchDetail($genre_id = null, $owner = null, $sort = null, $export=false)
	{
		$criteria=new CDbCriteria;

		$criteria->compare('song_id',$this->song_id,true);
		//		$criteria->compare('genre_id',$this->genre_id);
		//$criteria->compare('cp_id',$this->cp_id);
		$criteria->compare('ccp_id',$this->ccp_id);
		$criteria->compare('artist_id',$this->artist_id,false);
		$criteria->compare('played_count',$this->played_count,true);
		$criteria->compare('played_count_wap',$this->played_count_wap);
		$criteria->compare('played_count_api_ios',$this->played_count_api_ios);
		$criteria->compare('played_count_api_android',$this->played_count_api_android);
		$criteria->compare('downloaded_count',$this->downloaded_count,true);
		$criteria->compare('downloaded_count_web',$this->downloaded_count_web);
		$criteria->compare('downloaded_count_wap',$this->downloaded_count_wap);
		$criteria->compare('downloaded_count_api_ios',$this->downloaded_count_api_ios);
		$criteria->compare('downloaded_count_api_android',$this->downloaded_count_api_android);
		$criteria->compare('revenue_play_wap',$this->revenue_play_wap,true);
		$criteria->compare('revenue_play_api_ios',$this->revenue_play_api_ios,true);
		$criteria->compare('revenue_play_api_android',$this->revenue_play_api_android,true);
		$criteria->compare('revenue_download_web',$this->revenue_download_web,true);
		$criteria->compare('revenue_download_wap',$this->revenue_download_wap,true);
		$criteria->compare('revenue_download_api_ios',$this->revenue_download_api_ios,true);
		$criteria->compare('revenue_download_android',$this->revenue_download_android,true);
		if(is_array($this->date)){
			$criteria->addBetweenCondition('date',$this->date['from'],$this->date['to']);
		}else{
			//$criteria->compare('date',$this->date,true);
			$criteria->addCondition("t.date='{$this->date}'");
		}
		$criteria->group = "song_id";

		$criteria->select = "
				song_id,song_name, genre_id,cp_id,artist_id,
				SUM(played_count) AS played_count,
				SUM(played_count_wap) AS played_count_wap,
				SUM(played_count_api_ios) AS played_count_api_ios,
				SUM(played_count_api_android) AS played_count_api_android,
				SUM(downloaded_count) AS downloaded_count,
				SUM(downloaded_count_web) AS downloaded_count_web,
				SUM(downloaded_count_wap) AS downloaded_count_wap,
				SUM(downloaded_count_api_ios) AS downloaded_count_api_ios,
				SUM(downloaded_count_api_android) AS downloaded_count_api_android,
				SUM(revenue_play_wap) AS revenue_play_wap,
				SUM(revenue_play_api_ios) AS revenue_play_api_ios,
				SUM(revenue_play_api_android) AS revenue_play_api_android,
				SUM(revenue_download_web) AS revenue_download_web,
				SUM(revenue_download_wap) AS revenue_download_wap,
				SUM(revenue_download_api_ios) AS revenue_download_api_ios,
				SUM(revenue_download_android) AS revenue_download_android,
                SUM(revenue_play) AS revenue_play,
                SUM(revenue_download) AS revenue_download,
				revenue_play + revenue_download AS total_revenue
				";


		if(!$this->song_name){
			$criteria->addCondition("t.song_name <> ''");
		}
		else{
			$criteria->addCondition("t.song_name like '%$this->song_name%'");
		}
		if($genre_id){
			$criteria->addCondition("t.genre_id = '$genre_id'");
		}
		if($this->cp_id>0){
			$criteria->addCondition("t.cp_id = $this->cp_id");
		}
		if($owner){
			$criteria->addCondition("t2.owner = '$owner'");
			$criteria->join = "INNER JOIN song t2 ON t2.id = t.song_id";
		}

		$joinWith[] = 'artist';
		$joinWith[] = 'cp';
		$criteria->with = $joinWith;
		$criteria->order = "played_count desc, downloaded_count desc";
		if($sort)
		$criteria->order = "{$sort[0]} $sort[1]";
		$pageSize = $export?65000:Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']);
		$db = new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> $pageSize,
		),
		));
		//$db->setTotalItemCount(count(self::model()->findAll($criteria)));
		return $db;
	}

	function _buildCondition()
	{
		$condition = array();
		$condition[] = "1=1";

		if(is_array($this->date)){
			$condition[] = " date >= '{$this->date['from']}' AND date <= '{$this->date['to']}' ";
		}else{
			$condition[] = " date = '{$this->date}'";
		}
		if($this->genre_id){
			$condition[] = " genre_id = '{$this->genre_id}'";
		}
		if($this->cp_id){
			$condition[] = " cp_id = '{$this->cp_id}'";
		}
		if($this->artist_id){
			$condition[] = " artist_id = '{$this->artist_id}'";
		}
		if($this->song_name){
			$condition[] = " song_name like '%{$this->song_name}%'";
		}
		return implode(" AND ", $condition);
	}

	public function getTotalListenByTime($time)
	{
		$sql = "SELECT SUM(played_count) AS played_count FROM statistic_song WHERE date = '{$time}'";
		$result= Yii::app()->db->createCommand($sql)->queryScalar();
		return ($result>0)?$result:0;
	}
	public function getTotalRevListenByTime($time)
	{
		$sql = "SELECT SUM(revenue_play) AS revenue_play FROM statistic_song WHERE date = '{$time}'";
		$result= Yii::app()->db->createCommand($sql)->queryScalar();
		return ($result>0)?$result:0;
	}
	public function getTotalRevDownloadByTime($time)
	{
		$sql = "SELECT SUM(revenue_download) AS revenue_download FROM statistic_song WHERE date = '{$time}'";
		$result = Yii::app()->db->createCommand($sql)->queryScalar();
		return ($result>0)?$result:0;
	}
	public function getTotalDownloadByTime($time)
	{
		$sql = "SELECT SUM(downloaded_count) AS downloaded_count FROM statistic_song WHERE date = '{$time}'";
		$result = Yii::app()->db->createCommand($sql)->queryScalar();
		return ($result>0)?$result:0;
	}
        public function getTotalStatisticSongByTimeRange($date = null)
	{
            $where = "TRUE ";
            if(is_array($date)){
                    $where .= " AND date(date) >= '".$date['from']. "' AND date(date) <= '".$date['to']."' ";
            }else{
                    $where .= " AND date(date) = '" .$date ."' ";
            }
            $finalWhere = " WHERE $where ";
            $sql = "SELECT date(date) as date, 
                           SUM(downloaded_count) AS total_download,
			   SUM(downloaded_count) - CEIL(SUM(revenue_download)/2000) AS total_download_free,
			   SUM(played_count) AS total_listen,
			   SUM(played_count) - CEIL(SUM(revenue_play)/1000) AS total_listen_free,
			   SUM(played_count_A1) AS total_listen_A1,
			   SUM(played_count_A7) AS total_listen_A7,
				SUM(downloaded_count_A1) AS total_download_A1,
				SUM(downloaded_count_A7) AS total_download_A7
                    FROM statistic_song 
                    $finalWhere
                    GROUP BY date(date)
                    ORDER BY date(date) DESC";
            return Yii::app()->db->createCommand($sql)->queryAll();
	}
}