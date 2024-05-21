<?php

include '../components/connect.php'; // Inclui o arquivo de conexão com o banco de dados

session_start(); // Inicia a sessão

$admin_id = $_SESSION['admin_id']; // Obtém o ID do administrador da sessão

if(!isset($admin_id)){ // Verifica se o ID do administrador não está definido na sessão
   header('location:admin_login.php'); // Redireciona para a página de login do administrador
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Painel</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>



<section class="dashboard"> 

   <h1 class="heading">Painel de Dados</h1>

   <div class="box-container">

   <div class="box">
      <h3>Bem-Vindo</h3>
      <p><?= $fetch_profile['name']; ?></p>
      <a href="update_profile.php" class="btn">Atualizar perfil.</a>
   </div>

   <div class="box"> <!-- Box de pedidos completos totais -->
      <?php
         $total_completes = 0; // inicia c valor 0. será usada para calcular o total dos preços dos pedidos completos.
         $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");  //consulta SQL é preparada para selecionar todas as linhas da tabela "orders" onde o status de pagamento é "completed".
         $select_completes->execute(['completed']); 
         while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){ // utilizado para iterar sobre o resultado da consulta
            $total_completes += $fetch_completes['total_price']; // preço total de cada pedido é somado.
         }
      ?>
<div class="box"> <!-- Box de total de pedidos completos -->
   <h3><span>R$</span><?= $total_completes; ?><span>/-</span></h3> <!-- Exibe o valor total dos pedidos completos -->
   <p>Total</p> <!-- Título indicando que se trata do total -->
   <a href="placed_orders.php" class="btn">Veja</a> <!-- Botão para visualizar mais detalhes -->
</div>

<div class="box"> <!-- Box de número total de pedidos -->
   <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders`"); // Prepara uma consulta SQL para selecionar todas as linhas da tabela 'orders'
      $select_orders->execute(); // Executa a consulta
      $numbers_of_orders = $select_orders->rowCount(); // Conta o número de linhas retornadas pela consulta
   ?>
   <h3><?= $numbers_of_orders; ?></h3> <!-- Exibe o número total de pedidos -->
   <p>Compras Totais</p> <!-- Título indicando que se trata do número total de pedidos -->
   <a href="placed_orders.php" class="btn">Veja</a> <!-- Botão para visualizar mais detalhes -->
</div>

<div class="box"> <!-- Box de número total de produtos -->
   <?php
      $select_products = $conn->prepare("SELECT * FROM `products`"); // Prepara uma consulta SQL para selecionar todas as linhas da tabela 'products'
      $select_products->execute(); // Executa a consulta
      $numbers_of_products = $select_products->rowCount(); // Conta o número de linhas retornadas pela consulta
   ?>
   <h3><?= $numbers_of_products; ?></h3> <!-- Exibe o número total de produtos -->
   <p>Produtos Adicionados</p> <!-- Título indicando que se trata do número total de produtos -->
   <a href="products.php" class="btn">Veja</a> <!-- Botão para visualizar mais detalhes -->
</div>

<div class="box"> <!-- Box de número total de contas de usuários -->
   <?php
      $select_users = $conn->prepare("SELECT * FROM `users`"); // Prepara uma consulta SQL para selecionar todas as linhas da tabela 'users'
      $select_users->execute(); // Executa a consulta
      $numbers_of_users = $select_users->rowCount(); // Conta o número de linhas retornadas pela consulta
   ?>
   <h3><?= $numbers_of_users; ?></h3> <!-- Exibe o número total de contas de usuários -->
   <p>Contas</p> <!-- Título indicando que se trata do número total de contas de usuários -->
   <a href="users_accounts.php" class="btn">Vejas</a> <!-- Botão para visualizar mais detalhes -->
</div>

<div class="box"> <!-- Box de número total de contas de administradores -->
   <?php
      $select_admins = $conn->prepare("SELECT * FROM `admin`"); // Prepara uma consulta SQL para selecionar todas as linhas da tabela 'admin'
      $select_admins->execute(); // Executa a consulta
      $numbers_of_admins = $select_admins->rowCount(); // Conta o número de linhas retornadas pela consulta
   ?>
   <h3><?= $numbers_of_admins; ?></h3> <!-- Exibe o número total de contas de administradores -->
   <p>Admin</p> <!-- Título indicando que se trata do número total de contas de administradores -->
   <a href="admin_accounts.php" class="btn">Veja</a> <!-- Botão para visualizar mais detalhes -->
</div>

   </div>

   </div>

</section>











<script src="../js/admin_script.js"></script>

</body>
</html>