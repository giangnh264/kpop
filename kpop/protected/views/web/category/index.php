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
<!--<div class="herald-section container ">
    <div class="row">
        <div class="herald-module col-mod-main herald-main-content col-lg-9 col-md-9">

            <div class="herald-mod-wrap"><div class="herald-mod-head herald-cat-2"><div class="herald-mod-title"><h1 class="h6 herald-mod-h herald-color"><?php /*echo strtoupper($category->name);*/?></h1></div></div></div>

            <div class="row row-eq-height herald-posts">
                <?php
/*                foreach ($news as $item):
                */?>
                <article class="herald-lay-d post-140 post type-post status-publish format-standard has-post-thumbnail hentry category-travel">
                    <div class="row">

                        <div class="col-lg-6 col-xs-6 col-sm-5">
                            <div class="herald-post-thumbnail herald-format-icon-middle">
                                <a href="<?php /*echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));*/?>" title="The top 10 traveling taboos you should break">
                                    <img width="215" height="120" src="<?php /*echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;*/?>"
                                         class="attachment-herald-lay-d size-herald-lay-d wp-post-image" alt=""
                                         srcset="<?php /*echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;*/?> 215w,
                                         <?php /*echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;*/?> 990w,
                                         <?php /*echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;*/?> 1320w,
                                         <?php /*echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;*/?> 470w,
                                         <?php /*echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;*/?> 640w,
                                         <?php /*echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;*/?> 300w,
                                         <?php /*echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;*/?> 414w" sizes="(max-width: 215px) 100vw, 215px" data-wp-pid="1259">									</a>
                            </div>
                        </div>

                        <div class="col-lg-6 col-xs-6 col-sm-7 herald-no-pad">
                            <div class="entry-header">
                                <h2 class="entry-title h6"><a href="<?php /*echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));*/?>"><?php /*echo Formatter::smartCut($item->title, 100, 0); */?></a></h2>
                                <div class="entry-meta meta-small"><div class="meta-item herald-date"><span class="updated"><?php /*echo Formatter::formatTimeAgo($item->created_time);*/?></span></div></div>
                            </div>
                        </div>
                    </div>
                </article>
                <?php /*endforeach;*/?>
            </div>

        <?php /*$this->widget ( "application.widgets.web.common.VLinkPager", array (
            "pages" => $page,
            "maxButtonCount" => Yii::app ()->params ["constLimit"] ["pager.max.button.count"],
            "header" => "",
            "htmlOptions" => array ( "class" => "pager" )
            ) );*/?>

        </div>
        <div class="herald-sidebar col-lg-3 col-md-3 herald-sidebar-right" style="min-height: 1176px;">

            <div id="categories-2" class="widget widget_categories"><h4 class="widget-title h6"><span>Topics</span></h4>		<ul>
                    <li class="cat-item cat-item-48"><a href="http://demo.mekshq.com/herald/?cat=48"><span class="category-text">Celebrities</span><span class="count">5</span></a>
                    </li>
                    <li class="cat-item cat-item-6"><a href="http://demo.mekshq.com/herald/?cat=6"><span class="category-text">Entertainment</span><span class="count">7</span></a>
                    </li>
                    <li class="cat-item cat-item-3"><a href="http://demo.mekshq.com/herald/?cat=3"><span class="category-text">Fashion</span><span class="count">7</span></a>
                    </li>
                    <li class="cat-item cat-item-4"><a href="http://demo.mekshq.com/herald/?cat=4"><span class="category-text">Food &amp; Drinks</span><span class="count">10</span></a>
                    </li>
                    <li class="cat-item cat-item-43"><a href="http://demo.mekshq.com/herald/?cat=43"><span class="category-text">Movies</span><span class="count">5</span></a>
                    </li>
                    <li class="cat-item cat-item-42"><a href="http://demo.mekshq.com/herald/?cat=42"><span class="category-text">Music</span><span class="count">5</span></a>
                    </li>
                    <li class="cat-item cat-item-5"><a href="http://demo.mekshq.com/herald/?cat=5"><span class="category-text">Sports</span><span class="count">9</span></a>
                    </li>
                    <li class="cat-item cat-item-7"><a href="http://demo.mekshq.com/herald/?cat=7"><span class="category-text">Technology</span><span class="count">7</span></a>
                    </li>
                    <li class="cat-item cat-item-2 current-cat"><a href="http://demo.mekshq.com/herald/?cat=2"><span class="category-text">Travel</span><span class="count">7</span></a>
                    </li>
                </ul>
            </div><div id="herald_posts_widget-9" class="widget herald_posts_widget"><h4 class="widget-title h6"><span>Featured</span></h4>

                <div class="row ">

                    <article class="herald-lay-g post-203 post type-post status-publish format-standard has-post-thumbnail hentry category-food-and tag-earth tag-ecology tag-solar-energy">
                        <div class="row">

                            <div class="col-lg-4 col-xs-3">
                                <div class="herald-post-thumbnail">
                                    <a href="http://demo.mekshq.com/herald/?p=203" title="Grandma’s secret blueberry pie recipe revealed!">
                                        <img width="74" height="55" src="http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald024-74x55.jpg" class="attachment-herald-lay-g1 size-herald-lay-g1 wp-post-image" alt="" srcset="http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald024-74x55.jpg 74w, http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald024-111x83.jpg 111w, http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald024-215x161.jpg 215w, http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald024-300x225.jpg 300w" sizes="(max-width: 74px) 100vw, 74px" data-wp-pid="1163">			</a>
                                </div>
                            </div>

                            <div class="col-lg-8 col-xs-9 herald-no-pad">
                                <div class="entry-header">
                                    <span class="meta-category meta-small"><a href="http://demo.mekshq.com/herald/?cat=4" class="herald-cat-4">Food &amp; Drinks</a></span>

                                    <h2 class="entry-title h7"><a href="http://demo.mekshq.com/herald/?p=203">Grandma’s secret blueberry pie recipe revealed!</a></h2>
                                </div>
                            </div>

                        </div>
                    </article>
                    <article class="herald-lay-g post-180 post type-post status-publish format-standard has-post-thumbnail hentry category-sports tag-blog tag-magazine tag-technology-2">
                        <div class="row">

                            <div class="col-lg-4 col-xs-3">
                                <div class="herald-post-thumbnail">
                                    <a href="http://demo.mekshq.com/herald/?p=180" title="Little known facts about football and why they matter">
                                        <img width="74" height="55" src="http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald018-74x55.jpg" class="attachment-herald-lay-g1 size-herald-lay-g1 wp-post-image" alt="" srcset="http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald018-74x55.jpg 74w, http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald018-111x83.jpg 111w, http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald018-215x161.jpg 215w, http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald018-300x225.jpg 300w" sizes="(max-width: 74px) 100vw, 74px" data-wp-pid="1157">			</a>
                                </div>
                            </div>

                            <div class="col-lg-8 col-xs-9 herald-no-pad">
                                <div class="entry-header">
                                    <span class="meta-category meta-small"><a href="http://demo.mekshq.com/herald/?cat=5" class="herald-cat-5">Sports</a></span>

                                    <h2 class="entry-title h7"><a href="http://demo.mekshq.com/herald/?p=180">Little known facts about football and why they matter</a></h2>
                                </div>
                            </div>

                        </div>
                    </article>
                    <article class="herald-lay-g post-197 post type-post status-publish format-standard has-post-thumbnail hentry category-sports">
                        <div class="row">

                            <div class="col-lg-4 col-xs-3">
                                <div class="herald-post-thumbnail">
                                    <a href="http://demo.mekshq.com/herald/?p=197" title="Learn to play golf by practicing 15 minutes a day">
                                        <img width="74" height="55" src="http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald081-74x55.jpg" class="attachment-herald-lay-g1 size-herald-lay-g1 wp-post-image" alt="" srcset="http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald081-74x55.jpg 74w, http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald081-111x83.jpg 111w, http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald081-215x161.jpg 215w, http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald081-300x225.jpg 300w" sizes="(max-width: 74px) 100vw, 74px" data-wp-pid="1220">			</a>
                                </div>
                            </div>

                            <div class="col-lg-8 col-xs-9 herald-no-pad">
                                <div class="entry-header">
                                    <span class="meta-category meta-small"><a href="http://demo.mekshq.com/herald/?cat=5" class="herald-cat-5">Sports</a></span>

                                    <h2 class="entry-title h7"><a href="http://demo.mekshq.com/herald/?p=197">Learn to play golf by practicing 15 minutes a day</a></h2>
                                </div>
                            </div>

                        </div>
                    </article>
                    <article class="herald-lay-g post-192 post type-post status-publish format-standard has-post-thumbnail hentry category-fashion">
                        <div class="row">

                            <div class="col-lg-4 col-xs-3">
                                <div class="herald-post-thumbnail">
                                    <a href="http://demo.mekshq.com/herald/?p=192" title="Everything you ever need to known about scarves">
                                        <img width="74" height="55" src="http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald092-74x55.jpg" class="attachment-herald-lay-g1 size-herald-lay-g1 wp-post-image" alt="" srcset="http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald092-74x55.jpg 74w, http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald092-111x83.jpg 111w, http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald092-215x161.jpg 215w, http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald092-300x225.jpg 300w" sizes="(max-width: 74px) 100vw, 74px" data-wp-pid="1231">			</a>
                                </div>
                            </div>

                            <div class="col-lg-8 col-xs-9 herald-no-pad">
                                <div class="entry-header">
                                    <span class="meta-category meta-small"><a href="http://demo.mekshq.com/herald/?cat=3" class="herald-cat-3">Fashion</a></span>

                                    <h2 class="entry-title h7"><a href="http://demo.mekshq.com/herald/?p=192">Everything you ever need to known about scarves</a></h2>
                                </div>
                            </div>

                        </div>
                    </article>
                    <article class="herald-lay-g post-191 post type-post status-publish format-standard has-post-thumbnail hentry category-food-and">
                        <div class="row">

                            <div class="col-lg-4 col-xs-3">
                                <div class="herald-post-thumbnail">
                                    <a href="http://demo.mekshq.com/herald/?p=191" title="Pasta is the secret ingredient for a healthy lifestyle">
                                        <img width="74" height="55" src="http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald119-74x55.jpg" class="attachment-herald-lay-g1 size-herald-lay-g1 wp-post-image" alt="" srcset="http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald119-74x55.jpg 74w, http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald119-111x83.jpg 111w, http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald119-215x161.jpg 215w, http://demo.mekshq.com/herald/wp-content/uploads/2015/11/herald119-300x225.jpg 300w" sizes="(max-width: 74px) 100vw, 74px" data-wp-pid="1258">			</a>
                                </div>
                            </div>

                            <div class="col-lg-8 col-xs-9 herald-no-pad">
                                <div class="entry-header">
                                    <span class="meta-category meta-small"><a href="http://demo.mekshq.com/herald/?cat=4" class="herald-cat-4">Food &amp; Drinks</a></span>

                                    <h2 class="entry-title h7"><a href="http://demo.mekshq.com/herald/?p=191">Pasta is the secret ingredient for a healthy lifestyle</a></h2>
                                </div>
                            </div>

                        </div>
                    </article>

                </div>



            </div>
            <div class="herald-sticky">
                <div id="mks_ads_widget-15" class="widget mks_ads_widget">



                    <ul class="mks_adswidget_ul custom">
                        <li data-showind="0">
                            <a href="http://themeforest.net/item/herald-news-portal-magazine-wordpress-theme/13800118?ref=meks&amp;license=regular&amp;open_purchase_for_item_id=13800118&amp;purchasable=source" target="_blank">
                                <img src="http://mekshq.com/static/herald/banner300x316_white.jpg" alt="banner300x316_white.jpg" style="width:300px; height:316px;" width="300" height="316">
                            </a>
                        </li>
                    </ul>




                </div>			</div>

        </div>
    </div>
</div>

-->