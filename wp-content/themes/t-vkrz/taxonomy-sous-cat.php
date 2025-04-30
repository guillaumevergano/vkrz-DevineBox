<?php
get_header();
$post_count             = 0;
$current_cat            = get_queried_object();
$current_cat_id         = $current_cat->term_taxonomy_id;
$category               = get_term($current_cat_id, 'sous-cat');
if ($category && !is_wp_error($category)) {
  $post_count = $category->count;
}
?>
<div class="my-3 archive-container">
  <div class="container-xxl">
    <div class="row">
      <div class="col-md-12">
        <div class="intro-archive">
          <div class="iconarchive <?php echo ($current_cat->term_id == 2) ? 'rotating' : ''; ?>">
            <?php the_field('icone_cat', 'term_' . $current_cat->term_id); ?>
          </div>
          <h1>
            <?php echo $current_cat->name; ?> <span class="infonbtops"><?php echo $post_count; ?> TopList</span>
          </h1>
          <h2>
            <?php echo $current_cat->description; ?>
          </h2>
        </div>
        <section>
          <div class="row mt-4 all-tops-cat">
            <?php for ($i = 0; $i < 6; $i++) : ?>
              <div class="col-md-4 col-6 me-50">
                <div class="card loading-card">
                  <div class="card-1">
                  </div>
                  <div class="card-2 p-3">
                    <div class="row">
                      <div class="col-4">
                        <div class="inner-card">
                        </div>
                      </div>
                      <div class="col-8">
                        <div class="inner-card">
                        </div>
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col-6">
                        <div class="inner-card">
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="inner-card">
                        </div>
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col-2">
                        <div class="inner-card">
                        </div>
                      </div>
                      <div class="col-10">
                        <div class="inner-card">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endfor; ?>
          </div>
        </section>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const current_cat_id = <?php echo $current_cat_id; ?>;
    fetchDataFuncHelper(`${SITE_BASE_URL}wp-json/v1/gettopssubcat/${current_cat_id}/60000`)
      .then(results => {
        if (results) {
          const divToFillWithTops = document.querySelector('.all-tops-cat');
          processTops(results, divToFillWithTops, "col-sm-4 col-6");
        } else {
          console.log('No results or unexpected response format.');
        }
      })
      .catch(error => {
        console.error('Error fetching data:', error);
      });
  });
</script>
<?php get_footer(); ?>