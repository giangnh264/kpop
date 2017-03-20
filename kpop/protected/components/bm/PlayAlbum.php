<?php
class PlayAlbum extends BasePlayAlbum {
	/**
	 *
	 *  get song price for charging
	 */
	protected function defineBiz() {

		//not send sms
		$this->params['send_sms'] = 'not_send';

		//set params for log user_activity and transaction
		$this->params['obj1_id'] = $this->albumObj->id;
		$this->params['obj1_name'] = $this->albumObj->name;
        $this->params['obj2_name'] = $this->params['msisdn'];
		//get Song price
		$price = $this->albumObj->price;
		$this->params['packageId'] = 0;
        $this->params['package_name'] = 'CHACHA0';
        $this->params['reason'] = 'CONTENT';
		// get song price by package if user registered
		$dateNow = date('Y-m-d H:i:s',strtotime("-1 day"));
		if($this->userSubscribe) {
			$this->params['packageId'] = $this->userSubscribe->package_id;
            $this->params['user_id'] = $this->userSubscribe->user_id;
			$packageInfo = BmPackageModel::model()->getById($this->userSubscribe->package_id);
            $this->params['package_name'] = $packageInfo->code;
			$price = 0;

			// REASON: Lưu ý, nếu truyền sai thì không charge được
			// neu la goi cuoc bundle, reason truyen sang chinh la la note luc Vinaphone goi sang (tam thoi khong su dung case nay)
			// if(($this->userSubscribe->bundle == 1) && ($this->userSubscribe->event != "")) $this->params['reason'] = $this->userSubscribe->event;

			// Nếu nghe/tải có phí, reason truyền sang là CONTENT
			// Nếu nghe/tải miễn phí theo gói, reason truyền sang là mã gói.
			if($price == 0) $this->params['reason'] = $packageInfo->code;

            if ($this->userSubscribe->event == 'KM_MI_CHACHAFUN_052012')
            {
                $this->params['reason'] = 'CHACHAFUN_KM';
            }
			$this->params['note'] = $this->userSubscribe->event;
		}
		// Neu trong vong 24 tieng da listen bai nay thi ko tru tien
		//get last play
		$this->params['checkLastActivity'] = 0;
		$lastPlayAlbum = BmUserTransactionModel::model()->checkCharging24h($this->params);
		if($lastPlayAlbum) {
			$price = 0;
			$this->params['checkLastActivity'] = 1;
		}
        $this->params['charge_note'] = '';
        $playType = 'Streaming';
        $this->params['album_songs'] = BmSongModel::model()->getSongsOfAlbum($this->albumObj->id);
        if(count($this->params['album_songs']) == 0){
        	// Nếu album ko có bài hát nào thì ko charg
        	$this->params['checkLastActivity'] = 1;
        }

        $songPrice = (int)($price/count($this->params['album_songs']));
		$this->params['price'] = $price;
        $this->params['requestId'] = time();
        $contentType = 'PLAYLIST';
        $this->params['items'] = '';
        foreach ($this->params['album_songs'] as $songObj)
        {
            //$songObj = BmSongModel::model()->published()->findByPk($song->song_id);
			$songGenre = SongGenreModel::model()->getCatBySong($songObj->id,false, true);
            $subContentType = BmGenreModel::getSubcontentType($songGenre[0]);
            $contentName = addslashes(bmCommon::removeSpecialCharacters($songObj->name));
            $cpName = CpModel::model()->findByPk($songObj->cp_id)->name;
            $this->params['items'] .= "<item contenttype=\"MUSIC\" subcontenttype=\"{$subContentType}\" contentid=\"{$songObj->code}\" contentname=\"{$contentName}\" cpname=\"{$cpName}\" note=\"song\" playtype=\"{$playType}\" contentprice=\"{$songPrice}\"/>";

            $this->params['items_list'][] = array(
            		'content_type'=>'MUSIC',
            		'content_id'=>$songObj->id,
            		'content_code'=>$songObj->code,
            		'content_name'=>$contentName,
            		'cp_id'=>$songObj->cp_id,
            		'cp_name'=>$cpName,
            		'genre_type'=>$subContentType,
            		'genre_id'=>$songGenre[0]
            );

        }

        // $genreId = SongGenreModel::model()->getCatBySong($this->songObj->id);
        // $genreId =  $genreId[0]->genre_id;

        // $subContentType = BmGenreModel::getSubcontentType($genreId);
        // $contentName = addslashes(bmCommon::removeSpecialCharacters($this->songObj->name));
        $this->params['curlType'] = 7;
        $this->params['originPrice'] = $this->albumObj->price;
		return 'success' ;
	}
}