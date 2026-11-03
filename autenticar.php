
<?php

session_start();

require_once "classes/Usuarios.class.php";

$usuarios = new Usuarios();

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

$usuario = $usuarios->buscarPorEmail($email);

if ($usuario && password_verify($senha, $usuario['senha'])) {

    session_regenerate_id(true);

    $_SESSION['id_usuario'] = $usuario['id_usuario'];
    $_SESSION['nome_usuario'] = $usuario['nome'];

    header("Location: principal.php");
    exit();

} else {

    header("Location: login.php?erro=1");
    exit();
}
