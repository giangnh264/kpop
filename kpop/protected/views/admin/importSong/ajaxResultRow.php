<?php 
if(count($imported))
echo '<tr >
	<td></td>
	<td class="odd">'.$imported['name'].'</td>
	<td >
		'.$imported['path'].'
	</td>
	<td>
		'.$imported['stt'].'
	</td>
</tr>';
    
else
echo '<tr >
	<td></td>
	<td class="odd">'.$notImport['name'].'</td>
	<td >
		'.$notImport['path'].'
	</td>
	<td>
		'.$notImport['stt'].'
	</td>
</tr>';
?>