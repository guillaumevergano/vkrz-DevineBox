<div class="col-md-4 col-12">
    <div class="card ecommerce-card">
        <div class="item-img text-center">
            <?php
            if (has_post_thumbnail()) {
                the_post_thumbnail('large', array('class' => 'img-fluid produit-img'));
            }
            ?>
        </div>
        <div class="card-body same-h">
            <div class="item-wrapper">
                <div class="item-cost">
                    <h6 class="item-price badge rounded bg-label-info">
                        <?php the_field('nombre_de_viewers_minimum'); ?> viewers minimum
                    </h6>
                </div>
            </div>
            <div class="item-name">
                <h3>
                    <?php the_title(); ?>
                </h3>
            </div>
            <div class="card-text text-muted">
                <?php the_content(); ?>
            </div>
        </div>
        <div class="item-options text-center px-1 pb-1 pt-0">
            <button type="button" class="btn btn-primary w-100 waves-effect" data-bs-toggle="modal" data-bs-target="#cart-commande">
                <span class="add-to-cart">Sélectionner</span>
            </button>
        </div>
    </div>
</div>