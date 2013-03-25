<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Create a <?= $type; ?>!</title>
  
  <script type='text/javascript' src='http://code.jquery.com/jquery-1.8.2.js'></script>
  <link rel="stylesheet" type="text/css" href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css">
  <script type='text/javascript' src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.1.0/bootstrap.min.js"></script>


<script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){

	$("#submit").click(function(e){
		e.preventDefault();
		
		var saveData = {
				'type':'<?= $type; ?>',
				'name':$("input[name=name]").val(),
				'tags':$("input[name=tags]").length ? $("input[name=tags]").val() : "", 
			}		

		switch(saveData.type) {
			case "game":
				saveData['attrib[type]'] = ['visibility','pitch','description','date','location','price'];
				saveData['attrib[value]'] = [
					$("input[name=visible]").val(),
					$("textarea[name=pitch]").val(),
					$("textarea[name=description]").val(),
					$("input[name=date]").val(),
					$("input[name=location]").val(),
					$("input[name=price]").val()
				];
				break;
			case "player":
				saveData['game'] = $("input[name=game]").val();
				saveData['attrib[type]'] = ['email','adress_street_1',
				'adress_street_2','adress_zip','adress_city',
				'adress_city','year_of_birth','health_info',
				'price_group','mail_ok'];
				saveData['attrib[value]'] = [
					$("input[name=email]").val(),
					$("textarea[name=adress_street_1]").val(),
					$("textarea[name=adress_street_2]").val(),
					$("input[name=adress_zip]").val(),
					$("input[name=adress_city]").val(),
					$("input[name=address_country]").val(),
					$("input[name=year_of_birth]").val(),
					$("textarea[name=health_info]").val(),
					$("input[type=radio]:checked").val(),
					!!$("input[name=mail_ok]:checked").length
				];			
				break;
			case "character":
				saveData['player'] = $("input[name=player]").val();
				saveData['attrib[type]'] = ['email','adress_street_1',
				'adress_street_2','adress_zip','adress_city',
				'adress_city','year_of_birth','health_info',
				'price_group','mail_ok'];
				saveData['attrib[value]'] = [
					$("input[name=email]").val(),
					$("textarea[name=adress_street_1]").val(),
					$("textarea[name=adress_street_2]").val(),
					$("input[name=adress_zip]").val(),
					$("input[name=adress_city]").val(),
					$("input[name=address_country]").val(),
					$("input[name=year_of_birth]").val(),
					$("textarea[name=health_info]").val(),
					$("input[type=radio]:checked").val(),
					!!$("input[name=mail_ok]:checked").length
				];			
				break;				
		}
			
		$.post("/Pellucid/new/<?= $type; ?>",saveData, function(resp) {
			$("#mod").html(resp).modal();
		});

	});
});//]]>  
</script>


</head>
<body>

  <form class="form-horizontal">
    <fieldset>
	
<?php 
switch($type) {
	case "game":
?>
  
      <div id="legend" class="">
        <legend class="">New Game</legend>
      </div>
    <div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">Name</label>
          <div class="controls">
            <input type="text" placeholder="a catchy name" class="input-xlarge" name="name">
            <p class="help-block">This is the name that will be listed in the games lists</p>
          </div>
        </div>

    <div class="control-group">
          <label class="control-label">Visibility</label>
          <div class="controls">
      <!-- Inline Radios -->
      <label class="radio inline">
        <input type="radio" value="1" name="visible" checked="checked">
        Public
      </label>
      <label class="radio inline">
        <input type="radio" value="2" name="visible">
        Direct link only (unlisted)
      </label>
      <label class="radio inline">
        <input type="radio" value="0" name="visible">
        Hidden
      </label>
  </div>
        </div>

    <div class="control-group">

          <!-- Textarea -->
          <label class="control-label">Pitch (optional)</label>
          <div class="controls">
            <div class="textarea">
                  <textarea type="" class="" style="margin: 0px; width: 269px; height: 45px;" name="pitch"> </textarea>
            </div>
          </div>
        </div>

    <div class="control-group">

          <!-- Textarea -->
          <label class="control-label">Description (optional)</label>
          <div class="controls">
            <div class="textarea">
                  <textarea type="" class="" style="margin: 0px; width: 269px; height: 117px;" name="description"> </textarea>
            </div>
          </div>
        </div>

    

    <div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">Tags (optional)</label>
          <div class="controls">
            <input type="text" placeholder="comma separated (e.g. zombies, bunnys)" name="tags" class="input-xlarge">
            <p class="help-block"></p>
          </div>
        </div>

    

    <div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">Date (optional)</label>
          <div class="controls">
            <input type="date" placeholder="yyyy-mm-dd" class="input-xlarge" name="date">
            <p class="help-block">When is the game?</p>
          </div>
        </div>

    

    <div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">Location (optional)</label>
          <div class="controls">
            <input type="text" placeholder="city, country or GPS" class="input-xlarge" name="location">
            <p class="help-block">This helps players to find games close by</p>
          </div>
        </div>

    <div class="control-group">
          <label class="control-label">Price range</label>
          <div class="controls">
      <!-- Multiple Radios -->
      <label class="radio">
        <input type="radio" value="0" name="price" checked="checked">
        Free
      </label>
      <label class="radio">
        <input type="radio" value="1" name="price">
        Low (&lt; &euro;10)
      </label>
      <label class="radio">
        <input type="radio" value="2" name="price">
        Moderate (&euro;10 - &euro;30)
      </label>
      <label class="radio">
        <input type="radio" value="3" name="price">
        Medium (&euro;30 - &euro;60)
      </label>
      <label class="radio">
        <input type="radio" value="4" name="price">
        High (&gt; &euro;60)
      </label>
  </div>

        </div>

    <div class="control-group">
		<label class="control-label"></label>

		<!-- Button -->
		<div class="controls">
			<button class="btn btn-primary" id="submit">Create Game!</button>
		</div>
    </div>
<?php 
	break;
	case "player":
?>
	<div id="legend" class="">
		<legend class="">Register Player</legend>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label">Game name</label>
	  <div class="controls">
		<input id="game" name="game" type="text" placeholder="" class="input-xlarge" required="" disabled="disabled" value="<?= $parent->name ?>">
		<input id="game_id" name="game_id" type="hidden" value="<?= $parent->id ?>">
	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label">Full name</label>
	  <div class="controls">
		<input id="name" name="name" type="text" placeholder="" class="input-xlarge" required="">
	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label">E-mail</label>
	  <div class="controls">
		<input id="email" name="email" type="text" placeholder="" class="input-xlarge" required="" value="<?= $user ? $user->email : '' ?>">
	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label">Street</label>
	  <div class="controls">
		<input id="adress_street_1" name="adress_street_1" type="text" placeholder="address line one" class="input-xlarge" required="">

	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label"></label>
	  <div class="controls">
		<input id="adress_street_2" name="adress_street_2" type="text" placeholder="address line two" class="input-xlarge">
	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label">ZIP code</label>
	  <div class="controls">
		<input id="adress_zip" name="adress_zip" type="text" placeholder="" class="input-xlarge" required="">
	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label">City</label>
	  <div class="controls">
		<input id="adress_city" name="adress_city" type="text" placeholder="" class="input-xlarge" required="">

	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label">Country</label>
	  <div class="controls">
		<input id="address_country" name="address_country" type="text" placeholder="" class="input-xlarge">
	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label">Year of birth</label>
	  <div class="controls">
		<input id="year_of_birth" name="year_of_birth" type="text" placeholder="YYYYY" class="input-xlarge" required="">
	  </div>
	</div>

	<!-- Textarea -->
	<div class="control-group">
	  <label class="control-label">Health information</label>
	  <div class="controls">                     
		<div id="health_info" name="health_info" class="textarea">
		  <textarea></textarea>
		</div>
	  </div>
	</div>

	<!-- Multiple Radios -->
	<div class="control-group">
	  <label class="control-label">Price group</label>
	  <div class="controls">
		<label class="radio">
		  <input type="radio" name="price_group" value="Group A" checked="checked">
		  Group A
		</label>
		<label class="radio">
		  <input type="radio" name="price_group" value="Group B">
		  Group B
		</label>
		<label class="radio">
		  <input type="radio" name="price_group" value="Group C">
		  Group C
		</label>
	  </div>
	</div>

	<!-- Multiple Checkboxes -->
	<div class="control-group">
	  <label class="control-label">Contact</label>
	  <div class="controls">
		<label class="checkbox">
		  <input type="checkbox" name="mail_ok" value="I'm OK with you using my e-mail to contact me.">
		  I'm OK with you using my e-mail to contact me.
		</label>
	  </div>
	</div>

	<!-- Button -->
	<div class="control-group">
	  <label class="control-label"></label>
	  <div class="controls">
		<button id="submit" name="submit" class="btn btn-primary">Register Me!</button>
	  </div>
	</div>
<?php 
	break;
	case "character":
?>
<?php 
	break;
	case "group":
?>
<?php 
	break;
	case "plot":
?>
<?php 
	break;
	case "user":
?>
<?php 
	break; 
	default:
		echo "Creation of " . $type . " is not implemented yet.";
}
?>		
    </fieldset>
  </form>

  <div id="mod" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
</body>


</html>