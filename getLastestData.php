<?php
    include "connect.php";
    $query = "SELECT * FROM s ORDER BY date DESC LIMIT 1";
    $data = mysqli_query($conn, $query);
    $a = array();
    while($row = mysqli_fetch_assoc($data)){
        array_push($a, new Data(
            $row['h'],
            $row['t'],
            $row['l']
        ));
    }

    print json_encode($a);

    class Data{
        function Data($h, $t, $l){
            $this->h = $h;
            $this->t = $t;
            $this->l = $l;
        }
    }

    mysqli_close($conn);
?>