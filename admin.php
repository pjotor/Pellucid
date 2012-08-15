<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?
  //Global settings
  require_once('inc/settings.php');
  //DB & Template Libs
  require_once('inc/libs.php');

  function renderOptions($items, $selected = null) {
    $html = "";
    foreach($items as $item) {
      $html .= "<option value=\"{$item->id}\"";
      if($selected == $item->id) $html .= " selected ";
      $html .= ">" . htmlspecialchars($item->name) . "</option>\n";
    }  
    return $html;
  }
  
  //$cols = array( 'key' )
  function renderTableRows($items, $type, $cols, $selected = null) {
    $html = ""; $i = 0;
    foreach($items as $item) {
      $html .= "<tr class=\"";
      if($i % 2 == 0) $html .= "gray";
      if($selected == $item->id) $html .= " selected";
      $html .= "\">";
      
      foreach($cols as $col) {
        $html .= isset($item[$col]) ? "<td>" . $item[$col] . "</td>" : "<td>-</td>";
      }
      
      $html .= "<td><a href=\"?type={$type}&edit=" . $item->id . "\">EDIT  </a>";
      $html .= "<span class=\"v_line\">| </span> <a href=\"?type={$type}&delete=";
      $html .= $item->id . "\" class=\"delete\">DELETE </a></td>";
      $html .= "</tr>";
    }
    return $html;
  }  
  
  $games = R::findAll('game',' ORDER BY created DESC ');
  $players = R::findAll('player',' ORDER BY created DESC ');
  $characters = R::findAll('character',' ORDER BY created DESC ');
  $plots = R::findAll('plot',' ORDER BY created DESC ');
  $playerGroups = R::find('group',' type = ? ORDER BY created DESC ', array('playergroup'));
  $characterGroups = R::find('group',' type = ? ORDER BY created DESC ', array('charactergroup'));
?>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  <title>Pellucid Admin</title>
  <!-- Based on Ninja Admin //-->
  <link rel="stylesheet" type="text/css"  href="css/admin.css" />
  <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script>
$(document).ready(function(){

  //Handle attribute addition and subtraction
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
  
  //Resets index
  function refreshAttr() {
    $("#attributes > div").each(function(i,n){
      $(this).children(".type").attr("name", "attrib[type][" + i + "]");
      $(this).children(".val").attr("name", "attrib[value][" + i + "]");
    });
  }  
  
  if( document.location.hash.length ) {
    $(".navigation a").removeClass("active");
    $(".navigation a[href='" + document.location.hash + "']").addClass("active");
  }
  $(".navigation a").click(function(){
    $(".navigation a").removeClass("active");
    $(this).addClass("active");
  });
});
</script>  
</head>

<body>

	<div class="wrapper">
	
		<h1 class="logo">PELLUCID ADMIN</h1>
		<p class="txt_right">Logged in as <strong>Admin</strong>  <span class="v_line"> | </span> <a href="#"> Logout</a></p>
	
	<!-- Navigation -->
	
		<div class="navigation">
				<ul>
					<li><a href="#games" class="active">GAMES</a></li>
					<li><a href="#manage">MANAGE</a></li>
					<li><a href="#settings">SETTINGS</a></li>
					<li><a href="#users">USERS</a></li>
				</ul>
        
				<div id="searchform">
					<form method="get" action="">
					<input type="text" value="" placeholder="find something good..." class="search_box" name="search" />
					<input type="submit" class="search_btn" value="SEARCH" />
					</form>
				</div>
        
				<ul class="sub clear">
					<li><a href="#players">PLAYERS</a></li>
					<li><a href="#characters">CHARACTERS</a></li>
					<li><a href="#groups">GROUPS</a></li>
					<li><a href="#plots">PLOTS</a></li>
					<li><a href="#relations">RELATIONS</a></li>
				</ul>
        
		</div>
		
		<div class="clear"></div>
	
    <!-- Content START //-->
  
		<div class="content">
		
    <!-- PLAYERS -->
        
        <div class="in">			
        
          <table width="850" border="0" cellspacing="0" cellpadding="10" class="table_main" >
            <tr style="background-color:#d9d8d8; font-size:14px;">
            <td width="5%"><strong>ID</strong></td>            
            <td width="2.5%"><strong>ACTIVE</strong></td>
            <td width="30%"><strong>NAME</strong></td>
            <td width="2.5%"><strong>PAYED</strong></td>
            <td width="20%"><strong>EMAIL</strong></td>
            <td width="15%"><strong>PHONE</strong></td>            
            <td width="20%"><strong>DO IT</strong></td>
            </tr>

            <?= renderTableRows($players, 'player', array('id', 'active', 'name', 'payed', 'email', 'phone')); ?>
            
          </table>
                  
        </div>
		
    <!-- CHARACTERS -->
        
        <div class="in">			
        
          <table width="850" border="0" cellspacing="0" cellpadding="10" class="table_main" >
            <tr style="background-color:#d9d8d8; font-size:14px;">
            <td width="2.5%"><strong>ACTIVE</strong></td>
            <td width="20%"><strong>NAME</strong></td>
            <td width="20%"><strong>REAL NAME</strong></td>
            <td width="20%"><strong>OCCUPATION</strong></td>
            <td width="17.5%"><strong>GROUPS</strong></td>            
            <td width="20%"><strong>DO IT</strong></td>
            </tr>

            <?= renderTableRows($characters, 'character', array('active', 'name', 'realName', 'occupation', 'groups')); ?>
            
          </table>
                  
        </div>
    
    <!-- PLOTS -->
        
        <div class="in">			
        
          <table width="850" border="0" cellspacing="0" cellpadding="10" class="table_main" >
            <tr style="background-color:#d9d8d8; font-size:14px;">
            <td width="2.5%"><strong>ACTIVE</strong></td>
            <td width="20%"><strong>NAME</strong></td>
            <td width="20%"><strong>REAL NAME</strong></td>
            <td width="20%"><strong>OCCUPATION</strong></td>
            <td width="15%"><strong>GROUPS</strong></td>            
            <td width="20%"><strong>DO IT</strong></td>
            </tr>

            <?= renderTableRows($plots, 'plot', array('active', 'name', 'realName', 'occupation', 'groups')); ?>
            
          </table>
                  
        </div>    
    
    
    
    
    
    
    
    
    
    
  <!-- Template parts //-->
    
	<!-- Intro -->
		
				<div class="in author">
					<h2>The stroy so far...</h2>
					<p>Author <a href="#">Bruce Lee</a> | created 10-14-08</p>
				</div>
			
				<div class="line"></div>
				
	<!-- Checks -->
	
        <div class="check_main">
            
          <div class="check">
            <div class="good">Nice work <strong>Ninja Admin!</strong></div>
          </div>
          <div class="check">
            <div class="bad">You need more training, please <a href="#">try again</a>.</div>
          </div>
          
        </div>
			
      
	<!-- Form -->
			
				<div class="in forms">
					<form id="form1" name="form1" method="post" action="">
	
      			<p><strong>TITLE</strong><br />
            <input type="text" name="name" class="box" /></p>
					 
	  				<p><strong>GAME</strong><br />
							<select name="game" class="box2" >
                <?= renderOptions($games); ?>
              </select>
            </p>

            <p><strong>ATTRIBUTES</strong><br />
            <div id="attributes">
              <div class="attr add">
                <input type="text" class="box½ type" name="attrib[type][]" value="" placeholder="type"/>
                <input type="text" class="box½ val" name="attrib[value][]" value="" placeholder="value"/>
                <button class="com_btn">+</button>
              </div>
            </div>
            </p>
            
            <p><strong>TAGS</strong><br />
            <input type="text" name="tags" class="box" value="" placeholder="comma separated.."/></p>
            
	  				<p><strong>DESCRIPTION</strong><br />
            <textarea name="mes" rows="5" cols="30" class="box" ></textarea></p> 

            <p><input name="submit" type="submit" id="submit"  tabindex="5" class="com_btn" value="UPDATE" /></p>
            
					</form>
				</div>
				
				
  <!-- List -->
        
        <div class="in">			
        
          <table width="850" border="0" cellspacing="0" cellpadding="10" class="table_main" >
            <tr style="background-color:#d9d8d8; font-size:14px;">
            <td width="25%"><strong>USER</strong></td>
            <td width="25%"><strong>EMAIL</strong></td>
            <td width="30%"><strong>SOMETHING</strong></td>
            <td width="20%"><strong>DO IT</strong></td>
            </tr>

            <tr class="gray">
            <td>Bruce Lee </td>
            <td><a href="#">bruce@kungfu.com</a></td>
            <td>Loriem ipsum dolor sit amet </td>
            <td><a href="#">EDIT  </a><span class="v_line">| </span> <a href="#" class="delete">DELETE </a></td>
            </tr>
            <tr>
            <td>Jackie Chan</td>
            <td><a href="#">thechan@yahoo.com</a></td>
            <td>Loriem ipsum dolor sit amet </td>
            <td><a href="#">EDIT  </a><span class="v_line">| </span> <a href="#" class="delete">DELETE </a></td>
            </tr>
            <tr class="gray">
            <td>John Claude Van Damme</td>
            <td><a href="#">vandamme@gmail.com</a></td>
            <td>Loriem ipsum dolor sit amet </td>
            <td><a href="#">EDIT  </a><span class="v_line">| </span> <a href="#" class="delete">DELETE </a></td>
            </tr>
             <tr>
            <td>Ben Johnson </td>
            <td><a href="#">ben@kungu.com</a></td>
            <td>Loriem ipsum dolor sit amet </td>
            <td><a href="#">EDIT  </a><span class="v_line">| </span> <a href="#" class="delete">DELETE </a></td>
            </tr>
          </table>
                  
        </div>
		
    <!-- Content END //-->
    
		</div>
		
    
  <!-- Footer -->
    
		<p class="footer">Based on Ninja Admin - <a href="#">ADVANCED  SEARCH</a> <span class="v_line"> |</span> <a href="#">LOGOUT</a></p>
		
	</div>
</body>
</html>
