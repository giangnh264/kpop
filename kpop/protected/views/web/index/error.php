<div class="error_page">
	<div class="img-404">
		<img src="/web/images/not-found.png"/>
	</div>
	<div class="content-404">
		<?php
		$albumList = MainContentModel::getListByCollection('ALBUM_HOT', 1, 4);
		?>
		<div class="box_content">
			<ul class="list_playlist">
				<?php if ($albumList):
					$i=0;
					foreach ($albumList as $album):
						$urlKey = ($album->url_key)?$album->url_key:Common::makeFriendlyUrl(trim($album->name));
						$link = Yii::app()->createUrl("album/view",array("id"=>$album->id,"title"=>Common::makeFriendlyUrl($urlKey), "artist"=>Common::makeFriendlyUrl(trim($album->artist_name))));
						$linkArtist = Yii::app()->createUrl("/search")."?".http_build_query(array("q"=>CHtml::encode($album->artist_name)));
						$titleLink = $altImg = CHtml::encode($album->name).' - '.CHtml::encode($album->artist_name);
						?>
						<li class="<?php if($i == 1 || $i == 0) echo 'mart_0'; else echo '';?>">
							<a href="<?php echo $link ?>"><img src="<?php echo AvatarHelper::getAvatar("album", $album->id,200)?>" alt="<?php echo $altImg; ?>"/></a>
							<div class="info">
								<h3 class="name over-text"><a href="<?php echo $link ?>" title="<?php echo CHtml::encode($album->name);?>"><?php echo CHtml::encode($album->name);?></a></h3>
								<p class="singer over-text"><a href="<?php echo $linkArtist;?>" title="<?php echo $titleLink; ?>"><?php echo CHtml::encode($album->artist_name); ?></a></p>
							</div>
							<a title="<?php echo CHtml::encode($album->name); ?>" href="<?php echo $link ?>"><span class="circle-play"></span></a>
						</li>
						<?php
						$i++;
					endforeach;?>
				<?php else:?>
					<p class="pt10"><?php echo Yii::t("web", "Không có album nào"); ?></p>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</div>
<?php
if(YII_DEBUG):
?>
	<div class="traces">
		<h3>Error:</h3>
		<?php 
			echo $_GET['dev'];exit;
			if(isset($_GET['dev'])){				
					echo "<pre>";print_r($error);echo "</pre>";exit();  
			}			
		?>
		<h2>Stack Trace</h2>
		<?php $count=0; ?>
		<table style="width:100%;">
		<?php foreach($error['traces'] as $n => $trace): ?>
		<?php
			$cssClass='app expanded';
		?>
		<tr class="trace <?php echo $cssClass; ?>">
			<td class="number">
				#<?php echo $n; ?>
			</td>
			<td class="content">
				<div class="trace-file">
					<?php
						echo '&nbsp;';
						echo htmlspecialchars($trace['file'],ENT_QUOTES,Yii::app()->charset)."(".$trace['line'].")";
						echo ': ';
						if(!empty($trace['class']))
							echo "<strong>{$trace['class']}</strong>{$trace['type']}";
						echo "<strong>{$trace['function']}</strong>(";
						if(!empty($trace['args']))
							echo htmlspecialchars(argumentsToString($trace['args']),ENT_QUOTES,Yii::app()->charset);
						echo ')';
					?>
				</div>

			</td>
		</tr>
		<?php endforeach; ?>
		</table>
	</div>
<?php
endif;

function argumentsToString($args)
{
	$count=0;

	$isAssoc=$args!==array_values($args);

	foreach($args as $key => $value)
	{
		$count++;
		if($count>=5)
		{
			if($count>5)
				unset($args[$key]);
			else
				$args[$key]='...';
			continue;
		}

		if(is_object($value))
			$args[$key] = get_class($value);
		elseif(is_bool($value))
		$args[$key] = $value ? 'true' : 'false';
		elseif(is_string($value))
		{
			if(strlen($value)>64)
				$args[$key] = '"'.substr($value,0,64).'..."';
			else
				$args[$key] = '"'.$value.'"';
		}
		elseif(is_array($value))
		$args[$key] = 'array('.argumentsToString($value).')';
		elseif($value===null)
		$args[$key] = 'null';
		elseif(is_resource($value))
		$args[$key] = 'resource';

		if(is_string($key))
		{
			$args[$key] = '"'.$key.'" => '.$args[$key];
		}
		elseif($isAssoc)
		{
			$args[$key] = $key.' => '.$args[$key];
		}
	}
	$out = implode(", ", $args);

	return $out;
}
?>