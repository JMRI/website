<!DOCTYPE html>
<html>
<head>
	<title>JMRI Icons</title>
</head>
<body>
<h1>JMRI Resources</h1>


<?php
// find showIcons directory
$name = getcwd();
$n = strrpos($name, "/extras");

require(substr($name,0,$n+strlen("/extras"))."/showIcons.php");

showSubdirs();
showFiles();

?>
</table>


</body>
</html>
