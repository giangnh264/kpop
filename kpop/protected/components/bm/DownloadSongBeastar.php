<?php
class DownloadSongBeastar extends BaseDownloadSongBeastar {
	/**
	 *
	 *  get song price for charging
	 */
	protected function defineBiz() {

		//set receivePhone send sms
		//neu la action download va nguon tu wap thi khong can send sms
        $this->params['send_sms'] = 'not_send';
        $this->params['base_id'] = $this->songObj->id;

		//set params for log user_activity and transaction
		$this->params['obj1_id'] = $this->songObj->id;
		$this->params['obj1_name'] = $this->songObj->name;
		$this->params['obj2_name'] = $this->params['to_phone'];
        $this->params['genre_id'] = $this->songObj->genre_id;
		//get Song price
		$price = 1000;
		$this->params['packageId'] = 0;
        $this->params['reason'] = 'CONTENT';
		// get song price by package if user registered
//		if($this->userSubscribe)
//        {
//			$this->params['packageId'] = $this->userSubscribe->package_id;
//            $this->params['user_id'] = $this->userSubscribe->user_id;
//            $packageInfo = BmPackageModel::model()->getById($this->userSubscribe->package_id);
//            $this->params['package_name'] = $packageInfo->code;
//			if ($this->params['msisdn'] == $this->params['to_phone'])
//            {
//                $price = $packageInfo->price_song_download;
//                $this->params['reason'] = $packageInfo->code;
//                if ($this->userSubscribe->event == 'KM_MI_CHACHAFUN_052012')
//                {
//                    $this->params['note'] = 'KM_MI_CHACHAFUN_052012';
//                    $this->params['reason'] = 'CHACHAFUN_KM';
//                }
//            }
//		}

		//download trong 24h price = 0
		$this->params['checkLastActivity'] = 0;
//		$lastDownloadSong = BmUserTransactionModel::model()->checkCharging24h($this->params);
//		if($lastDownloadSong) {
//			$price = Yii::app()->params['promotion.song.price'];
//			$this->params['checkLastActivity'] = 1;
//		}

		$this->params['price'] = $price;
        $this->params['requestId'] = time();
        $subContentType = BmGenreModel::getSubcontentType($this->songObj->genre_id);
        $contentName = addslashes(bmCommon::removeSpecialCharacters($this->songObj->name));
        $this->params['note'] = 'download_chachastar';
        $this->params['charge_note'] = '';
        $playType = 'Download';
        $this->params['cp_id'] = $this->songObj->cp_id;
        $this->params['cp_name'] = CpModel::model()->findByPk($this->params['cp_id'])->name;
        $this->params['items'] = "<item contenttype=\"MUSIC\" subcontenttype=\"{$subContentType}\" contentid=\"{$this->songObj->code}\" contentname=\"{$contentName}\" cpname=\"{$this->params['cp_name']}\" note=\"song\" playtype=\"{$playType}\" contentprice=\"{$price}\"/>";
        $this->params['curlType'] = 2;
        $this->params['originPrice'] = 1000;

		return 'success' ;
	}
}