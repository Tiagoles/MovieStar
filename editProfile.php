<?php
include_once("Templates/header.php");
include_once("dao/UserDAO.php");
include_once("database.php");
include_once("url.php");
$user = new User();
$UserDAO = new UserDAOMysql($conn, $BASE_URL);
$UserData = $UserDAO->verifyToken();
if($UserData){
    include("SessionDestroy.php");
}
$fullName = $user->GetFullname($UserData);
if (empty($UserData->image)) {
    $UserData->image = "user.png";
}
?>

<body>
    <div class="container-fluid" id="main-container">
        <div class="col-md-12">
            <form method="post" action="<?= $BASE_URL ?>processUser.php" class="form" enctype="multipart/form-data">
                <input type="hidden" name="type" value="update">
                <div class="row">
                    <div class="col-md-4 ms-2">
                        <p class="h1"><?= $fullName ?></p>
                        <p class="page-description">Altere os seus dados abaixo:</p>

                        <div class="col-auto">
                            <label for="name" class="col-form-label">Nome</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?= ucfirst($UserData->name) ?>">
                        </div>


                        <div class="col-auto">
                            <label for="lastname" class="col-form-label">Sobrenome</label>
                            <input type="text" id="lastname" name="lastname" class="form-control" value="<?= ucfirst($UserData->lastname) ?>">
                        </div>


                        <div class="col-auto">
                            <label for="lastname" class="col-form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control disabled" readonly value="<?= $UserData->email ?>">
                        </div>
                        <div id="BtnChangeContainer" class="d-flex justify-content-end">
                            <input type="submit" value="Alterar" class="mt-1 btn btn-card">
                        </div>

                    </div>
                    <div class="ms-5 col-md-3" id="containerImgBio">
                        <div id="profile-img-container" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $UserData->image ?>');"></div>
                        <label for="image">Foto de perfil:</label>
                        <input type="file" class="form-control form-control-sm" id="image" name="image">
                        <div class="mt-1">
                            <textarea class="form-control" name="bio" id="bio" cols="" rows="6" placeholder="Conte sobre você..."><?= ucfirst($UserData->bio) ?></textarea>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-4 ms-2">
                    <form action="<?= $BASE_URL ?>processUser.php" method="post">
                        <div class="col-auto">
                            <h2>Alteração de senha</h2>
                            <p class="page-description">Digite a nova senha e confirme:</p>
                            <input type="hidden" name="type" value="changepassword">
                            <input type="hidden" name="id" value="<?=$UserData->id?>">
                            <label for="password">Senha</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Digite a sua nova senha">
                        </div>
                        <div class="col-auto">
                            <input type="hidden" name="type" value="changepassword">
                            <label for="confirmpassword">Senha</label>
                            <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Digite novamente a sua senha">
                            <div id="BtnChangePasswordContainer" class="d-flex justify-content-end">
                                <input type="submit" class="mt-1 btn btn-card" value="Alterar senha">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
include_once("Templates/footer.php");
