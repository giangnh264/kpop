<?php

class URLHelper {

    /**
     *
     * Enter description here ...
     * @param string $controller
     * @param integer $id
     * @param string $url_key
     *
     * Ex: 	buildFriendlyURL('song',1,'hello') -> /song/hello,1.html
     * 		buildFriendlyURL('song',1) -> /song/detail/1
     */
    static function buildFriendlyURL($controller, $id, $url_key = null) {
        if ($url_key == 'list')
            return "/{$controller}/$url_key";
        if ($url_key == "list/artist")
            return "/$controller/$url_key/$id";
        if ($controller == 'user')
            return '/user/profile/' . $id;

        return '/' . $controller . ($url_key ? "/$url_key,$id.html" : "/detail/$id");
    }

    static function buildXmlURL($table, $page = null) {
        if ($page)
            return Yii::app()->createUrl("sitemap/xml", array('t' => $table, 'p' => $page));
        else
            return Yii::app()->createUrl("sitemap/xml", array('t' => $table));
    }
    
    public static function  makeUrl($object)
    {
    	Yii::import("application.vendors.Hashids.*");
    	$hashids = new Hashids(Yii::app()->params["hash_url"]);
    	
    	$prefix = $sufix = "";
		$id = $hashids->encode($object["id"]);

    	if(isset($object["obj_type"])){
    		switch ($object["obj_type"]) {
    			case "album":
    				$prefix = "album-";
    				$suffix = "ab";
    				break;
    			case "playlist":
    				$prefix = "playlist-";
    				$suffix = "pl";
    				break;
				case "user_playlist":
					$prefix = "playlist-";
					$suffix = "pu";
					break;
    			case "song":
    				$suffix = "so";
    				break;
    			case "video":
    				$suffix = "mv";
    				break;
				case "playall_song_bxh":
					$prefix = "";
					$suffix = "cs";
					break;
				case "playall_song_artist":
					$prefix = "nhung-bai-hat-hay-nhat-cua-";
					$suffix = "ca";
					break;
				case "html_view":
					$prefix = "html-";
					$suffix = "hl";
					break;
				case "bxh":
					$prefix = "bang-xep-hang-";
					$suffix = "bx";
					break;
    		}
    	}
		$urlKey = $prefix.Common::makeFriendlyUrl($object["name"]);

		if(isset($object["artist"]) && $object["artist"] != ""){
			$urlKey = $prefix.Common::makeFriendlyUrl($object["name"]."-".$object["artist"]);
		}
		if($object["obj_type"]=='playlist'){
			$urlKey = $prefix.Common::makeFriendlyUrl($object["name"]);
		}

		$params = array("url_key" => $urlKey,"code"=>$suffix.$id);
		if(isset($object['other'])){
			foreach($object['other'] as $key => $ac){
				$params[$key]=$ac;
			}
		}
    	$link = Yii::app()->createAbsoluteUrl("site/url", $params);
    	return $link;
    }
    
    public static function makeUrlChart($object)
	{
		$dataBxhId = array(
			'SONG_VN'=>1,
			'SONG_KOR'=>2,
			'SONG_EUR'=>3,
			'VIDEO_VN'=>4,
			'VIDEO_KOR'=>5,
			'VIDEO_EUR'=>6,
			'ALBUM_VN'=>7,
			'ALBUM_KOR'=>8,
			'ALBUM_EUR'=>9
		);
		Yii::import("application.vendors.Hashids.*");
		$hashids = new Hashids(Yii::app()->params["hash_url"]);
		$prefix = 'bang-xep-hang-';
		if($object['type']=='SONG'){
			$s = 'bai-hat';
		}elseif($object['type']=='VIDEO'){
			$s = 'video';
		}else{
			$s = 'album';
		}
		switch($object['genre'])
		{
			case 'VN':
				$urlKey = 'bang-xep-hang-'.$s.'-viet-nam';
				break;
			case 'EUR':
				$urlKey = 'bang-xep-hang-'.$s.'-au-my';
				break;
			case 'KOR':
				$urlKey = 'bang-xep-hang-'.$s.'-han-quoc';
				break;
		}
		$suffix = 'bx';
		$code = $hashids->encode($dataBxhId[$object['type'].'_'.$object['genre']]);
		$code = $suffix.$code;
		$link = Yii::app()->createAbsoluteUrl("site/url", array("url_key" => $urlKey,"code"=>$code));
		return $link;
	}
        
    public static function makeUrlGenre($object)
	{
		Yii::import("application.vendors.Hashids.*");
		$hashids = new Hashids(Yii::app()->params["hash_url"]);
		$type = $object['type'];
		$name = $object['name'];
		$id = $object['id'];
		$gt = isset($object['gt'])?$object['gt']:'';
		$suffix = 'gr';
		$code = $hashids->encode($id);
		$code = $suffix.$code;
		$prefix = 'nhac-';
		$urlKey = $prefix.Common::makeFriendlyUrl($name);
		if($type=='song'){
			$type='bai-hat';
		}
		$params = array("action"=>$type,"url_key" => $urlKey,"code"=>$code);
		if(!empty($gt)){
			if($gt=='new') $gt='moi';
			$params['gt']=$gt;
		}
		if(isset($object['other'])){
			foreach($object['other'] as $key => $ac){
				$params[$key]=$ac;
			}
		}
		$link = Yii::app()->createAbsoluteUrl("site/url2", $params);
		return $link;
	}

}
