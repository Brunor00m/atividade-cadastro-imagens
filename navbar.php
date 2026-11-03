
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <a class="navbar-brand" href="principal.php">
            Sistema de Produtos
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="produtos.php">
                        Produtos cadastrados
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        Inserir produto
                    </a>
                </li>

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown">
                        Usuários
                    </a>

                    <ul class="dropdown-menu">

                        <li>
                            <a class="dropdown-item" href="usuarios.php">
                                Listar usuários
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="usuarios.php?acao=inserir">
                                Inserir usuário
                            </a>
                        </li>

                    </ul>

                </li>

            </ul>

            <span class="navbar-text text-white me-3">
                Olá, <?= htmlspecialchars($_SESSION['nome_usuario']) ?>
            </span>

            <a href="logout.php" class="btn btn-outline-light btn-sm">
                Sair
            </a>

        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
