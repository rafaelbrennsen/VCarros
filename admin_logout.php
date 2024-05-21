<?php
// Inclui o arquivo de conexão com o banco de dados
include 'connect.php';
// Inicia a sessão
session_start();
// Limpa todas as variáveis de sessão
session_unset();
// Destrói a sessão atual
session_destroy();

// Redireciona o usuário para a página de login do administrador
header('location:../admin/admin_login.php');

?>