<?php
    include 'conecta.php';

    if(isset($_COOKIE["id"]) && isset($_COOKIE["token"]) && isset($_COOKIE["secure"])){
        $id = $_COOKIE["id"];
        $token = $_COOKIE["token"];
        $secure = $_COOKIE["secure"];

        $stmt = $conexao ->prepare("SELECT id, username, picture, online, creation FROM user WHERE (id = ? AND token LIKE ? AND secure =?) limit 1");
        $stmt->bind_param("isi",$id, $token, $secure);
        $stmt->execute();
        $me = $stmt->get_result()->fetch_assoc();

        if(!$me){
            die("<script>location.href = auth.html</script>");
        }else{
            $uid = $me['id'];
            $username = $me['username'];
            $user_picture = $me['picture'];
            $user_online = date('d/t/y',$me['online']);
            $user_creation = $me['creation'];

            $stmt = $conexao->prepare("UPDATE user SET `online` = now() WHERE id = ?");
            $stmt->bind_param("i", $uid);
            $stmt->execute();
        }
    }else{
        die(header('HTTP/1.0 401 senha errada'));
    }
?>