<?php
require_once 'classes/Produto.class.php';
$produto = new Produto();

// Processa o envio do formulário
if (isset($_POST['nome'])) {
    $nome      = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $valor     = $_POST['valor'];
    $fotos     = isset($_FILES['foto']) ? $_FILES['foto'] : array();

    $produto->enviarProduto($nome, $descricao, $valor, $fotos);

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
    <style>
        * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

:root {
    --laranja: #ff6b35;
    --laranja-escuro: #e85d2a;
    --laranja-claro: #fff1eb;
    --creme: #fffaf7;
    --branco: #ffffff;
    --texto: #27272a;
    --cinza: #71717a;
    --borda: #f0e2dc;
}

body {
    min-height: 100vh;
    background:
        radial-gradient(circle at top left, #ffe3d5 0, transparent 30%),
        radial-gradient(circle at bottom right, #ffeadf 0, transparent 30%),
        var(--creme);
    color: var(--texto);
    padding: 40px 20px;
}

/* =========================
   CABEÇALHO
========================= */

h1 {
    text-align: center;
    font-size: 2.4rem;
    font-weight: 800;
    color: #252525;
    margin-bottom: 35px;
}

h1::after {
    content: "";
    display: block;
    width: 55px;
    height: 5px;
    background: var(--laranja);
    border-radius: 10px;
    margin: 12px auto 0;
}

/* =========================
   FORMULÁRIO
========================= */

form {
    width: 100%;
    max-width: 850px;
    margin: 0 auto 60px;
    padding: 35px;
    background: var(--branco);
    border-radius: 20px;
    border: 1px solid var(--borda);
    box-shadow: 0 15px 40px rgba(83, 39, 21, 0.08);

    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

/* Cada campo */
.form-group {
    margin-bottom: 5px;
}

/* Faz descrição ocupar a largura toda */
.form-group:nth-child(2),
.form-group:nth-child(4),
button {
    grid-column: 1 / -1;
}

label {
    display: block;
    margin-bottom: 8px;
    font-size: 0.9rem;
    font-weight: 700;
    color: #44403c;
}

input[type="text"],
input[type="number"],
textarea,
input[type="file"] {
    width: 100%;
    padding: 13px 15px;
    border: 1px solid #ddd6d2;
    border-radius: 10px;
    background: #fffdfc;
    color: var(--texto);
    font-size: 0.95rem;
    transition: 0.25s ease;
}

input[type="text"]:focus,
input[type="number"]:focus,
textarea:focus {
    outline: none;
    border-color: var(--laranja);
    background: #fff;
    box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.10);
}

textarea {
    resize: vertical;
    min-height: 130px;
}

input[type="file"] {
    border: 2px dashed #ffc7b3;
    background: var(--laranja-claro);
    cursor: pointer;
}

input[type="file"]:hover {
    border-color: var(--laranja);
    background: #fff0e9;
}

/* =========================
   BOTÃO
========================= */

button[type="submit"] {
    margin-top: 10px;
    padding: 14px 20px;

    border: none;
    border-radius: 10px;

    background: var(--laranja);
    color: white;

    font-size: 1rem;
    font-weight: 700;

    cursor: pointer;

    transition: 0.25s ease;
}

button[type="submit"]:hover {
    background: var(--laranja-escuro);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(232, 93, 42, 0.25);
}

button[type="submit"]:active {
    transform: translateY(0);
}

/* =========================
   SEPARADOR
========================= */

hr {
    border: none;
    height: 1px;
    background: #eadfd9;

    width: 100%;
    max-width: 1100px;

    margin: 0 auto 35px;
}

/* =========================
   TÍTULO DOS PRODUTOS
========================= */

body > h2 {
    max-width: 1100px;
    margin: 0 auto 25px;

    text-align: left;

    font-size: 1.5rem;
    font-weight: 750;
    color: #292524;
}

/* Pequeno detalhe laranja */
body > h2::before {
    content: "";
    display: inline-block;

    width: 7px;
    height: 25px;

    background: var(--laranja);
    border-radius: 5px;

    margin-right: 10px;
    vertical-align: middle;
}

/* =========================
   GRID DE PRODUTOS
========================= */

.produtos-grid {
    width: 100%;
    max-width: 1100px;
    margin: 0 auto;

    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

/* =========================
   CARD
========================= */

.produto-card-link {
    text-decoration: none;
    color: inherit;
}

.produto-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;

    border: 1px solid var(--borda);

    box-shadow: 0 5px 18px rgba(83, 39, 21, 0.06);

    transition: 0.3s ease;
}

.produto-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 30px rgba(83, 39, 21, 0.13);
}

/* =========================
   IMAGEM
========================= */

.produto-card img {
    width: 100%;
    height: 190px;

    display: block;

    object-fit: cover;

    transition: 0.35s ease;
}

.produto-card:hover img {
    transform: scale(1.04);
}

/* =========================
   NOME
========================= */

.produto-card h2 {
    padding: 16px;

    margin: 0;

    font-size: 1rem;
    font-weight: 700;

    text-align: left;

    color: #292524;

    border-top: 1px solid #f3eee9;
}

.produto-card:hover h2 {
    color: var(--laranja-escuro);
}

/* =========================
   SEM PRODUTOS
========================= */

.empty-msg {
    grid-column: 1 / -1;

    text-align: center;

    padding: 40px;

    background: white;

    border-radius: 15px;

    color: var(--cinza);

    border: 1px dashed #e5cfc4;
}

/* =========================
   RESPONSIVO
========================= */

@media (max-width: 900px) {
    .produtos-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 650px) {

    body {
        padding: 25px 15px;
    }

    h1 {
        font-size: 2rem;
    }

    form {
        grid-template-columns: 1fr;
        padding: 25px;
    }

    .form-group:nth-child(2),
    .form-group:nth-child(4),
    button {
        grid-column: auto;
    }

    .produtos-grid {
        grid-template-columns: 1fr;
    }

    body > h2 {
        text-align: center;
    }

    body > h2::before {
        display: none;
    }
}

    </style>
</head>
<body>

    <h1>Cadastrar Produto</h1>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nome">Nome do Produto</label>
            <input type="text" id="nome" name="nome" required placeholder="Ex: Sofá Retrátil">
        </div>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" rows="4" required placeholder="Informe os detalhes do produto..."></textarea>
        </div>

        <div class="form-group">
            <label for="valor">Valor (R$)</label>
            <input type="number" id="valor" name="valor" step="0.01" min="0" required placeholder="0.00">
        </div>

        <div class="form-group">
            <label for="foto">Imagens do Produto</label>
            <input type="file" id="foto" name="foto[]" multiple required>
        </div>

        <button type="submit">Cadastrar Produto</button>
    </form>

    <hr>

    <h2>Produtos Cadastrados</h2>

    <section class="produtos-grid">
        <?php
        $dadosProduto = $produto->buscarProdutos();

        if (empty($dadosProduto)) {
            echo "<p class='empty-msg'>Ainda não há produtos cadastrados aqui!</p>";
        } else {
            foreach ($dadosProduto as $Value) {
                ?>
                <a href="exibir_produto.php?id=<?php echo $Value['id_produto']; ?>" class="produto-card-link">
                    <div class="produto-card">
                        <?php if (!empty($Value['foto_capa'])): ?>
                            <img src="imgs/<?php echo $Value['foto_capa']; ?>" alt="<?php echo $Value['nome_produto']; ?>">
                        <?php endif; ?>
                        <h2><?php echo $Value['nome_produto']; ?></h2>
                    </div>
                </a>
                <?php
            }
        }
        ?>
    </section>

</body>
</html>