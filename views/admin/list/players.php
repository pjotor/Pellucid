				
	<!-- Players -->
	
	<div class="in">			
		<table width="850" border="0" cellspacing="0" cellpadding="10" class="table_main" >
		  <tr style="background-color:#d9d8d8; font-size:14px;">
			<td width="55%"><strong>USER</strong></td>
			<td width="40%"><strong>EMAIL</strong></td>
			<td width="5%"><strong>EDIT</strong></td>
		  </tr>
		  
	<?php foreach ($content as $player) : 
		$attributes = array();
		foreach ($player["attributes"] as $attrib) {
			$attributes[$attrib["title"]] = $attrib["value"];
		}
	?>
		  <tr class="gray">
			<td><a href="/Pellucid/<?= $type ?>/<?= $player["id"] ?>"><?= $player["name"] ?></a></td>

		<?php if(isset($attributes["email"])) : ?>
			<td><a href="<?= $attributes["email"] ?>"><?= $attributes["email"] ?></a></td>
		<?php else : ?>
			<td>-</td>
		<?php endif; ?>
			
			<td><a href="/Pellucid/admin/<?= $type ?>/<?= $player["id"] ?>">EDIT</a></td>
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
	</div>
				
	<!-- /Players -->
	