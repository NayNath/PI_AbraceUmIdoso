<?php
/*editar: foto, Sobre mim, celular/telefone, email, cep,estado, cidade, bairro, rua, numero*/
require_once "../conexao/conexao.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: listar.php");
    exit;
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM voluntarios WHERE idVoluntario = :idVoluntario LIMIT 1";

// Prepara o SQL para ser executado com segurança
$stmt = $pdo->prepare($sql);

// Executa o SQL passando o ID como parâmetro
$stmt->execute(['idVoluntario' => $idVoluntario]);

// Guarda os dados do usuário encontrados no banco
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Se não encontrar nenhum usuário com esse ID, volta para a lista
if (!$usuario) {
    header("Location: listar.php");
    exit;
}

$mensagem = "";

// Verifica se o formulário foi enviado usando método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Pega o nome enviado pelo formulário e remove espaços extras
    $nome = trim($_POST['nomePessoa']);

    // Pega o e-mail enviado pelo formulário
    $email = trim($_POST['email']);

    // Verifica se o campo senha foi preenchido
    if (!empty($_POST['senha'])) {

        // Criptografa a nova senha para armazenar com segurança
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        // Monta o SQL para atualizar todos os dados, incluindo a senha
        $sql = "UPDATE usuarios SET nome = :nome, email = :email, senha = :senha, tipo = :tipo WHERE id = :id";

        // Cria os valores que serão enviados juntos com o SQL
        $params = [
            ':nome' => $nome,
            ':email' => $email,
            ':senha' => $senha,
            ':tipo' => $tipo,
            ':id' => $id
        ];

    } else {

        // Se a senha não for preenchida, atualiza apenas nome, email e tipo
        $sql = "UPDATE usuarios SET nome = :nome, email = :email, tipo = :tipo WHERE id = :id";

        // Valores que serão enviados no SQL (sem a senha)
        $params = [
            ':nome' => $nome,
            ':email' => $email,
            ':tipo' => $tipo,
            ':id' => $id
        ];
    }

    try {
        // Prepara o SQL para ser executado
        $stmt = $pdo->prepare($sql);

        // Executa o SQL passando os valores coletados
        $stmt->execute($params);

        // Após salvar as alterações, volta para a lista de usuários
        header("Location: listar.php");
        exit;

    } catch (PDOException $e) {

        // Se ocorrer algum erro, cria uma mensagem mostrando o problema
        $mensagem = "<p class='erro'>Erro ao atualizar: ".$e->getMessage()."</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>