<?php
$homeEmbedUrl =  "http://".$_SERVER['SERVER_NAME'];
$url = $homeEmbedUrl.Yii::app()->createUrl("news/index", array('id'=>$news->id, 'url_key'=>Common::makeFriendlyUrl($news->title)));
$image =  Yii::app()->params['storage']['NewsUrl'] . $news->url_img;

$title = $news->title;
$description = $news->description;
Yii::app()->SEO->setMetaTitle($title);
Yii::app()->SEO->setMetaDescription($news->description);
Yii::app()->SEO->setMetaKeyword($title);
Yii::app()->SEO->setCanonical($url);
Yii::app()->SEO->addMetaProp('og:url',$url);
Yii::app()->SEO->addMetaProp('og:title',$title);
Yii::app()->SEO->addMetaProp('og:description',$description);
Yii::app()->SEO->addMetaProp('og:type',"music.song");
Yii::app()->SEO->addMetaProp('og:image',$image);
Yii::app()->SEO->addMetaProp('og:image:width','600');
Yii::app()->SEO->addMetaProp('og:image:height','600');
Yii::app()->SEO->addMetaProp('og:site_name',Yii::app()->name);
Yii::app()->SEO->addMetaProp('og:updated_time',time());

?>


















<div class="herald-section container">
    <article id="post-171"
             class="herald-single post-171 post type-post status-publish format-standard has-post-thumbnail hentry category-entertainment tag-blog tag-music-2 tag-studio">
        <div class="row">

            <div class="col-lg-9 col-md-9 col-mod-single col-mod-main">
                <?php $category = CategoryModel::model()->findByPk($news->category_id); ?>
                <header class="entry-header">
                    <span class="meta-category"><a href="http://demo.mekshq.com/herald/?cat=6"
                                                   class="herald-cat-6"><?php echo $category->name; ?></a></span>
                    <h1 class="entry-title h1"><?php echo $news->title ?></h1>
                    <div class="entry-meta entry-meta-single">
                        <div class="meta-item herald-date"><span
                                class="updated"><?php echo Formatter::formatTimeAgo($news->created_time); ?></span>
                        </div>
                        <div class="meta-item herald-views">3,291 Views</div>
                    </div>
                </header>

                <div class="row">

                    <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs herald-left">

                        <div class="entry-meta-wrapper ">

                            <div class="entry-meta entry-meta-single">
                                <div class="meta-item herald-comments"><a
                                        href="http://demo.mekshq.com/herald/?p=171#respond">Add Comment</a></div>
                            </div>

                            <ul class="herald-share">
                                <span class="herald-share-meta"><i class="fa fa-share-alt"></i>Share This!</span>
                                <div class="meta-share-wrapper" style="display: none;">
                                    <li class="facebook"><a href="javascript:void(0);"
                                                            data-url="http://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fdemo.mekshq.com%2Fherald%2F%3Fp%3D171&amp;t=Start+recording+like+a+pro+with+the+help+of+these+6+tips"><i
                                                class="fa fa-facebook"></i><span>Facebook</span></a></li>
                                    <li class="twitter"><a href="javascript:void(0);"
                                                           data-url="http://twitter.com/intent/tweet?url=http%3A%2F%2Fdemo.mekshq.com%2Fherald%2F%3Fp%3D171&amp;text=Start+recording+like+a+pro+with+the+help+of+these+6+tips"><i
                                                class="fa fa-twitter"></i><span>Twitter</span></a></li>
                                    <li class="gplus"><a href="javascript:void(0);"
                                                         data-url="https://plus.google.com/share?url=http%3A%2F%2Fdemo.mekshq.com%2Fherald%2F%3Fp%3D171"><i
                                                class="fa fa-google-plus"></i><span>Google Plus</span></a></li>
                                    <li class="pinterest"><a href="javascript:void(0);"
                                                             data-url="http://pinterest.com/pin/create/button/?url=http%3A%2F%2Fdemo.mekshq.com%2Fherald%2F%3Fp%3D171&amp;media=http%3A%2F%2Fdemo.mekshq.com%2Fherald%2Fwp-content%2Fuploads%2F2015%2F11%2Fherald043.jpg&amp;description=Start+recording+like+a+pro+with+the+help+of+these+6+tips"><i
                                                class="fa fa-pinterest"></i><span>Pinterest</span></a></li>
                                    <li class="linkedin"><a href="javascript:void(0);"
                                                            data-url="http://www.linkedin.com/shareArticle?mini=true&amp;url=http%3A%2F%2Fdemo.mekshq.com%2Fherald%2F%3Fp%3D171&amp;title=Start+recording+like+a+pro+with+the+help+of+these+6+tips"><i
                                                class="fa fa-linkedin"></i><span>LinkedIn</span></a></li>
                                </div>
                            </ul>
                        </div>

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-10">
                        <div class="entry-content herald-entry-content">
                            <?php echo $news->content; ?>

                            <div class="meta-tags">
                                <span>Tags</span>
                                <?php foreach ($news->relations_tag_news as $relations_tag_new) :?>
                                    <a href="#" rel="tag"><?php echo $relations_tag_new->tag->name;?></a>
                                <?php endforeach; ?>
                            </div>

                            <div class="herald-ad"><a
                                    href="http://themeforest.net/item/herald-news-portal-magazine-wordpress-theme/13800118?ref=meks&amp;license=regular&amp;open_purchase_for_item_id=13800118&amp;purchasable=source"><img
                                        src="http://mekshq.com/static/herald/banner728x90_dark.jpg" alt=""></a></div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="herald-sidebar col-lg-3 col-md-3 herald-sidebar-right">

                <div id="herald_posts_widget-9" class="widget herald_posts_widget"><h4 class="widget-title h6"><span>Tin tức liên quan</span>
                    </h4>

                    <div class="row ">
                        <?php
                        foreach ($news_relate as $item):
                            ?>
                            <article
                                class="herald-lay-g post-171 post type-post status-publish format-standard has-post-thumbnail hentry category-entertainment tag-blog tag-music-2 tag-studio">
                                <div class="row">

                                    <div class="col-lg-4 col-xs-3">
                                        <div class="herald-post-thumbnail">
                                            <a href="<?php echo Yii::app()->createUrl('news/index', array('id' => $item->id, 'url_key' => Common::makeFriendlyUrl($item->title))); ?>"
                                               title="Start recording like a pro with the help of these 6 tips">
                                                <img
                                                    src="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img; ?>"
                                                    class="attachment-herald-lay-g1 size-herald-lay-g1 wp-post-image"
                                                    alt=""

                                                    sizes="(max-width: 74px) 100vw, 74px" data-wp-pid="1182" width="74"
                                                    height="55"> </a>
                                        </div>
                                    </div>

                                    <div class="col-lg-8 col-xs-9 herald-no-pad">
                                        <div class="entry-header">
                                    <span class="meta-category meta-small"><a
                                            href="<?php echo Yii::app()->createUrl('category/index', array('url_key' => $category->url_key)); ?>"
                                            class="herald-cat-6"><?php echo $category->name; ?></a></span>

                                            <h2 class="entry-title h7"><a
                                                    href="<?php echo Yii::app()->createUrl('news/index', array('id' => $item->id, 'url_key' => Common::makeFriendlyUrl($item->title))); ?>"><?php echo Formatter::smartCut($item->title, 90, 0); ?></a>
                                            </h2>
                                        </div>
                                    </div>

                                </div>
                            </article>

                        <?php endforeach; ?>
                    </div>

                </div>

            </div>


        </div>
    </article>

</div>
