<?php
    if(empty($Movie->image)){
        $Movie->image = 'movie_cover.jpg';
    }; 
?>
<div class="card movie-card">
    <div class="card-img-top" style="background-image: url('<?= $BASE_URL ?>img/movies/<?= $Movie->image ?>');"></div>
    <div class="card-body">
        <p class="card-rating">
            <i class="fas fa-star"></i>
            <span class="rating"><?=$Movie->rating?></span>
        </p>
        <h5 class="card-title">
            <a href="<?= $BASE_URL ?>movie.php?id=<?$Movie->id ?>"><?= ucfirst($Movie->title) ?></a>
        </h5>
        <div class="row">
            <div class="col">
                <a href="<?= $BASE_URL ?>movie.php?id=<?= $Movie->id ?>" class="btn btn-primary rate-btn">Avaliar</a>
                <a href="<?= $BASE_URL ?>movie.php?id=<?= $Movie->id ?>" class="btn btn-primary btn-card">Conhecer</a>
            </div>
        </div>
    </div>
</div>