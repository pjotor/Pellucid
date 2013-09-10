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
				'tags':$("input[name=tags]").val() || "", 
				'attrib[type]':[],
				'attrib[value]':[]
			}		

		var n;
		$(".attribute, .bean").each(function(i,o){ 
			n = $(o); 
			if( $.inArray(n.attr("type"), ["radio", "checkbox"]) > -1) {
				if(n.is(":checked")) {
					if(n.hasClass("bean")) {
						saveData[n.attr("name")] = n.val();
					} else {
						saveData['attrib[type]'].push(n.attr("name"));
						saveData['attrib[value]'].push(n.val());
					}
				}			
			} else if(n.val().length) {
				if(n.hasClass("bean")) {
					saveData[n.attr("name")] = n.val();
				} else {			
					saveData['attrib[type]'].push(n.attr("name"));
					saveData['attrib[value]'].push(n.val());
				}
			}			
		});
/*
		switch(saveData.type){
			case "player":
				saveData['user'] = $("input[name=user_id]").val();
				saveData['game'] = $("input[name=game_id]").val();
			break;
			case "character":
				saveData['players'] = $("input[name=players]").val();		
				saveData['game'] = $("input[name=game_id]").val();
			break;
			case "realation":
				saveData['character[init]'] = $("input[name=inits]").val();		
				saveData['character[recip]'] = $("input[name=recips]").val();
				saveData['game'] = $("input[name=game_id]").val();
			break;
			case "plot":
				saveData['parent'] = $("input[name=parent_id]").val() || "";
				saveData['characters'] = $("input[name=characters]").val() || "";
				saveData['group'] = $("input[name=group]").val() || "";
				saveData['game'] = $("input[name=game_id]").val();
			break;	
			case "user":
		
			break;					
		}
*/
		$.post("/Pellucid/new/<?= $type; ?>",saveData, function(resp) {
			var out;

			if(resp.error) {
				$("#myModalLabel").text("Well, well...");
				out = $("<span/>", { text: resp.error });
			} else {
				resp = JSON.parse(resp);
				$("#myModalLabel").text("Woot!");
				out = $("<a/>", { href: resp.link }).text( resp.success ).html();			
			}
			$("#mod p").html(out);
			$("#mod").modal();
		});

	});
});//]]>  
</script>

</head>
<body>

  <form class="form-horizontal">
    <fieldset>
	
<?php 
$fract = true;
switch($type) {
	case "game":
		include "new/game.php";
	break;
	case "player":
		include "new/player.php";
	break;
	case "character":
		include "new/character.php";
	break;
//	case "group":
//echo "Creation of " . $type . " is not implemented yet.";
//		include "new/group.php";
	break;
	case "plot":
echo "Creation of " . $type . " is not implemented yet.";	
//		include "new/plot.php";
	break;
	case "user":
		include "new/user_info.php";
	break; 
	default:
		include "new/default.php";	
}
?>		
    </fieldset>
  </form>

	<!-- Modal -->
	<div id="mod" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Well, well...</h3>
	  </div>
	  <div class="modal-body">
		<p></p>
	  </div>
	  <div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	  </div>
	</div>
  
</body>


</html>