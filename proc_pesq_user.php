<?php
//Incluir a conexão com banco de dados
include_once 'conexao.php';

$cep = filter_input(INPUT_POST, 'palavra', FILTER_SANITIZE_STRING);

//Pesquisar no banco de dados nome do usuario referente a palavra digitada
$result_user = "SELECT * FROM consultacep WHERE cep LIKE '%$cep%' LIMIT 20";
$resultado_user = mysqli_query($conn, $result_user);

if(($resultado_user) AND ($resultado_user->num_rows != 0 )){
	while($row_user = mysqli_fetch_assoc($resultado_user)){
		echo "<li>".$row_user['cep']."</li>";
		echo "<li>".$row_user['endereco']."</li>";
		echo "<li>".$row_user['bairro']."</li>";
		echo "<li>".$row_user['cidade']."</li>";
		echo "<li>".$row_user['estado']."</li>";
	}
}else{
	echo "Nenhum usuário encontrado ...";
}
