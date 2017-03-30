<?php
class BannerModel extends BaseBannerModel {

    const INACTIVE = 0;
    const ACTIVE = 1;

    /**
     * Returns the static model of the specified AR class.
     * @return Banner the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('start_time', $this->start_time, true);
        $criteria->compare('expired_time', $this->expired_time, true);
        $criteria->compare('image_file', $this->image_file, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('channel', $this->channel, true);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('sorder', $this->sorder);
        $criteria->order = " sorder asc, id desc ";
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']),
                    ),
                ));
    }
    public function scopes() {
        return array(
            "published" => array(
                "condition" => "`t`.`status` = " . self::ACTIVE,
            ),
        );
    }

    public function getAllBannerbyChannel($channel = 'web') {
        $c = new CDbCriteria();
        $arBanner = array();
        $index = 0;
        $expired_time = date('Y-m-d', time());
        $c->condition = "channel = :Channel AND expired_time > :expired_time";
        $c->params = array(':Channel' => $channel, ':expired_time' => $expired_time);
        $c->order = " sorder asc, id desc";
        $result = BannerModel::model()->published()->findAll($c);

        foreach ($result as $banner) {
            $imageFile = "http://222.255.28.103:8080/css/wap/images/banner/" . $banner->image_file;
            if($banner->height != null && $banner->width !=null){
                $height = $banner->height;
                $width = $banner->width;
            }
            else
            {
                $height = $width = "100%";
            }
            $arBanner[$index]['image_file'] = $imageFile;
            $arBanner[$index]['id'] = $banner ? $banner->id : "";
            $arBanner[$index]['name'] = $banner ? $banner->name : "";
            $arBanner[$index]['url'] = $banner ? $banner->url : "";
            $arBanner[$index]['start_time'] = $banner ? $banner->start_time : "";
            $arBanner[$index]['expired_time'] = $banner ? $banner->expired_time : "";
            $arBanner[$index]['channel'] = $banner ? $banner->channel : "";
            $arBanner[$index]['position'] = $banner ? $banner->position : "";
            $arBanner[$index]['rate'] = $banner ? $banner->rate : "";
            $arBanner[$index]['sorder'] = $banner ? $banner->sorder : "";
            $arBanner[$index]['height'] = $height;
            $arBanner[$index]['width'] = $width;
            $index++;
        }
        return json_encode($arBanner, JSON_HEX_QUOT); //,JSON_HEX_QUOT | JSON_HEX_APOS | JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE
    }

    public static function getBanner($channel,$position = -1) {
        $criteria = new CDbCriteria;
        $expired_time = date('Y-m-d', time());
        $conExtra = "";
        if($position > 0)
            $conExtra = " AND position = $position";
        $criteria->condition = "channel = :Channel $conExtra AND expired_time > :expired_time AND status =:ST";
        $criteria->params = array(':Channel' => $channel, ':expired_time' => $expired_time, ":ST" => "1");
        $criteria->order = "RAND()";

        /* $banners = Yii::app()->cache->get("BANNER_$channel");
        if(false===$banners){
        	$banners = BannerModel::model()->findAll($criteria);
        	Yii::app()->cache->set("BANNER_$channel",$banners,Yii::app()->params['cacheTime']);
        } */

        $banners = BannerModel::model()->findAll($criteria);

        $arrRes = array();
        foreach ($banners as $bn) {
            $file = $bn->image_file;
            if($bn->height != null && $bn->width !=null){
                $height = $bn->height;
                $width = $bn->width;
            }
            else
            {
                $height = $width = "100%";
            }
            $url = Yii::app()->params['storage']['bannerUrl'];

            if (strrpos($file, ".swf") !== false) {
                $content = '
                <div id="flashContent" style="width:100%; height:100%;">
                    <object width="' . $width . '" height="' . $height . '" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
                    codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0">
                    <param name="SRC" value="'.$url . $bn->image_file . '">
                    <param name="wmode" value="transparent"/>
                    <embed src="'.$url . $bn->image_file . '" width="' . $width . '" height="' . $height . '">
                    </embed>
                    </object>
                </div>';
            }
            else{
            	$content = '<a href="' . $bn->url . '" target="_blank"><img src="'.$url . $bn->image_file . '" alt="photo" style="width:' .$width . 'px; height: ' .$height . 'px" /></a>';
            }


            $arrRes[] = array('position' => $bn->position, 'content' => $content,'rate'=>$bn->rate);
        }
        return ($arrRes);
    }

    public function __get($name)
    {
    	if($name == 'url' && $this->channel=='wap' && $this->log_click == 1 ){
    		return Yii::app()->params['base_url']."/banner/logads?id={$this->id}&url_to=".urlencode(parent::__get('url'));
    	}
    	return parent::__get($name);
    }

}