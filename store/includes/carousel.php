<?php
require_once "./Classes/System.php";
$banner = new System();
$results = $banner->get_all_banner();

?>

<section id="carousel">
    <div class="container-fluid">

        <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            </div>
            <div class="carousel-inner">
                <?php 
                    $counter = 0;
                    foreach ($results as $result): 
                ?>
                <div class="carousel-item <?php echo ($counter == 0) ? 'active' : ''; ?>">
                    <img src="./<?php echo $result['image'] ?>" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block carousel-content">
                        <h4 class="badge bg-danger rounded-0 display-4"><?php echo $result['badge_text'] ?></h4>
                        <h1 class="display-3"><?php echo $result['heading'] ?></h1>
                        <p><?php echo $result['title'] ?></p>
                        <a href="./category.php" class="btn btn-shop"><?php echo $result['btn_text'] ?></a>
                    </div>
                </div>
                <?php 
                    $counter++;
                    endforeach; 
                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

    </div>
</section>