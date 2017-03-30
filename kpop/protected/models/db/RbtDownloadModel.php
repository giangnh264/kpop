<?php
class RbtDownloadModel extends BaseRbtDownloadModel {

    /**
     * Returns the static model of the specified AR class.
     * @return RbtDownload the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
	
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('rbt_id', $this->rbt_id, true);
        $criteria->compare('rbt_code', $this->rbt_code, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('from_phone', $this->from_phone, true);
        $criteria->compare('to_phone', $this->to_phone, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('channel', $this->channel, true);


        if (!empty($this->download_datetime) && is_array($this->download_datetime)) {
            $criteria->addBetweenCondition('download_datetime', $this->download_datetime['from'], $this->download_datetime['to']);
        } else {
            $criteria->compare('download_datetime', $this->download_datetime, true);
        }

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => array('defaultOrder' => 'download_datetime DESC'),
                    'pagination' => array(
                        'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']),
                    ),
                ));
    }

    /**
     * get so luot tai o cac Channel 
     */
    public function getCountChannel($date, $channel) {
//        var_dump($date);
//        var_dump($channel);
        if (!empty($channel))
            $addWhere = " channel = '" . $channel . "' AND ";
        else
            $addWhere = "";
        if (is_array($date)){
            $result = Yii::app()->db->createCommand("select channel,sum(amount) as total from rbt_download where $addWhere download_datetime BETWEEN '" . $date['from'] . "' AND '" . $date['to'] . "' group by channel ")
                    ->queryAll();
//            echo "select channel,count(*) as total from rbt_download where $addWhere download_datetime BETWEEN '" . $date['from'] . "' AND '" . $date['to'] . "' group by channel ";
        }
        else {
            $result = Yii::app()->db->createCommand("select channel,sum(amount) as total from rbt_download where $addWhere download_datetime = '" . $date . "' group by channel ")
                    ->queryAll();
//            echo "select channel,count(*) as total from rbt_download where $addWhere download_datetime = '" . $date . "' group by channel ";
        }
//        var_dump($result);
        return $result;
    }

    /**
     * lay tong so tien thu dc
     */
    public function getTotalMoney($date, $channel) {         
        if (!empty($channel))
            $addWhere = " channel = '" . $channel . "' AND ";
        else
            $addWhere = "";

        if (is_array($date)){
            $result = Yii::app()->db->createCommand("select sum(price) as total_money from rbt_download where $addWhere download_datetime BETWEEN '" . $date['from'] . "' AND '" . $date['to'] . "' ")
                    ->queryAll();
//            echo "select sum(price*amount) as total_money from rbt_download where $addWhere download_datetime BETWEEN '" . $date['from'] . "' AND '" . $date['to'] . "' ";
        }
        else {
            $result = Yii::app()->db->createCommand("select sum(price) as total_money from rbt_download where $addWhere download_datetime = '" . $date . "' ")
                    ->queryAll();
//            echo "select sum(price*amount) as total_money from rbt_download where $addWhere download_datetime = '" . $date . "' ";
        }
//        var_dump($result);
        return $result[0]['total_money'];
    }

}