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
	$data = array();
	if(file_exists("data/config.json"))
	{
		$data = json_decode(file_get_contents("data/config.json"), true);
	}
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
						<span class="system"><?php echo $plug['system']; ?></span>
					</td>
	  				<td class="centered"><?php echo $plug['unit']; ?></td>
	  				<td class="centered">
	  					<a href="javascript:;" rel="<?php echo $plug['id']; ?>" class="btn btn-default glyphicon glyphicon-pencil edit"> Ändern</a>
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


	  <div id="editForm" class="modal fade" role="dialog">
	    <div class="modal-dialog">

	  		<div class="panel panel-primary">
	  			<div class="panel-heading">Daten ändern</div>

			  	<form role="form" style="padding:15px;">
			  		<div class="form-group">
			    		<label for="editName">Name der Funksteckdose</label>
			    		<input type="text" class="form-control" id="editName" placeholder="Name" name="name">
			  		</div>
			  		<div class="form-group">
			    		<label for="editCode">Hauscode / Systemcode</label>
			    		<input type="text" class="form-control" id="editCode" placeholder="z.B. 01100" name="code">
			  		</div>
			  		<div class="form-group">
			    		<label for="editUnit">Nummer der Funksteckdose</label>
			    		<input type="text" class="form-control" id="editUnit" placeholder="A=1, B=2, C=3" name="unit">
			  		</div>

					<button type="submit" class="btn btn-default">Ändern</button>
			  	</form>
		  	</div>
	  	</div>
	</div>

  	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
  	<script src="index.js"></script>
</body>
</html>