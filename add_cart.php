<?php
// Verifica se o formulário de adição ao carrinho foi submetido
if(isset($_POST['add_to_cart'])){
   // Verifica se o ID do usuário está vazio
   if($user_id == ''){
   // Redireciona o usuário para a página de login se o ID do usuário estiver vazio
      header('location:login.php');
   }else{
      // Obtém e filtra os dados enviados pelo formulário
      $pid = $_POST['pid'];
      $pid = filter_var($pid, FILTER_SANITIZE_STRING);
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $price = $_POST['price'];
      $price = filter_var($price, FILTER_SANITIZE_STRING);
      $image = $_POST['image'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);
      $qty = $_POST['qty'];
      $qty = filter_var($qty, FILTER_SANITIZE_STRING);
      // Verifica se o item já está no carrinho do usuário
      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
      $check_cart_numbers->execute([$name, $user_id]);
      // Se o item já estiver no carrinho, exibe uma mensagem informando ao usuário
      if($check_cart_numbers->rowCount() > 0){
         $message[] = 'Já adicionado ao carrinho!';
      }else{
         // Se o item ainda não estiver no carrinho, insere-o no banco de dados
         $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
         $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
         $message[] = 'Adicionado!';
         
      }

   }

}

?>