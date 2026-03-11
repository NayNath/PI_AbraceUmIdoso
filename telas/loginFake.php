<?php
session_start();
require_once "../conexao/conexao.php";

$email = trim($_POST['email']);
$senha = trim($_POST['senha']);

$sql = "SELECT voluntarios.senha, voluntarios.idVoluntario, contatos.email
        FROM voluntarios
        INNER JOIN contatos 
        ON voluntarios.idContatos = contatos.idContatos
        WHERE contatos.email = :email";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if($usuario){

    if(password_verify($senha, $usuario['senha'])){

        $_SESSION['idVoluntario'] = $usuario['idVoluntario'];
        $_SESSION['email'] = $usuario['email'];

        header("Location: perfilVoluntario.php");
        exit;

    } else {
        echo "Senha incorreta";
        var_dump($usuario);
    }

} else {
    echo "Email não encontrado";
    var_dump($usuario);
}
?>