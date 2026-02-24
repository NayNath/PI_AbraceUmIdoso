<?php
require_once "./conexao/conexao.php";
require_once "./Classes/Pessoas.php";
require_once "./Classes/Contatos.php";
require_once "./Classes/Enderecos.php";
require_once "./Classes/ValidarEntradas.php";


$validar = new ValidarEntradas();
 
 
if($_SERVER['REQUEST_METHOD']==='POST'){
        $nomePessoa = trim($_POST['nomePessoa']);
        $cpf = trim($_POST['cpf']);
        $dateNascimento = trim($_POST['dateNascimento']);
        $fotoPerfil = trim($_POST['fotoPerfil']);
        $sobre = trim($_POST['sobre']);
        $celular = trim($_POST['celular']);
        $email = trim($_POST['email']);
        $telefone = trim($_POST['telefone']);
        $cep = trim($_POST['cep']);
        $cidade = trim($_POST['cidade']);
        $bairro = trim($_POST['bairro']);
        $estado = trim($_POST['estado']);
        $rua = trim($_POST['rua']);
        $nomeLogradouro = trim($_POST['nomeLogradouro']);
        $tipoLogradouro = trim($_POST['tipoLogradouro']);
        $numero = trim($_POST['numero']);
        $complemento = trim($_POST['complemento']);
        $senha = trim($_POST['senha']);
        $confirmarSenha = trim($_POST['confirmarSenha']);
   
        // ---------------------------------------- Checar se os campos estão preenchidos ----------------------------------------
        $validar->obrigatorio('nomePessoa',$nomePessoa);
        $validar->obrigatorio('cpf',$cpf);
        $validar->obrigatorio('dateNascimento',$dateNascimento);
        $validar->obrigatorio('fotoPerfil',$fotoPerfil);
        $validar->obrigatorio('sobre',$sobre);
        $validar->obrigatorio('celular',$celular);
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
        $validar->tamanhoMax('nomePessoa',$nomePessoa, 50);
        $validar->tamanhoMax('fotoPerfil',$fotoPerfil,250);
        $validar->tamanhoMax('sobre',$sobre, 150);
        $validar->tamanhoMax('email',$email,50);
        $validar->tamanhoMax('cidade',$cidade, 50);
        $validar->tamanhoMax('bairro',$bairro, 50);
        $validar->tamanhoMax('rua',$rua, 50);
        $validar->tamanhoMax('numero',$numero, 6);
        $validar->tamanhoMax('senha',$senha, 45);
        $validar->tamanhoMax('confirmarSenha',$confirmarSenha, 45);


        // ---------------------------------------- Checar se o campo é numérico ----------------------------------------
        $validar->numero('cpf',$cpf);
        $validar->numero('celular',$celular);
        $validar->numero('telefone',$telefone);
        $validar->numero('cep',$cep);
        $validar->numero('numero',$numero);


        // ---------------------------------------- Checar E-mail (email) ----------------------------------------
        $validar->email('email',$email);


        // ---------------------------------------- Checar se o damanho esta certo (cep,telefone,celular,cpf,estado)----------------------------------------
        $validar->tamanhoExato('cpf',$cpf,11);
        $validar->tamanhoExato('celular',$celular,11);
        $validar->tamanhoExato('telefone',$telefone, 11);
        $validar->tamanhoExato('cep',$cep, 8);
        $validar->tamanhoExato('estado',$estado, 2);


        // ---------------------------------------- Checar string sem número ----------------------------------------
        $validar->stringSemNumero('nomePessoa',$nomePessoa);
        $validar->stringSemNumero('estado',$estado);


        // ---------------------------------------- Checar Data de nascimento ----------------------------------------
        $validar->maiorDeIdade('dateNascimento',$dateNascimento);


        // ---------------------------------------- Checar Senha ----------------------------------------
        $validar->senha($senha, $confirmarSenha);




        if($validar->temErros()){
                $erros = $validar->getErros();
                header("Location: ./front/cadastro.html");
        }else{


                try{


                /*======================================================PESSOAS======================================================*/
                        $pdo->beginTransaction();


                        $stmt = $pdo->prepare("INSERT INTO pessoas (nomePessoa, cpf, dateNascimento, fotoPerfil, sobre)
                        VALUES (:nomePessoa, :cpf, :dateNascimento, :fotoPerfil, :sobre)");


                        $stmt->execute([':nomePessoa' => $nomePessoa,
                                                ':cpf'=>$cpf,
                                                ':dateNascimento'=> $dateNascimento,
                                                ':fotoPerfil'=> $fotoPerfil,
                                                ':sobre'=> $sobre]);
                        if(!$stmt->rowCount()){
                        throw new Exception("Erro ao inserir em pessoas");
                        }


                       
                        $idPessoa = $pdo->lastInsertId();//Retorna o ID da última linha ou valor de sequência inserido


                /*======================================================CONTATOS======================================================*/                            
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


                /*======================================================ENDERECOS======================================================*/        
                        $stmt = $pdo->prepare("INSERT INTO voluntarios(senha,idContatos,idEndereco,idPessoa)
                        VALUES (:senha,:idContatos,:idEndereco,:idPessoa)");


                        $stmt->execute([':senha'=>password_hash($senha, PASSWORD_DEFAULT),
                                                ':idContatos'=>$idContatos,
                                                ':idEndereco'=>$idEndereco,
                                                ':idPessoa'=>$idPessoa]);
                       
                        $idVoluntario = $pdo->lastInsertId();


                        $pdo->commit();
                        $mensagem="<p class='sucesso'>Cadastro efetivado</p>";
                } catch (Exception $e) {
                        $pdo->rollBack();
                        echo $e->getMessage();
                }
        }
}
?>