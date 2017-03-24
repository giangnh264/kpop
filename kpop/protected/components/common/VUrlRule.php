<?php
Yii::import('system.web.CBaseUrlRule');
Yii::import('application.vendors.Hashids.*');
define("url_hash_key", "VegaMusicScrypt##");

class VUrlRule extends CBaseUrlRule
{
	public function createUrl($manager,$route,$params,$ampersand)
	{
		$urlKey = isset($params['title'])?$params['title']:(isset($params['url_key'])?$params['url_key']:'');
		$artist = isset($params['artist'])?$params['artist']:'';
		if($artist != ''){
			$urlKey = $urlKey . '-' . $artist;
		}
		$otherParams = $params;
		if(isset($otherParams['title'])) unset($otherParams['title']);
		if(isset($otherParams['url_key'])) unset($otherParams['url_key']);
		if(isset($otherParams['artist'])) unset($otherParams['artist']);
		if(isset($otherParams['id'])) unset($otherParams['id']);
		if(!empty($otherParams)){
			$qrOtherParams = http_build_query($otherParams);
			$strParam = "?".$qrOtherParams;
		}else{
			$strParam = "";
		}
		$pId = isset($params['id'])?$params['id']:0;
		$id = $this->edScrypt($pId);
		if ($route==='song/view'){
			return 'bai-hat/'.$urlKey.','.$id.'.html'.$strParam;
		/*}if ($route==='song/list') {
			return 'bai-hat.html' . $strParam;*/
		}elseif($route==='video/view'){
			return 'video/'.$urlKey.','.$id.'.html'.$strParam;
		}elseif($route==='album/view'){
			return 'album/'.$urlKey.','.$id.'.html'.$strParam;
		}elseif($route==='videoplaylist/view'){
			return 'video-playlist/'.$urlKey.','.$id.'.html'.$strParam;
		}elseif($route==='collection/view'){
			return 'phat-tat-ca/'.$urlKey.','.$id.'.html'.$strParam;
		}elseif($route==='collection/view'){
			return 'phat-tat-ca/'.$urlKey.','.$id.'.html'.$strParam;
		}elseif($route==='album/index'){
			return 'album/'.$urlKey.',-tl'.$id.'.html'.$strParam;
		}elseif($route==='song/index'){
			return 'bai-hat/'.$urlKey.',-tl'.$id.'.html'.$strParam;
		}elseif($route==='video/index'){
			return 'video/'.$urlKey.',-tl'.$id.'.html'.$strParam;
		}elseif($route==='horoscopes/view'){
			return 'radio/'.$urlKey.','.$id.'.html'.$strParam;
		}elseif($route==='topContent/view'){
			return 'chu-de-am-nhac/'.$urlKey.','.$id.'.html'.$strParam;
		}elseif($route==='promotion/about'){
			return 'ctkm';
		}elseif($route==='promotion/check'){
			return 'ctkm/tracuu';
		}elseif($route==='promotion/hotlist'){
			return 'ctkm/noidunghot';
		}elseif($route==='promotion/list'){
			return 'ctkm/trung-giai';
		}
		return false;  // this rule does not apply
	}

	public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
	{
		$isSong = strpos($pathInfo, 'bai-hat/');
		$isVideo = strpos($pathInfo, 'video/');
		$isAlbum = strpos($pathInfo, 'album/');
		$isVideoPlaylist = strpos($pathInfo, 'video-playlist/');
		$isCollection = strpos($pathInfo, 'phat-tat-ca/');
		$isTopContent = strpos($pathInfo, 'chu-de-am-nhac/');
		$isRadio = strpos($pathInfo, 'radio/');
		$isCtkm = strpos($pathInfo, 'ctkm/');

		if ($isSong===0 && strpos($pathInfo,',')!==false){
			$is_song_genre = strpos($pathInfo, '-tl');
			if($is_song_genre){
				$matches = explode(',',$pathInfo);
				$endCryptRaw = $matches[1];
				$endCryptRaw = substr($endCryptRaw,3);
				$endCryptRaw  = str_replace('.html','',$endCryptRaw);
				$endCryptRaw = $this->deScrypt($endCryptRaw);
				$_REQUEST['id'] = $endCryptRaw;
				return 'song/index/id/'.$endCryptRaw;
			}else{
				$matches = explode(',',$pathInfo);
				$endCryptRaw = $matches[1];
				$endCryptRaw  = str_replace('.html','',$endCryptRaw);
				$endCryptRaw = $this->deScrypt($endCryptRaw);
				$_REQUEST['id'] = $endCryptRaw;
				return 'song/view/id/'.$endCryptRaw;
			}
		}elseif($isVideo===0 && strpos($pathInfo,',')!==false){
			$is_video_genre = strpos($pathInfo, '-tl');
			if($is_video_genre){
				$matches = explode(',',$pathInfo);
				$endCryptRaw = $matches[1];
				$endCryptRaw = substr($endCryptRaw,3);
				$endCryptRaw  = str_replace('.html','',$endCryptRaw);
				$endCryptRaw = $this->deScrypt($endCryptRaw);
				$_REQUEST['id'] = $endCryptRaw;
				return 'video/index/id/'.$endCryptRaw;
			}else{
				$matches = explode(',',$pathInfo);
				$endCryptRaw = $matches[1];
				$endCryptRaw  = str_replace('.html','',$endCryptRaw);
				$endCryptRaw = $this->deScrypt($endCryptRaw);
				$_REQUEST['id'] = $endCryptRaw;
				return 'video/view/id/'.$endCryptRaw;
			}
		}elseif($isAlbum===0 && strpos($pathInfo,',')!==false){
			$is_album_genre = strpos($pathInfo, '-tl');
			if($is_album_genre){
				$matches = explode(',',$pathInfo);
				$endCryptRaw = $matches[1];
				$endCryptRaw = substr($endCryptRaw,3);
				$endCryptRaw  = str_replace('.html','',$endCryptRaw);
				$endCryptRaw = $this->deScrypt($endCryptRaw);
				$_REQUEST['id'] = $endCryptRaw;
				return 'album/index/id/'.$endCryptRaw;
			}else{
				$matches = explode(',',$pathInfo);
				$endCryptRaw = $matches[1];
				$endCryptRaw  = str_replace('.html','',$endCryptRaw);
				$endCryptRaw = $this->deScrypt($endCryptRaw);
				$_REQUEST['id'] = $endCryptRaw;
				return 'album/view/id/'.$endCryptRaw;
			}
		}elseif($isVideoPlaylist===0 && strpos($pathInfo,',')!==false){
            $matches = explode(',',$pathInfo);
            $endCryptRaw = $matches[1];
            $endCryptRaw  = str_replace('.html','',$endCryptRaw);
			$endCryptRaw = $this->deScrypt($endCryptRaw);
			$_REQUEST['id'] = $endCryptRaw;
			return 'videoplaylist/view/id/'.$endCryptRaw;
		}elseif($isCollection===0 && strpos($pathInfo,',')!==false){
			$matches = explode(',',$pathInfo);
			$endCryptRaw = $matches[1];
			$endCryptRaw  = str_replace('.html','',$endCryptRaw);
			$endCryptRaw = $this->deScrypt($endCryptRaw);
			$_REQUEST['id'] = $endCryptRaw;
			return 'collection/view/id/'.$endCryptRaw;
		}elseif($isRadio===0 && strpos($pathInfo,',')!==false){
			$matches = explode(',',$pathInfo);
			$endCryptRaw = $matches[1];
			$endCryptRaw  = str_replace('.html','',$endCryptRaw);
			$endCryptRaw = $this->deScrypt($endCryptRaw);
			$_REQUEST['id'] = $endCryptRaw;
			return 'horoscopes/view/id/'.$endCryptRaw;
		}elseif($isTopContent===0 && strpos($pathInfo,',')!==false){
			$matches = explode(',',$pathInfo);
			$endCryptRaw = $matches[1];
			$endCryptRaw  = str_replace('.html','',$endCryptRaw);
			$endCryptRaw = $this->deScrypt($endCryptRaw);
			$_REQUEST['id'] = $endCryptRaw;
			return 'topContent/view/id/'.$endCryptRaw;
		}elseif ($isCtkm===0){
			$is_tracuu = strpos($pathInfo, 'tracuu');
			$is_hot = strpos($pathInfo, 'noidunghot');
			$is_danhsach = strpos($pathInfo, 'trung-giai');
			if($is_tracuu){
				return 'promotion/check';
			}elseif($is_hot){
				return 'promotion/hotlist';
			}elseif($is_danhsach){
				return 'promotion/list';
			}else{
				return 'promotion/about';
			}
	}

		return false;  // this rule does not apply
	}
	public function edScrypt($in)
	{
		$hashids = new Hashids(url_hash_key);
		$out = $hashids->encode($in);
		return $out;
	}
    public function deScrypt($hashStr)
    {
    	$hashids = new Hashids(url_hash_key);
    	$id = $hashids->decode($hashStr);
    	$id = $id[0];
    	return $id;
    }
}