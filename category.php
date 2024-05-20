<?php
// Inclui o arquivo de conexão com o banco de dados
include 'components/connect.php';
// Inicia a sessão
session_start();
// Verifica se o ID do usuário está definido na sessão
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};
// Inclui o script para adicionar produtos ao carrinho
include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Categorias</title>


   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

 
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="products">

   <h1 class="title">Carros</h1>

   <div class="box-container">

      <?php
         $category = $_GET['category'];
         $select_products = $conn->prepare("SELECT * FROM `products` WHERE category = ?");
         // Consulta executada para selecionar todos os produtos da tabela products que correspondem a categoria fornecida.
         $select_products->execute([$category]);
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
         // Se houver produtos da categoria especificada, o código entra em loop, (while) para iterar sobre cada linha de resultado retornado pela consutla
         // Durante cada iteração, os dados do prod são recuperados e armazenados na var $fetch_products;
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
         <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
         <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
         <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
         <div class="name"><?= $fetch_products['name']; ?></div>
         <div class="flex">
            <div class="price"><span>$</span><?= $fetch_products['price']; ?></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
         </div>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">Nenhum produto adicionado ainda :(</p>';
         }
      ?>

   </div>

</section>

















<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>


<script src="js/script.js"></script>


</body>
</html>