	
	<!-- Default -->
	
	<div class="in">			
		<table width="850" border="0" cellspacing="0" cellpadding="10" class="table_main" >
		  <tr style="background-color:#d9d8d8; font-size:14px;">
			<td width="95%"><strong>NAME</strong></td>
			<td width="5%"><strong>EDIT</strong></td>
		  </tr>
		  
	<?php foreach ($content as $item) : 
		$attributes = array();
		foreach ($item["attributes"] as $attrib) {
			$attributes[$attrib["title"]] = $attrib["value"];
		}
	?>
		  <tr class="gray">
			<td><a href="/Pellucid/<?= $type ?>/<?= $item["id"] ?>"><?= $item["name"] ?></a></td>
			<td><a href="/Pellucid/admin/<?= $type ?>/<?= $item["id"] ?>">EDIT</a></td>
		  </tr>
		  
		  <tr class="collapsable">
			  <td colspan ="3">
				<span class="show">+</span>
				<pre>
<?php var_dump($attributes); ?>
				</pre>
			  </td>
		  </tr>
	<?php endforeach; ?>
		</table>	
		
		<pre>
<?php var_dump($content); ?>
		</pre>
	</div>
				
	<!-- /Default -->	