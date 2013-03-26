<?php if($fract) : ?> 
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label">Game name</label>
	  <div class="controls">
		<input id="game" name="game" type="text" placeholder="" class="input-xlarge" required="" disabled="disabled" value="<?= $parent->name ?>">
		<input id="game_id" name="game_id" class="attribute" type="hidden" value="<?= $parent->id ?>">
	  </div>
	</div>
<?php endif; ?>