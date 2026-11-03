
<?php

require_once "classes/Usuarios.class.php";

$usuarios = new Usuarios();

$usuarios->inserirUsuario(
    "Administrador",
    "admin@gmail.com",
    "123456"
);

echo "Usuário criado com sucesso!";