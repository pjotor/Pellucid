<?
  //Global settings
  require_once('inc/settings.php');
  //DB & Template Libs
  require_once('inc/libs.php');

  $games = R::findAll('game',' ORDER BY created DESC ');
  $players = R::findAll('player',' ORDER BY created DESC ');
  $characters = R::findAll('character',' ORDER BY created DESC ');
  $plots = R::findAll('plot',' ORDER BY created DESC ');
  $playerGroups = R::find('group',' type = ? ORDER BY created DESC ', array('playergroup'));
  $characterGroups = R::find('group',' type = ? ORDER BY created DESC ', array('charactergroup'));
?>
<style>
  select, input, label { width: 200px; margin: 2.5px; display: inline-block; vertical-align: top; }
  input[type='submit'], input[type='reset'] { width: 407px; }
  fieldset { width: 450px; float: left; }
  
  .attr > button { width: 25px; }
  #attributes { margin-bottom: 5px; }
</style>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#attributes").on("click", "button", function(e){ 
    e.preventDefault();
    if($(this).text() == "-") {
      $(this).parent().remove();
      refreshAttr();
      return;
    }
    var newAttr = $(this).parent().clone();
    newAttr.children("input").each(function(){ $(this).val(null); });
    newAttr.appendTo("#attributes");
    
    $(this).parent().removeClass("add").addClass("rem").end().text("-");
    refreshAttr();
  });
  
  function refreshAttr() {
    $("#attributes > div").each(function(i,n){
      $(this).children(".type").attr("name", "attrib[type][" + i + "]");
      $(this).children(".val").attr("name", "attrib[value][" + i + "]");
    });
  }
  
  $("#show").on("change","select", function(){ 
    var type = $(this).attr("name").replace("show:","");
    $.post("engine.php",{action:'get', type:type, id:$(this).val()}, function(resp){ 
      switch(type) {
        case "game":
          show("player", resp[0].players);
        break;
        case "player":
          show("character", resp[0].characters);
        break;
        case "character":
          show("plot", resp[0].players);
        break;
      }
    });    
  });
  
  $("#show").on("click","input[type='reset']", function(){ 
    $("#show select:not(:first)").children().remove().end().attr("disabled",true);
  });
  
  function show(type, list) {
    var sel = $("select[name='show:" + type + "']");
    sel.children().remove();
    var opt;
    $.each(list, function(i,n){
      opt = $("<option/>");
      opt.text(n.name).val(n.id);
      opt.appendTo(sel);
    });
    sel.attr("disabled",false);
  }
});
</script>

<form action="engine.php" method="post">
  <fieldset>
  <legend>Inputs:</legend>
  
  <label for="type">Resource type:</label>
  <select name="type">
    <option value="game">Game</option>
    <option value="player">Player</option>
    <option value="character">Character</option>
    <option value="plot">Plot</option>
    <option value="playerGroup">Group (players)</option>
    <option value="characterGroup">Group (characters)</option>
  </select><br/>
  
  <label for="name">Name:</label>
  <input type="text" name="name" value="" placeholder="name"/><br/>

  <label for="attributes">Attributes:</label>
  <div id="attributes">
    <div class="attr add">
      <input type="text" class="type" name="attrib[type][]" value="" placeholder="type"/>
      <input type="text" class="val" name="attrib[value][]" value="" placeholder="value"/>
      <button>+</button>
    </div>
  </div>

  <label for="tags">Tags:</label>
  <input type="text" name="tags" value="" placeholder="comma separated.."/><br/>

  <label for="game">Games:</label>  
  <select name="game">
  <?php foreach($games as $item): ?>
    <option value="<?php echo $item->id; ?>"><?php echo htmlspecialchars($item->name); ?></option>
  <?php endforeach; ?>
  </select><br/>
  
  <label for="plots">Plots:</label>  
  <select name="plots">
  <?php foreach($plots as $item): ?>
    <option value="<?php echo $item->id; ?>"><?php echo htmlspecialchars($item->name); ?></option>
  <?php endforeach; ?>
  </select><br/>  
  
  <label for="players[]">Players:</label>  
  <select name="players[]" multiple="true" size="3">
  <?php foreach($players as $item): ?>
    <option value="<?php echo $item->id; ?>"><?php echo htmlspecialchars($item->name); ?></option>
  <?php endforeach; ?>
  </select><br/>
  
  <label for="characters[]">Characters:</label>    
  <select name="characters[]" multiple="true" size="3">
  <?php foreach($characters as $item): ?>
    <option value="<?php echo $item->id; ?>"><?php echo htmlspecialchars($item->name); ?></option>
  <?php endforeach; ?>
  </select></br>  
  
  <label for="playerGroups">Player groups:</label>    
  <select name="playerGroups">
  <?php foreach($playerGroups as $item): ?>
    <option value="<?php echo $item->id; ?>"><?php echo htmlspecialchars($item->name); ?></option>
  <?php endforeach; ?>
  </select><br/>
  
  <label for="characterGroups">Character groups:</label>    
  <select name="characterGroups">
  <?php foreach($characterGroups as $item): ?>
    <option value="<?php echo $item->id; ?>"><?php echo htmlspecialchars($item->name); ?></option>
  <?php endforeach; ?>
  </select><br/>  

  <input type="submit" name="action" value="save" />
  
  </fieldset>
</form>

<form id="show">
<fieldset>
  <legend>Show:</legend>

  <label for="show:game">Games:</label>  
  <select name="show:game" multiple="true" size="2">
  <?php foreach($games as $item): ?>
    <option value="<?php echo $item->id; ?>"><?php echo htmlspecialchars($item->name); ?></option>
  <?php endforeach; ?>
  </select>
  <label for="show:player">Players:</label>  
  <select name="show:player" multiple="true" size="2" disabled="true">
  </select>
  <br/>

  <label for="show:character">Characters:</label>  
  <select name="show:character" multiple="true" size="2" disabled="true">
  </select>
  <label for="show:plot">Plots:</label>  
  <select name="show:plot" multiple="true" size="2" disabled="true">
  </select>
  <br/>  
  

  <label for="show:playerGroup">Player groups:</label>  
  <select name="show:playerGroup" multiple="true" size="2" disabled="true">
  </select>
  <label for="show:playerGroupPlayers">Players:</label>  
  <select name="show:playerGroupPlayers" multiple="true" size="2" disabled="true">
  </select>
  <br/>  
  
  <label for="show:characterGroup">Character groups:</label>  
  <select name="show:characterGroup" multiple="true" size="2" disabled="true">
  </select>
  <label for="show:characterGroupCharacters">Characters:</label>  
  <select name="show:characterGroupCharacters" multiple="true" size="2" disabled="true">
  </select>
  <br/>    
  
  <input type="reset">
  </fieldset>
</form>