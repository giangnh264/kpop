<?php
class DownloadRingtone extends BaseDownloadRingtone {
	/**
	 *
	 *  get song price for charging
	 */
	protected function defineBiz() {

		//set receivePhone send sms
		//neu la action download va nguon tu wap thi khong can send sms
		if(($this->params['msisdn'] == $this->params['to_phone']) && ($this->params['source'] == 'wap')) {
			$this->params['send_sms'] = 'not_send';
		}

		//set params for log user_activity and transaction
		$this->params['obj1_id'] = $this->rtObj->id;
		$this->params['obj1_name'] = $this->rtObj->name;
		$this->params['obj2_name'] = $this->params['to_phone'];

        $this->params['genre_id'] = $this->rtObj->category_id;
		//get Song price
		$price = $this->rtObj->price;
		$this->params['packageId'] = 0;
        $this->params['package_name'] = 'CHACHA0';
        $this->params['reason'] = 'CONTENT';
		// get song price by package if user registered
        $dateNow = date('Y-m-d H:i:s');
		if($this->userSubscribe && $this->userSubscribe->expired_time>=$dateNow)
        {
			$this->params['packageId'] = $this->userSubscribe->package_id;
            $this->params['user_id'] = $this->userSubscribe->user_id;
            $packageInfo = BmPackageModel::model()->getById($this->userSubscribe->package_id);
            $this->params['package_name'] = $packageInfo->code;
            $price = $packageInfo->price_ringtone_download;
            //$this->params['reason'] = $packageInfo->code;
            if ($this->params['msisdn'] == $this->params['to_phone'])
            {
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

		}
        if ($this->params['msisdn'] != $this->params['to_phone'])
        {
            $price = $this->rtObj->price;
        }

		//download trong 24h price = 0
		$this->params['checkLastActivity'] = 0;
		$lastDownloadRingtone = BmUserTransactionModel::model()->checkCharging24h($this->params);
		if($lastDownloadRingtone) {
			$price = 0;
			$this->params['checkLastActivity'] = 1;
		}

		$this->params['price'] = $price;
        $this->params['requestId'] = time();
        $subContentType = BmRingtoneCategoryModel::getRingtoneSubcontentType($this->rtObj->category_id);
        $contentName = addslashes(bmCommon::removeSpecialCharacters($this->rtObj->name));
        $this->params['charge_note'] = '';
        $playType = 'Download';
        $this->params['cp_id'] = $this->rtObj->cp_id;
        $this->params['cp_name'] = CpModel::model()->findByPk($this->params['cp_id'])->name;
        $this->params['items'] = "<item contenttype=\"MUSIC\" subcontenttype=\"{$subContentType}\" contentid=\"{$this->rtObj->code}\" contentname=\"{$contentName}\" cpname=\"{$this->params['cp_name']}\" note=\"ringtone\" playtype=\"{$playType}\" contentprice=\"{$price}\"/>";
        $this->params['genre_type'] = $subContentType;
        $this->params['content_type'] = 'MUSIC';

        $this->params['curlType'] = 3;
        $this->params['originPrice'] = $this->rtObj->price;
		return 'success' ;
	}
}