<?php if($fract) : ?> 
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
        <input class="attribute" type="radio" value="1" name="visible" checked="checked">
        Public
      </label>
      <label class="radio inline">
        <input class="attribute" type="radio" value="2" name="visible">
        Direct link only (unlisted)
      </label>
      <label class="radio inline">
        <input class="attribute" type="radio" value="0" name="visible">
        Hidden
      </label>
  </div>
        </div>

    <div class="control-group">

          <!-- Textarea -->
          <label class="control-label">Pitch (optional)</label>
          <div class="controls">
            <div class="textarea">
                  <textarea type="" class="attribute" style="margin: 0px; width: 269px; height: 45px;" name="pitch"> </textarea>
            </div>
          </div>
        </div>

    <div class="control-group">

          <!-- Textarea -->
          <label class="control-label">Description (optional)</label>
          <div class="controls">
            <div class="textarea">
                  <textarea type="" class="attribute" style="margin: 0px; width: 269px; height: 117px;" name="description"> </textarea>
            </div>
          </div>
        </div>

    <div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">Tags (optional)</label>
          <div class="controls">
            <input type="text" placeholder="comma separated (e.g. zombies, bunnys)" name="tags" class="input-xlarge attribute">
            <p class="help-block"></p>
          </div>
        </div>

    <div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">Date (optional)</label>
          <div class="controls">
            <input type="date" placeholder="yyyy-mm-dd" class="input-xlarge attribute" name="date">
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
        <input class="attribute" type="radio" value="0" name="price" checked="checked">
        Free
      </label>
      <label class="radio">
        <input class="attribute" type="radio" value="1" name="price">
        Low (&lt; &euro;10)
      </label>
      <label class="radio">
        <input class="attribute" type="radio" value="2" name="price">
        Moderate (&euro;10 - &euro;30)
      </label>
      <label class="radio">
        <input class="attribute" type="radio" value="3" name="price">
        Medium (&euro;30 - &euro;60)
      </label>
      <label class="radio">
        <input class="attribute" type="radio" value="4" name="price">
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
<?php endif; ?>	