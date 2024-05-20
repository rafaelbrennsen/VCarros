<?php
session_start();

// Verifica se o usuário não está logado
if (!isset($_SESSION['user_id'])) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: login.php");
    exit; // Certifique-se de sair após o redirecionamento
}
// Inclui o arquivo de conexão com o banco de dados
include 'components/connect.php';
// Inicia a sessão
session_start();
// Verifica se o ID do usuário está definido na sessão
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
// Redireciona para a página inicial se o usuário não estiver logado
   header('location:home.php');
};
// Se o formulário de exclusão de item for enviado
if(isset($_POST['delete'])){
   // Obtém o ID do item do carrinho a ser excluído
   $cart_id = $_POST['cart_id'];
   // Prepara e executa a query para excluir o item do carrinho
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
   $message[] = 'Item deletado.';
}
// Se o formulário de exclusão de todos os itens do carrinho for enviado
if(isset($_POST['delete_all'])){
   // Prepara e executa a query para excluir todos os itens do carrinho do usuário
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   $message[] = 'Carrinho limpo.';
}
// Se o formulário de atualização da quantidade de um item do carrinho for enviado
if(isset($_POST['update_qty'])){
   // Obtém o ID do item do carrinho e a nova quantidade
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   // Prepara e executa a query para atualizar a quantidade do item no carrinho
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'Carrinho atualizado.';
}
// Inicializa a variável para armazenar o total geral do carrinho
$grand_total = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Carrinho</title>

  
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   

<?php include 'components/user_header.php'; ?>


<div class="heading">
   <h3>Carrinho de Compras</h3>
   <p><a href="home.php">Início</a> <span> / Carrinho</span></p>
</div>



<section class="products">

   <h1 class="title">Seu carrinho</h1>

   <div class="box-container">

      <?php
         $grand_total = 0;
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
         <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
         <button type="submit" class="fas fa-times" name="delete" onclick="return confirm('Excluir item do carrinho?');"></button>
         <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
         <div class="name"><?= $fetch_cart['name']; ?></div>
         <div class="flex">
            <div class="price"><span>R$</span><?= $fetch_cart['price']; ?></div>
            <input type="number" name="qty" class="qty" min="1" max="1" value="1" maxlength="2">
            <button type="submit" class="fas fa-edit" name="update_qty"></button>
         </div>
         <div class="sub-total"> sub total : <span>R$<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div>
      </form>
      <?php
               $grand_total += $sub_total;
            }
         }else{
            echo '<p class="empty">Seu carrinho está vazio.</p>';
         }
      ?>

   </div>

   <div class="cart-total">
      <p>Total: <span>R$<?= $grand_total; ?></span></p>
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">Continuar para o pagamento</a>
   </div>

   <div class="more-btn">
      <form action="" method="post">
         <button type="submit" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" name="delete_all" onclick="return confirm('Deseja mesmo retirar todos itens do carrinho?');">Remover todos itens</button>
      </form>
      <a href="menu.php" class="btn">Continue Comprando</a>
   </div>

</section>













<?php include 'components/footer.php'; ?>










<script src="js/script.js"></script>

</body>
</html>