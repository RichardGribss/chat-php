<?php
    $conexao = mysqli_connect("localhost","root","","quicktalk");
mysqli_query($conexao, "SET ime_zone='+00:00'");
date_default_timezone_set("UTC");
if(mysqli_connect_errno()){
    echo "deu pau".mysqli_connect_errno();
    exit();
}
?>