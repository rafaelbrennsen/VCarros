<?php
// Inclui o arquivo de conexão com o banco de dados
include '../components/connect.php';

// Inicia a sessão
session_start();

// Obtém o ID do administrador da sessão
$admin_id = $_SESSION['admin_id'];

// Verifica se o ID do administrador não está definido na sessão e redireciona para a página de login, finalizando o script
if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit(); // Adicionando exit() para garantir que o script pare após redirecionar
}

// Verifica se o formulário de atualização de pagamento foi enviado
if (isset($_POST['update_payment'])) {
    // Obtém o ID do pedido e o novo status de pagamento do formulário
    $order_id = $_POST['order_id'];
    $payment_status = $_POST['payment_status'];
    // Prepara e executa uma consulta para atualizar o status de pagamento do pedido no banco de dados
    $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $update_status->execute([$payment_status, $order_id]);
    // Adiciona uma mensagem informando que o pagamento foi atualizado
    $message[] = 'Pagamento atualizado.';
} else {
    // Inicializando $payment_status como vazio caso o formulário não seja enviado
    $payment_status = '';
}

// Verifica se há uma requisição para excluir um pedido
if (isset($_GET['delete'])) {
    // Obtém o ID do pedido a ser excluído da URL
    $delete_id = $_GET['delete'];
    // Prepara e executa uma consulta para excluir o pedido do banco de dados usando o ID
    $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
    $delete_order->execute([$delete_id]);
    // Após excluir o pedido, redireciona de volta para a página de pedidos
    header('location:placed_orders.php');
    exit(); // Adicionando exit() para garantir que o script pare após redirecionar
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Compras Realizadas</title>

   <!-- Inclusão do CSS do Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- Inclusão do arquivo de estilo personalizado -->
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- Seção de pedidos realizados -->
<section class="placed-orders">

   <!-- Título da seção -->
   <h1 class="heading">Compras Realizadas</h1>

   <!-- Container para os boxes de pedidos -->
   <div class="box-container">

   <?php
      // Prepara e executa uma consulta para selecionar todos os pedidos do banco de dados
      $select_orders = $conn->prepare("SELECT * FROM `orders`");
      $select_orders->execute();
      
      // Verifica se há algum pedido retornado pela consulta
      if ($select_orders->rowCount() > 0) {
         // Itera sobre todos os pedidos retornados
         while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
   ?>
   <!-- Box de pedido -->
   <div class="box">
      <!-- ID do usuário que realizou o pedido -->
      <p> ID de usuario : <span><?= $fetch_orders['user_id']; ?></span> </p>
      <!-- Data e hora em que o pedido foi realizado -->
      <p> Adicionado em : <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <!-- Nome do cliente -->
      <p> Nome : <span><?= $fetch_orders['name']; ?></span> </p>
      <!-- E-mail do cliente -->
      <p> email : <span><?= $fetch_orders['email']; ?></span> </p>
      <!-- Número de telefone do cliente -->
      <p> Telefone : <span><?= $fetch_orders['number']; ?></span> </p>
      <!-- Endereço de entrega do pedido -->
      <p> Endereço : <span><?= $fetch_orders['address']; ?></span> </p>
      <!-- Número total de itens no pedido -->
      <p> Itens : <span><?= $fetch_orders['total_products']; ?></span> </p>
      <!-- Preço total do pedido -->
      <p> Preço Total : <span>R$<?= $fetch_orders['total_price']; ?>/-</span> </p>
      <!-- Método de pagamento do pedido -->
      <p> Metodo de Pagamento : <span><?= isset($fetch_orders['payment_status']) ? $fetch_orders['payment_status'] : ''; ?></span> </p>
      <!-- Formulário para atualizar o status de pagamento do pedido -->
      <form action="" method="POST">
         <!-- Campo oculto para enviar o ID do pedido -->
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
         <!-- Dropdown para selecionar o novo status de pagamento -->
         <select name="payment_status">
            <option value="<?= $payment_status ?>" selected disabled><?= isset($fetch_orders['payment_status']) ? $fetch_orders['payment_status'] : ''; ?></option>
            <option value="Pendente">Pendente</option>
            <option value="completed">Completada</option>
         </select>
         <!-- Botão de envio do formulário -->
         <input type="submit" value="Atualize." class="btn" name="update_payment">
      </form>
   </div>
   <!-- Fechando a chave do loop while -->
   <?php
         }
      } else {
         echo '<p class="empty">Nenhuma compra realizada ainda.</p>';
      }
   ?>

   </div>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>