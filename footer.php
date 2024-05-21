<footer class="footer"> <!-- Define a seção de rodapé da página. -->

   <section class="grid"> <!--  Define uma seção de grade para organizar o conteúdo do rodapé. -->

      <div class="box"> <!-- Representa um bloco de conteúdo dentro da seção de grade -->
         <img src="images/email-icon.png" alt="">
         <h3>Nosso Email!</h3>
         <a href="mailto:.com">VCarros@gmail.com</a>
         <a href="mailto:.com">VCarros@hotmail.com</a>
      </div>

      <div class="box">
         <img src="images/clock-icon.png" alt="">
         <h3>Suporte - Horário de Funcionamento</h3>
         <p>6:00 até 23:00</p>
      </div>

      <div class="box">
         <img src="images/map-icon.png" alt="">
         <h3>Nosso Endereço</h3>
         <a href="#">Brasil, Curitiba-PR, PUCPR, Eng. de Software</a>
      </div>

      <div class="box">
         <img src="images/phone-icon.png" alt="">
         <h3>Nossos Telefones</h3>
         <a href="tel:1234567890">41 9898-9888</a>
         <a href="tel:1112223333">41 3003-3000</a>
      </div>

   </section>

   <div class="credit">&copy; copyright @ <?= date('Y'); ?> Por <span>Mariana Cavilha, Rafael Segatto, Rafael Brennsen, Leonardo Tulio</span> | feito com amor ❤️</div>
<!-- ^ date = Exibe o ano atual dinamicamente utilizando a função date() do PHP. -->
</footer>

<div class="loader"> <!--  Define uma seção para exibir um loader. -->
   <img src="images/loader.gif" alt="">
   <!-- Meu gif de carrinho bravo -->
</div>