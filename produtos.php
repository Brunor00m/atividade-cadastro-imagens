
<?php
require_once "verificarLogin.php";
require_once "classes/Produto.class.php";

$produto = new Produto();
$dadosProduto = $produto->buscarProdutos();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<?php require_once "navbar.php"; ?>

<div class="container mt-4">

    <h1>Produtos cadastrados</h1>

    <section class="row">

        <?php if (empty($dadosProduto)) { ?>

            <p>Ainda não há produtos cadastrados aqui!</p>

        <?php } else { ?>

            <?php foreach ($dadosProduto as $value) { ?>

                <div class="col-md-4 mb-4">

                    <div class="card shadow">

                        <a href="exibir_produto.php?id=<?php echo $value['id_produto']; ?>">

                            <img
                                src="imgs/<?php echo htmlspecialchars($value['foto_capa'] ?? ''); ?>"
                                class="card-img-top"
                                alt="Imagem do produto"
                                style="height: 250px; object-fit: cover;"
                            >

                        </a>

                        <div class="card-body">

                            <h5 class="card-title">
                                <?php echo htmlspecialchars($value['nome_produto']); ?>
                            </h5>

                        </div>

                    </div>

                </div>

            <?php } ?>

        <?php } ?>

    </section>

</div>

</body>
</html>
