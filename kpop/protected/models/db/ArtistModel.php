 <?php
class ArtistModel extends BaseArtistModel
{
	const ACTIVE = 1;
	const DEACTIVE = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Artist the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($joinRbt="")
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->alias = 't';
		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url_key',$this->url_key,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('song_count',$this->song_count,true);
		$criteria->compare('video_count',$this->video_count,true);
		$criteria->compare('album_count',$this->album_count,true);
		$criteria->compare('genre_id',$this->genre_id);
		$criteria->compare('artist_type_id',$this->artist_type_id);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('t.status',$this->status);
        $criteria->compare('t.artist_key',$this->artist_key);
        $criteria->order = "t.name ASC";
        if(isset($joinRbt))
        {
            if($joinRbt == 1){
                $criteria->addCondition(" EXISTS (select * from rbt where rbt.artist_id = t.id) ");
            }
            if($joinRbt == -1){
                $criteria->addCondition(" NOT EXISTS (select * from rbt where rbt.artist_id = t.id) ");

//                        $criteria->join = "LEFT JOIN rbt ON t.id = rbt.artist_id";
//                        $criteria->addCondition("rbt.artist_id = 0 OR rbt.artist_id IS NULL");
            }
        }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                                'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
                        ),
		));
	}


	public function scopes() {
		return array(
				"published" => array(
						"condition" => "t.status = " . self::ACTIVE,
						"order"=>"name ASC"
				),
		);
	}

	public function getAvatarPath($id=null,$size=150,$isFolder = false)
	{
		if(!isset($id)) $id = $this->id;
		if($isFolder){
			$savePath = Common::storageSolutionEncode($id);
		}else{
			$savePath = Common::storageSolutionEncode($id).$id.".jpg";
		}
		$savePath = Common::storageSolutionEncode($id).$id.".jpg";
		$path = Yii::app()->params['storage']['artistDir'].DS.$size.DS.$savePath;
		return $path;
	}

	public function getAvatarUrl($id=null, $size="150", $cacheBrowser = false)
	{
        if(!isset($id)) $id = $this->id;

    	// browser cache
    	if($cacheBrowser)
    	{
    		$version = isset($this->updated_time) ? $this->updated_time:0;
    	}
    	else $version = time();

		$path = AvatarHelper::getAvatar("artist", $id, $size);
		return $path."?v=".$version;
	}


    /**
     *
     * Hàm này thực hiện encode 1 artist thành string để lưu trong trường artist_data trong DB
     * @return string : json encode data
     */
    public function encodeData()
    {
        $data = array(
            'id' => $this->id,
            'name' => $this->name,
            'url_key' => $this->url_key,
        );

        return json_encode($data);
    }

    /**
     *
     * Hàm này thực hiện decode trường artist_data thành mảng, khóa là thuộc tính tương ứng của artist
     * @param string $data
     * @return array
     */
    public function decodeData($data)
    {
        return json_decode($data, true);
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

}