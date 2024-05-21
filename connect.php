<?php
// Define as credenciais de acesso ao banco de dados
$db_name = 'mysql:host=localhost:3307;dbname=vcarros'; // Nome do banco de dados e tipo de host
$user_name = 'root'; // Nome de usuário do banco de dados
$user_password = ''; // Senha do usuário do banco de dados
// Cria uma nova instância da classe PDO para estabelecer a conexão
$conn = new PDO($db_name, $user_name, $user_password);
// ^ representa uma conexão com o banco de dados MySQL
?>