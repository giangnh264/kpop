<div class="header-trending hidden-xs hidden-sm">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <?php
                        $news = WebNewsModel::model()->getLastet(6, 0);
                        foreach ($news as $item):
                    ?>
                    <div class="col-lg-2 col-md-2">
                        <div class="herald-post-thumbnail">
                            <a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>$item->url_key));?>"
                               title="<?php echo $item->title;?>">
                                <img width="150" height="150" src="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?>" class="attachment-thumbnail size-thumbnail wp-post-image"
                                     alt="" srcset="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 150w, <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 65w, <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 180w,
                                      <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 300w, <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 600w"
                                     sizes="(max-width: 150px) 100vw, 150px" data-wp-pid="1163"/></a>
                        </div>
                        <h4 class="h6"><a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>$item->url_key));?>"><?php echo Formatter::smartCut($item->title, 80, 0); ?></a></h4></div>
                   <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
</div>
