<?php
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    include_once 'db.php';
    $query="select * from fingerprints order by fingerprint_code desc limit 1";
    if($result = $db->query($query)){
    $row = $result -> fetch_assoc();
    $fp_id=$row['id'];
    $fp_id = $fp_id + 1 ;
        // $id = $_POST['id'];
        fopen("stop_script","w");
        // sleep(1);
        // echo "Deleting File\n";
        unlink("stop_script");
        $a = popen("python enroll.py '$fp_id '", 'r'); 
    
        while($b = fgets($a, 2048)) { 
            if(strpos($b, "Remove") !== false){
                echo "DONE";
            }
            else{
                echo $b."\n"; 
            }
        
        ob_flush();flush(); 
        } 
        pclose($a); 
    // echo "Creatting File\n";
    }
    else{
        echo $db->error;
    }

?>