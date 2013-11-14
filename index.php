<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>433PiRemote Admin</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="style.css">
</head>

<?php
	$data = array(
		array('id' => "2", "name" => "Schrank", "system" => "01100", "unit" => 1),
		array('id' => "3", "name" => "Bett", "system" => "01100", "unit" => 2),
		array('id' => "4", "name" => "Sessel", "system" => "01100", "unit" => 3),
		array('id' => "5", "name" => "Bild", "system" => "01100", "unit" => 4),
		array('id' => "6", "name" => "Strobo", "system" => "01000", "unit" => 1),
	);
?>

  <body>
  	<div class="container">

  		<h1>433PiRemote Verwaltung</h1>

		<ul class="nav nav-tabs">
		  <li class="active"><a href="#home" data-toggle="tab">Übersicht</a></li>
		  <li><a href="#new" data-toggle="tab">Neue Funksteckdose einbinden</a></li>
		</ul>

		<div class="tab-content">
		  <div class="tab-pane active" id="home">
	  		<table class="table table-striped">
	  			<tr>
	  				<th style="width: 15%" class="centered">#</th>
	  				<th style="width: 24%">Name</th>
	  				<th style="width: 18%" class="centered">Systemcode</th>
	  				<th style="width: 18%" class="centered">Steckdosennummer</th>
	  				<th style="width: 25%" class="centered">&nbsp;</th>
	  			</tr>
	  			<?php foreach($data as $plug) : ?>
	  			<tr>
	  				<td class="centered"><?php echo $plug['id']; ?></td>
	  				<td><?php echo $plug['name']; ?></td>
	  				<td class="centered">
					  <div class="dip-wrapper">
					  	<div class="tl">ON</div><div class="tr">DIP</div>
					  	<div class="switch-wrapper">
						  	<div class="switch"><div class="knob tl"></div><div class="number">1</div></div>
						  	<div class="switch"><div class="knob tl"></div><div class="number">2</div></div>
						  	<div class="switch"><div class="knob tl"></div><div class="number">3</div></div>
						  	<div class="switch"><div class="knob tl"></div><div class="number">4</div></div>
						  	<div class="switch"><div class="knob tl"></div><div class="number">5</div></div>
						</div>
					  </div>
					  <?php echo $plug['system']; ?>
					</td>
	  				<td class="centered"><?php echo $plug['unit']; ?></td>
	  				<td class="centered">
	  					<a href="javascript:;" rel="<?php echo $plug['id']; ?>" class="btn btn-default glyphicon glyphicon-pencil"> Ändern</a>
	  					<a href="delete.php?id=<?php echo $plug['id']; ?>" class="btn btn-default glyphicon glyphicon-remove"> Löschen</a>
	  				</td>
	  			</tr>
	  			<?php endforeach; ?>
	  		</table>
		  </div>
		  <div class="tab-pane" id="new">

	  		<div id="newForm" class="panel panel-primary">
	  			<div class="panel-heading">Neue Funksteckdose einbinden</div>

			  	<form role="form" style="padding:15px;">
			  		<div class="form-group">
			    		<label for="newName">Name der Funksteckdose</label>
			    		<input type="text" class="form-control" id="newName" placeholder="Name" name="name">
			  		</div>
			  		<div class="form-group">
			    		<label for="newCode">Hauscode / Systemcode</label>
			    		<input type="text" class="form-control" id="newCode" placeholder="z.B. 01100" name="code">
			  		</div>
			  		<div class="form-group">
			    		<label for="newUnit">Nummer der Funksteckdose</label>
			    		<input type="text" class="form-control" id="newUnit" placeholder="A=1, B=2, C=3" name="unit">
			  		</div>

					<button type="submit" class="btn btn-default">Anlegen</button>
			  	</form>
		  	</div>
		  </div>
		</div>

	  </div>

	  <div class="dip-wrapper hidden" id="templateDIPSwitch">
	  	<div class="tl">ON</div><div class="tr">DIP</div>
	  	<div class="switch-wrapper">
		  	<div class="switch"><div class="knob tl"></div><div class="number">1</div></div>
		  	<div class="switch"><div class="knob tl"></div><div class="number">2</div></div>
		  	<div class="switch"><div class="knob tl"></div><div class="number">3</div></div>
		  	<div class="switch"><div class="knob tl"></div><div class="number">4</div></div>
		  	<div class="switch"><div class="knob tl"></div><div class="number">5</div></div>
		</div>
	  </div>

  	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
  </body>
</html>