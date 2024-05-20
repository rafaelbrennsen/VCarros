<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};?>
<?php include 'components/user_header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>VCarros</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   


<div class="heading">
   <h3>Compras</h3>
   <p><a href="html.php">Início</a> <span> / Compras</span></p>
</div>

<section class="orders">

   <h1 class="title">Suas Compras</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">Por favor faça login para ver suas compras!</p>';
      } else {
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
      <?php if(isset($fetch_orders['Nome'])): ?>
         <p>name : <span><?= $fetch_orders['Nome']; ?></span></p>
      <?php endif; ?>
      <?php if(isset($fetch_orders['Email'])): ?>
         <p>email : <span><?= $fetch_orders['Email']; ?></span></p>
      <?php endif; ?>
      <?php if(isset($fetch_orders['Número'])): ?>
         <p>number : <span><?= $fetch_orders['Número']; ?></span></p>
      <?php endif; ?>
      <?php if(isset($fetch_orders['Endereço'])): ?>
         <p>address : <span><?= $fetch_orders['Endereço']; ?></span></p>
      <?php endif; ?>
      <?php if(isset($fetch_orders['Método'])): ?>
         <p>Metodo de Pagamento : <span><?= $fetch_orders['Método']; ?></span></p>
      <?php endif; ?>
      <p>Seus Pedidos : <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>Preço total : <span>R$<?= $fetch_orders['total_price']; ?>/-</span></p>
      <p>Status do Pagamento : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
   </div>
   <?php
            }
         } else {
            echo '<p class="empty">Nenhuma compra feita ainda!</p>';
         }
      }
   ?>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
