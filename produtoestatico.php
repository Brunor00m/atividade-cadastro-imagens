<?php require_once "classes/Produto.class.php"; $produto = new Produto(); $produtos = $produto->buscarProdutos(); ?> <!DOCTYPE html> <html lang="pt-BR"> <head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Produtos</title>

<link rel="stylesheet" href="css/produtoestatico.css">

</head> <body>
<header class="cabecalho">
    <div class="container">

        <h1>Produtos</h1>

        <a href="index.php" class="btn-cadastrar">
            Cadastrar produto
        </a>

    </div>
</header>


<main class="container">

    <?php if (count($produtos) > 0): ?>

        <section class="produtos">

            <?php foreach ($produtos as $p): ?>

                <article class="card">

                    <div class="imagem-container">

                        <?php if (!empty($p['foto_capa'])): ?>

                            <img
                                src="imgs/<?php echo htmlspecialchars($p['foto_capa']); ?>"
                                alt="<?php echo htmlspecialchars($p['nome_produto']); ?>"
                            >

                        <?php else: ?>

                            <div class="sem-imagem">
                                Sem imagem
                            </div>

                        <?php endif; ?>

                    </div>


                    <div class="card-conteudo">

                        <h2>
                            <?php echo htmlspecialchars($p['nome_produto']); ?>
                        </h2>

                        <p class="descricao">
                            <?php echo htmlspecialchars($p['descricao']); ?>
                        </p>

                        <p class="preco">
                            R$ <?php echo number_format($p['valor'], 2, ',', '.'); ?>
                        </p>

                    </div>

                </article>

            <?php endforeach; ?>

        </section>

    <?php else: ?>

        <div class="nenhum-produto">

            <h2>Nenhum produto cadastrado</h2>

            <p>
                Ainda não existem produtos cadastrados.
            </p>

            <a href="index.php" class="btn-cadastrar">
                Cadastrar primeiro produto
            </a>

        </div>

    <?php endif; ?>

</main>

</body> </html>