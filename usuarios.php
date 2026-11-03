
<?php

require_once "verificarLogin.php";
require_once "classes/Usuarios.class.php";

$usuario = new Usuarios();

$acao = $_GET['acao'] ?? 'listar';
$mensagem = '';

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $operacao = $_POST['operacao'] ?? '';

    if ($operacao === 'inserir') {

        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $senha = $_POST['senha'];

        if ($nome && $email && $senha) {
            try {
                $usuario->inserirUsuario($nome, $email, $senha);
                header("Location: usuarios.php?sucesso=1");
                exit();
            } catch (PDOException $e) {
                $mensagem = "Não foi possível cadastrar. Verifique se o e-mail já existe.";
            }
        }

    } elseif ($operacao === 'alterar') {

        $id = $_POST['id_usuario'];
        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $senha = $_POST['senha'];

        if ($nome && $email) {
            try {
                $usuario->alterarUsuario(
                    $id,
                    $nome,
                    $email,
                    $senha
                );

                header("Location: usuarios.php?sucesso=2");
                exit();
            } catch (PDOException $e) {
                $mensagem = "Não foi possível alterar. Verifique o e-mail.";
            }
        }

    } elseif ($operacao === 'apagar') {

        $id = (int) $_POST['id_usuario'];

        // Não permite excluir a própria conta logada
        if ($id === (int) $_SESSION['id_usuario']) {
            $mensagem = "Você não pode excluir sua própria conta.";
        } else {
            $usuario->apagarUsuario($id);
            header("Location: usuarios.php?sucesso=3");
            exit();
        }
    }
}

$dados = null;

if ($acao === 'editar') {
    $dados = $usuario->buscarUsuario($_GET['id'] ?? 0);

    if (!$dados) {
        header("Location: usuarios.php");
        exit();
    }
}

$lista = $usuario->listarUsuarios();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gerenciar Usuários</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<?php require_once "navbar.php"; ?>

<div class="container mt-4">

    <h2>Gerenciamento de Usuários</h2>

    <?php if (isset($_GET['sucesso'])) { ?>
        <div class="alert alert-success">
            <?php
            if ($_GET['sucesso'] == 1) echo "Usuário cadastrado!";
            if ($_GET['sucesso'] == 2) echo "Usuário atualizado!";
            if ($_GET['sucesso'] == 3) echo "Usuário excluído!";
            ?>
        </div>
    <?php } ?>

    <?php if ($mensagem) { ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($mensagem) ?>
        </div>
    <?php } ?>

    <?php if ($acao === 'inserir' || $acao === 'editar') { ?>

        <div class="card shadow mb-4">

            <div class="card-body">

                <h4>
                    <?= $acao === 'editar' ? 'Alterar Usuário' : 'Cadastrar Usuário' ?>
                </h4>

                <form method="POST">

                    <input type="hidden"
                           name="operacao"
                           value="<?= $acao === 'editar' ? 'alterar' : 'inserir' ?>">

                    <?php if ($acao === 'editar') { ?>
                        <input type="hidden"
                               name="id_usuario"
                               value="<?= $dados['id_usuario'] ?>">
                    <?php } ?>

                    <div class="mb-3">
                        <label class="form-label">Nome</label>

                        <input type="text"
                               name="nome"
                               class="form-control"
                               value="<?= htmlspecialchars($dados['nome'] ?? '') ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">E-mail</label>

                        <input type="email"
                               name="email"
                               class="form-control"
                               value="<?= htmlspecialchars($dados['email'] ?? '') ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Senha
                            <?php if ($acao === 'editar') { ?>
                                (deixe em branco para manter a atual)
                            <?php } ?>
                        </label>

                        <input type="password"
                               name="senha"
                               class="form-control"
                               <?= $acao === 'inserir' ? 'required' : '' ?>>
                    </div>

                    <button type="submit" class="btn btn-success">
                        Salvar
                    </button>

                    <a href="usuarios.php" class="btn btn-secondary">
                        Voltar
                    </a>

                </form>

            </div>
        </div>

    <?php } else { ?>

        <a href="usuarios.php?acao=inserir"
           class="btn btn-success mb-3">
            + Novo usuário
        </a>

        <div class="table-responsive">

            <table class="table table-bordered table-striped">

                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($lista as $u) { ?>

                        <tr>
                            <td><?= $u['id_usuario'] ?></td>

                            <td>
                                <?= htmlspecialchars($u['nome']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($u['email']) ?>
                            </td>

                            <td>

                                <a href="usuarios.php?acao=editar&id=<?= $u['id_usuario'] ?>"
                                   class="btn btn-warning btn-sm">
                                    Editar
                                </a>

                                <form method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Deseja realmente excluir este usuário?')">

                                    <input type="hidden"
                                           name="operacao"
                                           value="apagar">

                                    <input type="hidden"
                                           name="id_usuario"
                                           value="<?= $u['id_usuario'] ?>">

                                    <button type="submit"
                                            class="btn btn-danger btn-sm">
                                        Excluir
                                    </button>

                                </form>

                            </td>
                        </tr>

                    <?php } ?>

                    <?php if (empty($lista)) { ?>
                        <tr>
                            <td colspan="4" class="text-center">
                                Nenhum usuário cadastrado.
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>

            </table>

        </div>

    <?php } ?>

</div>

</body>
</html>
