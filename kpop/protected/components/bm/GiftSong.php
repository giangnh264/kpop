<?php
class GiftSong extends  BaseGiftSong {

	protected function defineBiz() {

		//set params for log user_activity and transaction
		$this->params['obj1_id'] = $this->songObj->id;
		$this->params['obj1_name'] = $this->songObj->name;
		$this->params['obj2_name'] = $this->params['to_phone'];

		$genreId = SongGenreModel::model()->getCatBySong($this->songObj->id);
        $genreId =  $genreId[0]->genre_id;
        $this->params['genre_id'] = $genreId;

		//get Song price
		$org_price = $price = Yii::app()->params['songGiftPrice']; // Config price for giftsong
		$this->params['packageId'] = 0;
        $this->params['package_name'] = 'CHACHA0';
        $this->params['reason'] = 'CONTENT';
        $this->params['charge_note'] = '';

		// get song price by package if user registered
		if($this->params['source'] == 'ivr'){
			$dateNow = date('Y-m-d H:i:s',strtotime("-1 day"));
			if($this->userSubscribe && $this->userSubscribe->expired_time>=$dateNow)
			{
				$this->params['packageId'] = $this->userSubscribe->package_id;
				$this->params['user_id'] = $this->userSubscribe->user_id;
				$packageInfo = BmPackageModel::model()->getById($this->userSubscribe->package_id);
				$this->params['package_name'] = $packageInfo->code;
				$price = 0; //Free giftsong for CHACHAFUN

				// REASON: Lưu ý, nếu truyền sai thì không charge được
				// neu la goi cuoc bundle, reason truyen sang chinh la la note luc Vinaphone goi sang (tam thoi khong su dung case nay)
				// if(($this->userSubscribe->bundle == 1) && ($this->userSubscribe->event != "")) $this->params['reason'] = $this->userSubscribe->event;

				// Nếu nghe/tải có phí, reason truyền sang là CONTENT
				// Nếu nghe/tải miễn phí theo gói, reason truyền sang là mã gói.
				if($price == 0) $this->params['reason'] = $packageInfo->code;

				$this->params['note'] = $this->userSubscribe->event;
				$this->params['charge_note'] = $packageInfo->code;
			}
		}

		$this->params['price'] = $price;
        $this->params['requestId'] = time();
        $this->params['originPrice'] = $org_price;
        $this->params['curlType'] = 2;
        $playType = 'GiftSong';
        $subContentType = BmGenreModel::getSubcontentType($genreId);
        $contentName = addslashes(bmCommon::removeSpecialCharacters($this->songObj->name));
        $this->params['cp_id'] = $this->songObj->cp_id;
        $this->params['cp_name'] = CpModel::model()->findByPk($this->songObj->cp_id)->name;
        $this->params['items'] = "<item contenttype=\"MUSIC\" subcontenttype=\"{$subContentType}\" contentid=\"{$this->songObj->code}\" contentname=\"{$contentName}\" cpname=\"{$this->params['cp_name']}\" note=\"song\" playtype=\"{$playType}\" contentprice=\"{$price}\"/>";
        $this->params['genre_type'] = $subContentType;
        $this->params['content_type'] = 'MUSIC';
		return 'success' ;
	}
}
