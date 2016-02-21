<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">

<head>
 <title>JMRI: Most Recent Release Note</title>
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<META 
     HTTP-EQUIV="Refresh"
     CONTENT="0; URL=https://github.com/JMRI/website/blob/master/releasenotes/<?php
// find and insert most recent 
$d = dir(".");
while (false !== ($entry = $d->read())) {
   if (substr($entry,0,4) == 'jmri' && substr($entry,-6) == '.shtml' ) {
     $list[] = $entry;
   }
}
$d->close();
sort($list);
print $list[count($list)-1]

?>">
</head>
<body>
This page should have immediately taken you to the
release note for the latest (in progress) JMRI test release.
<p>
If it hasn't, please 
<a href="https://github.com/JMRI/website/blob/master/releasenotes/<?php
// find and insert most recent 
$d = dir(".");
while (false !== ($entry = $d->read())) {
   if (substr($entry,0,4) == 'jmri' && substr($entry,-6) == '.shtml' ) {
     $list[] = $entry;
   }
}
$d->close();
sort($list);
print $list[count($list)-1]

?>">click here</a>.

</body>
</html>

