<?php

include '../components/connect.php';

session_start(); // inicia sessão php

if(isset($_POST['submit'])){ // verifica se o form de login foi enviado ' determinado pelo paramentro submit '

   $name = $_POST['name']; // = $name = obtem o nome de usuario do formulario 
   $name = filter_var($name, FILTER_SANITIZE_STRING); // remove/codifica caracteres não seguros da string 
   $pass = sha1($_POST['pass']); // = $pass = obtem a senha de usuario e a criptografia usando o SHA1 
   $pass = filter_var($pass, FILTER_SANITIZE_STRING); // remove/codifica caracteres não seguros da string 

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND password = ?"); // Consulta o SQL para selecionar o administrador com o nome de usu e senha de usu;
   $select_admin->execute([$name, $pass]); // executa a consulta com os valores fornecidos. 
   
   if($select_admin->rowCount() > 0){ // verifica se a consulta resultou pelo menos 1 linha. 
      $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC); // obtem os dados do adm. 
      $_SESSION['admin_id'] = $fetch_admin_id['id']; // armazena o id do adm na variavel da sessão admin_id
      header('location:dashboard.php'); // redireciona para o painel de controle. 
   }else{
      $message[] = 'Nome e/ou senha incorreto(s).'; // msg de erro armazenada. 
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head> 
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php
if(isset($message)){ // verifica se a var $message é definida e não é nula 
   foreach($message as $message){ // itera sobre cada elemento do array $message 
      echo '
      <div class="message">
         <span>'.$message.'</span> 
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   } // no span, exibe a msg de erro dentro da tag span
   // no i class, exibe msg c ícone de fechar, q ao ser clicado, remove o elemento pai (a div c a class message) da árvore.
}
?>



<section class="form-container">

   <form action="" method="POST"> <!-- form cria um formulario, action fala p onde os dados do form vão, como está vazio, retorna p msm pag, logo, o form é processado pela msm pag q se encontra. -->
      <h3>Entre agora! <!-- Formulário -->
      </h3>
      <p>Nome = <span>admin</span> & Senha = <span>111</span></p> <!-- p = paragrafo, mostra exemplo de nome d usuario e senha -->
      <input type="text" name="name" maxlength="20" required placeholder="Insira seu nome" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="Insira sua senha" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Login" name="submit" class="btn">
   </form>
<!-- ^^ Campos de entrada de texto, required é q o campo é obrigatorio, placeholder exibe orientação, class box é so atribuicao ao CSS. -->
<!-- oniput =  impede que o usuário insira espaços no início ou no final do nome de usuário. É COM JAVASCRIPT. --> 
</section>













</body>
</html>