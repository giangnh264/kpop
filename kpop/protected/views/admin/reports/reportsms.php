<?php

$this->pageLabel = Yii::t('admin', "Export thuê bao được bắn sms quảng bá app chacha");
$curentUrl = Yii::app()->request->getRequestUri();
$this->menu = array(
    array('label' => Yii::t('admin', 'Export'), 'url' => $curentUrl . '&s=1&export=1'),
);
?>