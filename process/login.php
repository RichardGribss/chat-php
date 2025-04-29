<?php
include 'conecta.php';

if(isset($_POST['email']) && isset($_POST['password'])){
    $email == $_POST['email'];
    $password = $_POST['password'];

    if($_POST['email'] == '' && $_POST['password'] == ''){
        die(header("HTTP/1.0 401 Preencha todos os campos"));
    }

    $stmt = $conexao->prepare("SELECT id, password, token, secure FROM user WHERE (email LIKE ? OR username LIKE ?) LIMIT 1");
    $stmt->bind_param("ss", $email,$email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if($user && password_verify($password, $user['password'])){
        setcookie("ID",$user['id'], time() + (10*365*24*60*60));
        setcookie("TOKEN",$user['token'], time() + (10*365*24*60*60));
        setcookie("SECURE",$user['secure'], time() + (10*365*24*60*60));
        return true;
    }else{
        die(header('HTTP/1.0 401 senha errada'));
    }
}else{
    die(header("HTTP/1.0 401 Formulário de autenticação inválido"));
}
?>