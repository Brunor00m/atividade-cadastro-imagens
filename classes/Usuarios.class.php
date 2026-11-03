
<?php

class Usuarios
{
    private $pdo;

    public function __construct()
    {
        $dns = "mysql:host=localhost;dbname=imagem_db;charset=utf8";
        $user = "root";
        $pass = "";

        try {
            $this->pdo = new PDO($dns, $user, $pass);
            $this->pdo->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }

    
    public function inserirUsuario($nome, $email, $senha)
    {
        $sql = "INSERT INTO usuarios (nome, email, senha)
                VALUES (:nome, :email, :senha)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(
            ':senha',
            password_hash($senha, PASSWORD_DEFAULT)
        );

        return $stmt->execute();
    }
    
    public function alterarUsuario($id, $nome, $email, $senha = '')
    {
        if (!empty($senha)) {
            $sql = "UPDATE usuarios
                    SET nome = :nome,
                        email = :email,
                        senha = :senha
                    WHERE id_usuario = :id";

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindValue(
                ':senha',
                password_hash($senha, PASSWORD_DEFAULT)
            );
        } else {
            $sql = "UPDATE usuarios
                    SET nome = :nome,
                        email = :email
                    WHERE id_usuario = :id";

            $stmt = $this->pdo->prepare($sql);
        }

        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }

    
    public function apagarUsuario($id)
    {
        $sql = "DELETE FROM usuarios WHERE id_usuario = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }

    
    public function listarUsuarios()
    {
        $sql = "SELECT id_usuario, nome, email
                FROM usuarios
                ORDER BY id_usuario DESC";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function buscarUsuario($id)
    {
        $sql = "SELECT id_usuario, nome, email
                FROM usuarios
                WHERE id_usuario = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function buscarPorEmail($email)
    {
        $sql = "SELECT *
                FROM usuarios
                WHERE email = :email";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
