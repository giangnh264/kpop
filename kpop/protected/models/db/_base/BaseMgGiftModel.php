<?php

/**
 * This is the model class for table "mg_gift".
 *
 * The followings are the available columns in table 'mg_gift':
 * @property string $id
 * @property string $from_phone
 * @property string $to_phone
 * @property integer $type
 * @property integer $status
 * @property integer $song_id
 * @property string $song_code
 * @property string $song_nicename
 * @property string $song_path
 * @property integer $status_sms_receive
 * @property integer $status_sms_send
 * @property integer $count_call
 * @property string $last_call
 * @property integer $status_receiver
 * @property integer $status_sender
 * @property integer $type_send
 * @property string $delivery_time
 * @property string $created_time
 * @property string $updated_time
 */
class BaseMgGiftModel extends MainActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return MgGift the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'mg_gift';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('from_phone, to_phone, song_id', 'required'),
            array('type, status, song_id, status_sms_receive, status_sms_send, count_call, status_receiver, status_sender, type_send', 'numerical', 'integerOnly' => true),
            array('from_phone, to_phone', 'length', 'max' => 50),
            array('song_code', 'length', 'max' => 150),
            array('song_nicename, song_path', 'length', 'max' => 255),
            array('last_call, delivery_time, created_time, updated_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, from_phone, to_phone, type, status, song_id, song_code, song_nicename, song_path, status_sms_receive, status_sms_send, count_call, last_call, status_receiver, status_sender, type_send, delivery_time, created_time, updated_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return Common::loadMessages("db");
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
        $criteria->compare('from_phone', $this->from_phone, true);
        $criteria->compare('to_phone', $this->to_phone, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('status', $this->status);
        $criteria->compare('song_id', $this->song_id);
        $criteria->compare('song_code', $this->song_code, true);
        $criteria->compare('song_nicename', $this->song_nicename, true);
        $criteria->compare('song_path', $this->song_path, true);
        $criteria->compare('status_sms_receive', $this->status_sms_receive);
        $criteria->compare('status_sms_send', $this->status_sms_send);
        $criteria->compare('count_call', $this->count_call);
        $criteria->compare('last_call', $this->last_call, true);
        $criteria->compare('status_receiver', $this->status_receiver);
        $criteria->compare('status_sender', $this->status_sender);
        $criteria->compare('type_send', $this->type_send);
        $criteria->compare('delivery_time', $this->delivery_time, true);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_time', $this->updated_time, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']),
                    ),
                ));
    }

}