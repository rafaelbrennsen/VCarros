<?php
// Verifica se a variável $message está definida
if(isset($message)){
   // Loop através de cada mensagem na variável $message
   foreach($message as $message){
      // Exibe cada mensagem em uma div com a classe "message"
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="dashboard.php" class="logo">Admin<span>Painel</span></a>

      <nav class="navbar">
         <a href="dashboard.php">Início</a>
         <a href="products.php">Veículos</a>
         <a href="placed_orders.php">Compras</a>
         <a href="admin_accounts.php">Administração</a>
         <a href="users_accounts.php">Usuários</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
// Seleciona o perfil do administrador usando o ID do administrador
            $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
<!-- Exibe o nome do administrador e links para atualizar o perfil e fazer logout -->
         <p><?= $fetch_profile['name']; ?></p>
         <a href="update_profile.php" class="btn">Atualize o perfil</a>
         <div class="flex-btn">
            <a href="admin_login.php" class="option-btn">Login</a>
            <a href="register_admin.php" class="option-btn">Registre-se</a>
         </div>
         <a href="../home.php" onclick="return confirm('Deseja deslogar do site?');" class="delete-btn">Sair</a>
      </div>

   </section>

</header>