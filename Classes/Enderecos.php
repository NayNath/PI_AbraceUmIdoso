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
    public function buscarCep($cep){
        if (!isset($cep) || strlen($cep) != 8) {
            $mensagem = "ERRO: CEP invalido!!!";
        }
        else {
            $url = "https://viacep.com.br/ws/{$cep}/json/";


            $configuracoes = [
                "http"=>[
                    "method"=> "GET",
                    "header"=> "Content-Type: application/json"
                ]
            ];
           
            $context = stream_context_create($configuracoes);
            $response = file_get_contents($url, false, $context);


            if ($response == false) {
                $mensagem = "Erro ao acessar a API ViaCEP.";
            }
            else{
                $dados = json_decode($response, true);
                if (isset($dados['erro'])==true){
                    $mensagem = "CEP não encontrado.";
                }
                else{
                    echo "${dados['cep']}";
                    echo "${dados['bairro']}";
                    echo "${dados['uf']}";
                    echo "${dados['logradouro']}";
                    echo "${dados['localidade']}";
                }
            }  
        }
    }
}
?>
