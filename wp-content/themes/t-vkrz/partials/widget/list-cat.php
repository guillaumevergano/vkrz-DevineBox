<div class="row mt-3">
  <?php
  $cat_t = get_terms(array(
    'taxonomy'      => 'categorie',
    'orderby'       => 'count',
    'order'         => 'DESC',
    'hide_empty'    => true,
  ));
  foreach ($cat_t as $cat) : ?>
    <div class="col-3 col-sm-4 col-6">
      <div class="card scaler cat-min">
        <div class="card-header d-flex align-items-center justify-content-between">
          <div>
            <h4 class="font-weight-bolder mb-0">
              <span class="ico2 ">
                <span>
                  <?php the_field('icone_cat', 'term_' . $cat->term_id); ?>
                </span>
              </span>
              <?php echo $cat->name; ?>
            </h4>
          </div>
          <div class="p-50 m-0 text-primary nb-top-in-cat">
            <?php echo $cat->count; ?> TopList
          </div>
        </div>
        <a href="<?php echo get_category_link($cat->term_id); ?>" class="stretched-link"></a>
      </div>
    </div>
  <?php endforeach; ?>
</div>