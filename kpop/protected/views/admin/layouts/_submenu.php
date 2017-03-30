<?php

return array(
    'song' => array(
        array(
            "url" => array("route" => "/song/index"),
            "label" => Yii::t('admin', 'Tất cả'),
            "visible" => UserAccess::checkAccess("SongIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/song/index", 'params' => array('AdminSongModel[status]' => AdminSongModel::NOT_CONVERT)),
            "label" => Yii::t('admin', 'Chưa Convert'),
            "visible" => UserAccess::checkAccess("SongIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/song/index", 'params' => array('AdminSongModel[status]' => AdminSongModel::CONVERT_FAIL)),
            "label" => Yii::t('admin', 'Convert lỗi'),
            "visible" => UserAccess::checkAccess("SongIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/song/index", 'params' => array('AdminSongModel[status]' => AdminSongModel::WAIT_APPROVED)),
            "label" => Yii::t('admin', 'Chờ duyệt'),
            "visible" => UserAccess::checkAccess("SongIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/song/index", 'params' => array('AdminSongModel[status]' => AdminSongModel::ACTIVE)),
            "label" => Yii::t('admin', 'Đã duyệt'),
            "visible" => UserAccess::checkAccess("SongIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/song/index", 'params' => array('AdminSongModel[status]' => AdminSongModel::DELETED)),
            "label" => Yii::t('admin', 'Đã xóa'),
            "visible" => UserAccess::checkAccess("SongIndex", Yii::app()->user->Id),
        ),
    ),
    'radio' => array(
        array(
            "url" => array("route" => "/radio/channel/create"),
            "label" => Yii::t('admin', 'Tạo mới kênh'),
            "visible" => UserAccess::checkAccess("Radio-ChannelCreate", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/radio/channel"),
            "label" => Yii::t('admin', 'Danh sách kênh'),
            "visible" => UserAccess::checkAccess("Radio-ChannelIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/weather/index"),
            "label" => Yii::t('admin', 'Thời tiết'),
            "visible" => UserAccess::checkAccess("WeatherIndex", Yii::app()->user->Id),
        ),
    ),
    'video' => array(
        array(
            "url" => array("route" => "/video/index"),
            "label" => Yii::t('admin', 'Tất cả'),
            "visible" => UserAccess::checkAccess("VideoIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/video/index", 'params' => array('AdminVideoModel[status]' => AdminVideoModel::NOT_CONVERT)),
            "label" => Yii::t('admin', 'Chưa convert'),
            "visible" => UserAccess::checkAccess("VideoIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/video/index", 'params' => array('AdminVideoModel[status]' => AdminVideoModel::CONVERT_FAIL)),
            "label" => Yii::t('admin', 'Convert lỗi'),
            "visible" => UserAccess::checkAccess("VideoIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/video/index", 'params' => array('AdminVideoModel[status]' => AdminVideoModel::WAIT_APPROVED)),
            "label" => Yii::t('admin', 'Chờ duyệt'),
            "visible" => UserAccess::checkAccess("VideoIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/video/index", 'params' => array('AdminVideoModel[status]' => AdminVideoModel::ACTIVE)),
            "label" => Yii::t('admin', 'Đã duyệt'),
            "visible" => UserAccess::checkAccess("VideoIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/video/index", 'params' => array('AdminVideoModel[status]' => AdminVideoModel::DELETED)),
            "label" => Yii::t('admin', 'Đã xóa'),
            "visible" => UserAccess::checkAccess("VideoIndex", Yii::app()->user->Id),
        ),
    ),
    'videoPlaylist' => array(
        array(
            "url" => array("route" => "/videoPlaylist/index"),
            "label" => Yii::t('admin', 'Tất cả'),
            "visible" => UserAccess::checkAccess("VideoPlaylistIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/videoPlaylist/create"),
            "label" => Yii::t('admin', 'Tạo mới'),
            "visible" => UserAccess::checkAccess("VideoPlaylistCreate", Yii::app()->user->Id),
        ),
    ),
    'album' => array(
        array(
            "url" => array("route" => "/album/index"),
            "label" => Yii::t('admin', 'Tất cả'),
            "visible" => UserAccess::checkAccess("AlbumIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/album/index", 'params' => array('AdminAlbumModel[status]' => AdminAlbumModel::WAIT_APPROVED)),
            "label" => Yii::t('admin', 'Chờ duyệt'),
            "visible" => UserAccess::checkAccess("AlbumIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/album/index", 'params' => array('AdminAlbumModel[status]' => AdminAlbumModel::ACTIVE)),
            "label" => Yii::t('admin', 'Đã duyệt'),
            "visible" => UserAccess::checkAccess("AlbumIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/album/index", 'params' => array('AdminAlbumModel[status]' => AdminAlbumModel::DELETED)),
            "label" => Yii::t('admin', 'Đã xóa'),
            "visible" => UserAccess::checkAccess("AlbumIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/toolsAlbum/create"),
            "label" => Yii::t('admin', 'Tạo Album'),
            "visible" => UserAccess::checkAccess("AlbumIndex", Yii::app()->user->Id),
        ),
    ),
    'album_detail' => array(
        array(
            "url" => array("route" => "/album/view", "params" => array('id' => Yii::app()->request->getParam('id'))),
            "label" => Yii::t('admin', 'Thông tin album'),
            "visible" => UserAccess::checkAccess("AlbumView", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/album/songList", "params" => array('id' => Yii::app()->request->getParam('id'))),
            "label" => Yii::t('admin', 'Danh sách bài hát'),
            "visible" => UserAccess::checkAccess("AlbumSongList", Yii::app()->user->Id),
        ),
    ),
    'playlist' => array(
        array(
            "url" => array("route" => "/playlist/index"),
            "label" => Yii::t('admin', 'Tất cả'),
            "visible" => UserAccess::checkAccess("PlaylistIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/playlist/create"),
            "label" => Yii::t('admin', 'Tạo mới'),
            "visible" => UserAccess::checkAccess("PlaylistCreate", Yii::app()->user->Id),
        ),
    ),
    'playlist_detail' => array(
        array(
            "url" => array("route" => "/playlist/view", "params" => array('id' => Yii::app()->request->getParam('id'))),
            "label" => Yii::t('admin', 'Playlist info'),
            "visible" => UserAccess::checkAccess("PlaylistView", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/playlist/songList", "params" => array('id' => Yii::app()->request->getParam('id'))),
            "label" => Yii::t('admin', 'Song in Playlist'),
            "visible" => UserAccess::checkAccess("PlaylistSongList", Yii::app()->user->Id),
        ),
    ),
    'artist' => array(
        array(
            "url" => array("route" => "/artist/index"),
            "label" => Yii::t('admin', 'Danh sách'),
            "visible" => UserAccess::checkAccess("ArtistIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/artist/create"),
            "label" => Yii::t('admin', 'Tạo mới'),
            "visible" => UserAccess::checkAccess("ArtistCreate", Yii::app()->user->Id),
        ),
    ),
    'collection' => array(
        array(
            "url" => array("route" => "/Collection/index"),
            "label" => Yii::t('admin', 'Bộ sưu tập'),
            "visible" => UserAccess::checkAccess("CollectionIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/collection/create"),
            "label" => Yii::t('admin', 'Tạo mới'),
            "visible" => UserAccess::checkAccess("CollectionCreate", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/collection/listWebFront"),
            "label" => Yii::t('admin', 'DS trên trang chủ web'),
            "visible" => UserAccess::checkAccess("CollectionListWebFront", Yii::app()->user->Id),
        ),
    ),
    'topContent' => array(
        array(
            "url" => array("route" => "/topContent/index"),
            "label" => Yii::t('admin', 'Danh sách'),
            "visible" => UserAccess::checkAccess("TopContentIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/topContent/create"),
            "label" => Yii::t('admin', 'Tạo mới'),
            "visible" => UserAccess::checkAccess("TopContentCreate", Yii::app()->user->Id),
        ),
    ),
    'chart' => array(
        array(
            "url" => array("route" => "/Chart/index"),
            "label" => Yii::t('admin', 'Bảng xếp hạng'),
            "visible" => UserAccess::checkAccess("ChartIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/chart/create"),
            "label" => Yii::t('admin', 'Tạo mới'),
            "visible" => UserAccess::checkAccess("ChartCreate", Yii::app()->user->Id),
        ),
    ),
    'event' => array(
        array(
            "url" => array("route" => "/event/gameEventThread"),
            "label" => Yii::t('admin', 'Bộ câu hỏi'),
            "visible" => UserAccess::checkAccess("event-GameEventThreadIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/event/gameEventQuestion"),
            "label" => Yii::t('admin', 'DS câu hỏi'),
            "visible" => UserAccess::checkAccess("event-GameEventQuestionIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/event/gameEventReportDay"),
            "label" => Yii::t('admin', 'Thống kê người chơi'),
            "visible" => UserAccess::checkAccess("event-GameEventReportDayIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/event/gameEventReportAll"),
            "label" => Yii::t('admin', 'Thống kê tổng hợp'),
            "visible" => UserAccess::checkAccess("event-GameEventReportAllIndex", Yii::app()->user->Id),
        ),
    ),
    'genre' => array(
        array(
            "url" => array("route" => "/genre/index"),
            "label" => Yii::t('admin', 'Danh sách'),
            "visible" => UserAccess::checkAccess("GenreIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/genre/create"),
            "label" => Yii::t('admin', 'Tạo mới'),
            "visible" => UserAccess::checkAccess("GenreCreate", Yii::app()->user->Id),
        ),
    ),
    'user' => array(
        array(
            "url" => array("route" => "/userSubscribe/index"),
            "label" => Yii::t('admin', 'Danh sách thuê bao'),
            "visible" => UserAccess::checkAccess("userSubscribeIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/userLog/index"),
            "label" => Yii::t('admin', 'Tra cứu log người dùng'),
            "visible" => UserAccess::checkAccess("UserLogIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/transLog/index"),
            "label" => Yii::t('admin', 'Tra cứu log giao dịch'),
            "visible" => UserAccess::checkAccess("TransLogIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/transLogUser/viewLog"),
            "label" => Yii::t('admin', 'Chăm sóc khách hàng'),
            "visible" => UserAccess::checkAccess("TransLogUserViewLog", Yii::app()->user->Id),
        ),
    ),
    'reports' => array(
        'content' => array(
            array(
                "url" => array("route" => "/reports/reportVegaContent"),
                "label" => Yii::t('admin', 'Nội dung biên tập'),
                "visible" => UserAccess::checkAccess("ReportsReportVegaContent", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/song"),
                "label" => Yii::t('admin', 'Bài hát'),
                "visible" => UserAccess::checkAccess("ReportsSong", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/songDetail"),
                "label" => Yii::t('admin', 'Theo từng bài'),
                "visible" => UserAccess::checkAccess("ReportsSongDetail", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/video"),
                "label" => Yii::t('admin', 'Video'),
                "visible" => UserAccess::checkAccess("ReportsVideo", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/videoDetail"),
                "label" => Yii::t('admin', 'Theo từng video'),
                "visible" => UserAccess::checkAccess("ReportsVideoDetail", Yii::app()->user->Id),
            ),
        ),
        'daily' => array(
            array(
                "url" => array("route" => "/reports/dailyReportRevenue"),
                "label" => Yii::t('admin', 'Thống kê Doanh thu'),
                "visible" => UserAccess::checkAccess("ReportsDailyReportRevenue", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/dailyReportMsisdn"),
                "label" => Yii::t('admin', 'Thống kê Thuê bao'),
                "visible" => UserAccess::checkAccess("ReportsDailyReportMsisdn", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/dailyRegister"),
                "label" => Yii::t('admin', 'Thống kê Đăng ký/Hủy'),
                "visible" => UserAccess::checkAccess("ReportsDailyRegister", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/dailyExtent"),
                "label" => Yii::t('admin', 'Thống kê Gia hạn'),
                "visible" => UserAccess::checkAccess("ReportsDailyExtent", Yii::app()->user->Id),
            ),
            array(
                "url"=>array("route"=>"reports/detectLog"),
                "label"=>Yii::t('admin','Thống kê truy cập'),
                "visible"=>UserAccess::checkAccess("ReportsDetectLog", Yii::app()->user->Id),
            ),
        ),
        'rev' => array(
            /* array(
                "url" => array("route" => "/reports/contentSp"),
                "label" => Yii::t('admin', 'Doanh thu SP'),
                "visible" => UserAccess::checkAccess("ReportsContentSp", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/contentCp"),
                "label" => Yii::t('admin', 'Doanh thu CP'),
                "visible" => UserAccess::checkAccess("ReportsContentCp", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/daily"),
                "label" => Yii::t('admin', 'Doanh thu trong ngày'),
                "visible" => UserAccess::checkAccess("ReportsDaily", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/revenue"),
                "label" => Yii::t('admin', 'Doanh thu thời gian'),
                "visible" => UserAccess::checkAccess("ReportsRevenue", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/revenueCp"),
                "label" => Yii::t('admin', 'Doanh thu Cp (Gói cước)'),
                "visible" => UserAccess::checkAccess("ReportsRevenueCp", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/revenueContent"),
                "label" => Yii::t('admin', 'Doanh thu Cp (Nội dung)'),
                "visible" => UserAccess::checkAccess("ReportsRevenueContent", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/dailyTime"),
                "label" => Yii::t('admin', 'Doanh thu chi tiết theo thời gian'),
                "visible" => UserAccess::checkAccess("ReportsDailyTime", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/copyrightCPArtist"),
                "label" => Yii::t('admin', 'Doanh thu gói'),
                "visible" => UserAccess::checkAccess("ReportsCopyrightCPArtist", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/evenueRetailArtist"),
                "label" => Yii::t('admin', 'Doanh thu lẻ ca sỹ'),
                "visible" => UserAccess::checkAccess("ReportsEvenueRetailArtist", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/revenueSongdetailArtist"),
                "label" => Yii::t('admin', 'Doanh thu chi tiết ca sỹ'),
                "visible" => UserAccess::checkAccess("ReportsRevenueSongdetailArtist", Yii::app()->user->Id),
            ), */
        ),
        'subs' => array(
           /*  array(
                "url" => array("route" => "/reports/subscribeReport"),
                "label" => Yii::t('admin', 'Danh sách thuê bao'),
                "visible" => UserAccess::checkAccess("ReportsSubscribeReport", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/register"),
                "label" => Yii::t('admin', 'Số lượt đăng ký'),
                "visible" => UserAccess::checkAccess("ReportsRegister", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/unregister"),
                "label" => Yii::t('admin', 'Số lượt hủy'),
                "visible" => UserAccess::checkAccess("ReportsUnregister", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/subscribeExt"),
                "label" => Yii::t('admin', 'Số lượt gia hạn'),
                "visible" => UserAccess::checkAccess("ReportsSubscribeExt", Yii::app()->user->Id),
            ), */
            /* array(
                "url" => array("route" => "/reports/subscribeExtSuccess"),
                "label" => Yii::t('admin', 'Gia hạn qua IVR'),
                "visible" => UserAccess::checkAccess("ReportsSubscribeExtSuccess", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/unSubscribeExtSuccess"),
                "label" => Yii::t('admin', 'Hủy qua IVR'),
                "visible" => UserAccess::checkAccess("ReportsUnSubscribeExtSuccess", Yii::app()->user->Id),
            ), */
            /* array(
                "url" => array("route" => "/reports/subscribeStatistic"),
                "label" => Yii::t('admin', 'Thống kê chung'),
                "visible" => UserAccess::checkAccess("ReportsSubscribeStatistic", Yii::app()->user->Id),
            ), */
        ),
        'trans' => array(
            array(
                "url" => array("route" => "/reports/detailByTrans"),
                "label" => Yii::t('admin', 'Giao dịch theo thuê bao'),
                "visible" => UserAccess::checkAccess("ReportsDetailByTrans", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/detailByTime"),
                "label" => Yii::t('admin', 'Giao dịch theo ngày'),
                "visible" => UserAccess::checkAccess("ReportsDetailByTime", Yii::app()->user->Id),
            ),
        ),
        'ads' => array(
            array(
                "url" => array("route" => "/reports/reportAdsClick"),
                "label" => Yii::t('admin', 'Thống kê lượt Click'),
                "visible" => UserAccess::checkAccess("ReportsReportAdsClick", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/reportAdsIp"),
                "label" => Yii::t('admin', 'Danh sách IP'),
                "visible" => UserAccess::checkAccess("ReportsReportAdsIp", Yii::app()->user->Id),
            ),
        ),
        'copyright' => array(
            array(
                "url" => array("route" => "/reports/copyrightCP"),
                "label" => Yii::t('admin', 'Doanh thu gói'),
                "visible" => UserAccess::checkAccess("ReportsCopyrightCP", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/CCPRetail"),
                "label" => Yii::t('admin', 'Doanh thu bán lẻ'),
                "visible" => UserAccess::checkAccess("ReportsCCPRetail", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/CCPSongdetail"),
                "label" => Yii::t('admin', 'Thống kê chi tiết bài hát'),
                "visible" => UserAccess::checkAccess("ReportsCCPSongdetail", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/reports/CCPVideoDetailReport"),
                "label" => Yii::t('admin', 'Thống kê chi tiết video'),
                "visible" => UserAccess::checkAccess("ReportsCCPVideodetail", Yii::app()->user->Id),
            ),
        ),
    ),
    'cms' => array(
        array(
            "url" => array("route" => "/news"),
            "label" => Yii::t('admin', 'Tin tức'),
            "visible" => UserAccess::checkAccess("NewsIndex", Yii::app()->user->Id)
        ),
        array(
            "url" => array("route" => "/html/index"),
            "label" => Yii::t('admin', 'Wap'),
            "visible" => UserAccess::checkAccess("HtmlIndex", Yii::app()->user->Id),
            array(
                "url" => array("route" => "/html/index", "params" => array("channel" => "wap")),
                "label" => Yii::t('admin', 'HTML'),
                "visible" => UserAccess::checkAccess("HtmlIndex", Yii::app()->user->Id)
            ),
            array(
                "url" => array("route" => "/banner/index", "params" => array("channel" => "wap")),
                "label" => Yii::t('admin', 'Banner'),
                "visible" => UserAccess::checkAccess("BannerIndex", Yii::app()->user->Id)
            ),
            array(
                "url" => array("route" => "/newsEvent/index", "params" => array("channel" => "wap")),
                "label" => Yii::t('admin', 'Sự kiện'),
                "visible" => UserAccess::checkAccess("NewsEventIndex", Yii::app()->user->Id)
            ),
            array(
                "url" => array("route" => "/newsEvent/index", "params" => array("channel" => "web")),
                "label" => Yii::t('admin', 'SlideShow'),
                "visible" => UserAccess::checkAccess("NewsEventIndex", Yii::app()->user->Id)
            ),
            array(
                "url" => array("route" => "/newsEvent/index", "params" => array("channel" => "vinaportal")),
                "label" => Yii::t('admin', 'Tin nổi bật'),
                "visible" => UserAccess::checkAccess("NewsEventIndex", Yii::app()->user->Id)
            ),
        ),
        array(
            "url" => array("route" => "/banner/index", "params" => array("channel" => "app")),
            "label" => Yii::t('admin', 'Apps'),
            "visible" => UserAccess::checkAccess("BannerIndex", Yii::app()->user->Id)
        ),
        /* array(
            "url" => array("route" => "/feedback/index"),
            "label" => Yii::t('admin', 'Feedback'),
            "visible" => UserAccess::checkAccess("FeedbackIndex", Yii::app()->user->Id)
        ), */
        /* array(
            "url" => array("route" => "/shortlink/default"),
            "label" => Yii::t('admin', 'Short Link'),
            "visible" => UserAccess::checkAccess("shortlink-DefaultIndex", Yii::app()->user->Id)
        ), */
        array(
            "url" => array("route" => "/contentLimit/index"),
            "label" => Yii::t('admin', 'Giới hạn nội dung độc quyền'),
            "visible" => UserAccess::checkAccess("ContentLimitIndex", Yii::app()->user->Id)
        ),
        array(
            "url" => array("route" => "/topContent/index"),
            "label" => Yii::t('admin', 'Chủ đề âm nhạc'),
            "visible" => UserAccess::checkAccess("ContentLimitIndex", Yii::app()->user->Id)
        ),
        array(
            "url" => array("route" => "#"),
            "label" => Yii::t('admin', 'Gamification'),
            "visible" => UserAccess::checkAccess("gamification-AdminEventGroupAdmin", Yii::app()->user->Id),
            array(
                "url" => array("route" => "/gamification/AdminEventGroup/admin"),
                "label" => Yii::t('admin', 'Nhóm sự kiện'),
                "visible" => UserAccess::checkAccess("gamification-AdminEventGroupAdmin", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/gamification/AdminEvent/admin"),
                "label" => Yii::t('admin', 'Sự kiện'),
                "visible" => UserAccess::checkAccess("gamification-AdminEventAdmin", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/gamification/AdminUser/index"),
                "label" => Yii::t('admin', 'Tra cứu điểm khách hàng'),
                "visible" => UserAccess::checkAccess("gamification-AdminUserIndex", Yii::app()->user->Id),
            ),
            array(
                "url" => array("route" => "/gamification/AdminUserEvent/admin"),
                "label" => Yii::t('admin', 'Log sự kiện khách hàng'),
                "visible" => UserAccess::checkAccess("gamification-AdminUserEventAdmin", Yii::app()->user->Id),
            ),
        ),
        array(
            "url" => array("route" => "/textLink/index"),
            "label" => Yii::t('admin', 'Text Link'),
            "visible" => UserAccess::checkAccess("TextLinkIndex", Yii::app()->user->Id)
        ),

    ),

    'customer' => array(
        array(
            "url" => array("route" => "/customer"),
            "label" => Yii::t('admin', 'Trạng thái thuê bao'),
            "visible" => UserAccess::checkAccess("CustomerIndex", Yii::app()->user->Id)
        ),
        array(
            "url" => array("route" => "/customer/Subscriber"),
            "label" => Yii::t('admin', 'ĐK/Hủy gói cước'),
            "visible" => UserAccess::checkAccess("CustomerSubscriber", Yii::app()->user->Id),

        ),
        array(
            "url" => array("route" => "/user/default/create","params" => array('content_type' => "subscribe")),
            "label" => Yii::t('admin', 'Đăng ký theo danh sách'),
            "visible" => UserAccess::checkAccess("CustomerSubscriber", Yii::app()->user->Id),

        ),
        array(
            "url" => array("route" => "/user/default/create","params" => array('content_type' => "unsubscribe")),
            "label" => Yii::t('admin', 'Hủy theo danh sách'),
            "visible" => UserAccess::checkAccess("CustomerSubscriber", Yii::app()->user->Id),

        ),


        /*  array(
              "url" => array("route" => "/customer/Useraction"),
              "label" => Yii::t('admin', 'Nhật ký người dùng '),
              "visible" => UserAccess::checkAccess("CustomerUseraction", Yii::app()->user->Id)
          ),*/
        array(
            "url" => array("route" => "/customer/extend"),
            "label" => Yii::t('admin', 'ĐK/Hủy gia hạn'),
            "visible" => UserAccess::checkAccess("CustomerEntend", Yii::app()->user->Id)
        ),
        array(
            "url" => array("route" => "/customer/sms"),
            "label" => Yii::t('admin', 'Tin nhắn MO, MT'),
            "visible" => UserAccess::checkAccess("CustomerSms", Yii::app()->user->Id)
        ),
        array(
            "url" => array("route" => "/customer/history"),
            "label" => Yii::t('admin', 'Lịch sử sử dụng'),
            "visible" => UserAccess::checkAccess("CustomerHistory", Yii::app()->user->Id)
        ),
		array(
            "url" => array("route" => "/customer/logAction"),
            "label" => Yii::t('admin', 'Log tác động khách hàng'),
            "visible" => UserAccess::checkAccess("CustomerHistory", Yii::app()->user->Id)
        ),
        array(
            "url" => array("route" => "/customer/LogRevenue"),
            "label" => Yii::t('admin', 'Lịch sử trừ cước'),
            "visible" => UserAccess::checkAccess("CustomerHistory", Yii::app()->user->Id)
        ),
    ),
    'system' => array(
       /* array(
            "url" => array("route" => "/cp/index"),
            "label" => Yii::t('admin', 'Quản lý CP'),
            "visible" => UserAccess::checkAccess("CpIndex", Yii::app()->user->Id)
        ),*/
        /* array(
            "url" => array("route" => "/ccp/index"),
            "label" => Yii::t('admin', 'Quản lý CCP'),
            "visible" => UserAccess::checkAccess("CCpIndex", Yii::app()->user->Id)
        ), */
        array(
            "url" => array("route" => "/package/index"),
            "label" => Yii::t('admin', 'Quản lý Gói cước'),
            "visible" => UserAccess::checkAccess("PackageIndex", Yii::app()->user->Id)
        ),
        /* array(
            "url" => array("route" => "/contentApprove/index"),
            "label" => Yii::t('admin', 'Quản lý CTV'),
            "visible" => UserAccess::checkAccess("ContentApproveIndex", Yii::app()->user->Id),
            array(
                "url" => array("route" => "/reportAccount/index"),
                "label" => Yii::t('admin', 'Khối lượng công việc'),
                "visible" => UserAccess::checkAccess("ReportAccountIndex", Yii::app()->user->Id)
            )
        ), */
        /* array(
            "url" => array("route" => "/emailTemplate/index"),
            "label" => Yii::t('admin', 'Email Template'),
            "visible" => UserAccess::checkAccess("EmailTemplateIndex", Yii::app()->user->Id)
        ), */

        array(
            "url" => array("route" => "/config/index"),
            "label" => Yii::t('admin', 'Cấu hình hệ thống'),
            "visible" => UserAccess::checkAccess("ConfigIndex", Yii::app()->user->Id)
        ),
    		
    	array(
    		"url" => array("route" => "/smsConfig/index"),
    		"label" => Yii::t('admin', 'Cấu hình SMSMT'),
    		"visible" => UserAccess::checkAccess("SmsConfigIndex", Yii::app()->user->Id)
    	),
        array(
            "url" => array("route" => "/config/update", "params" => array('id' => 13)),
            "label" => Yii::t('admin', 'Quản lý Email'),
            "visible" => UserAccess::checkAccess("SmsConfigIndex", Yii::app()->user->Id)
        ),
        /* array(
            "url" => array("route" => "/import_song/importUpload/newimport"),
            "label" => Yii::t('admin', 'Import Songs'),
            "visible" => UserAccess::checkAccess("Import_song-ImportUploadNewimport", Yii::app()->user->Id),
            array(
                "url" => array("route" => "/import_song/importSongFile/index"),
                "label" => Yii::t('admin', 'Import File List'),
                "visible" => UserAccess::checkAccess("Import_song-ImportSongFileIndex", Yii::app()->user->Id)
            )
        ), */

    ),
    'monitoring' => array(
        array(
            "url" => array("route" => "/monitoring/detect"),
            "label" => Yii::t('admin', 'Monitoring nhận diện'),
            "visible" => UserAccess::checkAccess("MonitoringDetect", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/monitoring/subscribe"),
            "label" => Yii::t('admin', 'Monitoring đăng ký'),
            "visible" => UserAccess::checkAccess("MonitoringSubscribe", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/monitoring/extend"),
            "label" => Yii::t('admin', 'Monitoring gia hạn'),
            "visible" => UserAccess::checkAccess("MonitoringExtend", Yii::app()->user->Id),
        ),
    ),
    'tools-checksong' => array(
        array(
            "url" => array("route" => "/tools/importUpload/newimport"),
            "label" => Yii::t('admin', 'Import Song'),
            "visible" => UserAccess::checkAccess("tools-ImportUploadNewimport", Yii::app()->user->Id)
        ),
        array(
            "url" => array("route" => "/tools/importSongFile/index"),
            "label" => Yii::t('admin', 'List Song'),
            "visible" => UserAccess::checkAccess("tools-ImportSongFileIndex", Yii::app()->user->Id)
        )
    ),
    'tools-exportsong' => array(
        array(
            "url" => array("route" => "/tools/exportSong/index"),
            "label" => Yii::t('admin', 'Export song'),
            "visible" => UserAccess::checkAccess("tools-ExportSongIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/tools/exportVideo/index"),
            "label" => Yii::t('admin', 'Export video'),
            "visible" => UserAccess::checkAccess("tools-ExportVideoIndex", Yii::app()->user->Id),
        ),
    ),
	'tools-copyright'=>array(
			array(
					"url" => array("route" => "/copyright_content/default/index"),
					"label" => Yii::t('admin', 'Nhập bản quyền'),
					"visible" => UserAccess::checkAccess("copyright_content-DefaultIndex", Yii::app()->user->Id),
			),
			array(
					"url"=>array("route"=>"/copyright"),
					"label"=>Yii::t('admin','Phụ lục'),
					"visible"=>UserAccess::checkAccess("CopyrightIndex", Yii::app()->user->Id),
			),
    ),
	'KPI'=>array(
	        array(
	            "url" => array("route" => "/userSubscribe/index"),
	            "label" => Yii::t('admin', 'Danh sách thuê bao'),
	            "visible" => UserAccess::checkAccess("userSubscribeIndex", Yii::app()->user->Id),
	        ),
	        array(
	            "url" => array("route" => "/kpi/logAction"),
	            "label" => Yii::t('admin', 'Log tác động'),
	            "visible" => UserAccess::checkAccess("KpiLogAction", Yii::app()->user->Id),
	        ),
	        array(
	            "url" => array("route" => "/kpi/logSms"),
	            "label" => Yii::t('admin', 'Log Sms MT'),
	            "visible" => UserAccess::checkAccess("KpiLogSms", Yii::app()->user->Id),
	        ),
	        array(
	            "url" => array("route" => "/kpi/syncStatus"),
	            "label" => Yii::t('admin', 'Log đồng bộ thuê bao'),
	            "visible" => UserAccess::checkAccess("KpiSyncStatus", Yii::app()->user->Id),
	        ),			
			 array(
	            "url" => array("route" => "/monitoring/KPI"),
	            "label" => Yii::t('admin', 'KPI chung'),
	            "visible" => UserAccess::checkAccess("KpiSyncStatus", Yii::app()->user->Id),
	        ),
			array(
                "url" => array("route" => "/monitoring/detect"),
                "label" => Yii::t('admin', 'KPI nhận diện'),
                "visible" => UserAccess::checkAccess("MonitoringDetect", Yii::app()->user->Id),
            ),

            array(
                "url" => array("route" => "/monitoring/extend"),
                "label" => Yii::t('admin', 'KPI gia hạn'),
                "visible" => UserAccess::checkAccess("MonitoringExtend", Yii::app()->user->Id),
            ),
        array(
            "url" => array("route" => "/monitoring/subscribe"),
            "label" => Yii::t('admin', 'KPI đăng ký'),
            "visible" => UserAccess::checkAccess("MonitoringSubscribe", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/monitoring/unsubscribe"),
            "label" => Yii::t('admin', 'KPI hủy'),
            "visible" => UserAccess::checkAccess("MonitoringUnSubscribe", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/monitoring/charge"),
            "label" => Yii::t('admin', 'KPI Charge'),
            "visible" => UserAccess::checkAccess("MonitoringCharge", Yii::app()->user->Id),
        ),
		 array(
            "url" => array("link" => "http://cms.amusic.vn/nagios/"),  
            "label" => Yii::t('admin', 'Giám sát hệ thống'),
            "visible" => UserAccess::checkAccess("MonitoringUnSubscribe", Yii::app()->user->Id),
        ),
	)
);

