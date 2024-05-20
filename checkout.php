<?php
// Inclui o arquivo de conexão com o banco de dados
include 'components/connect.php';
// inicia a sessão
session_start();
// verifica se o usuario ta logado
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
// Se o usuário não estiver logado, define $user_id como vazio e redireciona para a página inicial
   $user_id = '';
   header('location:home.php');
};
// Verifica se o formulário foi enviado
if(isset($_POST['submit'])){
// Obtém os dados do formulário e os filtra para evitar injeção de SQL
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];
// Verifica se o carrinho do usuário não está vazio
   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      if($address == ''){
         $message[] = 'Adicione seu endereço!';
      }else{
         
         $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
         $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

         $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
         $delete_cart->execute([$user_id]);

         $message[] = 'Pedido realizado!';
      }
      
   }else{
      $message[] = 'Seu carrinho está vazio';
   }

}

?>

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
   

<?php include 'components/user_header.php'; ?>


<div class="heading">
   <h3>Pagamento</h3>
   <p><a href="home.php">Inicio</a> <span> / Pagamento</span></p>
</div>

<section class="checkout">

   <h1 class="title">Lista de compra</h1>

<form action="" method="post">

   <div class="cart-items">
      <h3>Itens do Carrinho</h3>
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
      <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price">R$<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></span></p>
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
      <p class="grand-total"><span class="name">Total:</span><span class="price">R$<?= $grand_total; ?></span></p>
      <a href="cart.php" class="btn">Ver Carrinho</a>
   </div>

   <input type="hidden" name="total_products" value="<?= $total_products; ?>">
   <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
   <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
   <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
   <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
   <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">

   
   <div class="user-info">
      <h3>Suas Informações</h3>
      <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
      <a href="update_profile.php" class="btn">Atualizar Informações</a>
      <h3>Endereço</h3>
      <p><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['address'] == ''){echo 'Coloque seu endereço';}else{echo $fetch_profile['address'];} ?></span></p>
      <a href="update_address.php" class="btn">Atualizar Endereço</a>
      <select name="method" class="box" required>
         <option value="" disabled selected>Selecionar Metodo de Pagamento --</option>
         <option value="cash on delivery">Dinheiro</option>
         <option value="credit card">Cartão de Credito</option>
         <option value="paytm">Cartão de debito</option>
         <option value="paypal">paypal</option>
      </select>
      <input type="submit" value="Realizar Pdido" class="btn <?php if($fetch_profile['address'] == ''){echo 'Desativado';} ?>" style="width:100%; background:var(--red); color:var(--white);" name="submit">
   </div>

</form>
   
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>