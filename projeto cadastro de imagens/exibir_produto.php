<?php
require 'classes/Produto.class.php';

$produto = new Produto();

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id_produto = $_GET['id'];

    $dadosProduto = $produto->buscarProduto($id_produto);
    $dadosImagens = $produto->buscarImagens($id_produto);

    if (empty($dadosProduto)) {
        echo "<script>
                alert('Produto não encontrado!');
                window.location.href='index.php';
              </script>";
        exit();
    }

} else {

    echo "<script>
            alert('Faltou o id do produto!');
            window.location.href='index.php';
          </script>";

    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <link rel="stylesheet" href="css/exibir_produto.css">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Exibir Produto</title>

</head>

<body>

<section>

    <!-- DADOS DO PRODUTO -->
    <div>

        <h1>
            <?php echo htmlspecialchars($dadosProduto['nome_produto']); ?>
        </h1>

        <p>
            <span>Descrição:</span>
            <?php echo htmlspecialchars($dadosProduto['descricao']); ?>
        </p>

        <p>
            <span>Valor:</span>
            R$
            <?php
            echo number_format(
                $dadosProduto['valor'],
                2,
                ',',
                '.'
            );
            ?>
        </p>

    </div>


    <!-- IMAGENS -->
    <div id="imagens">

        <?php foreach ($dadosImagens as $dado) { ?>

            <div class="imagem-produto">

                <img
                    src="./imgs/<?php echo htmlspecialchars($dado['nome_imagem']); ?>"
                    alt="Imagem do produto"
                    width="300"
                >

                <br><br>

                <button
                    class="compra verde"
                    type="button"
                >
                    Comprar
                </button>

            </div>

            <br>

        <?php } ?>

    </div>

</section>

</body>

</html>
