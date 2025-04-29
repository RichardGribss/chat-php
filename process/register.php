<?php
include 'conecta.php';

if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['RepPassword'])){
    $username = $_POST['username'];
    $email == $_POST['email'];
    $password = $_POST['password'];

    if($_POST['username'] == '' && $_POST['email'] == '' && $_POST['password'] == ''){
        die(header("HTTP/1.0 401 Preencha todos os campos"));
        break;
    }

    $checkuser = $conexao->prepare("SELECT username FROM user WHERE  username = ? LIMIT 1");
    $checkuser->bind_param("ss", $username);
    $checkuser->execute();
    if($checkuser->get_result()->num_rows>0){
        die(header("HTTP/1.0 401 Este nome já esta cadastrado"));
    }

    $checkemail = $conexao->prepare("SELECT email FROM user WHERE  email = ? LIMIT 1");
    $checkemail->bind_param("ss", $email);
    $checkuser->execute();
    if($checemail->get_result()->num_rows>0){
        die(header("HTTP/1.0 401 Este email já esta cadastrado"));
    }

    $token = bin2hex(openssl_random_pseudo_bytes(20));
    $secure = rand(10000000, 99999999999);

    $stmt = $conexao->prepare("INSERT INTO user (username, email, password, online, token, secure, creation) values (?, ?, ?, now(), ?, ?, now()");
    $stmt->bind_param("?????i", $username, $email, $password, $token, $secure);
    $stmt->execute();

    $getUser = $conexao->prepare("SELECT id WHERE email = ? LIMIT 1");
    $getUser->bind_param("s", $email);
    $getUser->execute();
    $user = $getUser->get_result()->fetch_assoc();

    if($stmt && $user){
        setcookie("ID",$user['id'], time() + (10*365*24*60*60));
        setcookie("TOKEN",$user['token'], time() + (10*365*24*60*60));
        setcookie("SECURE",$user['secure'], time() + (10*365*24*60*60));
       
    }else{
        die(header("HTTP/1.0 401 Este email já esta cadastrado"));
    }
}
?>