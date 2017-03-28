<header id="header" class="main-header">
    <div class="top-header">
        <div class="container">


            <div class="vce-wrap-right">
                <div class="menu-social-menu-container">
                    <ul id="vce_social_menu" class="soc-nav-menu">
                        <li id="menu-item-59" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-59"><a href="https://www.facebook.com/mekshq"><span class="vce-social-name">Facebook</span></a>
                        </li>
                        <li id="menu-item-65" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-65"><a href="https://twitter.com/mekshq"><span class="vce-social-name">Twitter</span></a>
                        </li>
                        <li id="menu-item-73" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-73"><a href="https://plus.google.com/u/0/+meksHQgplus/posts"><span class="vce-social-name">Google Plus</span></a>
                        </li>
                        <li id="menu-item-216" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-216"><a href="http://instagram.com/"><span class="vce-social-name">Instagram</span></a></li>
                        <li id="menu-item-217" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-217"><a href="https://vk.com/"><span class="vce-social-name">VK</span></a></li>
                    </ul>
                </div>
            </div>


        </div>
    </div>
    <div class="container header-1-wrapper header-main-area">
        <div class="vce-res-nav">
            <a class="vce-responsive-nav" href="#sidr-main"><i class="fa fa-bars"></i></a>
        </div>
        <div class="site-branding">


            <h1 class="site-title">
                <a href="http://demo.mekshq.com/voice/" title="Voice" class="has-logo"><img src="http://demo.mekshq.com/voice/wp-content/themes/voice/images/voice_logo.png" alt="Voice"></a>
            </h1>

            <span class="site-description">A Magazine WordPress Theme with a Twist</span>


        </div>
    </div>

    <div class="header-bottom-wrapper">
        <div class="container">
            <nav id="site-navigation" class="main-navigation" role="navigation">
                <ul id="vce_main_navigation_menu" class="nav-menu">
                    <li id="menu-item-211" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-207 current_page_item menu-item-211">
                        <a href="<?php echo Yii::app()->params['base_url']?>">Home</a>
                    </li>
                    <?php
                    foreach ($categorys as $category):
                    ?>
                    <li id="menu-item" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-213 vce-mega-cat vce-cat-4">
                        <a href="<?php echo Yii::app()->createUrl('category/index', array('url_key'=>$category->url_key));?>" data-mega_cat_id="4"><?php echo $category->name;?></a>
                        <ul class="vce-mega-menu-wrapper">
                            <li class="vce-mega-menu-posts-wrap " data-numposts="5">
                                <ul>
                                <?php
                                    $news = WebNewsModel::model()->getNewsByCat($category->id, 5, 0);
                                    foreach ($news as $item):
                                ?>
                                    <li>

                                        <a class="mega-menu-img" href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>" title="Hipster Yoga at the End of the World">
                                            <img width="375" height="195" src="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?>" class="attachment-vce-lay-b size-vce-lay-b wp-post-image" alt="">
                                            <span class="vce-format-icon"> <i class="fa fa-play"></i> </span>
                                        </a>

                                        <a class="mega-menu-link" href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>" title="Hipster Yoga at the End of the World" style="height: 66px;">
                                            <?php echo Formatter::smartCut($item->title, 90, 0); ?></a>
                                    </li>
                                    <?php endforeach;?>

                                </ul>
                            </li>
                        </ul>
                    </li>
                    <?php endforeach;?>
                    <li id="menu-item-296" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-296"><a href="http://demo.mekshq.com/voice/?page_id=294">Contact</a>
                    </li>
                    <li class="search-header-wrap"><a class="search_header" href="javascript:void(0)">
                            <i class="fa fa-search"></i></a>
                        <ul class="search-header-form-ul">
                            <li>
                                <form class="search-header-form" action="http://demo.mekshq.com/voice/" method="get">
                                    <input name="s" class="search-input" size="20" type="text" value="Type here to search..." onfocus="(this.value == 'Type here to search...') &amp;&amp; (this.value = '')" onblur="(this.value == '') &amp;&amp; (this.value = 'Type here to search...')" placeholder="Type here to search..."></form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>