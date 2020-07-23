<?php
    include_once 'db.php';
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
        fopen("stop_script","w");
        // sleep(1);
        // echo "Deleting File\n";
        unlink("stop_script");
        $a = popen("python enroll2.py", 'r'); 
    
        while($b = fgets($a, 2048)) { 
            if(strpos($b, "Stored") !== false){
                $query ="insert into fingerprints values(null,'$fp_id',null)";
                $result = $db->query($query);
                if($db -> affected_rows > 0) 
                $query="select * from fingerprint order by fp_code desc limit 1";
                $result = $db->query($query);
                $row = $result -> fetch_assoc();
                $fp_id=$row['fp_id'];
                echo "ID:" .$fp_id;
            }
            else{
                echo $b."\n"; 
            }
        
        ob_flush();flush(); 
        } 
        pclose($a); 
    // echo "Creatting File\n";
    

?>