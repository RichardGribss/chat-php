<?php
include 'check.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die(header("HTTP/1.0 401 falta de parametros"));
}

if ($id === 0) {
    $id = $uid;
?>
    <form method="POST" enctype="multipart/form-data" id='uploadPic'>
        <input type="file" name="imgInp" accept="image/x-png,image/jpeg" id="imgInp" hidden>
        <div class="pictureContainer">
            <img id="userImg" src="profilePics/<?php echo $user_picture; ?>" />
            <label for="imgInp"></label>
        </div>
    </form>

<?php
} else {
    $stmt = $conexao->prepare("SELECT id, username, picture, online, creation FROM user WHERE (id = ? AND token LIKE ? AND secure =?) limit 1");
    $stmt->bind_param("isi", $id, $token, $secure);
    $stmt->execute();
    $me = $stmt->get_result()->fetch_assoc();

    if (!$user) {
        die(header("HTTP/1.0 401 falta de parametros"));
    } else {

        $username = $user['username'];
        $user_picture = $user['picture'];
        $user_online = date('d/m/y', $user['online']);
        $user_creation = $user['creation'];
    }
?>
    <div class="containerPicture">
        <img id="userImg" src="profilePics/<?php echo $user_picture; ?>" />
    </div>
<?php
}
?>
<p class="name"><?php echo $username; ?>
<p class="row">Online <?php echo timing($user_online); ?>