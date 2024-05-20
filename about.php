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

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sobre VCarros</title>
<!-- Bibliotecas externas + css -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<div class="heading">
   <h3>Sobre nós</h3>
   <p><a href="home.php">Início</a> <span> / Sobre</span></p>
</div>


<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/about-img.png" alt="">
      </div>

      <div class="content">
         <h3>Sobre Nós</h3>
         <p>A VCarros é uma plataforma em que um endereço digital é fornecido para atuar como um robusto marketplace especializado na venda de carros novos e usados. Nosso objetivo é conectar compradores e vendedores de maneira eficiente, proporcionando transações seguras e satisfatórias. Nosso compromisso com a excelência e a inovação garante que cada interação com a VCarros seja uma jornada única e gratificante. Explore nosso site e descubra por que somos a escolha preferida para aqueles que procuram comprar ou vender carros com confiança e facilidade.</p>
         <a href="menu.php" class="btn">Todos os Carros</a>
      </div>

   </div>

</section>


<section class="steps">

   <h1 class="title">Passos Simples</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/step-1.png" alt="">
         <h3>Escolher um Carro</h3>
         <p>Encontre o melhor carro para você, de acordo com suas necessidades!</p>
      </div>

      <div class="box">
         <img src="images/step-2.png" alt="">
         <h3>Adicione ao Carrinho</h3>
         <p>Após escolher seu carro, adicione-o ao carrinho.</p>
      </div>

      <div class="box">
         <img src="images/map-icon.png" alt="">
         <h3>Realize o Pagamento</h3>
         <p>Realize o pagamento do carro para poder recebe-lo.</p>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">Avaliações dos Clientes</h1>

   <div class="swiper reviews-slider">

      <div class="swiper-wrapper">

         <div class="swiper-slide slide">
            <img src="images/pic-1.png" alt="">
            <p>Top!!! ❤️</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>João S.</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/pic-2.png" alt="">
            <p>Recomendo!</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Gabriela G.</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/pic-3.png" alt="">
            <p>Muito bom! 😍</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Lucas F.</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/pic-4.png" alt="">
            <p>Felicidade após a compra! 🔥🔥🔥🔥</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Juca D.</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/pic-5.png" alt="">
            <p>Amei demais.</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Tarcio E.</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/pic-6.png" alt="">
            <p>Muito feliz com meu carro novo.</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Aline M.</h3>
         </div>

      </div>

      <div class="swiper-pagination"></div>

   </div>

</section>





















<?php include 'components/footer.php'; ?>







<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<!-- Inicialização do Swiper para o carrossel de avaliações -->

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   grabCursor: true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
      slidesPerView: 1,
      },
      700: {
      slidesPerView: 2,
      },
      1024: {
      slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>