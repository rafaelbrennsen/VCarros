<?php
// Verifica se a variável $message está definida
if(isset($messages)){
    // Itera sobre cada mensagem na variável $messages
    foreach($messages as $message){
        // Exibe cada mensagem em um formato HTML
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

      <a href="home.php" class="logo">VCarros 🚗</a>

      <nav class="navbar">
         <a href="home.php">Início</a>
         <a href="about.php">Sobre Nós</a>
         <a href="menu.php">Todos Carros</a>
         <a href="orders.php">Compras realizadas</a>
         <a href="anunciar.php">Anunciar Carro</a>
      </nav>

      <div class="icons">
         <?php
            // Conta o número de itens no carrinho do usuário atual
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $total_cart_items = $count_cart_items->rowCount();
         ?>
         <!-- Links para pesquisa e carrinho, exibindo o número total de itens no carrinho -->
         <a href="search.php"><i class="fas fa-search"></i></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
         <!-- Ícones para usuário e menu -->
         <div id="user-btn" class="fas fa-user"></div>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <div class="profile">
         <?php
         // Seleciona o perfil do usuário atual
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            // Verifica se o perfil foi encontrado
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <!-- Exibe o nome do usuário e botões de perfil e logout -->
         <p class="name"><?= $fetch_profile['name']; ?></p>
         <div class="flex">
            <a href="profile.php" class="btn">Perfil</a>
            <a href="components/user_logout.php" onclick="return confirm('Quer mesmo sair da conta?');" class="delete-btn">Sair</a>
         </div>
         <p class="account">
         <!-- Links para login e registro -->
            <a href="login.php">Login</a> or
            <a href="register.php">Registre-se</a>
         </p> 
         <?php
            }else{
         ?>
            <!-- Se o perfil não foi encontrado, exibe links de login -->
            <p class="name">Por favor Registre-se ou realize o Login.</p>
            <a href="login.php" class="btn">Login</a>
            <a href="admin/admin_login.php" class="btn">Login de admin</a>
         <?php
          }
         ?>
      </div>

   </section>

</header>

