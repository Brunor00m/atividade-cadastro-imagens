<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Produto
{
    private $pdo;

    public function __construct()
    {
        $dns  = "mysql:host=localhost;dbname=imagem_db;charset=utf8";
        $user = "root";
        $pass = "";

        try {
            $this->pdo = new PDO($dns, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erro na Conexão: " . $e->getMessage();
            exit();
        }
    }

    public function conecta()
    {
        return $this->pdo;
    }

    // Cadastrar produto e imagens
    public function enviarProduto($nome, $descricao, $valor, $fotos = array())
    {
        // Trata o valor monetário
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
        $valor = (float) $valor;

        // Insere o produto
        $sql = "INSERT INTO produtos 
                (nome_produto, descricao, valor) 
                VALUES (:n, :d, :v)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':n', $nome);
        $stmt->bindValue(':d', $descricao);
        $stmt->bindValue(':v', $valor);

        $isOk = $stmt->execute();

        if ($isOk) {

            // Pega o ID do produto cadastrado
            $id_produto = $this->pdo->lastInsertId();

            // Cria a pasta imgs caso ela não exista
            if (!file_exists("imgs")) {
                mkdir("imgs", 0777, true);
            }

            // Verifica se existem fotos
            if (isset($fotos['name']) && is_array($fotos['name'])) {

                for ($i = 0; $i < count($fotos['name']); $i++) {

                    if ($fotos['error'][$i] === UPLOAD_ERR_OK) {

                        $nome_original = $fotos['name'][$i];
                        $tmp_name      = $fotos['tmp_name'][$i];

                        // Pega a extensão da imagem
                        $ext = pathinfo(
                            $nome_original,
                            PATHINFO_EXTENSION
                        );

                        // Gera um nome único
                        $nome_foto = md5(
                            $nome_original . time() . rand(0, 9999)
                        ) . '.' . $ext;

                        // Caminho final da imagem
                        $caminho = "imgs/" . $nome_foto;

                        // Move a imagem para a pasta
                        if (move_uploaded_file($tmp_name, $caminho)) {

                            // Salva a imagem no banco
                            $sqlImg = "INSERT INTO imagens 
                                       (nome_imagem, fk_id_produto) 
                                       VALUES (:n, :p)";

                            $stmtImg = $this->pdo->prepare($sqlImg);

                            $stmtImg->bindValue(':n', $nome_foto);
                            $stmtImg->bindValue(':p', $id_produto);

                            $stmtImg->execute();
                        }
                    }
                }
            }

            return true;
        }

        return false;
    }

    // Buscar todos os produtos
    public function buscarProdutos()
    {
        $sql = "SELECT p.*,
                (
                    SELECT nome_imagem
                    FROM imagens
                    WHERE fk_id_produto = p.id_produto
                    LIMIT 1
                ) AS foto_capa
                FROM produtos p
                ORDER BY p.id_produto DESC";

        $stmt = $this->pdo->query($sql);

        if ($stmt) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return array();
    }

    // Buscar um produto pelo ID
    public function buscarProduto($id)
    {
        $sql = "SELECT *
                FROM produtos
                WHERE id_produto = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':id', $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return array();
    }

    // Buscar imagens de um produto
    public function buscarImagens($id)
    {
        $sql = "SELECT *
                FROM imagens
                WHERE fk_id_produto = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':id', $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return array();
    }
}
