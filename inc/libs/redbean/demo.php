<?php
require('rb.php');
R::setup('mysql:host=localhost;
  dbname=redbean','root','');
function getbaseurl(){ return $_SERVER['PHP_SELF'];}
function go($url) { echo getbaseurl().$url; }
$owner = 'me';
if (isset($_POST['action'])) { 
	try{	$bean = R::graph($_POST['inv'],true); 
		$bean->owner = $owner;
		R::store($bean);
    
    var_dump($bean);
    
	}catch(RedBean_Exception_Security $e) { ; }
//	header('Location: '.$_SERVER['REQUEST_URI']); exit; 
}
$in = reset(R::findOrDispense('inventory',' owner = ? ',array($owner)));
$in->owner = $owner;
?>
<html>
	<head><title>Malt Management System</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body>
		<h1>&#9830;&nbsp;Malts&nbsp;&#9830;</h1>
		<form action="" method="post">
		<input type="hidden" name="inv[type]" value="inventory">
		<input type="hidden" name="inv[id]" value="<?php echo $in->id; ?>">
		<ul id="categories" style="font-size:20px;">	
			<?php foreach($in->ownCategory as $cat): ?>
				<li id="cat-<?php echo $cat->id; ?>" >
					<span class="clickable" style="color:red;font-weight:bold;" onclick="document.getElementById('categories').removeChild(document.getElementById('cat-<?php echo $cat->id; ?>'));">&#10008;</span>
					<input type="hidden" name="inv[ownCategory][<?php echo $cat->id; ?>][type]" value="category" />
					<input type="hidden" name="inv[ownCategory][<?php echo $cat->id; ?>][id]" value="<?php echo $cat->id; ?>" />
					<input type="text" name="inv[ownCategory][<?php echo $cat->id; ?>][name]" value="<?php echo htmlspecialchars($cat->name); ?>" />
				</li>
			<?php endforeach; ?>
			<li>
				<input type="hidden" name="inv[ownCategory][new][type]" value="category" />
				<input type="text" name="inv[ownCategory][new][name]" value="" placeholder="new category.."/>
			</li>
		</ul>
		<div id="categoryscreen">
			<?php if (isset($_GET['cat'])): $c = $_GET['cat'];  ?>
				<?php foreach($in->ownCategory[$c]->ownItem as $item): ?>
					<div class="categorybox" id="box-<?php echo $item->id; ?>">
						<div class="category" style="background-color:#FFF;">
							<input type="hidden" name="inv[ownCategory][<?php echo $c; ?>][ownItem][<?php echo $item->id; ?>][type]" value="item" />
							<input type="hidden" name="inv[ownCategory][<?php echo $c; ?>][ownItem][<?php echo $item->id; ?>][id]" value="<?php echo $item->id ?>" />
							<input type="hidden" name="inv[ownCategory][<?php echo $c; ?>][ownItem][<?php echo $item->id; ?>][url]" value="<?php echo addslashes($item->url); ?>" />
							<img style="width:80px;margin-top:5px;" src="<?php echo addslashes($item->url); ?>" />
						</div>
						<span>
							<input style="text-align:center;width:100px;" type="text" name="inv[ownCategory][<?php echo $c; ?>][ownItem][<?php echo $item->id; ?>][title]" value="<?php echo htmlspecialchars($item->title) ?>" />
						</span>
						<span class="clickable" onclick="document.getElementById('categoryscreen').removeChild(document.getElementById('box-<?php echo $item->id; ?>'))">&#10008;</span>
						<div class="clear">&nbsp;</div>
					</div>
				<?php endforeach; ?>
				<div class="item">
					<div class="categorybox" >
						<input type="hidden" name="inv[ownCategory][<?php echo $c; ?>][ownItem][new][type]" value="item" />
						<div class="category" style="background-color:black;">
							<input style="width:80px;margin-top:20px;" placeholder="bottle..." type="text" name="inv[ownCategory][<?php echo $c; ?>][ownItem][new][url]" value="" /><br/>
						</div>
						<span>
							<input placeholder="brand, years" style="width:80px;" type="text" name="inv[ownCategory][<?php echo $c; ?>][ownItem][new][title]" value="" />
						</span>
						<div class="clear">&nbsp;</div>
					</div>
				</div>
			<?php else: ?>
				<?php foreach($in->ownCategory as $category):?>
					<div class="categorybox" >
						<a class="category" style="background-color:#FFF" href="<?php go('?cat='.$category->id); ?>">
							<?php if (count($category->ownItem)>0): ?>
								<img style="width:80px;margin-top:5px;" src="<?php echo addslashes(end($category->ownItem)->url); ?>" /> 
							<?php else: ?>
								<div style="color:#000;margin-top:30px;" >No items yet.<br/>Click to add items.</div>
							<?php endif; ?>
						</a>
						<span style="color:#FFF">&#10070;<?php echo htmlspecialchars($category->name); ?>&#10070;</span>
						<div class="clear">&nbsp;</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
			<div class="clear">&nbsp;</div>
		</div>
		<div class="foot">
		<input style="cursor:pointer;color:#FFBB56;" type="submit" name="action" value="save" />
		&nbsp;|&nbsp;&nbsp;<a style="cursor:pointer;text-decoration:none;color:#FFBB56;" href="<?php go(''); ?>">overview</a>
		</div>
		</form>
	</body>
</html>