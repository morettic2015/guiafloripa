<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *
 * DB::$user = 'appguia';
  DB::$password = '#4ppgu14Fl0r1p4!';
  DB::$dbName = 'guiafloripa';
  DB::$host = 'guiafloripa.com.br';
  DB::$port = '3306';
 */

class MysqlDB {

// Nas linhas abaixo você poderá colocar as informações do Banco de Dados.
    var $host = "guiafloripa.com.br"; // Nome ou IP do Servidor
    var $user = "appguia"; // Usuário do Servidor MySQL
    var $senha = "#4ppgu14Fl0r1p4!"; // Senha do Usuário MySQL
    var $dbase = "guiafloripa"; // Nome do seu Banco de Dados
// Criaremos as variáveis que Utilizaremos no script
    var $query;
    var $link;
    var $resultado;
    var $stmt;

// Instancia o Objeto para podermos usar
    function MySQL() {
// $this->conecta();
    }

    function hasNext() {
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
//  return mysqli_fetch_row($this->resultado);
    }

// Cria a função para efetuar conexão ao Banco MySQL (não é muito diferente da conexão padrão).
// Veja que abaixo, além de criarmos a conexão, geramos condições personalizadas para mensagens de erro.
    function connect() {

        $this->link = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbase, $this->user, $this->senha, array(
            PDO::ATTR_PERSISTENT => true
        ));
//
        /*   $this->link = mysqli_connect($this->host, $this->user, $this->senha, $this->dbase);
          if (!$this->link) {
          die("Database connection failed: " . mysqli_connect_error());
          } */
    }

// Cria a função para "query" no Banco de Dados
    function execute($query) {
        $this->connect();
        //var_dump($this->link);
        $this->stmt = $this->link->query($query);
        //var_dump($this->stmt);
        echo $query;
        /*  $this->connect();
          $this->resultado = mysqli_query($this->link, $query);
          return $this->resultado; */
    }

    function closeConn() {
        $this->link = null;
        /*   $this->resultado->close();
          $this->link->close(); */
    }

}

?>
