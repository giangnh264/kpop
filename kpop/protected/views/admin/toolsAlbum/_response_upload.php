<?php if(empty($error)):?>
<li class="ul-files success" id="song-toAlbum-<?php echo $index;?>">
<form id="S-<?php echo $index;?>">
<div class="row global_field">
<table width="100%">
<tr>
	<td><div id="sdx-song-<?php echo $index;?>"><span id="save-song-<?php echo $index;?>"><a onclick="AddSongToAlbum(<?php echo $index;?>)" href="javascript:void(0);">Save</a></span> | <a href="javascript:void(0);" onclick="$('#song-toAlbum-<?php echo $index;?>').remove()" >Delete</a></div></td>
	<td><div><?php echo $fileName;?></div></td>
	<td>Name</td>
	<td><input type="text" id="songName_<?php echo $index;?>" name="songInfo[<?php echo $index;?>][song_name]" value="<?php echo $rawname;?>" style="width: 200px;" />
	<input type="hidden" id="songFile_<?php echo $index;?>" name="songInfo[<?php echo $index;?>][song_file]" value="<?php echo $fileName;?>" style="width: 200px;" />
	</td>
	<td><a onclick="getComposerList(<?php echo $index;?>);">Chọn nhạc sỹ</a></td>
	<td><div class="composer-ids" id="composer_ids_<?php echo $index;?>"></div></td>
	<td><a onclick="getArtistList(<?php echo $index;?>);">Chọn ca sỹ</a></td>
	<td><div class="artist-ids" id="artist_ids_<?php echo $index;?>"></div></td>
</tr>
</table>
</div>
</form>
<div id="res-load-<?php echo $index;?>"></div>
</li>
<?php else:?>
<li class="error">
<div><?php echo $error;?></div>
</li>
<?php endif;?>