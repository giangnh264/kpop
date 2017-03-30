<?php
$descMeta = $this->htmlTitle;
if ($news) {
    $i = 0;
    foreach ($news as $item) {
        $i++;
        $newsName[] = $item->title;
        if ($i == 4)
            break;
    }
    $descMeta .= '.' . implode(', ', $newsName);
}
$this->headMeta = '<meta name="title" content="' . $this->htmlTitle . '" />
                    <meta name="description" content="' . $descMeta . '" />';
$this->htmlTitle = $category->name . ' | Tin tức mới nhất trong thể loại '. $category->name . ' | KPOP.VN';
$this->headMeta = '<meta name="title" content="' . $category->name . '" />'

?>
<div id="main-wrapper" class="vce-sid-right">
    <div id="content" class="container site-content">
        <div id="primary" class="vce-main-content">
            <div id="main-box-1" class="main-box vce-border-top  ">

                <h3 class="main-box-title cat-<?php echo $category->id;?>"><?php echo $category->name;?></h3>
                <div class="main-box-inside ">
                    <div class="vce-loop-wrap">
                        <?php foreach ($news as $item): ?>
                        <article class="vce-post vce-lay-c post-203 post type-post status-publish format-standard has-post-thumbnail hentry category-environment category-technology tag-earth tag-ecology tag-solar-energy" style="height: 444px;">

                            <div class="meta-image">
                                <a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>" title="Solar Energy for Mother Earth and Everyday Smiles">
                                    <img width="375" height="195" src="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?>"
                                         class="attachment-vce-lay-b size-vce-lay-b wp-post-image" alt="">
                                </a>
                            </div>

                            <header class="entry-header">

                                <h2 class="entry-title"><a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>" title="<?php echo $item->title; ?>"><?php echo Formatter::smartCut($item->title, 45, 0); ?></a></h2>
                                <div class="entry-meta"><div class="meta-item date"><span class="updated"><?php echo Formatter::formatTimeAgo($item->created_time);?></span></div></div>	</header>

                            <div class="entry-content">
                                <p><?php echo Formatter::smartCut($item->description, 90, 0); ?></p>
                            </div>

                        </article>
                        <?php endforeach;?>
                    </div>
                </div>
                <?php $this->widget ( "application.widgets.web.common.VLinkPager", array (
                    "pages" => $page,
                    "maxButtonCount" => Yii::app ()->params ["constLimit"] ["pager.max.button.count"],
                    "header" => "",
                    "htmlOptions" => array ( "class" => "pager" )
                ) );?>
            </div>
        </div>
        <aside id="sidebar" class="sidebar right">

            <div id="mks_ads_widget-2" class="widget mks_ads_widget">
                <ul class="mks_adswidget_ul large">
                    <li data-showind="0">
                        <a href="#" target="_blank">
                            <img src="<?php echo Yii::app()->request->baseUrl?>/web/images/ads1.jpg" alt="ad_300x250.png" style="width:300px; height:250px;" width="300" height="250"/>
                        </a>
                    </li>
                </ul>

            </div>

            <!--Pic nổi bật trong tuan-->
            <?php $this->widget('application.widgets.web.right_col.FeaturedPic', array()); ?>
            <!--end Pic nổi bật trong tuan-->


            <div id="mks_flickr_widget-2" class="widget mks_flickr_widget"><h4 class="widget-title">Photo
                    Stream</h4>
                <ul class="flickr">
                    <li><a href="http://www.flickr.com/photos/116797173@N07/32983511835/"
                           title="Zosterops japonicus" target="_blank"><img
                                src="http://farm1.staticflickr.com/485/32983511835_ce689782d8_t.jpg"
                                alt="Zosterops japonicus" style="width: 80px; height: 80px;"/></a></li>
                    <li><a href="http://www.flickr.com/photos/116797173@N07/27468006050/"
                           title="Taima Temple (Nara, Japan)" target="_blank"><img
                                src="http://farm8.staticflickr.com/7385/27468006050_24f0110a9f_t.jpg"
                                alt="Taima Temple (Nara, Japan)" style="width: 80px; height: 80px;"/></a></li>
                    <li><a href="http://www.flickr.com/photos/116797173@N07/22608568342/" title="Osaka Sep. 23"
                           target="_blank"><img
                                src="http://farm6.staticflickr.com/5696/22608568342_fa6eb833eb_t.jpg"
                                alt="Osaka Sep. 23" style="width: 80px; height: 80px;"/></a></li>
                    <li><a href="http://www.flickr.com/photos/116797173@N07/22484453611/"
                           title="Mt. Fuji Oct.25 Morning" target="_blank"><img
                                src="http://farm6.staticflickr.com/5748/22484453611_245bffbbe5_t.jpg"
                                alt="Mt. Fuji Oct.25 Morning" style="width: 80px; height: 80px;"/></a></li>
                    <li><a href="http://www.flickr.com/photos/116797173@N07/20977886324/" title="Red Magic Lily 4"
                           target="_blank"><img src="http://farm1.staticflickr.com/563/20977886324_4a550fd12d_t.jpg"
                                                alt="Red Magic Lily 4" style="width: 80px; height: 80px;"/></a></li>
                    <li><a href="http://www.flickr.com/photos/116797173@N07/21368165919/" title="White Magic Lily"
                           target="_blank"><img
                                src="http://farm6.staticflickr.com/5775/21368165919_2a8d6e7ccd_t.jpg"
                                alt="White Magic Lily" style="width: 80px; height: 80px;"/></a></li>
                    <li><a href="http://www.flickr.com/photos/116797173@N07/20764481298/" title="Bumble Bee"
                           target="_blank"><img
                                src="http://farm6.staticflickr.com/5680/20764481298_541ef7db76_t.jpg" alt="Bumble Bee"
                                style="width: 80px; height: 80px;"/></a></li>
                    <li><a href="http://www.flickr.com/photos/116797173@N07/20739919020/"
                           title="Asian Swallowtail 2" target="_blank"><img
                                src="http://farm1.staticflickr.com/578/20739919020_7f6b03d725_t.jpg"
                                alt="Asian Swallowtail 2" style="width: 80px; height: 80px;"/></a></li>
                    <li><a href="http://www.flickr.com/photos/116797173@N07/20278515544/" title="Manifold 12"
                           target="_blank"><img
                                src="http://farm6.staticflickr.com/5622/20278515544_2679498fe9_t.jpg" alt="Manifold 12"
                                style="width: 80px; height: 80px;"/></a></li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="vce-sticky">
                <div id="mks_ads_widget-3" class="widget mks_ads_widget"><h4 class="widget-title">Advertisement</h4>


                    <ul class="mks_adswidget_ul small">
                        <li data-showind="0">
                            <a href="#" target="_blank">
                                <img src="http://mekshq.com/static/voice/ad_125x125_blue.png"
                                     alt="ad_125x125_blue.png" style="width:125px; height:125px;" width="125"
                                     height="125"/>
                            </a>
                        </li>
                        <li data-showind="0">
                            <a href="#" target="_blank">
                                <img src="http://mekshq.com/static/voice/ad_125x125_green.png"
                                     alt="ad_125x125_green.png" style="width:125px; height:125px;" width="125"
                                     height="125"/>
                            </a>
                        </li>
                        <li data-showind="0">
                            <a href="#" target="_blank">
                                <img src="http://mekshq.com/static/voice/ad_125x125_orange.png"
                                     alt="ad_125x125_orange.png" style="width:125px; height:125px;" width="125"
                                     height="125"/>
                            </a>
                        </li>
                        <li data-showind="0">
                            <a href="#" target="_blank">
                                <img src="http://mekshq.com/static/voice/ad_125x125_violet.png"
                                     alt="ad_125x125_violet.png" style="width:125px; height:125px;" width="125"
                                     height="125"/>
                            </a>
                        </li>
                    </ul>


                </div>

                <div id="mks_themeforest_widget-2" class="widget mks_themeforest_widget"><h4 class="widget-title">
                        More Themes By Meks</h4>

                    <ul class="mks_themeforest_widget_ul">
                        <li>
                            <a href="https://themeforest.net/item/typology-text-based-minimal-wordpress-blog-theme/19547842?ref=meks"
                               title="Typology - Text Based Minimal WordPress Blog Theme" target="_blank"><img
                                    width="80" height="80"
                                    src="https://preview-tf.s3.envato.com/files/222177166/thumbnail.png"
                                    alt="Typology - Text Based Minimal WordPress Blog Theme "/></a></li>
                        <li>
                            <a href="https://themeforest.net/item/gridlove-creative-grid-style-news-magazine-wordpress-theme/17990371?ref=meks"
                               title="Gridlove - Creative Grid Style News & Magazine WordPress Theme"
                               target="_blank"><img width="80" height="80"
                                                    src="https://preview-tf.s3.envato.com/files/212670037/thumbnail.png"
                                                    alt="Gridlove - Creative Grid Style News & Magazine WordPress Theme "/></a>
                        </li>
                        <li>
                            <a href="https://themeforest.net/item/vlog-video-blog-magazine-wordpress-theme/15968884?ref=meks"
                               title="Vlog - Video Blog / Magazine WordPress Theme" target="_blank"><img width="80"
                                                                                                         height="80"
                                                                                                         src="https://preview-tf.s3.envato.com/files/195600775/vlog_thumbnail.png"
                                                                                                         alt="Vlog - Video Blog / Magazine WordPress Theme "/></a>
                        </li>
                        <li>
                            <a href="https://themeforest.net/item/herald-news-portal-magazine-wordpress-theme/13800118?ref=meks"
                               title="Herald - News Portal & Magazine WordPress Theme" target="_blank"><img
                                    width="80" height="80"
                                    src="https://preview-tf.s3.envato.com/files/162180131/avatar.jpg"
                                    alt="Herald - News Portal & Magazine WordPress Theme "/></a></li>
                        <li>
                            <a href="https://themeforest.net/item/sidewalk-elegant-personal-blog-wordpress-theme/11444883?ref=meks"
                               title="Sidewalk - Elegant Personal Blog WordPress Theme" target="_blank"><img
                                    width="80" height="80"
                                    src="https://preview-tf.s3.envato.com/files/133752784/sidewalk_thumbnail.jpg"
                                    alt="Sidewalk - Elegant Personal Blog WordPress Theme "/></a></li>
                        <li>
                            <a href="https://themeforest.net/item/voice-clean-newsmagazine-wordpress-theme/9646105?ref=meks"
                               title="Voice - Clean News/Magazine WordPress Theme" target="_blank"><img width="80"
                                                                                                        height="80"
                                                                                                        src="https://preview-tf.s3.envato.com/files/213467497/voice_avatar.png"
                                                                                                        alt="Voice - Clean News/Magazine WordPress Theme "/></a>
                        </li>
                    </ul>
                    <p class="mks_read_more"><a href="http://themeforest.net/user/meks/portfolio?ref=meks"
                                                target="_blank" class="more">View more</a></p>

                </div>
            </div>
        </aside>
    </div>

</div>