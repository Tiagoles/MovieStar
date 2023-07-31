

<?php
require_once('Models/User.php');
if(empty($Review->user->image)){
    $Review->user->image = 'user.png';
}
$User = new User();
$FullName = $User->getFullName($Review->user);
?>
<div class="col-md-12 review">
    <div class="row">
        <div class="col-md-1">
            <div class="profile-image-container review-image" style="background-image:url('<?= $BASE_URL ?>img/users/<?= $Review->user->image ?>')"></div>
        </div>
        <div class="col-md-9 author-details-container">
            <h4 class="author-name">
                <a href="profile.php?id=<?= $UserData->id ?>"><?=$FullName?></a>
            </h4>
            <p id="note"><i class="fas fa-star"></i><?=$Review->rating?></p>
        </div>
        <div class="col-md-3 comment">
            <p><?=$Review->review?></p>
        </div>
    </div>
</div>