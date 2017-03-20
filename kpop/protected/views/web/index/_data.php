<?php $this->layout = false;?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/web/js/_slidebar.js");
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/web/js/_home.js");
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/web/js/_right.js");
$image = "http://amusic.vn/img/sharefb.jpg";
Yii::app()->SEO->addMetaProp('og:image', $image);
?>
    <div class="slide">
        <?php $this->widget('application.widgets.web.slideshowWidget.Init', array()); ?>
    </div>
    <div class="video_playlist_widget box pt25" id="box_video_playlist">
        <?php
        $this->widget('application.widgets.web.videoplaylist.ListSlideBar',
            array(
                'List' => $video_playlist,
                'link' => Yii::app()->createUrl('/videoplaylist'),
            ));
        ?>
    </div>
    <div class="album_widget box" id="box_album">
        <?php
        $this->widget('application.widgets.web.album.AlbumSlideBar',
            array(
                'albumList' => $albums,
                'link' => Yii::app()->createUrl('/album'),
            ));
        ?>
    </div>
    <div class="video_widget box" id="box_video">
        <?php
        $this->widget('application.widgets.web.video.VideoSlideBar',
            array(
                'videoList' => $videos,
                'link' => Yii::app()->createUrl('/video'),
            ));
        ?>
    </div>
    <div class="song_box" id="box_song">
        <?php
        $this->widget('application.widgets.web.song.SongListWidget',
            array(
                'songList' => $songs,
                'type' => 'hot',
                'title' => Yii::t('web', 'Top Song'),
                'link' => Yii::app()->createUrl('/song/index', array('type' => 'HOT')),

            ));
        ?>
        <?php
        $this->widget('application.widgets.web.song.SongListWidget',
            array(
                'songList' => $song_new,
                'type' => 'new',
                'title' => Yii::t('web', 'New Song'),
                'link' => Yii::app()->createUrl('/song/index', array('type' => 'NEW')),
            ));
        ?>
    </div>
<?php if (Yii::app()->params['enable_news'] == 1): ?>
    <div class="news_hot box pt25">
        <?php
        $this->widget('application.widgets.web.news.ListHome');
        ?>
    </div>
<?php endif; ?>
<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id' => 'sidebar-r')); ?>
    <div class="box" id="banner_1">
    </div>
    <!--<div class="box_app">
        <?php /*$this->widget('application.widgets.web.app.appWidget');*/ ?>
    </div>-->
    <!--<div class="box" id="box_radio_list">
    </div>-->
    <!-- <div class="box">
        <?php /*$this->widget('application.widgets.web.topContent.ListContent',array()); */ ?>
    </div>-->
    <div class="box" id="box_chart_song">
    </div>
    <div class="box" id="box_chart_video">
    </div>
    <div class="box" id="box_chart_album">
    </div>
<?php $this->endWidget(); ?>