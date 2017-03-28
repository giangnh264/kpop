<div class="vce-module-columns">
    <?php foreach ($list_data as $data): ?>
    <div id="main-box-3" class="main-box vce-border-top main-box-half ">
        <h3 class="main-box-title cat-<?php echo $data[0]['id']?>"><?php echo $data[0]['name']?></h3>
        <div class="main-box-inside ">
            <article
                class="vce-post vce-lay-c post-192 post type-post status-publish format-video has-post-thumbnail hentry category-fashion post_format-post-format-video">
                <div class="meta-image">
                    <a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$data['news'][0]['id'], 'url_key'=>Common::makeFriendlyUrl($data['news'][0]['title'])));?>" title="<?php echo $data['news'][0]['title'];?>">
                        <img width="375" height="195" src="<?php echo Yii::app()->params['storage']['NewsUrl'] . $data['news'][0]['url_img'];?>" class="attachment-vce-lay-b size-vce-lay-b wp-post-image" alt=""/>
                    </a>
                </div>

                <header class="entry-header">
                                    <span class="meta-category"><a href="<?php echo Yii::app()->createUrl('category/index', array('url_key'=>$data[0]['url_key']));?>" class="category-<?php echo $data[0]['id']?>"><?php echo $data[0]['name']?></a></span>
                    <h2 class="entry-title"><a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$data['news'][0]['id'], 'url_key'=>Common::makeFriendlyUrl($data['news'][0]['title'])));?>"
                                               title="<?php echo $data['news'][0]['title'];?>"><?php echo Formatter::smartCut($data['news'][0]['title'],50, 0);?></a></h2>
                    <div class="entry-meta">
                        <div class="meta-item date"><span class="updated"><?php echo Formatter::formatTimeAgo($data['news'][0]['created_time']);?></span></div>
                    </div>
                </header>

                <div class="entry-content">
                    <p><?php echo Formatter::smartCut($data['news'][0]['description'],95, 0);?></p>
                </div>
            </article>

            <div class="vce-loop-wrap">
                <?php   for($i=1;$i< count($data['news']); $i++) :?>
                    <article
                        class="vce-post vce-lay-d post-144 post type-post status-publish format-standard has-post-thumbnail hentry category-fashion">
                        <div class="meta-image">
                            <a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>"
                               title="Staying in Fashion With the Perfect Accessory">
                                <img width="145" height="100"
                                     src="<?php echo Yii::app()->params['storage']['NewsUrl'] . $data['news'][$i]['url_img'];?>"
                                     class="attachment-vce-lay-d size-vce-lay-d wp-post-image" alt=""
                                     srcset="<?php echo Yii::app()->params['storage']['NewsUrl'] . $data['news'][$i]['url_img'];?> 145w,
                                            <?php echo Yii::app()->params['storage']['NewsUrl'] . $data['news'][$i]['url_img'];?> 380w"
                                     sizes="(max-width: 145px) 100vw, 145px"/> </a>
                        </div>
                        <header class="entry-header"> <span class="meta-category">
                                <a href="<?php echo Yii::app()->createUrl('category/index', array('url_key'=>$data[0]['url_key']));?>"  class="category-4"><?php echo $data[0]['name'];?></a></span>
                            <h2 class="entry-title">
                                <a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$data['news'][$i]['id'], 'url_key'=>Common::makeFriendlyUrl($data['news'][$i]['title'])));?>" title="<?php echo $data['news'][$i]['title'];?>"><?php echo Formatter::smartCut($data['news'][$i]['title'],45, 0);?></a></h2>
                        </header>

                    </article>
                <?php endfor;?>

            </div>

        </div>
    </div>
    <?php endforeach;?>
</div>
