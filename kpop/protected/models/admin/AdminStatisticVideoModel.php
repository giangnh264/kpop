<?php

Yii::import('application.models.db.StatisticVideoModel');

class AdminStatisticVideoModel extends StatisticVideoModel
{
    var $className = __CLASS__;
	var $period;
    var $sum_played_count;
    var $sum_downloaded_count;    
    var $sum_revenue;
    var $name;
    public $size_export_list = null;
    
    
    public function relations()
    {
        return  CMap::mergeArray( parent::relations(),   array(
            'genre'=>array(self::BELONGS_TO, 'AdminGenreModel', 'genre_id', 'select'=>'id, name'),
            'cp'=>array(self::BELONGS_TO, 'AdminCpModel', 'cp_id', 'select'=>'id, name', 'joinType'=>'LEFT JOIN'),
            'artist'=>array(self::BELONGS_TO, 'AdminArtistModel', 'artist_id', 'select'=>'id, name', 'joinType'=>'LEFT JOIN'),
        ));
    }
    
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
        $criteria->join .= " INNER JOIN video on video.id = t.video_id ";
        
        if (is_array($this->date)){
            $criteria->addBetweenCondition('date', $this->date[0], $this->date[1]);
        }
        else
            $criteria->compare('date',$this->date);
		$criteria->compare('cp_id',$this->cp_id);
		$criteria->compare('t.artist_id',$this->artist_id,false);
        
        $criteria->select = "video.name AS name,SUM(downloaded_count) as sum_downloaded_count, SUM(played_count) AS sum_played_count";
        $criteria->group  = "video_id";
        
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
    
    
	public function getTotalListenByTime($time)
	{
		$sql = "SELECT SUM(played_count) AS played_count FROM statistic_video WHERE date = '{$time}'";
		$data = Yii::app()->db->createCommand($sql)->queryRow();
		if(!empty($data)) return $data['played_count'];
		return 0;
	}
	
	public function getTotalRevListenByTime($time)
	{
		$sql = "SELECT SUM(revenue_play) AS revenue_play FROM statistic_video WHERE date = '{$time}'";
		$data = Yii::app()->db->createCommand($sql)->queryRow();
		if(!empty($data)) return $data['revenue_play'];
		return 0;
	}
	public function getTotalRevDownloadByTime($time)
	{
		$sql = "SELECT SUM(downloaded_count) AS downloaded_count FROM statistic_video WHERE date = '{$time}'";
		$data = Yii::app()->db->createCommand($sql)->queryRow();
		if(!empty($data)) return $data['downloaded_count'];
		return 0;
	}
	public function getTotalDownloadByTime($time)
	{
		$sql = "SELECT SUM(revenue_download) AS revenue_download FROM statistic_video WHERE date = '{$time}'";
		$data = Yii::app()->db->createCommand($sql)->queryRow();
		if(!empty($data)) return $data['revenue_download'];
		return 0;
	}
	
	public function SearchDetail($genre_id = null, $owner = null, $sort = null)
	{
		$criteria=new CDbCriteria;

		$criteria->compare('video_id',$this->video_id,true);
//		$criteria->compare('genre_id',$this->genre_id);
		$criteria->compare('cp_id',$this->cp_id);
		//$criteria->compare('ccp_id',$this->ccp_id);
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
			$criteria->compare('date',$this->date,true);
		}
		
		$criteria->group = "video_id";
		
		$criteria->select = "
				video_id,video_name, genre_id,cp_id,artist_id,
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
		                
                if(!$this->video_name){
                    $criteria->addCondition("video_name <> ''");
                }
                else{
                    
                    $criteria->addCondition("video_name like '%$this->video_name%'");
                }
                
                if($genre_id){
                    $criteria->addCondition("t.genre_id = '$genre_id'");
                }
                
                $joinWith[] = 'artist';
                $joinWith[] = 'cp';
                $criteria->with = $joinWith;
                $criteria->order = "played_count desc, downloaded_count desc";
                if($sort)
                    $criteria->order = "{$sort[0]} $sort[1]";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 'total_revenue DESC'),
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
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
                $add_where .= " AND genre_id IN ($genre_ids)";
            }
            else
                $add_where .= " AND genre_id = $genre_id";
        }
        
        $add_where1 = "";
        if($owner){
            $add_where1 .= " and vid.owner = '$owner'";
        }
        
//        $finalWhere = empty($add_where)?" WHERE $where ":" WHERE $where $add_where";
        
        if(empty($add_where)){
            $finalWhere = " WHERE $where ";
            if(!empty($owner)){
                $finalWhere = " INNER JOIN video vid ON vid.id = statistic_video.video_id WHERE $where $add_where1";
            }
        }else{
            $finalWhere = " WHERE $where $add_where";
            if(!empty($owner)){
                $finalWhere = " INNER JOIN video vid ON vid.id = statistic_video.video_id  WHERE $where $add_where $add_where1";
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
				 
			FROM statistic_video 
			$finalWhere 
			GROUP BY date 
			ORDER BY date DESC 
		";
		$data = Yii::app()->db->createCommand($sql)->queryAll();
		return $data; 
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
                if($this->video_name){
			$condition[] = " video_name like '%{$this->video_name}%'";
		}
		return implode(" AND ", $condition);
	}	
        
        public function getVideoStatistic($ccp_id = null,$date =null, $copyrightType=0)
	{
		$where = "TRUE ";
		$criteria = new CDbCriteria;
		$criteria->condition = "parent_id = 0 AND status = ". VideoModel::ACTIVE;
		if(is_array($date)){
			$where .= " AND statistic_video.date >= '".$date['from']. "' AND statistic_video.date <= '".$date['to']."' ";
		}else{
			$where .= " AND statistic_video.date = '" .$date."' ";
		}
		$finalWhere = " WHERE $where ";
		$finalWhere .= " AND copyright.ccp=".mysql_escape_string($ccp_id)." AND copyright.type=".$copyrightType;
		$sql = "
			SELECT
           		date,
                        SUM(played_count-play_not_free) AS played_count_video,
                        SUM(revenue_play) AS revenue_played_video,
                        SUM(downloaded_count-download_not_free) AS downloaded_count_video,
                        SUM(revenue_download) AS revenue_download_video
                    FROM statistic_video
                    INNER JOIN video_copyright vcp ON statistic_video.video_id = vcp.video_id
                    INNER JOIN copyright ON copyright.id = vcp.copryright_id
                    $finalWhere
                    GROUP BY date
                    ORDER BY date DESC";
            return Yii::app()->db->createCommand($sql)->queryAll();
	}
        public function getTotalVideoViewByTime($time)
	{
		$sql = "SELECT SUM(played_count) AS played_count FROM statistic_video WHERE date = '{$time}'";
		$result= Yii::app()->db->createCommand($sql)->queryScalar();
		return ($result>0)?$result:0;
	}
        public function getTotalVideoDownloadByTime($time)
	{
		$sql = "SELECT SUM(downloaded_count) AS downloaded_count_video FROM statistic_video WHERE date = '{$time}'";
		$result = Yii::app()->db->createCommand($sql)->queryScalar();
		return ($result>0)?$result:0;
	}
        public function getTotalStatisticVideoByTimeRange($date = null)
	{
            $where = "TRUE ";
            if(is_array($date)){
                    $where .= " AND date(date) >= '".$date['from']. "' AND date(date) <= '".$date['to']."' ";
            }else{
                    $where .= " AND date(date) = '" .$date ."' ";
            }
            $finalWhere = " WHERE $where ";
            $sql = "SELECT date(date) as date, 
                           SUM(downloaded_count) AS total_download_video,
			   SUM(downloaded_count) - CEIL(SUM(revenue_download)/2000) AS total_download_free_video,
			   SUM(played_count) AS total_listen_video,
			   SUM(played_count) - CEIL(SUM(revenue_play)/1000) AS total_listen_free_video
                    FROM statistic_video 
                    $finalWhere
                    GROUP BY date(date)
                    ORDER BY date(date) DESC";
            return Yii::app()->db->createCommand($sql)->queryAll();
	}
        
        public function getVideoCCPRetail($ccp_id = null,$date =null, $copyrightType=0)
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
            if(is_array($date)){
                    $where .= " AND ss.date >= '".$date['from']. "' AND ss.date <= '".$date['to']."' ";
            }else{
                    $where .= " AND ss.date = '" .$date ."' ";
            }
            $finalWhere = " WHERE $where ";
            $VNgenre = $this->getGenreParentList(Yii::app()->params['VNGenre']);
            $sql = "
                    SELECT date,
                            SUM(ss.revenue_play)/1000 as played_count_nofree_video ,
                            ceil(SUM(ss.revenue_download)/2000) as downloaded_count_nofree_video,
                            (CASE WHEN genre_id IN ($VNgenre)
                                    THEN SUM(revenue_download) ELSE SUM(revenue_download) END)
                                            AS total_revenue_download_video,
                            (CASE WHEN genre_id IN ($VNgenre)
                                    THEN SUM(revenue_play)  ELSE SUM(revenue_play) END)
                                            AS total_revenue_play_video
                            FROM statistic_video as ss
                            INNER JOIN video_copyright vcp ON ss.video_id = vcp.video_id
                            INNER JOIN copyright ON copyright.id = vcp.copryright_id
                            $finalWhere
                            GROUP BY ss.date
                            ORDER BY ss.date DESC

                    ";
            return Yii::app()->db->createCommand($sql)->queryAll();
	}
        
	/**
	 * Reports CCP video Detail
	 */
	public function SearchCCPVideoDetail($ccp_id=0,$copyrightType=0)
	{
		$criteria=new CDbCriteria;

		/* if($copyrightType==0){
			//TQ
			$criteria->compare('ccp_id',$ccp);
		}else{
			$criteria->compare('ccpr_id',$ccp);
		} */
		$criteria->compare('video_id',$this->video_id);
		$criteria->compare('artist_id',$this->artist_id);
		//$criteria->compare('ccp_id',$this->ccp_id);
		//$criteria->compare('ccpr_id',$this->ccpr_id);



		if(is_array($this->date)){
			$criteria->addBetweenCondition('date',$this->date['from'],$this->date['to']);
		}else{
			$criteria->compare('date',$this->date);
		}
		$criteria->group = "t.video_id";

		$criteria->select = "
				video_id,video_name, genre_id,cp_id,artist_id,
				SUM(played_count) AS played_count,
				SUM(downloaded_count) AS downloaded_count,
                                SUM(revenue_play) AS revenue_play,
                                SUM(revenue_download) AS revenue_download,
				revenue_play + revenue_download AS total_revenue,
				SUM(play_not_free) as play_not_free,
				SUM(download_not_free) as download_not_free
				";

		$criteria->join = "INNER JOIN video_copyright vcp ON t.video_id = vcp.video_id
                           INNER JOIN copyright ON copyright.id = vcp.copryright_id";
		$criteria->addCondition("copyright.ccp=".mysql_escape_string($ccp_id));
        $criteria->addCondition("copyright.type=".$copyrightType);
        //$criteria->addCondition("(vcp.assign_cp_id=copyright.id || vcp.assign_cp_id=0)");

		if(!$this->video_name){
			$criteria->addCondition("video_name <> ''");
		}
		else{
			$criteria->addCondition("video_name like '%$this->video_name%'");
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
}