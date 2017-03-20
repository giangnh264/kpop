<header id="header" class="herald-site-header">
    <div class="header-middle herald-header-wraper hidden-xs hidden-sm">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 hel-el">

                    <div class="hel-l herald-go-hor">
                        <div class="site-branding">
                            <h1 class="site-title h1"><a href="<?php echo Yii::app()->params['base_url']?>" rel="home"><img
                                        class="herald-logo"
                                        src="<?php echo Yii::app()->request->baseUrl?>/web/images/logo-kpop.png" alt="Herald"></a></h1>
                        </div>
                    </div>

                    <div class="hel-r herald-go-hor">
                        <div class="herald-ad hidden-xs"><a
                                href="#"><img src="<?php echo Yii::app()->request->baseUrl?>/web/images/banner-kfun.png" alt="All KPOP"/></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="header-bottom herald-header-wraper hidden-sm hidden-xs">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 hel-el">

                <div class="hel-l">
                    <nav class="main-navigation herald-menu">
                        <ul id="menu-herald-main" class="menu">
                            <li id="menu-item-984"
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-207 current_page_item current-menu-ancestor current-menu-parent current_page_parent current_page_ancestor menu-item-984">
                                <a href="<?php echo Yii::app()->params['base_url']?>">Home</a>
                            </li>
                            <?php
                            foreach ($categorys as $category):
                            ?>
                            <li id="menu-item-1354"
                                class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-1354 herald-mega-menu">
                                <a href="http://demo.mekshq.com/herald/?cat=6"><?php echo strtoupper($category->name);?></a>
                                <ul class="sub-menu">
                                    <li class="container herald-section ">
                                        <div class="row">
                                            <div class="herald-module col-lg-9">
                                                <div class="row row-eq-height">
                                                    <?php
                                                    $news = WebNewsModel::model()->getNewsByCat($category->id, 4, 0);
                                                    foreach ($news as $item):
                                                    ?>
                                                    <article
                                                        class="herald-lay-i post-171 post type-post status-publish format-standard has-post-thumbnail hentry category-entertainment tag-blog tag-music-2 tag-studio">
                                                        <div class="herald-post-thumbnail herald-format-icon-small">
                                                            <a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>$item->url_key));?>"
                                                               title="Start recording like a pro with the help of these 6 tips">
                                                                <img width="215" height="120"  src="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?>" class="attachment-herald-lay-d size-herald-lay-d wp-post-image"
                                                                     alt="<?php echo $item->title;?>"
                                                                     srcset="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 215w, <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 990w, <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 1320w, images//herald043-470x264.jpg 470w, <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 640w, <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 300w, <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 414w"
                                                                     sizes="(max-width: 215px) 100vw, 215px" data-wp-pid="1182"/> </a>
                                                        </div>

                                                        <div class="entry-header">
                                                                <span class="meta-category meta-small"><a href="#" class="herald-cat-6"><?php echo strtoupper($category->name);?></a></span>

                                                            <h2 class="entry-title h6"><a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>$item->url_key));?>"><?php echo Formatter::smartCut($item->title, 90, 0); ?></a></h2>
                                                            <div class="entry-meta meta-small">
                                                                <div class="meta-item herald-date"><span class="updated">6 days ago</span></div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                    <?php endforeach;?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <?php endforeach;?>
                        </ul>
                    </nav>
                    <div class="herald-menu-popup-search">
                        <span class="fa fa-search"></span>
                        <div class="herald-in-popup">
                            <form class="herald-search-form" action="http://demo.mekshq.com/herald/" method="get">
                                <input name="s" class="herald-search-input" type="text" value=""
                                       placeholder="Type here to search..."/>
                                <button type="submit" class="herald-search-submit"></button>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="hel-r">
                    <ul id="menu-herald-social" class="herald-soc-nav">
                        <li id="menu-item-1037"
                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1037"><a
                                href="https://www.facebook.com/Mr.Koigiang"><span
                                    class="herald-social-name">Facebook</span></a></li>
                        <li id="menu-item-1038"
                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1038"><a
                                href="https://twitter.com/koigiang"><span
                                    class="herald-social-name">Twitter</span></a></li>
                        <li id="menu-item-1039"
                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1039"><a
                                href="https://plus.google.com/u/0/107033946089516550101"><span
                                    class="herald-social-name">Google+</span></a></li>
                        <li id="menu-item-1040"
                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1040"><a
                                href="https://www.instagram.com/koigiang/"><span class="herald-social-name">Instagram</span></a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include_once '_newest.php';?>
</header>