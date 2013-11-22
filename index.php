<?php
	include_once 'PiRemote.class.php';
	$remoteBackend = new PiRemote();

function performAction($group, $switch, $action, $delay)
{
  include_once 'config.php';
  $output = $group.$switch.$action.$delay;
  if (strlen($output) < 8) return;
  $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");
  socket_bind($socket, $source) or die("Could not bind to socket\n");
  socket_connect($socket, $target, $port) or die("Could not connect to socket\n");
  socket_write($socket, $output, strlen ($output)) or die("Could not write output\n");
  socket_close($socket);
}

/*
 * actually send to the daemon
 * then reload the webpage without parameters
 */
$getId = (isset($_GET['id']) ? $_GET['id'] : null);
$getAction = (isset($_GET['action']) ? $_GET['action'] : null);
if(isset($getId, $getAction))
{
	$entry = $remoteBackend->getEntry($getId);
	if(isset($entry))
	{
		$nGroup = $entry['system'];
		$nSwitch = $entry['unit'];
		if($getAction == "on") $nAction = (!$entry['inverseAction'] ? 1 : 0);
		if($getAction == "off") $nAction = (!$entry['inverseAction'] ? 0 : 1);
		$nDelay = 0;
		performAction($nGroup, $nSwitch, $nAction, $nDelay);
	}
	header("Location: index.php?delay=$nDelay");
}

$data = $remoteBackend->getEntries();

if(isset($nAll))
{
  foreach($data as $current) {
    $ig = $current["system"];
    $is = $current["unit"];
    $ii = $current["inverseAction"];
    if($ii) $nAll = abs($nAll - 1);
    performAction($ig, $is, $nAll, $nDelay);
    time_nanosleep(0, 500000000);
  }
  header("Location: index.php?delay=$nDelay");
}

?>
<html>
  <head>
    <title>433PiRemote</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="favicon.png">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap-theme.min.css">
  </head>
  <body>
	<div class="container">
    	
	<h1>433PiRemote</h1>

	<h2>ALLES</h2>
	<div class="row buttons">
		<div class="col-xs-6">
			<a class="btn btn-danger btn-block" href="?all=0">aus</a>
		</div>
		<div class="col-xs-6">
			<a class="btn btn-success btn-block" href="?all=1">an</a>
		</div>
	</div>

	<hr>

<?php
/*
 * table containing all configured sockets
 */
foreach($data as $current) {
	$id = $current["id"];
	$name = $current["name"];
?>
	<h2><?php echo $name ?></h2>
	<div class="row buttons">
		<div class="col-xs-6">
			<a class="btn btn-danger btn-block" href="?id=<?php echo $id ?>&action=off">aus</a>
		</div>
		<div class="col-xs-6">
			<a class="btn btn-success btn-block" href="?id=<?php echo $id ?>&action=on">an</a>
		</div>
	</div>
<?php
}
?>
	<p class="well" style="margin-top: 20px;">
		<a href="admin/">Verwaltung</a>
	<p>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://code.jquery.com/jquery.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
  </body>
</html>

