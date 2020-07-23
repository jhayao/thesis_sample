<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
    // echo "Creatting File\n";
    fopen("stop_script","w");
    // sleep(1);
    // echo "Deleting File\n";
    unlink("stop_script");
    $a = popen('python scan.py', 'r'); 

    while($b = fgets($a, 2048)) { 
    echo $b."\n"; 
    ob_flush();flush(); 
    } 
    pclose($a); 

?>