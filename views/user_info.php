<?php if($fract) : ?> 
	<div id="legend" class="">
		<legend class="">Player demographic</legend>
		<p class="help-block">This helps us to create better games for you.</p>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label">Full name</label>
	  <div class="controls">
		<input id="name" name="name" type="text" placeholder="" class="input-xlarge attribute" required="" value="<?= isset($attribute["name"]) ? $attribute["name"] : '' ?>">
	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label">E-mail</label>
	  <div class="controls">
		<input id="email" name="email" type="text" placeholder="" class="input-xlarge attribute" required="" value="<?= isset($user["email"]) ? $user["email"] : '' ?>">
		<input id="user_id" name="user_id" type="hidden" value="<?= isset($user["id"]) ? $user["id"] : '' ?>">
	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label">Street</label>
	  <div class="controls">
		<input id="adress_street_1" name="adress_street_1" type="text" placeholder="address line one" class="input-xlarge attribute" required="" value="<?= isset($attribute["adress_street_1"]) ? $attribute["adress_street_1"] : '' ?>">

	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label"></label>
	  <div class="controls">
		<input id="adress_street_2" name="adress_street_2" type="text" placeholder="address line two" class="input-xlarge attribute" value="<?= isset($attribute["adress_street_2"]) ? $attribute["adress_street_2"] : '' ?>">
	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label">ZIP code</label>
	  <div class="controls">
		<input id="adress_zip" name="adress_zip" type="text" placeholder="" class="input-xlarge attribute" required="" value="<?= isset($attribute["adress_zip"]) ? $attribute["adress_zip"] : '' ?>">
	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label">City</label>
	  <div class="controls">
		<input id="adress_city" name="adress_city" type="text" placeholder="" class="input-xlarge attribute" required="" value="<?= isset($attribute["adress_city"]) ? $attribute["adress_city"] : '' ?>">

	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label">Country</label>
	  <div class="controls">
		<input id="address_country" name="address_country" type="text" placeholder="" class="input-xlarge attribute" value="<?= isset($attribute["adress_country"]) ? $attribute["adress_country"] : '' ?>">
	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label">Year of birth</label>
	  <div class="controls">
		<input id="year_of_birth" name="year_of_birth" type="text" placeholder="YYYYY" class="input-xlarge attribute" required="" value="<?= isset($attribute["year_of_birth"]) ? $attribute["year_of_birth"] : '' ?>">
	  </div>
	</div>

	<!-- Textarea -->
	<div class="control-group">
	  <label class="control-label">Health information</label>
	  <div class="controls">                     
		<div class="textarea">
		  <textarea class="attribute" id="health_info" name="health_info"><?= isset($attribute["health_info"]) ? $attribute["health_info"] : '' ?></textarea>
		</div>
	  </div>
	</div>

	<!-- Multiple Radios -->
<!--	
	<div class="control-group">
	  <label class="control-label">Price group</label>
	  <div class="controls">
		<label class="radio">
		  <input type="radio" name="price_group" value="Group A" checked="checked" class="attribute">
		  Group A
		</label>
		<label class="radio">
		  <input type="radio" name="price_group" value="Group B" class="attribute">
		  Group B
		</label>
		<label class="radio">
		  <input type="radio" name="price_group" value="Group C" class="attribute">
		  Group C
		</label>
	  </div>
	</div>
//-->

	<!-- Multiple Checkboxes -->
	<div class="control-group">
	  <label class="control-label">Contact</label>
	  <div class="controls">
		<label class="checkbox">
		  <input type="checkbox" name="mail_ok" value="1" class="attribute" <?= isset($attribute["mail_ok"]) ? 'checked' : '' ?>>
		  I'm OK with you using my e-mail to contact me.
		</label>
	  </div>
	</div>

	<!-- Button -->
	<div class="control-group">
	  <label class="control-label"></label>
	  <div class="controls">
		<button id="submit" name="submit" class="btn btn-primary">Save!</button>
	  </div>
	</div>
<?php endif; ?>	