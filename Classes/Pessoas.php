<?php
require_once "../conexao/conexao.php";
class Pessoas{
    public string $nomePessoa, $cpf, $fotoPerfil, $sobre;
    public $dateNascimento;


    public function __construct($nomePessoa, $cpf, $fotoPerfil, $sobre, $dateNascimento){
        $this->nomePessoa = $nomePessoa;
        $this->cpf = $cpf;
        $this->fotoPerfil = $fotoPerfil;
        $this->sobre = $sobre;
        $this->dateNascimento = $dateNascimento;
    }
    public function __get($valor){
        return $this->$valor;
    }
    public function __set($valor, $campo){
        return  $this->$valor = $campo;
    }
}
?>
