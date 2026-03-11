<?php
require_once "../conexao/conexao.php";
class Enderecos {
    public string $cep, $estado, $cidade, $bairro, $numero,$rua, $nomeLogradouro, $tipoLogradouro;

    public function __construct($cep, $estado, $cidade, $bairro, $numero, $rua) {
        $this->cep = $cep;
        $this->estado = $estado;
        $this->cidade = $cidade;
        $this->bairro = $bairro;
        $this->rua = $rua;
        $this->numero = $numero;
        //$this->nomeLogradouro = $nomeLogradouro;
        //$this->tipoLogradouro = $tipoLogradouro;
    }
    public function __get($valor){
        return $this->$valor;
    }
    public function __set($valor, $campo){
        return  $this->$valor = $campo;
    }
}
?>
