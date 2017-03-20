<?php

class DownloadSong extends BaseDownloadSong {

    /**
     *
     *  get song price for charging
     */
    protected function defineBiz() {

        //set receivePhone send sms
        //neu la action download va nguon tu wap thi khong can send sms
        if (($this->params['msisdn'] == $this->params['to_phone']) && ($this->params['source'] == 'wap')) {
            $this->params['send_sms'] = 'not_send';
        }
        if ($this->songObj->base_id != 0) {
            $this->params['base_id'] = $this->songObj->base_id;
        } else {
            $this->params['base_id'] = $this->songObj->id;
        }
        $genreId = SongGenreModel::model()->getCatBySong($this->songObj->id);
        $genreId = $genreId[0]->genre_id;

        //set params for log user_activity and transaction
        $this->params['obj1_id'] = $this->songObj->id;
        $this->params['obj1_name'] = $this->songObj->name;
        $this->params['obj2_name'] = $this->params['to_phone'];
        $this->params['genre_id'] = $genreId;
        //get Song price
        //$price = $this->songObj->download_price;

        $this->params['packageId'] = 0;
        $this->params['package_name'] = 'DEFAULT';
        $this->params['reason'] = 'CONTENT';

        // get song price by package if user registered
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
        /* if($this->params['source'] == 'ivr') $this->params['price'] = 3000; */

        $this->params['requestId'] = time();
        $subContentType = BmGenreModel::getSubcontentType($genreId);
        $contentName = addslashes(bmCommon::removeSpecialCharacters($this->songObj->name));
        $this->params['charge_note'] = '';
        $playType = 'Download';
        $this->params['cp_id'] = $this->songObj->cp_id;
        $this->params['cp_name'] = CpModel::model()->findByPk($this->params['cp_id'])->name;
        $this->params['items'] = "<item contenttype=\"MUSIC\" subcontenttype=\"{$subContentType}\" contentid=\"{$this->songObj->code}\" contentname=\"{$contentName}\" cpname=\"{$this->params['cp_name']}\" note=\"song\" playtype=\"{$playType}\" contentprice=\"{$price}\"/>";
        $this->params['genre_type'] = $subContentType;
        $this->params['content_type'] = 'MUSIC';

        $this->params['curlType'] = 2;
        $this->params['originPrice'] = $this->songObj->download_price;

        return 'success';
    }

}
