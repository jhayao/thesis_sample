<?php
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    if(!empty($_POST['id']))
    {

        $id = $_POST['id'];
        fopen("stop_script","w");
        // sleep(1);
        // echo "Deleting File\n";
        unlink("stop_script");
        $a = popen("python match.py '$id'", 'r'); 
    
        while($b = fgets($a, 2048)) { 
        echo $b."\n"; 
        ob_flush();flush(); 
        } 
        pclose($a); 
    }
    // echo "Creatting File\n";
    

?>