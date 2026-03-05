<?php
require_once "../conexao/conexao.php";
require_once "../classes/Contatos.php";
require_once "../classes/Enderecos.php";
require_once "../classes/ValidarEntradas.php";

$validar = new ValidarEntradas(); 
 
if($_SERVER['REQUEST_METHOD']==='POST'){
        $nomeInstituicao = trim(ucwords($_POST['nomeInstituicao']));
        $cnpj = trim($_POST['cnpj']);
        $fotoPerfil = trim($_POST['fotoPerfil']);
        $celular = null;
        $email = trim($_POST['email']);
        $telefone = trim($_POST['telefone']);
        $cep = trim($_POST['cep']);
        $cidade = trim(ucwords($_POST['cidade']));
        $bairro = trim(ucwords($_POST['bairro']));
        $estado = trim($_POST['estado']);
        $rua = trim(ucwords($_POST['rua']));
        $nomeLogradouro = null;
        $tipoLogradouro = null;
        $numero = trim($_POST['numero']);
        $complemento = trim($_POST['complemento']);
        $senha = trim($_POST['senha']);
        $confirmarSenha = trim($_POST['confirmarSenha']);
   
        // ---------------------------------------- Checar se os campos estão preenchidos ----------------------------------------
        $validar->obrigatorio('nomeInstituicao',$nomeInstituicao);
        $validar->obrigatorio('cnpj',$cnpj);
        $validar->obrigatorio('fotoPerfil',$fotoPerfil);
        $validar->obrigatorio('email',$email);
        $validar->obrigatorio('telefone',$telefone);
        $validar->obrigatorio('cep',$cep);
        $validar->obrigatorio('cidade',$cidade);
        $validar->obrigatorio('bairro',$bairro);
        $validar->obrigatorio('estado',$estado);
        $validar->obrigatorio('rua',$rua);
        $validar->obrigatorio('numero',$numero);
        $validar->obrigatorio('senha',$senha);
        $validar->obrigatorio('confirmarSenha',$confirmarSenha);

        // ---------------------------------------- Checar tamanho maximo ----------------------------------------
        $validar->tamanhoMax('nomeInstituicao',$nomeInstituicao, 50);
        $validar->tamanhoMax('fotoPerfil',$fotoPerfil,250);
        $validar->tamanhoMax('email',$email,50);
        $validar->tamanhoMax('cidade',$cidade, 50);
        $validar->tamanhoMax('bairro',$bairro, 50);
        $validar->tamanhoMax('rua',$rua, 50);
        $validar->tamanhoMax('numero',$numero, 6);
        $validar->tamanhoMax('senha',$senha, 45);
        $validar->tamanhoMax('confirmarSenha',$confirmarSenha, 45);

        // ---------------------------------------- Checar se o campo é numérico ----------------------------------------
        $validar->numero('cnpj',$cnpj);
        $validar->numero('telefone',$telefone);
        $validar->numero('cep',$cep);
        $validar->numero('numero',$numero);

        // ---------------------------------------- Checar E-mail (email) ----------------------------------------
        $validar->email('email',$email);

        // ---------------------------------------- Checar se o damanho esta certo (cep,telefone,celular,cpf,estado)----------------------------------------
        $validar->tamanhoExato('cnpj',$cnpj,14);
        $validar->tamanhoExato('celular',$celular,11);
        $validar->tamanhoExato('telefone',$telefone, 11);
        $validar->tamanhoExato('cep',$cep, 8);
        $validar->tamanhoExato('estado',$estado, 2);

        // ---------------------------------------- Checar string sem número ----------------------------------------
        $validar->stringSemNumero('nomeInstituicao',$nomeInstituicao);
        $validar->stringSemNumero('estado',$estado);

        // ---------------------------------------- Checar Senha ----------------------------------------
        $validar->senha($senha, $confirmarSenha);

        if($validar->temErros()){
                $erros = $validar->getErros();
                header("Location: ./front/cadastro.html");
        }else{
                try{       

                /*======================================================CONTATOS======================================================*/                            
                        $pdo->beginTransaction();
                        $stmt = $pdo->prepare("INSERT INTO contatos(email,celular,telefone)
                                VALUES (:email,:celular,:telefone)");

                        $stmt->execute([':email'=>$email,
                                                ':celular'=>$celular,
                                                ':telefone'=>$telefone]);

                        $idContatos = $pdo->lastInsertId();//Retorna o ID da última linha ou valor de sequência inserido

                /*======================================================ENDERECOS======================================================*/        
                        $stmt = $pdo->prepare("INSERT INTO enderecos(cep,estado,cidade,bairro,numero,rua,nomeLogradouro,tipoLogradouro,complemento)
                        VALUES (:cep,:estado,:cidade,:bairro,:numero,:rua,:nomeLogradouro,:tipoLogradouro,:complemento)");

                        $stmt->execute([':cep'=>$cep,
                                                ':estado'=>$estado,
                                                ':cidade'=>$cidade,
                                                ':bairro'=>$bairro,
                                                ':numero'=>$numero,
                                                ':rua'=>$rua,
                                                ':nomeLogradouro'=>$nomeLogradouro,
                                                ':tipoLogradouro'=>$tipoLogradouro,
                                                ':complemento'=>$complemento]);
                                       
                        $idEndereco = $pdo->lastInsertId();//Retorna o ID da última linha ou valor de sequência inserido

                /*======================================================INSTITUICAO======================================================*/        
                        $stmt = $pdo->prepare("INSERT INTO instituicao(fotoPerfil,nomeInstituicao,cnpj,senha,idContatos,idEndereco,idPessoa)
                        VALUES (:fotoPerfil,:nomeInstituicao,:cnpj,:senha,:idContatos,:idEndereco,:idPessoa)");

                        $stmt->execute([':nomeInstituicao'=>$nomeInstituicao,
                                                ':fotoPerfil'=>$fotoPerfil,
                                                ':cnpj'=>$cnpj,
                                                ':senha'=>password_hash($senha, PASSWORD_DEFAULT),
                                                ':idContatos'=>$idContatos,
                                                ':idEndereco'=>$idEndereco,
                                                ':idPessoa'=>$idPessoa]);
                       
                        $idInstituicao = $pdo->lastInsertId();

                        $pdo->commit();
                        $mensagem="<p class='sucesso'>Cadastro efetivado</p>";
                } catch (Exception $e) {
                        $pdo->rollBack();
                        echo $e->getMessage();
                }
        }
}
?>