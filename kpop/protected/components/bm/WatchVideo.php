<?php

class WatchVideo extends BaseWatchVideo {

    /**
     *
     *  get video price for charging
     */
    protected function defineBiz() {
        //not send sms
        $this->params['send_sms'] = 'not_send';

        //set params for log user_activity and transaction
        $this->params['obj1_id'] = $this->videoObj->id;
        $this->params['obj1_name'] = $this->videoObj->name;
        $this->params['obj2_name'] = $this->params['msisdn'];
        $this->params['genre_id'] = $this->videoObj->genre_id;
        //get video price
        //$price = $this->videoObj->listen_price;
        $price = Yii::app()->params['promotion.video.play.unsub'];
        $this->params['package_name'] = 'DEFAULT';
        $this->params['reason'] = 'CONTENT';
        // get video price by package if user registered
        $dateNow = date('Y-m-d H:i:s', strtotime("-1 day"));
        //if($this->userSubscribe && $this->userSubscribe->expired_time>=$dateNow) {
        if ($this->userSubscribe) {
            $this->params['packageId'] = $this->userSubscribe->package_id;
            $this->params['user_id'] = $this->userSubscribe->user_id;
            $packageInfo = BmPackageModel::model()->getById($this->userSubscribe->package_id);
            $this->params['package_name'] = $packageInfo->code;
//            $price = $packageInfo->price_video_streaming;

            // Nếu nghe/tải có phí, reason truyền sang là CONTENT
            // Nếu nghe/tải miễn phí theo gói, reason truyền sang là mã gói.
            if ($price == 0)
                $this->params['reason'] = $packageInfo->code;

            
            $this->params['note'] = $this->userSubscribe->event;
        }

        if (isset($this->params['noteOptions']['note'])) {
            $this->params['note'] .= "|" . $this->params['noteOptions']['note'];
        }


        //da xem video trong vong 24h khong tinh cuoc
        //get last play

        $this->params['price'] = 0;

        $this->params['requestId'] = time();
        $contentType = 'VIDEO';
        $subContentType = BmGenreModel::getSubcontentType($this->videoObj->genre_id);
        $contentName = addslashes(bmCommon::removeSpecialCharacters($this->videoObj->name));
        $this->params['charge_note'] = '';
        $playType = 'Streaming';
        $this->params['cp_id'] = $this->videoObj->cp_id;
        $this->params['cp_name'] = CpModel::model()->findByPk($this->params['cp_id'])->name;
        $this->params['items'] = "<item contenttype=\"VIDEO\" subcontenttype=\"{$subContentType}\" contentid=\"{$this->videoObj->code}\" contentname=\"{$contentName}\" cpname=\"{$this->params['cp_name']}\" note=\"video\" playtype=\"{$playType}\" contentprice=\"{$price}\"/>";
        $this->params['genre_type'] = $subContentType;
        $this->params['content_type'] = 'VIDEO';

        $this->params['curlType'] = 6;
        $this->params['originPrice'] = $this->videoObj->listen_price;
        return 'success';
    }

}
