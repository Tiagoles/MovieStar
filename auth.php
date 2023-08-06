<?php
    include_once("./Templates/header.php");
    include_once('url.php');
?>

<body>
        <div id="main-container">
            <div class="col-md-12">
                <div class="row" id="auth-row">
                    <div class="col-md-4 mt-5" id="login-container">
                        <h2>Entrar</h2>
                        <form action="<?=$BASE_URL?>/authProcess.php" method="post" autocomplete="off">
                            <input type="hidden" value="login" name="type"> 
                            <div class="form-group">
                                <input type="email" class="form-control" id="emailLogin" name="email" placeholder="E-mail"> 
                                <input type="password" class="form-control" name="password" id="passwordLogin" placeholder="Senha">
                            </div>
                            <input type="submit" value="Entrar" class="btn btn-card">
                        </form>
                        <span class="or">ou</span>
                        <button class="btn text-white" id="button_Register">Cadastre-se agora</button>
                    </div>
                    <div class="col-md-4 mt-3" id="register-container">
                        <h2>Registre-se</h2>
                        <form action="<?=$BASE_URL?>/authProcess.php" method="post" autocomplete="off">
                           <input type="hidden" value="register" name="type"> 
                           <div class="form-group">
                                <input type="email" name="email" id="emailRegister" class="form-control"  placeholder="E-mail">
                            </div>
                            <div class="form-group">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Nome">
                            </div>
                            <div class="form-group">
                                <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Sobrenome">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="passwordRegister" class="form-control" placeholder="Senha">
                            </div>
                            <div class="form-group">
                                <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="Confirme a sua senha">
                            </div>
                            <input type="submit" value="Registrar" class="btn btn-card">
                        </form>
                        <span class="or">ou</span>
                        <button class="btn text-white" id="button_Login">Já cadastrado? faça login</button>
                    </div>
                    
                </div>
            </div>
        </div>
</body>
 
<?php
    include("./Templates/footer.php");
?>