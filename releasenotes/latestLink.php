<!-- tiny fragment to include the next release number and a link to its note --?

<a href="http://jmri.org/releasenotes/<?php
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

?>"><?php
// find and insert most recent 
$d = dir(".");
while (false !== ($entry = $d->read())) {
   if (substr($entry,0,4) == 'jmri' && substr($entry,-6) == '.shtml' ) {
     $list[] = $entry;
   }
}
$d->close();
sort($list);
print substr($list[count($list)-1],4,-6)

?></a>

