<?php
    include "connect.php";
    
    $query = "SELECT * FROM s";
    $data = mysqli_query($conn, $query);

    $a = array();
    while($row = mysqli_fetch_assoc($data)){
        array_push($a, new Data(
            $row['date'],
            $row['note_id'],
            $row['h'],
            $row['t'],
            $row['l']));
    }

    echo json_encode($a);
    
    class Data{
        function Data($date, $note_id, $h, $t, $l){
            $this->date = $date;
            $this->note_id = $note_id;
            $this->h = $h;
            $this->t = $t;
            $this->l = $l;
        }
    }
?>