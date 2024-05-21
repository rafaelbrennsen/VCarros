<?php

include '../components/connect.php'; // Inclui o arquivo de conexão com o banco de dados


session_start(); // Inicia a sessão

$admin_id = $_SESSION['admin_id']; // Obtém o ID do administrador da sessão


if(!isset($admin_id)){ // Verifica se o ID do administrador não está definido na sessão
   header('location:admin_login.php'); // Redireciona para a página de login do administrador
};

if(isset($_POST['update'])){ // Verifica se o formulário de atualização foi submetido

   $pid = $_POST['pid'];    // Obtém e filtra os dados do formulário
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
// Atualiza os dados do produto no banco de dados
   $update_product = $conn->prepare("UPDATE `products` SET name = ?, category = ?, price = ? WHERE id = ?");
   $update_product->execute([$name, $category, $price, $pid]);

   $message[] = 'Produto Atualizado!';
// Obtém e filtra os dados da nova imagem do produto
   $old_image = $_POST['old_image'];
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   if(!empty($image)){ // Verifica se uma nova imagem foi enviada
      if($image_size > 2000000){ // Verifica se o tamanho da imagem é maior que 2MB
         $message[] = 'Tamanho da imagem é muito grande :(';
      }else{  // Atualiza a imagem do produto no banco de dados e move o arquivo de imagem para a pasta de destino
         $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $pid]);
         move_uploaded_file($image_tmp_name, $image_folder);
         unlink('../uploaded_img/'.$old_image); // Remove a imagem antiga do servidor
         $message[] = 'Imagem Atualizada';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Atualize o produto.</title>

 
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>


<section class="update-product">

   <h1 class="heading">Atualize o Produto.</h1>

   <?php
      $update_id = $_GET['update'];
      $show_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $show_products->execute([$update_id]);
      if($show_products->rowCount() > 0){
         while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
      <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <span>Atualize o nome</span>
      <input type="text" required placeholder="Insira o nome do carro" name="name" maxlength="100" class="box" value="<?= $fetch_products['name']; ?>">
      <span>Atualize o preço</span>
      <input type="number" min="0" max="9999999999" required placeholder="Insira o preço" name="price" onkeypress="if(this.value.length == 10) return false;" class="box" value="<?= $fetch_products['price']; ?>">
      <span>Atualize a categoria</span>
      <select name="category" class="box" required>
         <option selected value="<?= $fetch_products['category']; ?>"><?= $fetch_products['category']; ?></option>
         <option value="Toyota">Toyota</option>
         <option value="Chevrolet">Chevrolet</option>
         <option value="Audi">Audi</option>
         <option value="Bmw">Bmw</option>
         <option value="Fiat">Fiat</option>
         <option value="Ford">Ford</option>
      </select>
      <span>Atualize a Imagem</span>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
      <div class="flex-btn">
         <input type="submit" value="update" class="btn" name="update">
         <a href="products.php" class="option-btn">Volte</a>
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">Nenhum produto adicionado ainda.</p>';
      }
   ?>

</section>













<script src="../js/admin_script.js"></script>

</body>
</html>