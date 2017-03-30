<?php
class RbtModel extends BaseRbtModel
{
	const DEACTIVE = 0;
	const ACTIVE = 1;

	public $downloaded_count;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Rbt the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rbt';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'rbt_collection_item' => array(self::HAS_MANY,'RbtCollectionItemModel','rbt_id'),
                    "rbt_statistic" => array(self::HAS_ONE, "RbtStatisticModel", "rbt_id"),
                    "rbt_download" => array(self::HAS_ONE, "RbtDownloadModel", "rbt_id"),
                    "rbt_ringtune" => array(self::HAS_ONE, "RbtRingtuneModel", "mo_id"),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
                $criteria->addCondition("code like '$this->code%'");
		$criteria->compare('name',$this->name,true);
		$criteria->compare('category_id',$this->category_id);
		if($this->artist_id == "1")
		$criteria->addCondition('artist_id >= '. $this->artist_id);
		if($this->artist_id == "0")
		$criteria->compare('artist_id',$this->artist_id);

		$criteria->compare('artist_name',$this->artist_name,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('song_id',$this->song_id,true);
		$criteria->compare('ringtone_id',$this->ringtone_id,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('convert_status',$this->convert_status);
		$criteria->compare('status',$this->status);
		$criteria->compare('updated_time',$this->updated_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
		),
		));
	}

	public function getOriginPath($id = null, $isFullPath = true)
	{
		if(!isset($id)) $id = $this->id;
		$savePath = Common::storageSolutionEncode($id).$id.".WMA";
		if($isFullPath)
		return $path = Yii::app()->params['storage']['rbtDir'].DS."origin".DS.$savePath;
		else
		return $savePath;
	}
	public function getOriginUrl($id = null)
	{
		if(!isset($id)) $id = $this->id;
		$savePath = Common::storageSolutionEncode($id).$id.".WMA";
		$path = Yii::app()->params['storage']['rbtUrl']."origin/".$savePath;
		return $path;
	}

	public function getAudioFilePath($id = null, $isFullPath = true)
	{
		if(!isset($id)) $id = $this->id;
		$savePath = Common::storageSolutionEncode($id).$id.".mp3";
		if($isFullPath){
			if($mediaPath){
				$mediaPath = $mediaPath."/";
			}
			return $path = Yii::app()->params['storage']['baseStorage'].$mediaPath."rbt/output".DS."mp3".DS.$savePath;
		}
		else
		return $savePath;
	}
	public function getAudioFileUrl($id = null)
	{
		if(!isset($id)) $id = $this->id;
		$savePath = Common::storageSolutionEncode($id).$id.".mp3";
		$mediaPath = Common::getMediaPath($id,'song');
		if($mediaPath){
			$mediaPath = $mediaPath."/";
		}
		$sufix = "";
		/* $pos = strrpos(Yii::app()->params['storage']['rbtUrl'], "audio.chacha.vn");
		if ($pos !== false) {
			$sufix = "output/";
		} */
		$path = Yii::app()->params['storage']['rbtUrl'].$mediaPath."rbt/".$sufix."mp3/".$savePath;

		return $path;
	}

	public function getMobileFileUrl($id = null)
	{
		if(!isset($id)) $id = $this->id;
		$savePath = Common::storageSolutionEncode($id).$id.".3gp";
		$mediaPath = Common::getMediaPath($item->id,'song');
		if($mediaPath){
			$mediaPath = $mediaPath."/";
		}
		$path = Yii::app()->params['storage']['rbtUrl'].$mediaPath."rbt/3gp/".$savePath;
		$path = str_replace("http://", "rtsp://", $path);
		return $path;
	}

	public function getByCode($code)
	{
		$c = new CDbCriteria();
		$c->condition = "code=:CODE";
		$c->params = array(":CODE"=>$code);
		return self::model()->find($c);
	}

	public function getByCodes($codes = array())
	{
		$c = new CDbCriteria();
		$c->addInCondition("code", $codes);
		return self::model()->findAll($c);
	}

	public function findAllByIds($ids) {
		$criteria = new CDbCriteria();
		$criteria->addInCondition('id', $ids);
		return $this->findAll($criteria);
	}
	
	public static function applySuggestCriteria($className, $criteria) {
		return $criteria;
		//        $host = ($_SERVER["HTTP_HOST"]);
		//        $arr = explode('.',$host);
		//
		//        if($arr[0] == 'm')
			//            return $criteria;
			//        if (!$criteria)
				//            $criteria = new CDbCriteria ();
	
		// thong tin cua nguoi dung hien tai duoc luu trong session
		$user = Yii::app()->user->getState('_user');
		// neu ton tai danh sach suggest cho nguoi dung
		if (isset($user) && (trim($user['suggested_list']) != "")) {
			$suggestCols = array();
			$suggestedIds = explode(",", $user['suggested_list']);
			$model = new $className();
			foreach ($suggestedIds as $suggestedId) {
				$colName = self::getSuggestedColNameById($suggestedId);
				if ($model->hasAttribute($colName)) {
					$suggestCols[] = $colName;
				}
			}
			if (!empty($suggestCols)) {
				// $suggestSelect la chuoi duoc gan vao phan SQL SELECT
				// $suggestSelect co dang: SELECT (suggest_1+suggest_2) AS suggestLevel
				$suggestSelect = "(" . implode("+t.", $suggestCols) . ") AS suggestLevel";
				if ($criteria->select != "") {
					$criteria->select .= ",$suggestSelect";
				} else {
					$criteria->select = $suggestSelect;
				}
	
				// order
				$suggestOrder = "suggestLevel DESC";
				if ($criteria->order != "") {
					$criteria->order = "$suggestOrder," . $criteria->order;
				} else {
					$criteria->order = $suggestOrder;
				}
			}
		}
	
		return $criteria;
	}

	public function getRbtObj($rbt_code){
		$rbt = RbtModel::model()->findbyAttributes(array('code'=>$rbt_code));
		return $rbtObj = array(
			'id'=>(int)$rbt['id'],
			'code'=>(string)$rbt['code'],
			'title'=>(string)$rbt['name_song'],
			'artist_name'=>(string)$rbt['name_singer'],
			'price'=>(int)$rbt['price'],
			'url_streaming'=>(string)$rbt['link_listen_web'],
			'downloaded_count'=>1000,
		);
	}
}