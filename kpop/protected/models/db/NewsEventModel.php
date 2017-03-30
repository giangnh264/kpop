<?php
class NewsEventModel extends BaseNewsEventModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return NewsEvent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function beforeSave() {
		$this->name = ucfirst($this->name);
		if(!$this->created_time) $this->created_time = new CDbExpression("NOW()");
		return parent::beforeSave();
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('sorder',$this->sorder);
        if($this->channel == 'wap')
            $criteria->compare('channel',$this->channel);
        else
            $criteria->compare('channel',$this->channel,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 't.sorder ASC'),
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}

    public static function getEvent($type = '', $channel = '') {
    	/* $newEvent = Yii::app()->cache->get("NEWS_EVENT_$channel_$type");

    	if(false===$newEvent){
    		$cr = new CDbCriteria();
	        if($type && $channel){
	            $cr->condition = 'type = :type AND channel = :channel';
	            $cr->params = array(':type' => $type,'channel' => $channel);
	            $cr->order = "sorder ASC,id DESC";
	            $search = self::model()->findAll($cr);
	            $newEvent = (!empty($search))?$search:null;
	        }else{
	        	$newEvent = null;
	        }
    		Yii::app()->cache->set("NEWS_EVENT_$channel_$type",$newEvent,Yii::app()->params['cacheTime']);
    	}
		return $newEvent; */

    	$cr = new CDbCriteria();
    	if($type && $channel){
    		$cr->condition = 'type = :type AND channel = :channel';
    		$cr->params = array(':type' => $type,'channel' => $channel);
    		$cr->order = "sorder ASC,id DESC";
    		$search = self::model()->findAll($cr);
    		$newEvent = (!empty($search))?$search:null;
    	}else{
    		$newEvent = null;
    	}
    	return $newEvent;
    }

    public static function getEventByChannel($channel = '',$type='', $limit = 10) {
    	$cr = new CDbCriteria();
    	if($channel){
			if($type){
				$cr->condition = 'channel = :channel AND type = :TYPE';
				$cr->params = array('channel' => $channel,':TYPE'=>$type);
			}else{
				$cr->condition = 'channel = :channel';
				$cr->params = array('channel' => $channel);
			}
    		$cr->order = "sorder ASC,id DESC";
			$cr->limit = $limit;
    		$search = self::model()->findAll($cr);
    		return (!empty($search))?$search:null;
    	}
    	return null;
    }

    public function getEventList()
    {
    	$criteria = new CDbCriteria;
    	$criteria->order = "sorder ASC, id DESC";
    	$results = self::model()->findAll($criteria);
    	return $results;
    }

    public function getEventLink($newsEvent)
    {
    	$link = "";
    	switch ($newsEvent->type)
    	{
    		case 'news' :
    			$link = yii::app()->createUrl('news/view', array('id' => $newsEvent->object_id, 'url_key' => Common::makeFriendlyUrl($newsEvent->name)));
    			//$link .= ".html";
    			///$link = "/news/view?id=".$newsEvent->object_id;
    			break;
    		case 'song' :
    			$link = yii::app()->createUrl('song/view', array('id' => $newsEvent->object_id, 'title' => Common::makeFriendlyUrl($newsEvent->name)));
    			//$link .= ".html";
    			///$link = "/song/view?id=".$newsEvent->object_id;
    			break;
			case 'album' :
				$link = yii::app()->createUrl('album/view', array('id' => $newsEvent->object_id, 'title' => Common::makeFriendlyUrl($newsEvent->name)));
   				break;
    		case 'video' :
    			$link = yii::app()->createUrl('video/view', array('id' => $newsEvent->object_id, 'title' => Common::makeFriendlyUrl($newsEvent->name)));
    			//$link .= ".html";
    			///$link = "/video/view?id=".$newsEvent->object_id;
    			break;
    		case 'register' :
    			$link = "/account/packageInfo?id=".$newsEvent->object_id;
    			break;
    		case 'custom' :
    			if($newsEvent->custom_link != null)
    				$link = $newsEvent->custom_link;
    			else
    				$link = "/account/guide?id=".$newsEvent->object_id;
    			break;
    	}
    	return $link;
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
    	$path = Yii::app()->params['storage']['newsEventDir'].DS.$size.DS.$savePath;
    	return $path;
    }

    public function getAvatarUrl($id=null, $size="150", $cacheBrowser = false)
    {
    	if(!isset($id)) $id = $this->id;

    	$path = AvatarHelper::getAvatar("newsEvent", $id, $size);
    	return $path."?v=".time();;
    }
}