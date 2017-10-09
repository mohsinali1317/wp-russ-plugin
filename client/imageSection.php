<?php 
if(count($itemImages) > 0){
?>
<div class="thumbnailImage">
<img src="<?php echo wp_get_attachment_image_url($itemImages[0]->imageId, 'thumbnail' ); ?>" class="img-responsive" alt ="<?php echo get_the_excerpt($itemImages[0]->imageId);?> "/>
</div>
<?php
}
?>


<div id="imageCrousel<?php echo "_" . $value->id ?>" class="carousel slide largeImage" data-ride="carousel" style="display: none;">
 
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <?php
        $i = 0;
        foreach ($itemImages as $s) {
            if ($i == 0) {
                $className = "active"; 
            }else{
                $className = "";
            }
            $i++;
            ?>
            <div class="item <?php echo $className; ?> images">
                <img src="<?php echo wp_get_attachment_image_url($s->imageId, 'full' ); ?>" class="img-responsive" alt ="<?php echo get_the_excerpt($s->imageId);?> "/>
                <!-- <div class="carousel-caption d-none d-md-block">
                    <p><?php echo get_the_excerpt($s->imageId);?></p>
                </div> -->
            </div>
            <?php
        }
        ?>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#imageCrousel<?php echo "_" . $value->id ?>" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#imageCrousel<?php echo "_" . $value->id ?>" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
    </a>
</div> 
