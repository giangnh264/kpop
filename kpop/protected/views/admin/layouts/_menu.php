<?php
$submenu = include '_submenu.php';

return  array(
        array(
                "url"=>array("route"=>"/song/index"),
                "label"=>Yii::t('admin','Nội dung'),
                "visible"=>UserAccess::checkAccess("MusicMenuView", Yii::app()->user->Id),

                CMap::mergeArray(
                array(
                "url"=>array("route"=>"/song/index"),
                "label"=>Yii::t('admin','Bài hát'),
                "visible"=>UserAccess::checkAccess("SongIndex", Yii::app()->user->Id),

                ),$submenu['song']),

                CMap::mergeArray(
                array(
                "url"=>array("route"=>"/video"),
                "label"=>Yii::t('admin','Video'),
                "visible"=>UserAccess::checkAccess("VideoIndex", Yii::app()->user->Id)
                ),$submenu['video']),
                
                CMap::mergeArray(
                    array(
                    "url"=>array("route"=>"/videoPlaylist"),
                    "label"=>Yii::t('admin','Video Playlist'),
                    "visible"=>UserAccess::checkAccess("VideoPlaylistIndex", Yii::app()->user->Id)
                    ),$submenu['videoPlaylist']),
            
                CMap::mergeArray(
                array(
                "url"=>array("route"=>"/album"),
                "label"=>Yii::t('admin','Album'),
                "visible"=>UserAccess::checkAccess("AlbumIndex", Yii::app()->user->Id)
                ),$submenu['album']),

                CMap::mergeArray(
                array(
                "url"=>array("route"=>"/playlist"),
                "label"=>Yii::t('admin','Playlist'),
                "visible"=>UserAccess::checkAccess("PlaylistIndex", Yii::app()->user->Id)
                ),$submenu['playlist']),

                CMap::mergeArray(
                array(
                "url"=>array("route"=>"/artist"),
                "label"=>Yii::t('admin','Nghệ sỹ'),
                "visible"=>UserAccess::checkAccess("ArtistIndex", Yii::app()->user->Id)
                ),$submenu['artist']),
        		CMap::mergeArray(
        		array(
        		"url"=>array("route"=>"/genre"),
        		"label"=>Yii::t('admin','Thể loại'),
        		"visible"=>UserAccess::checkAccess("GenreIndex", Yii::app()->user->Id)
        		),$submenu['genre']),

                CMap::mergeArray(
                array(
                "url"=>array("route"=>"/collection"),
                "label"=>Yii::t('admin','Bộ sưu tập'),
                "visible"=>UserAccess::checkAccess("CollectionIndex", Yii::app()->user->Id)
                ),$submenu['collection']),
            
            
                array(
                "url"=>array("route"=>"/chart"),
                "label"=>Yii::t('admin','Bảng xếp hạng'),
                "visible"=>UserAccess::checkAccess("ChartIndex", Yii::app()->user->Id)
                ),

       		
                CMap::mergeArray(
                array(
                "url"=>array("route"=>"/radio/channel"),
                "label"=>Yii::t('admin','Radio'),
                "visible"=>UserAccess::checkAccess("Radio-ChannelIndex", Yii::app()->user->Id)
                ),$submenu['radio']),


        ),

        /* array(
                "url"=>array("route"=>"/ringtone",),
                "label"=>Yii::t('admin','Nhạc chuông-chờ'),
                "visible"=>UserAccess::checkAccess("Rt-RbtMenuView", Yii::app()->user->Id),
                CMap::mergeArray(
                array(
                "url"=>array("route"=>"/ringtone",),
                "label"=>Yii::t('admin','Nhạc chuông'),
                "visible"=>UserAccess::checkAccess("RingtoneIndex", Yii::app()->user->Id),
                ),$submenu['ringtone']),

                CMap::mergeArray(
                array(
                "url"=>array("route"=>"/ringbacktone",),
                "label"=>Yii::t('admin','Nhạc chờ'),
                "visible"=>UserAccess::checkAccess("RingbacktoneIndex", Yii::app()->user->Id),
                ),$submenu['ringbacktone']),
        ), */


		/* array(
				"url"=>array("route"=>"/mgChannel",),
				"label"=>Yii::t('admin','IVR'),
				"visible"=>UserAccess::checkAccess("IVRMenuView", Yii::app()->user->Id),

				CMap::mergeArray(
				array(
				"url"=>array("route"=>"/mgChannel"),
				"label"=>Yii::t('admin','Musicgift'),
				"visible"=>UserAccess::checkAccess("mgChannelIndex", Yii::app()->user->Id)
				),$submenu['musicgift']),

				CMap::mergeArray(
				array(
				"url"=>array("route"=>"/ObdPhoneGroup"),
				"label"=>Yii::t('admin','OBD'),
				"visible"=>UserAccess::checkAccess("ObdPhoneGroupIndex", Yii::app()->user->Id)
				),$submenu['OBD']),
		), */


        /* CMap::mergeArray(
        array(
            "url"=>array("route"=>"/userSubscribe/index"),
            "label"=>Yii::t('admin','Thuê bao'),
            "visible"=>UserAccess::checkAccess("userSubscribeIndex", Yii::app()->user->Id)
            ),$submenu['user']), */
		
		
        array(
                "url"=>array("route"=>"/reports/allindex"),
                "label"=>Yii::t('admin','Thống kê'),
                "visible"=>UserAccess::checkAccess("ReportsMenuView", Yii::app()->user->Id),
				"key"=>"reports",

        		 array(
        		"url"=>array("route"=>"/reports/allindex"),
        		"label"=>Yii::t('admin','Tổng thống kê'),
        		"visible"=>UserAccess::checkAccess("ReportsAllindex", Yii::app()->user->Id)
        		),
        		array(
        		"url"=>array("route"=>"/reports/NewDaily"),
        		"label"=>Yii::t('admin','Thống kê ngày'),
        		"visible"=>UserAccess::checkAccess("ReportsNewDaily", Yii::app()->user->Id)
        		),
                        CMap::mergeArray(
        		array(
                            "url"=>array("route"=>"/reports/dailyReportRevenue"),
                            "label"=>Yii::t('admin','Thống kê chung'),
                            "visible"=>UserAccess::checkAccess("ReportsDailyReportRevenue", Yii::app()->user->Id),
                            ),$submenu['reports']['daily' ]),


        		 CMap::mergeArray(
        		array(
        		"url"=>array("route"=>"/reports"),
        		"label"=>Yii::t('admin','Thống kê nội dung'),
        		"visible"=>UserAccess::checkAccess("ReportsIndex", Yii::app()->user->Id),
        		),$submenu['reports']['content']),
			array(
				"url"=>array("route"=>"/reports/LogSmsMt"),
				"label"=>Yii::t('admin','Thống kê MT định kỳ'),
				"visible"=>UserAccess::checkAccess("ReportsLogSmsMt", Yii::app()->user->Id)
			),
			CMap::mergeArray(
				array(
				"url"=>array("route"=>"reports/copyrightCP"),
				"label"=>Yii::t('admin','Thống kê bản quyền'),
				"visible"=>UserAccess::checkAccess("ReportsMenuCopyright", Yii::app()->user->Id),
				),$submenu['reports']['copyright']),

        		 /*CMap::mergeArray(
        		array(
        			"url"=>array("route"=>"/reports/daily"),
        			"label"=>Yii::t('admin','Thống kê doanh thu'),
        			"visible"=>UserAccess::checkAccess("ReportsRevMenuView", Yii::app()->user->Id),
        		),$submenu['reports']['rev']),*/

        		/* CMap::mergeArray(
        		array(
        		"url"=>array("route"=>"reports/subscribeReport"),
        		"label"=>Yii::t('admin','Thống kê thuê bao'),
        		"visible"=>UserAccess::checkAccess("ReportsSubscribeReport", Yii::app()->user->Id),
        		),$submenu['reports']['subs']),
        	

        		/* CMap::mergeArray(
        		array(
        		"url"=>array("route"=>"reports/detailByTrans"),
        		"label"=>Yii::t('admin','Thống kê giao dịch'),
        		"visible"=>UserAccess::checkAccess("ReportsDetailByTrans", Yii::app()->user->Id),
        		),$submenu['reports']['trans']), */

				/*CMap::mergeArray(
				array(
					"url"=>array("route"=>"reports/detailByTrans"),
					"label"=>Yii::t('admin','Thống kê giao dịch'),
					"visible"=>UserAccess::checkAccess("ReportsDetailByTrans", Yii::app()->user->Id),
				),$submenu['reports']['trans']),*/





        		/* CMap::mergeArray(
        		array(
        		"url"=>array("route"=>"reports/copyrightCP"),
        		"label"=>Yii::t('admin','Thống kê bản quyền'),
        		"visible"=>UserAccess::checkAccess("ReportsMenuCopyright", Yii::app()->user->Id),
        		),$submenu['reports']['copyright']), */
				
        		/* array(
        			"url"=>array("route"=>"reports/shortlink"),
        			"label"=>Yii::t('admin','Thống kê Short Link'),
        			"visible"=>UserAccess::checkAccess("ReportsShortlink", Yii::app()->user->Id),
        		), */
        ),
        CMap::mergeArray(
        array(
        "url"=>array("route"=>"/customer"),
        "label"=>Yii::t('admin','Khách Hàng'),
        "visible"=>UserAccess::checkAccess("CustomerMenuView", Yii::app()->user->Id),
        ),$submenu['customer']),
		
		CMap::mergeArray(
		array(
		"url"=>array("route"=>"#"),
		"label"=>Yii::t('admin','KPI & Giám sát'),
		"visible"=>UserAccess::checkAccess("KPIMenu", Yii::app()->user->Id)
		),$submenu['KPI']),

		
        CMap::mergeArray(
        array(
        "url"=>array("route"=>"/news"),
        "label"=>Yii::t('admin','CMS'),
        "visible"=>UserAccess::checkAccess("CMSMenuView", Yii::app()->user->Id),
        ),$submenu['cms']),

		 
        array(
        "url"=>array("route"=>"/adminUser/index"),
        "label"=>Yii::t('admin','Admin User'),
        "visible"=>UserAccess::checkAccess("AdminUserMenuView", Yii::app()->user->Id),
        ),
		
        CMap::mergeArray(
        array(
        "url"=>array("route"=>"#"),
        "label"=>Yii::t('admin','Hệ thống'),
        "visible"=>UserAccess::checkAccess("SystemMenuView", Yii::app()->user->Id),
        ),$submenu['system']),
		
		array(
			"url"=>array("route"=>"#"),
			"label"=>Yii::t('admin','Tools'),
			"visible"=>UserAccess::checkAccess("SupperToolsView", Yii::app()->user->Id),
				/*array(
						"url" => array("route" => "/tools/song"),
						"label" => Yii::t('admin', 'Ẩn bài hát'),
						"visible" => UserAccess::checkAccess("tools-SongIndex", Yii::app()->user->Id),
				),
				array(
						"url" => array("route" => "/tools/video"),
						"label" => Yii::t('admin', 'Ẩn video'),
						"visible" => UserAccess::checkAccess("tools-VideoIndex", Yii::app()->user->Id),
				),
				array(
						"url" => array("route" => "/tools/copyright"),
						"label" => Yii::t('admin', 'Set ưu tiên - song'),
						"visible" => UserAccess::checkAccess("tools-CopyrightIndex", Yii::app()->user->Id),
				),
				CMap::mergeArray(
					array(
							"url" => array("route" => "/tools/importUpload/newimport"),
							"label" => Yii::t('admin', 'Check - song'),
							"visible" => UserAccess::checkAccess("tools-ImportUploadNewimport", Yii::app()->user->Id)
					),$submenu['tools-checksong']
				),
				CMap::mergeArray(
					array(
							"url" => array("route" => "/copyright_content/default/index"),
							"label" => Yii::t('admin', 'Bản quyền'),
							"visible" => UserAccess::checkAccess("copyright_content-DefaultIndex", Yii::app()->user->Id)
					),$submenu['tools-copyright']
				),
				
				array(
						"url" => array("route" => "/tools/toolsSettingGetMsisdn/index"),
						"label" => Yii::t('admin', 'Lọc thuê bao'),
						"visible" => UserAccess::checkAccess("tools-ToolsSettingGetMsisdnIndex", Yii::app()->user->Id),
				),*/
			CMap::mergeArray(
				array(
					"url" => array("route" => "/tools/exportSong/index"),
					"label" => Yii::t('admin', 'Export song - video'),
					"visible" => UserAccess::checkAccess("tools-ExportSongIndex", Yii::app()->user->Id)
				),$submenu['tools-exportsong']
			),
			array(
				"url" => array("route" => "/tools/importUpload/newimport"),
				"label" => Yii::t('admin', 'Import Upload'),
				"visible" => UserAccess::checkAccess("tools-importUploadNewimport", Yii::app()->user->Id),
			),
		),


	array(
		"url"=>array("route"=>"#"),
		"label"=>Yii::t('admin','Marketing'),
		"visible"=>UserAccess::checkAccess("MarkettingMenuView", Yii::app()->user->Id),
		array(
			"url"=>array("route"=>"reports/ReportAdsLanding"),
			"label"=>Yii::t('admin','Thống kê LandingPage'),
			"visible"=>UserAccess::checkAccess("ReportsReportAdsLanding", Yii::app()->user->Id),
		),
		CMap::mergeArray(
			array(
				"url"=>array("route"=>"reports/reportAdsClick"),
				"label"=>Yii::t('admin','Thống kê quảng cáo'),
				"visible"=>UserAccess::checkAccess("ReportsReportAdsClick", Yii::app()->user->Id),
			),$submenu['reports']['ads']),
		array(
			"url" => array("route" => "/ads/adsSource/index"),
			"label" => Yii::t('admin', 'Mã quảng cáo'),
			"visible" => UserAccess::checkAccess("ads-AdsSourceIndex", Yii::app()->user->Id)
		),
		array(
			"url" => array("route" => "/ads/adsMarketing/index"),
			"label" => Yii::t('admin', 'Link Quảng Cáo'),
			"visible" => UserAccess::checkAccess("ads-adsMarketingIndex", Yii::app()->user->Id)
		),
		array(
			"url" => array("route" => "/pushNotifSetting/index"),
			"label" => Yii::t('admin', 'PushNotifSetting'),
			"visible" => UserAccess::checkAccess("PushNotifSettingIndex", Yii::app()->user->Id)
		),
	),
	array(
		"url"=>array("route"=>"#"),
		"label"=>Yii::t('admin','Bản quyền'),
		"visible"=>UserAccess::checkAccess("ReportsMenuCopyright", Yii::app()->user->Id),
		array(
			"url" => array("route" => "/ccp/index"),
			"label" => Yii::t('admin', 'Quản lý CCP'),
			"visible" => UserAccess::checkAccess("CcpIndex", Yii::app()->user->Id)
		),
		array(
			"url" => array("route" => "/copyright"),
			"label" => Yii::t('admin', 'Quản lý Phụ lục'),
			"visible" => UserAccess::checkAccess("CopyrightIndex", Yii::app()->user->Id)
		),
		array(
			"url" => array("route" => "/copyright_content/default/index"),
			"label" => Yii::t('admin', 'Nhập bản quyền'),
			"visible" => UserAccess::checkAccess("Copyright_content-DefaultIndex", Yii::app()->user->Id)
		),
	),



);
