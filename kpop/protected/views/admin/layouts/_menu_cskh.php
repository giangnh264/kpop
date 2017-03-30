<?php
return  array(
        array(
        "url"=>array("route"=>"/customer"),
        "label"=>Yii::t('admin','Khách Hàng'),
        "visible"=>1,
        				array(
        						"url" => array("route" => "/customer"),
        						"label" => Yii::t('admin', 'Trạng thái thuê bao'),
        						"visible" => 1
        				),
        				array(
        						"url" => array("route" => "/customer/Subscriber"),
        						"label" => Yii::t('admin', 'ĐK/Hủy gói cước'),
        						"visible" => 1,
        		
        				),
        				array(
        						"url" => array("route" => "/user/default/create?content_type=subscribe"),
        						"label" => Yii::t('admin', 'Đăng ký theo danh sách'),
        						"visible" => 1
        		
        				),
        				array(
        						"url" => array("route" => "/user/default/create?content_type=unsubscribe"),
        						"label" => Yii::t('admin', 'Hủy theo danh sách'),
        						"visible" => 1,
        		
        				),
        		
        		
        				/*  array(
        				 "url" => array("route" => "/customer/Useraction"),
        						"label" => Yii::t('admin', 'Nhật ký người dùng '),
        						"visible" => 1
        				),*/
        				array(
        						"url" => array("route" => "/customer/extend"),
        						"label" => Yii::t('admin', 'ĐK/Hủy gia hạn'),
        						"visible" => 1
        				),
        				array(
        						"url" => array("route" => "/customer/sms"),
        						"label" => Yii::t('admin', 'Tin nhắn MO, MT'),
        						"visible" => 1
        				),
        				array(
        						"url" => array("route" => "/customer/history"),
        						"label" => Yii::t('admin', 'Lịch sử sử dụng'),
        						"visible" => 1
        				),
        				array(
        						"url" => array("route" => "/customer/logAction"),
        						"label" => Yii::t('admin', 'Log tác động khách hàng'),
        						"visible" => 1
        				),
        				array(
        						"url" => array("route" => "/customer/LogRevenue"),
        						"label" => Yii::t('admin', 'Lịch sử trừ cước'),
        						"visible" => 1
        				),
        ),
);
