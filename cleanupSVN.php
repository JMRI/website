<!DOCTYPE html>
<html>
<head>
	<title>Update from SVN</title>
</head>
<body>
<h1>Update from SVN</h1>

<?php

function my_exec($cmd, $input='') 
         {$proc=proc_open($cmd, array(0=>array('pipe', 'r'), 1=>array('pipe', 'w'), 2=>array('pipe', 'w')), $pipes); 
          fwrite($pipes[0], $input);fclose($pipes[0]); 
          $stdout=stream_get_contents($pipes[1]);fclose($pipes[1]); 
          $stderr=stream_get_contents($pipes[2]);fclose($pipes[2]); 
          $rtn=proc_close($proc); 
          return array('stdout'=>$stdout, 
                       'stderr'=>$stderr, 
                       'return'=>$rtn 
                      ); 
         } 


$command = 'svn cleanup . help jython k resources web xml';

echo 'Command: <pre>'.$command.'</pre><br>';

$vals = my_exec($command, ''); 

echo 'stdout:<br><hr>';
echo '<pre>';
echo $vals['stdout'];
echo '</pre><hr>';
echo 'stderr:<br><hr>';
echo '<pre>';
echo $vals['stderr'];
echo '</pre><hr>';
echo '<p>Returned: '.$vals['return'];
?>

</body>
</html>
