	
	<!-- Default -->
	
	<div class="in">			
	<?php
	foreach ($contents as $key=>$content) :
	?>
		<table width="850" border="0" cellspacing="0" cellpadding="10" class="table_main" >
		  <tr style="background-color:#d9d8d8; font-size:14px;">
			<td width="95%"><strong><?= $key ?></strong></td>
			<td width="5%"><strong>EDIT</strong></td>
		  </tr>
		  
	<?php 
		foreach ($content as $item) : 
		$attributes = array();
		foreach ($item["attributes"] as $attrib) {
			$attributes[$attrib["title"]] = $attrib["value"];
		}
	?>
		  <tr class="gray">
			<td><a href="/Pellucid/<?= $item["type"] ?>/<?= $item["id"] ?>"><?= $item["name"] ?></a></td>
			<td><a href="/Pellucid/admin/<?= $item["type"] ?>/<?= $item["id"] ?>">EDIT</a></td>
		  </tr>
		  
		  <tr class="collapsable">
			  <td colspan ="3">
				<span class="show">+</span>
				<pre>
<?php var_dump($attributes); ?>
				</pre>
			  </td>
		  </tr>
	<?php 
		endforeach; 
	?>
		</table>	
	<?php 
	endforeach; 
	?>
		
		
<!-- <?php var_dump($content); ?> //-->
	</div>
				
	<!-- /Default -->	