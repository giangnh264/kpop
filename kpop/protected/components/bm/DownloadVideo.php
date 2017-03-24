<?php

class DownloadVideo extends BaseDownloadVideo {

    /**
     *
     *  get video price for charging
     */
    protected function defineBiz() {

        //set receivePhone  send sms
        //neu la action download va nguon tu wap thi khong can send sms
        if (($this->params['msisdn'] == $this->params['to_phone']) && ($this->params['source'] == 'wap')) {
            $this->params['send_sms'] = 'not_send';
        }
        //set params for log user_activity and transaction
        $this->params['obj1_id'] = $this->videoObj->id;
        $this->params['obj1_name'] = $this->videoObj->name;
        $this->params['obj2_name'] = $this->params['to_phone'];
        $this->params['genre_id'] = $this->videoObj->genre_id;
        //get Video price
        //$price = $this->videoObj->download_price;
        $this->params['package_name'] = 'DEFAULT';
        $this->params['reason'] = 'CONTENT';

        // get video price by package if user registered
        $dateNow = date('Y-m-d H:i:s', strtotime("-1 day"));
        if ($this->userSubscribe) {
            $this->params['packageId'] = $this->userSubscribe->package_id;
            $this->params['user_id'] = $this->userSubscribe->user_id;
            $packageInfo = BmPackageModel::model()->getById($this->userSubscribe->package_id);
            $this->params['package_name'] = $packageInfo->code;
            $this->params['reason'] = $packageInfo->code;
        }

        if (isset($this->params['noteOptions']['note'])) {
            $this->params['note'] .= "|" . $this->params['noteOptions']['note'];
        }



        $this->params['price'] = 0;
        $this->params['requestId'] = time();
        $this->params['package'] = isset($packageInfo) ? $packageInfo->code : '';
        $subContentType = BmGenreModel::getSubcontentType($this->videoObj->genre_id);
        $contentName = addslashes(bmCommon::removeSpecialCharacters($this->videoObj->name));
        $this->params['charge_note'] = '';
        $playType = 'Download';
        $this->params['cp_id'] = $this->videoObj->cp_id;
        $this->params['cp_name'] = CpModel::model()->findByPk($this->params['cp_id'])->name;
        $this->params['items'] = "<item contenttype=\"VIDEO\" subcontenttype=\"{$subContentType}\" contentid=\"{$this->videoObj->code}\" contentname=\"{$contentName}\" cpname=\"{$this->params['cp_name']}\" note=\"video\" playtype=\"{$playType}\" contentprice=\"{$price}\"/>";
        $this->params['genre_type'] = $subContentType;
        $this->params['content_type'] = 'VIDEO';

        $this->params['curlType'] = 5;
        $this->params['originPrice'] = $this->videoObj->download_price;
        return 'success';
    }

}
