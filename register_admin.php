<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){ // Verifica se o ID do administrador não está definido na sessão
   header('location:admin_login.php'); // Redireciona para a página de login do administrador
};

if(isset($_POST['submit'])){ // Verifica se o formulário foi submetido

   $name = $_POST['name']; // Obtém e filtra os dados do formulário
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

// Prepara uma consulta para verificar se o nome já está em uso
   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
   $select_admin->execute([$name]);
   
   if($select_admin->rowCount() > 0){ // Verifica se o nome já está em uso
      $message[] = 'Nome ja em uso.'; // Adiciona uma mensagem de erro ao array $message
   }else{
      if($pass != $cpass){ // Verifica se as senhas não coincidem 
         $message[] = 'Senhas não conferem.'; // Adiciona uma mensagem de erro ao array $message
      }else{ // Insere um novo registro de administrador no banco de dados
         $insert_admin = $conn->prepare("INSERT INTO `admin`(name, password) VALUES(?,?)");
         $insert_admin->execute([$name, $cpass]);
         $message[] = 'Novo adm registrado.'; // Adiciona uma mensagem de sucesso ao array $message
      }
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
   <title>Registrar</title>


   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?> <!-- Inclui o cabeçalho do administrador -->



<section class="form-container">

   <form action="" method="POST"> <!-- Formulário para registro de um novo administrador -->
      <h3>Novo Registro</h3>
      <input type="text" name="name" maxlength="20" required placeholder="Insira seu nome" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="Insira sua senha" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" maxlength="20" required placeholder="Confirme sua senha" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Registrar" name="submit" class="btn">
   </form>

</section>


















<script src="../js/admin_script.js"></script>

</body>
</html>