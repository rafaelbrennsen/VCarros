<?php

include '../components/connect.php'; // Inclui o arquivo de conexão com o banco de dados

session_start(); // Inicia a sessão

$admin_id = $_SESSION['admin_id']; // Obtém o ID do administrador da sessão

if(!isset($admin_id)){ // Verifica se o ID do administrador está definido na sessão. Se não estiver, redireciona o usuário para a página de login do administrador
   header('location:admin_login.php');
}

if(isset($_POST['submit'])){ // Verifica se o formulário foi enviado

   $name = $_POST['name']; // Obtém e filtra o nome de usuário do formulário
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   if(!empty($name)){    // Verifica se o nome de usuário está vazio e se já existe no banco de dados
      $select_name = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
      $select_name->execute([$name]);
      if($select_name->rowCount() > 0){
         $message[] = 'username already taken!';
      }else{
// Atualiza o nome de usuário no banco de dados, se for válido
         $update_name = $conn->prepare("UPDATE `admin` SET name = ? WHERE id = ?");
         $update_name->execute([$name, $admin_id]);
      }
   }
   // Obtém a senha atual do administrador no banco de dados
   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $select_old_pass = $conn->prepare("SELECT password FROM `admin` WHERE id = ?");
   $select_old_pass->execute([$admin_id]);
   $fetch_prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
   $prev_pass = $fetch_prev_pass['password'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = sha1($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);
   // Obtém e filtra as senhas fornecidas no formulário ^
   // Verifica se a senha antiga fornecida no formulário corresponde à senha atual do administrador
   if($old_pass != $empty_pass){
      if($old_pass != $prev_pass){
         $message[] = 'Senhas não combinam';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'Senhas não combinam';
      }else{
         // Verifica se a nova senha e a confirmação de senha correspondem e se a nova senha não está vazia
         if($new_pass != $empty_pass){
         // Atualiza a senha do administrador no banco de dados, se for válido
            $update_pass = $conn->prepare("UPDATE `admin` SET password = ? WHERE id = ?");
            $update_pass->execute([$confirm_pass, $admin_id]);
            $message[] = 'Sucesso!';
         }else{
            $message[] = 'Insira uma nova senha.';
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
   <title>Atualizar perfil</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>



<section class="form-container">

   <form action="" method="POST">
      <h3>Atualizar perfil</h3>
      <input type="text" name="name" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" placeholder="<?= $fetch_profile['name']; ?>">
      <input type="password" name="old_pass" maxlength="20" placeholder="Insira sua senha antiga." class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" maxlength="20" placeholder="Insira sua nova senha." class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" maxlength="20" placeholder="Confirme sua nova senha." class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Atualize." name="submit" class="btn">
   </form>

</section>












<script src="../js/admin_script.js"></script>

</body>
</html>