<?php
//Gerencia exclusão de contas de adm, junto com exibição da lista de adm e cria novas contas adm.

include '../components/connect.php'; //inclui o arquivo php q contem as infos do bd

session_start(); // Inicia sessão 

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admin = $conn->prepare("DELETE FROM `admin` WHERE id = ?");
   $delete_admin->execute([$delete_id]);
   header('location:admin_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head> 
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contas ADM</title>

 
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


   <link rel="stylesheet" href="../css/admin_style.css"> 

</head>
<body>

<?php include '../components/admin_header.php' ?>


<section class="accounts">

   <h1 class="heading">Contas Adm</h1>

   <div class="box-container">

   <div class="box">
      <p>Registrar novo Adm</p>
      <a href="register_admin.php" class="option-btn">Registrar.</a>
   </div>  <!-- puxa a pasta register_admin.php para realizar o registro. -->

   <?php
      $select_account = $conn->prepare("SELECT * FROM `admin`");
      $select_account->execute();
      if($select_account->rowCount() > 0){
         while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  // Contém o id adm atual 
   ?>
   <div class="box">
      <p> admin id : <span><?= $fetch_accounts['id']; ?></span> </p> <!-- Exibindo id atual e nome abaixo do adm -->
      <p> username : <span><?= $fetch_accounts['name']; ?></span> </p>
      <div class="flex-btn"> <!-- Link c button para excluir a conta adm, envia um pedido com o cmd GET delete, exibindo um aviso dps -->
         <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('Apagar essa Conta');">Apagar</a>
         <?php 
            if($fetch_accounts['id'] == $admin_id){
               echo '<a href="update_profile.php" class="option-btn">update</a>';
            }
         ?>
      </div>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">Nenhuma conta disponível</p>';
   }
   ?>

   </div>

</section>























<script src="../js/admin_script.js"></script>

</body>
</html>