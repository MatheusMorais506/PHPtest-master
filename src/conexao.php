<?php
	$servidor = "localhost";
	$usuario = "";
	$senha = "";
	$dbname = "";
	
	//Criar a conexão
	$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
	if ($conn->connect_error){
		echo "Falha ao conectar: (" . $conn->connect_error . ")" . $conn->connect_error;
	};

	$query_create_table = "CREATE TABLE IF NOT EXISTS consultacep (
		id int(11) NOT NULL AUTO_INCREMENT,
		cep varchar(8) UNIQUE NOT NULL,
		endereco varchar(220) NOT NULL,
  		bairro varchar(220) NOT NULL,
  		cidade varchar(220) NOT NULL,
  		estado varchar(2) NOT NULL,
  		created datetime NOT NULL,
  		modified datetime DEFAULT NULL,
		PRIMARY KEY(id)
		)ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1"
	or die("Error in the create table ... " . $conn->connect_error);
	$conn->query($query_create_table);

?>