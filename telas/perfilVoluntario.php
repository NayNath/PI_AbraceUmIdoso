<?php
    session_start();
    require_once "../conexao/conexao.php";

    $idVoluntario = $_SESSION['idVoluntario'];

    $sql = "SELECT p.nomePessoa,p.fotoPerfil, p.sobre, c.email, c.telefone, c.celular,
        e.cep, e.cidade, e.estado, e.bairro, e.nomeLogradouro, e.numero, e.complemento
        FROM voluntarios v
        INNER JOIN pessoas p ON v.idPessoa = p.idPessoa
        INNER JOIN contatos c ON v.idContatos = c.idContatos
        INNER JOIN enderecos e ON v.idEndereco = e.idEndereco
        WHERE v.idVoluntario = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id',$idVoluntario);
    $stmt->execute();

    $dados = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil voluntário</title>
    <link rel="stylesheet" href="./../css/estilo.css">
    <link rel="stylesheet" href="./../css/perfil.css">

</head>
<body>
        <head>
    <meta charset="UTF-8">
    <title>Seu Título</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
   
    <link rel="stylesheet" href="caminho/para/seu/style.css">
    </head>
    <header class="cabecalho">
        <a href="#" class="logo">
            <img src="./../imagem/logoPI.jpg" alt="LogoAbraceUmIdoso">
        </a>
        <nav class="nav-menu">
            <ul>
                <li><a href="cadastroVoluntario.html">Cadastrar</a></li>
                <li><a href="/login" class="ga-nav" title="agendamento">Login</a></li>
            </ul>
            <ul>
            <li><a href="../index.html">Início</a></li>
            <li><a href="/agendamento" class="ga-nav" title="agendamento">Agendamento</a></li>
            <li><a href="/cartas" class="ga-nav" title="cartas">Cartas</a></li>
            <li><a href="perfilVoluntario.php" class="ga-nav" title="contato">Meu Perfil</a></li>
            <li><a href="contatos.html" class="ga-nav" title="contato">Fale Conosco</a></li>
            </ul>
        </nav>

    </header>
    <body>

   <main>
        <div class="perfil-container">
            <div class="foto">
                <p><?= htmlspecialchars($dados['fotoPerfil']) ?></p>
                <?php if(isset($erros['confirmarSenha'])): ?>
                    <img src="./../imagem/?= $dados['fotoPerfil'] ?>">
                <?php else: ?>
                        Sem imagem
                <?php endif; ?>
            </div>

            <h2><?= htmlspecialchars($dados['nomePessoa']) ?></h2>

            
            <div class="bio-box">
                <div class="titulo-sobre-mim"><label for="sobre-mim">Sobre Mim:</label><br></div>
                <p><?= htmlspecialchars($dados['sobre']) ?></p>
            </div>

            <h3>Informações pessoais:</h3>

            <?php
            // Função para mostrar campo, evita erros se dados faltarem
            function mostraCampo($label, $valor, $linkEditar) {
                $valor = htmlspecialchars($valor ?? '');
                echo "<div class='info-box'>
                        <span class='label'>$label</span>
                        <span class='valor'>$valor</span>
                        <a href='$linkEditar'>
                            <img src='../imagem/lapis.jpg' class='lapis' alt='Editar $label'>
                        </a>
                      </div>";
            }

            mostraCampo('Email:', $dados['email'], 'editarVoluntario.php');
            mostraCampo('Telefone:', $dados['telefone'], 'editarVoluntario.php');
            mostraCampo('Celular:', $dados['celular'], 'editarVoluntario.php');
            mostraCampo('CEP:', $dados['cep'], 'editarVoluntario.php');
            mostraCampo('Cidade:', $dados['cidade'], 'editarVoluntario.php');
            mostraCampo('Estado:', $dados['estado'], 'editarVoluntario.php');
            mostraCampo('Bairro:', $dados['bairro'], 'editarVoluntario.php');
            mostraCampo('Rua:', $dados['nomeLogradouro'], 'editarVoluntario.php');
            mostraCampo('Nº:', $dados['numero'], 'editarVoluntario.php');
            mostraCampo('Complemento:', $dados['complemento'], 'editarEndereco.php');
            ?>

            <div class="info-box">
                <span class="label">Senha:</span>
                <span class="valor">********</span>
                <a href="editarSenha.php">
                    <img src="../imagem/lapis.jpg" class="lapis" alt="Editar Senha" />
                </a>
            </div>
        </div>
    </main>


</div>
 
    <footer class="rodape"><p>© 2026 RastroCerto. Todos os direitos reservados</p></footer>
</body>
</html>
