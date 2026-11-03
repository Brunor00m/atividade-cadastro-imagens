
<?php
require_once "verificarLogin.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Página Principal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<?php require_once "navbar.php"; ?>

<div class="container mt-5">

    <div class="text-center">
        <h1>Bem-vindo ao Sistema!</h1>

        <p class="lead">
            Olá, <?= htmlspecialchars($_SESSION['nome_usuario']) ?>!
        </p>

        <p>
            Utilize o menu superior para acessar as funcionalidades.
        </p>
    </div>

    <div class="row mt-5">

        <div class="col-md-6 mb-3">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h4>Produtos</h4>
                    <p>Visualize e cadastre produtos com imagens.</p>
                    <a href="produtos.php" class="btn btn-primary">
                        Acessar produtos
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h4>Usuários</h4>
                    <p>Cadastre, altere, liste e exclua usuários.</p>
                    <a href="usuarios.php" class="btn btn-success">
                        Acessar usuários
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

</body>
</html>
