<?php

class Controller extends CController {

    public $layout = 'application.views.web.layouts.2column';
    public $breadcrumbs = array();

    public $htmlKeyword = "";
    public $htmlDescription = "";
    public $htmlTitle = "";
    public $headMeta = "";
	public $user_sub = 0;
    public function init() {
      
        // setup multi language

        if(!isset(Yii::app()->request->cookies['lang'])){
            $cookie = new CHttpCookie('lang', Yii::app()->params['defaultLanguage']);
            $cookie->expire = time() + 60 * 60 * 24 * 7;
            Yii::app()->request->cookies['lang'] = $cookie;
        }
        Yii::app()->language = trim(Yii::app()->request->cookies['lang']);

        // reload cache
        $this->updateCache();

        parent::init();
    }

    public function actionError(){}

    public function render($view, $data = null, $return = false) {

    	$this->htmlKeyword = Yii::app()->params['htmlMetadata']['keywords'];
    	if($this->htmlTitle){
    		$this->htmlTitle .= " | ". Common::strNormal($this->htmlTitle)." | ";
    	}
    	$this->htmlTitle .= Yii::app()->params['htmlMetadata']['title'];

    	if(!$this->htmlDescription){
    		$this->htmlDescription = Yii::app()->params['htmlMetadata']['description'];
    	}
        if($this->headMeta ==''){
    		$this->headMeta = '
    				<meta name="description" content="Amusic - trang nghe nhạc trực tuyến của MobiFone. Nghe nhạc online miễn phí, nghe tải nhạc chất lượng 320kbs về điện thoại nhanh nhất." />
					<meta name="keywords" content="nghe nhac truc tuyen, nghe nhac online, trang nghe nhac mobifone, nghe nhac tren dien thoai" />
			';
    	}
    	parent::render($view, $data, $return);
    }

    private function updateCache() {
    	if(Yii::app()->request->getParam('resetcache', 0) === 1)
    		Yii::app()->setComponent('cache', new CDummyCache());
    }



}