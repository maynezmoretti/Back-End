<?php
declare(strict_types=1);

// Camada de Acesso a Dados (DAO) para Almoxarifado
// essa camada é uma classe - usa paradigma de Programação Orientada ao Objeto

final class AlmoxarifadoDAO {
    // atributos -> características do objeto
    private PDO $pdo;

    // métodos -> ações
    // método que toda classe tem -> construtor -> permite instanciar objetos
    public function __constructor(PDO $pdo){
        $this->pdo = $pdo;
    }
    
    // métodos do CRUD
}