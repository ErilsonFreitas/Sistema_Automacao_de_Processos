<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="view/Bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="view/Bootstrap/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="view/js/jquery-1.8.2.js" type="text/javascript" ></script>
</head>

<body class="mh-100">
<section class="vh-100">
        <div class="container py-5 h-100">
          <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-8 col-lg-7 col-xl-6">
              
              <img src="view/icon/test.png" class="img-fluid" alt="Imagem">
            </div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1 border border-1 shadow-lg p-3 mb-5 bg-body rounded">
              <?php 
                if(isset($_SESSION['msg']) and ($_SESSION['msg'] != '')){
                  echo('<div class="alert alert-danger alert-dismissible fade show messageBox" id="myBtn">
                  <strong>'.$_SESSION['msg'].'</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" id="myAlert"></button>
                  </div>');
                  unset($_SESSION['msg']);
                  session_destroy();
                }
              
              ?>
                
              <form name="formlogin" method="post" action="controller/login.php" id="formlogin" >
                <div class="form-outline mb-4">
                  <input type="text" name="login" id="inputUser" class="form-control form-control-lg border border-2 rounded" autocomplete="off" />
                  <label class="form-label" for="inputUser">Usuário</label>
                </div>
                <div class="form-outline mb-4">
                  <input type="password" name="senha"  id="inputPass" class="form-control form-control-lg border border-2 rounded" autocomplete="off"/>
                  <label class="form-label" for="inputPass">Senha</label>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">Acessar Sistema</button>
              </form>
            </div>
          </div>
        </div>
      </section>
</body>

</html>