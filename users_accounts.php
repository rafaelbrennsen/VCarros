<?php
// Inclui o arquivo de conexão com o banco de dados
include '../components/connect.php';
// Inicia a sessão
session_start();
// Obtém o ID do administrador da sessão
$admin_id = $_SESSION['admin_id'];
// Verifica se o ID do administrador está definido na sessão. Se não estiver, redireciona o usuário para a página de login do administrador
if(!isset($admin_id)){
   header('location:admin_login.php');
}
// Verifica se a solicitação GET para deletar um usuário está definida
if(isset($_GET['delete'])){
// Obtém o ID do usuário a ser excluído da solicitação GET
   $delete_id = $_GET['delete'];
// Prepara e executa a consulta para excluir o usuário pelo ID
   $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_users->execute([$delete_id]);
// Prepara e executa a consulta para excluir pedidos associados ao usuário pelo ID
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
   $delete_order->execute([$delete_id]);
// Prepara e executa a consulta para excluir itens do carrinho associados ao usuário pelo ID
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$delete_id]);
// Redireciona de volta para a página de contas de usuário após a exclusão
   header('location:users_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contas</title>

 
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>



<section class="accounts">

   <h1 class="heading">Contas do Usuário</h1>
<!-- Contêiner para exibir as contas de usuário -->
   <div class="box-container">

   <?php
    // Seleciona todas as contas de usuário do banco de dados
      $select_account = $conn->prepare("SELECT * FROM `users`");
      $select_account->execute();
      // Verifica se há contas de usuário encontradas
      if($select_account->rowCount() > 0){
         // Loop através de cada conta de usuário
         while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <!-- Exibe cada conta de usuário em um box -->
   <div class="box">
      <p> user id : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> username : <span><?= $fetch_accounts['name']; ?></span> </p>
<!-- Link para excluir a conta de usuário com um aviso de confirmação -->
      <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('Deletar essa conta?');">Deletar</a>
   </div>
   <?php
      }
   }else{// Se não houver contas de usuário encontradas, exibe uma mensagem indicando que nenhuma conta está disponível
      echo '<p class="empty">Nenhuma conta disponível</p>';
   }
   ?>

   </div>

</section>










<script src="../js/admin_script.js"></script>

</body>
</html>