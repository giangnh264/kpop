<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <div class="fl">
	    <div class="row">
	        <?php echo $form->label($model,'code'); ?>
	        <?php echo $form->textField($model,'code', array('size'=>30)); ?>
	    </div>
	    <div class="row">
	        <?php echo $form->label($model,'name'); ?>
	        <?php echo $form->textField($model,'name', array('size'=>30)); ?>
	    </div>
		<div class="row">
			<label>Nhạc sỹ</label>
	    	<select name="is_composer" id="is_composer">
	    		<option value=""  <?php if($is_composer=='') echo 'selected';?>>Tất cả</option>
	    		<option value="1" <?php if($is_composer=='1') echo 'selected';?>>Có</option>
	    		<option value="2" <?php if($is_composer=='2') echo 'selected';?>>Không</option>
	    	</select>
		</div>
		<div class="row">
			<?php echo $form->label($model,'max_bitrate'); ?>
			<?php
			 	$bitrate = array('128'=>'128','192'=>'192','256'=>'256','320'=>'320');
				echo $form->dropDownList($model, 'max_bitrate', $bitrate, array('prompt'=>'Tất cả'));
			?>
		</div>
		<div class="row">
			<?php echo $form->label($model,'copyright'); ?>
			<!--<select name="copyright" id="copyright">
	    		<option value=""  <?php if($copyright=='') echo 'selected';?>>Tất cả</option>
	    		<option value="1" <?php if($copyright=='1') echo 'selected';?>>Có</option>
	    		<option value="2" <?php if($copyright=='2') echo 'selected';?>>Không</option>
	    	</select>-->
	    	<?php 
				$data = array(0=>'Tác Quyền', 1=>'Quyền Liên Quan');
				echo CHtml::dropDownList('ccp_type', $copyrightType, $data, array('prompt'=>'Tất cả'));
			?>
		</div>

	    <div class="row">
	        <?php echo $form->label($model,'artist_name'); ?>
	        <?php echo $form->textField($model,'artist_name', array('size'=>30)); ?>
	    </div>

        <?php /*
        <div class="row">
	        <?php echo $form->label($model,'artist_id');?>
	        <?php echo $form->textField($model,'artist_id', array('size'=>30)); ?>
                <p><i>(Gõ 0 để tìm những bài hát cần cập nhật ca sĩ)</i></p>
	    </div>
	    */?>


    </div>
    <div class="fl">
	    <div class="row">
	        <?php echo $form->label($model,'cp_id'); ?>
	        <?php #echo $form->textField($model,'cp_id', array('size'=>30)); ?>
	        <?php
	           $cp = CMap::mergeArray(
                                    array(''=> "Tất cả"),
                                       CHtml::listData($cpList, 'id', 'name')
                                    );
                echo CHtml::dropDownList("AdminSongModel[cp_id]", $model->cp_id, $cp )
	        ?>
	    </div>
	    <div class="row">
	        <?php echo $form->label($model,'genre_id'); ?>
	        <?php
	        	$genreId = isset($_GET["AdminSongModel"]["genre_id"])?$_GET["AdminSongModel"]["genre_id"]:"";
				$category = CMap::mergeArray(
									array(''=> "Tất cả"),
									   CHtml::listData($categoryList, 'id', 'name')
									);
                echo CHtml::dropDownList("AdminSongModel[genre_id]", $genreId, $category )
             ?>

	    </div>

	    <?php $style = ($this->type == AdminSongModel::ALL)?"display:block":"display:none"; ?>
	    <div class="row" style="<?php echo $style?>">
	        <?php echo $form->label($model,'status'); ?>
            <?php
               $status = array(
                                ''=> "Tất cả",
                                AdminSongModel::NOT_CONVERT=> "Chưa convert",
                                AdminSongModel::WAIT_APPROVED=> "Chờ duyệt",
                                AdminSongModel::ACTIVE=> "Đã duyệt",
                                AdminSongModel::CONVERT_FAIL=> "Convert lỗi",
                                AdminSongModel::DELETED=> "Đã xóa",
                                AdminSongModel::FEATURE=> "Chọn lọc",
                            );
                echo CHtml::dropDownList("AdminSongModel[status]",  $model->status, $status )
            ?>
	    </div>

        <div style="display:block" class="row">
            <label for="lyrics">Lyric</label>
            <select id="lyrics" name="lyrics">
                <option value="2" <?php if($lyric==2) echo "selected";?>>Tất cả</option>
                <option value="1" <?php if($lyric==1) echo "selected";?>>Có</option>
                <option value="0" <?php if($lyric==0) echo "selected";?>>Không</option>
            </select>
        </div>
		<div class="row">
            <?php echo $form->label($model,'created_time'); ?>
            <?php
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>'AdminSongModel[created_time]',
		       		'value'=>isset($_GET['AdminSongModel']['created_time'])?$_GET['AdminSongModel']['created_time']:'',
		        ));
		     ?>
        </div>
		<div class="row">
			<?php echo CHtml::label("Tên nhạc sỹ", "AdminSongModel_composer_name") ?>
			<?php
			$this->widget('application.widgets.admin.ArtistAuto', array(
					'fieldId' => 'AdminSongModel[composer_id]',
					'fieldName' => 'AdminSongModel[composer_name]',
					'fieldIdVal' => $model->composer_id,
					'fieldNameVal' => isset($_GET['AdminSongModel']['composer_name'])?$_GET['AdminSongModel']['composer_name']:"",
				)
			);

			?>
		</div>

	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
		<?php echo CHtml::resetButton('Reset') ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->