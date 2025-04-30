<?php
get_header();
$post_count             = 0;
$current_cat            = get_queried_object();
$current_cat_id         = $current_cat->term_taxonomy_id;
$category               = get_term($current_cat_id, 'categorie');
if ($category && !is_wp_error($category)) {
  $post_count = $category->count;
}
?>
<div class="my-3 archive-container">
  <div class="container-xxl">
    <div class="row">
      <div class="col-md-8">
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
        <section class="derniertopsection">
          <div class="row mt-4 render-lasttops-cat">
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
      <div class="col-md-4">
        <?php if ($current_cat_id == 7) : ?>
          <div class="row">
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="Pokémon">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/pokemon-copie.png" class="img-fluid" alt="Pokémon" decoding="async" fetchpriority="high" />
                    </div>
                    <h4 class="eh1">Pokémon</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/pokemon/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="Overwatch">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/6dcf1b21a9ba92982cade1e660b610d0.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/overwatch-copie.png" class="img-fluid" alt="Overwatch" decoding="async" />
                    </div>
                    <h4 class="eh1">Overwatch</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/overwatch/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="League of Legends">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy-3.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/lol-copie.png" class="img-fluid" alt="League of Legends" decoding="async" />
                    </div>
                    <h4 class="eh1">League of Legends</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/league-of-legends/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="Genshin Impact">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/f66.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/genshin-copie.png" class="img-fluid" alt="Genshin Impact" decoding="async" />
                    </div>
                    <h4 class="eh1">Genshin Impact</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/genshin-impact/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="Fortnite">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy-4.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/fortnite-copie.png" class="img-fluid" alt="Fortnite" decoding="async" />
                    </div>
                    <h4 class="eh1">Fortnite</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/fortnite/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="World of Warcraft">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy-2.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/wow-copie.png" class="img-fluid" alt="World of Warcraft" decoding="async" />
                    </div>
                    <h4 class="eh1">World of Warcraft</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/world-of-warcraft/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php elseif ($current_cat_id == 3) : // HTML RUBRIC Manga 
        ?>
          <div class="row">
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="One Piece">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy-7.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/op-copie.png" class="img-fluid" alt="One Piece" decoding="async" fetchpriority="high" />
                    </div>
                    <h4 class="eh1">One Piece</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/one-piece/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="Naruto">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy-8.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/naruto-copie.png" class="img-fluid" alt="Naruto" decoding="async" />
                    </div>
                    <h4 class="eh1">Naruto</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/naruto/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="Dragon Ball">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy-9.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/dbz-namek.png" class="img-fluid" alt="Dragon Ball" decoding="async" />
                    </div>
                    <h4 class="eh1">Dragon Ball</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/dragon-ball/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="My Hero Academia">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy-11.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/mha-copie.png" class="img-fluid" alt="My Hero Academia" decoding="async" />
                    </div>
                    <h4 class="eh1">My Hero Academia</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/my-hero-academia/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="Demon Slayer">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy-12.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/demon-slayer-copie.png" class="img-fluid" alt="Demon Slayer" decoding="async" />
                    </div>
                    <h4 class="eh1">Demon Slayer</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/demon-slayer/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="Hunter x Hunter">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy-5.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/hxh-copie.png" class="img-fluid" alt="Hunter x Hunter" decoding="async" />
                    </div>
                    <h4 class="eh1">Hunter x Hunter</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/hunter-x-hunter/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php elseif ($current_cat_id == 4) : // HTML RUBRIC Sport 
        ?>
          <div class="row">
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="GP EXPLORER">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/ae4d85b6-2907-43f9-9bbb-c78a4ed1135f-rw-1200.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/squeezie-copie.png" class="img-fluid" alt="GP EXPLORER" decoding="async" fetchpriority="high" />
                    </div>
                    <h4 class="eh1">GP EXPLORER</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/gp-explorer/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="Football">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy-1-2.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/a35ecda4-ad0d-4b95-966b-b73952b5b3ec-copie.png" class="img-fluid" alt="Football" decoding="async" />
                    </div>
                    <h4 class="eh1">Football</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/football/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="UFC">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy-5-2.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/ufc-copie.png" class="img-fluid" alt="UFC" decoding="async" />
                    </div>
                    <h4 class="eh1">UFC</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/ufc/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="Tennis">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy-3-2.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/federer.png" class="img-fluid" alt="Tennis" decoding="async" />
                    </div>
                    <h4 class="eh1">Tennis</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/tennis/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="Moto">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy-6-1.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/moto.png" class="img-fluid" alt="Moto" decoding="async" />
                    </div>
                    <h4 class="eh1">Moto</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/moto/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="Formule 1">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy-13.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/f-1.png" class="img-fluid" alt="Formule 1" decoding="async" />
                    </div>
                    <h4 class="eh1">Formule 1</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/formule-1/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php elseif ($current_cat_id == 5) : // HTML RUBRIC Ecran 
        ?>
          <div class="row">
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="Game of Thrones">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy-1-1.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/got1-copie.png" class="img-fluid" alt="Game of Thrones" decoding="async" fetchpriority="high" />
                    </div>
                    <h4 class="eh1">Game of Thrones</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/game-of-thrones/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="Marvel">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy.webp);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/marvell-copie.png" class="img-fluid" alt="Marvel" decoding="async" />
                    </div>
                    <h4 class="eh1">Marvel</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/marvel/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="Harry Potter">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy-6.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/hp-copie.png" class="img-fluid" alt="Harry Potter" decoding="async" />
                    </div>
                    <h4 class="eh1">Harry Potter</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/harry-potter/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="South Park">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy-3-1.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/south-park-copie.png" class="img-fluid" alt="South Park" decoding="async" />
                    </div>
                    <h4 class="eh1">South Park</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/south-park/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="Star Wars">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy-1.webp);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/star-wars-copie.png" class="img-fluid" alt="Star Wars" decoding="async" />
                    </div>
                    <h4 class="eh1">Star Wars</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/star-wars/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="rubrique-item" data-rubrique="Hunger Games">
                <div class="card">
                  <div class="card-body">
                    <div class="voile-rubrique" style="
                        background-image: url(https://vainkeurz.com/wp-content/uploads/2023/12/giphy-5-1.gif);
                      "></div>
                    <div class="illu-rubrique">
                      <img width="450" height="550" src="https://vainkeurz.com/wp-content/uploads/2023/12/hunger-games-copie.png" class="img-fluid" alt="Hunger Games" decoding="async" />
                    </div>
                    <h4 class="eh1">Hunger Games</h4>
                    <span class="infosrubriquenbtoplist"></span>
                    <a href="https://vainkeurz.com/rubrique/hunger-games/" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="filtres-bloc">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="d-flex flex-column">
                <div class="filtre-bloc">
                  <div class="row align-items-center">
                    <div class="col-md-3 mb-2 mb-sm-0">
                      <select id="rank-by-toplist" class="selectpicker w-100" data-style="btn-default">
                        <option data-tokens="al" data-rubrique="populaire" >Classé par popularité</option>
                        <option data-tokens="all" data-rubrique="recentes" >Classé par nouveauté</option>
                      </select>
                    </div>
                    <div class="col-md-3 mb-2 mb-sm-0">
                    <select id="selectpickerLiveSearch" class="selectpicker w-100" data-style="btn-default" data-live-search="true">
                        
                      </select>
                    </div>
                    <div class="col-md-2">
                      <label class="switch switch-primary">
                        <input type="checkbox" class="switch-input" value="todo" />
                        <span class="switch-toggle-slider">
                          <span class="switch-on">
                            <i class="ti ti-check"></i>
                          </span>
                          <span class="switch-off">
                            <i class="ti ti-x"></i>
                          </span>
                        </span>
                        <span class="switch-label">A faire</span>
                      </label>
                    </div>
                    <div class="col-md-4">
                      <div class="filtre-bloc">
                        <div class="input-group input-group-merge" id="search_form">
                          <span class="input-group-text" id="basic-addon-search31"><span class="va va-loupe va-lg"></span></span>
                          <input type="text" class="form-control" id="search-input" placeholder="Rechercher dans <?php echo $current_cat->name; ?>..." aria-label="Rechercher dans <?php echo $current_cat->name; ?>..." aria-describedby="basic-addon-search31" spellcheck="false">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <section class="row mt-4 grid-to-filtre render-tops render-tops-cat">
      <?php for ($i = 0; $i < 8; $i++) : ?>
        <div class="col-md-3 col-sm-4 col-6 me-50">
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
    </section>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const current_cat_id = <?php echo $current_cat_id; ?>;
    fetchDataFuncHelper(`${SITE_BASE_URL}wp-json/v1/getvedettetops/${current_cat_id}/6`)
      .then(results => {
        if (results) {
          const divToFillWithTops = document.querySelector('.render-lasttops-cat');
          processTops(results, divToFillWithTops, "col-sm-4 col-6");
          
        } else {
          console.log('No results or unexpected response format.');
        }
      })
      .catch(error => {
        console.error('Error fetching data:', error);
      });

    const renderTopsCatContainer = document.querySelector('.render-tops-cat');
    let page = 0, isFetching = false, excludeFirst6Tops = false;

    let currentAction = 'vkzr_fetch_toplist_popular';


    const buttons = document.querySelectorAll('.button_trie');
     // Écoute des changements dans le select
     document.getElementById('rank-by-toplist').addEventListener('change', function () {
          const rubrique = this.options[this.selectedIndex].getAttribute('data-rubrique');
          hasMoreData = true; // Il n'y a plus de données à charger
          window.addEventListener('scroll', handleScroll); // Réactiver le scroll infini
          currentAction = rubrique === 'populaire' ? 'vkzr_fetch_toplist_popular' : 'vkzr_fetch_toplist';
          
          // Réinitialise la pagination et le contenu
          page = 0;
          renderTopsCatContainer.innerHTML = '';

          // Réinitialise la valeur du selectpickerLiveSearch pour éviter qu'il influence la recherche
          const selectElement = document.getElementById('selectpickerLiveSearch');
          document.getElementById('selectpickerLiveSearch').value = "";
          selectElement.selectedIndex = 0; 
          $(selectElement).selectpicker('destroy'); // Supprime l'instance actuelle
          $(selectElement).selectpicker(); 

          // Charge les nouvelles données
          loadMoreData();
      });
            // Écoute du champ de recherche
      let searchTimeout;
      let lastSearchValue = "";

      document.getElementById('search-input').addEventListener('keyup', function () {
          clearTimeout(searchTimeout); // Réinitialise le timer à chaque frappe
          hasMoreData = true; // Il n'y a plus de données à charger
          window.addEventListener('scroll', handleScroll); // Réactiver le scroll infini
          const selectElement = document.getElementById('selectpickerLiveSearch');
          document.getElementById('selectpickerLiveSearch').value = "";
          selectElement.selectedIndex = 0; 
          $(selectElement).selectpicker('destroy'); // Supprime l'instance actuelle
          $(selectElement).selectpicker(); 
          searchTimeout = setTimeout(() => {
              const searchValue = document.getElementById('search-input').value.trim(); // Supprime les espaces inutiles

              if (searchValue !== lastSearchValue) { // Vérifie si la recherche a changé
                  lastSearchValue = searchValue; // Met à jour la dernière recherche
                  page = 0; // Réinitialise la pagination
                  renderTopsCatContainer.innerHTML = ''; // Vide le conteneur avant d'afficher les nouveaux résultats
                  loadMoreData();
              }
          }, 250); // Délai réduit à 300ms pour améliorer la réactivité
      });

      //the event of select 
      document.getElementById('selectpickerLiveSearch').addEventListener('change', function () {
          page = 0;  // Réinitialiser la pagination
          isFetching = false;  // Réinitialiser le flag de chargement
          hasMoreData = true; // Il n'y a plus de données à charger

          const selectElement = document.getElementById('search-input');
          document.getElementById('search-input').value = "";
          $(selectElement).selectpicker('destroy'); // Supprime l'instance actuelle
          $(selectElement).selectpicker(); 

          window.addEventListener('scroll', handleScroll); // Réactiver le scroll infini
          renderTopsCatContainer.innerHTML = ""; // Vider la liste avant de recharger
          loadMoreData();
      });

    document.querySelector('.switch-input').addEventListener('change',applyTodoFilter)
    
    let hasMoreData = true; // Variable pour suivre s'il reste des données à charger
    
    function loadMoreData() {
      if (isFetching || !hasMoreData) return; // Empêche les requêtes multiples et stoppe si plus de données

      isFetching = true;
      page++;

      const searchValueInput = document.getElementById('search-input').value.trim();
      const selectValue = document.getElementById('selectpickerLiveSearch').value;

      let searchValue = searchValueInput || selectValue ; 

      let actionToUse = searchValue ? 'vkzr_search_toplist_data_function' : currentAction;
      const url = new URL(`${SITE_BASE_URL}wp-admin/admin-ajax.php`);
      url.searchParams.set('action', actionToUse);
      url.searchParams.set('current_cat_id', current_cat_id);
      url.searchParams.set('page', page);

      if (searchValue !== "") {
          url.searchParams.set('search', searchValue);
      }
        //alors ici je veux mettre , if le searh est vide alors fait currentAction , si il n'est pas vide alors recupére de search 
        fetch(url)
          .then(response => response.json())
          .then(data => {
            if (data.success && data.data.length > 0) {
              const getTopListId = async (uuidUser, idtop) => {
                const response = await fetch(`${API_BASE_URL}toplist-list/get-with-idtop/${uuidUser}/${idtop}`);
                const data = await response.json();
                return data.id;
              };
              const redirectToUrl = async (uuidUser, idtop, topSlug) => {
                const topListId = await getTopListId(uuidUser, idtop);
                const newUrl = SITE_BASE_URL + "toplist/" + topSlug + "/" + topListId + "/";
                window.location.href = newUrl;
              };
              
              let collectionUser;

              data.data.forEach((t, i) => {
                let classformobile = "";
                if ((i === 8) && !excludeFirst6Tops) {
                  excludeFirst6Tops = true;
                  renderTopsCatContainer.innerHTML = "";
                  classformobile = "d-block d-sm-none";
                }
                let topState;
                let stateInfos;
                let pseudoSlug;

                let top_url = t.top_url;
                if (localStorage.getItem('inventaire_user')) {
                  collectionUser = JSON.parse(localStorage.getItem('inventaire_user'));
                }
                let topSlug = createSlug(t.top_title + "-" + t.top_question);

                if (!collectionUser || (collectionUser.list_top_pending === null && collectionUser.list_top_done === null)) {
                  topState = "todo";
                  stateInfos = getState(topState, t.top_type);
                } else {
                  topState = findIdTopStateInObject(collectionUser, t.top_id),
                    stateInfos = getState(topState, t.top_type);
                }
                if (stateInfos.slug == "done") {
                  top_url = 'javascript:void(0);'; // Setting URL to "do nothing"
                }

                renderTopsCatContainer.insertAdjacentHTML('beforeend', `
                  <div class="col-md-3 col-sm-4 col-6 ${classformobile} grid-item" data-filter-item="${topState} ${t.top_slug}" data-filter-name="${t.top_question} ${t.top_title}" data-id-top="${t.top_id}" >
                    <div class="min-tournoi card state-${t.top_type} h-100 d-flex flex-column topState-${topState}">
                      <div class="min-tournoi-content">
                        <div class="cov-illu-container">
                          <div class="cov-illu" style="background: url(${
                            t.top_img_min
                          }) center center no-repeat">
                          </div>
                        </div>
                      </div>
                      <div class="card-body d-flex flex-column flex-grow-1">
                        <div class="pushtop d-flex flex-column h-100">
                          <div class="min-tournoi-title flex-grow-1">
                            <h4 class="titre-top-min eh3 line-clamp-2">
                              ${
                                t.top_type === "sponso"
                                  ? `<span class="va va-gift va-md"></span>`
                                  : t.top_cat_icon
                              }
                              ${t.top_title}
                            </h4>
                            <h3 class="card-title eh2 line-clamp-3">${t.top_question}</h3>
                          </div>
                          <div class="min-tournoi-footer">
                            <a href="#" class="btn btn-little" data-bs-toggle="modal" data-bs-target="#modalcontenders-${
                              t.top_id
                            }">
                              ${t.top_number} <span class="va va-versus va-md"></span>
                            </a>
                            <a href="#" class="btn btn-little" data-bs-toggle="modal" data-bs-target="#modalClassementMondial-${
                              t.top_id
                            }">
                              Classement <span class="va va-globe va-md"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <a href="${t.top_url}" class="stretched-link"></a>
                    </div>
                    <div class="modal fade" id="modalClassementMondial-${
                      t.top_id
                    }" tabindex="-1" aria-labelledby="modalClassementMondialLabel" aria-hidden="true">
                      <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
                        <div class="modal-content">
                          <div class="modal-header d-flex align-items-center justify-content-center p-3">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Refermer le classement mondial</button>
                          </div>
                          <div class="modal-body p-0">
                            <!-- Loader -->
                            <div id="loader-classementMondial-${t.top_id}" class="text-center p-5">
                              <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Chargement du classement mondial en cours...</span>
                              </div>
                            </div>
                            <!-- Placeholder for iframe -->
                            <div id="iframeContainer-${t.top_id}" data-src="${
                    t.toplist_mondiale
                  }?dontshowmenu=true" style="display: none;"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- CONTENDERS MODAL -->
                    <div class="modal animate__animated animate__swing" id="modalcontenders-${
                      t.top_id
                    }" tabindex="-1" aria-labelledby="swinganimationModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                          <div class="modal-header d-flex align-items-center justify-content-center p-3">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Refermer la liste des contenders</button>
                          </div>
                          
                          <div class="modal-body">
                            <div class="text-center">
                              <!-- Loader -->
                              <div id="loader-contenders-${t.top_id}" class="text-center p-5">
                                <div class="spinner-border text-primary" role="status">
                                  <span class="visually-hidden">Présentation des contenders en cours...</span>
                                </div>
                              </div>
                            </div>
                            <div class="list-contenders">
                              <div class="row align-items-center justify-content-center list-contenders-items">
                                
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer d-flex align-items-center justify-content-center">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Refermer</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- // CONTENDERS MODAL -->
                `);
              });

              // After all HTML is created, add event listeners
              data.data.forEach(t => {
                const modalContenders = document.querySelector(`#modalcontenders-${t.top_id}`);
                if (modalContenders) {
                  modalContenders.addEventListener('show.bs.modal', function () {
                    const loader_contenders = document.getElementById(`loader-contenders-${t.top_id}`);
                    const container = this.querySelector(".list-contenders-items");
                    
                    if (loader_contenders) loader_contenders.style.display = 'block';
                    if (container) container.style.display = 'none';

                    loadContendersIntoModal(t.top_id, container).then(() => {
                      if (loader_contenders) loader_contenders.style.display = 'none';
                      if (container) container.style.display = 'flex';
                    });
                  });

                  modalContenders.addEventListener('hide.bs.modal', function () {
                    const loader_contenders = document.getElementById(`loader-contenders-${t.top_id}`);
                    const container = this.querySelector(".list-contenders-items");
                    
                    if (loader_contenders) loader_contenders.style.display = 'block';
                    if (container) container.style.display = 'none';
                  });
                }

                const modalClassement = document.querySelector(`#modalClassementMondial-${t.top_id}`);
                if (modalClassement) {
                  modalClassement.addEventListener('show.bs.modal', function () {
                    const container = document.getElementById(`iframeContainer-${t.top_id}`);
                    const loader = document.getElementById(`loader-classementMondial-${t.top_id}`);
                    
                    if (!container.querySelector('iframe')) {
                      const iframe = document.createElement('iframe');
                      iframe.id = `classementMondialIframe-${t.top_id}`;
                      iframe.src = container.dataset.src;
                      iframe.width = '100%';
                      iframe.style.height = '98vh';
                      iframe.style.border = 'none';
                      iframe.style.display = 'none';
                      
                      iframe.onload = function() {
                        loader.style.display = 'none';
                        container.style.display = 'block';
                        iframe.style.display = 'block';
                      };
                      
                      container.appendChild(iframe);
                    } else {
                      loader.style.display = 'none';
                      container.style.display = 'block';
                    }
                  });

                  modalClassement.addEventListener('hide.bs.modal', function () {
                    const container = document.getElementById(`iframeContainer-${t.top_id}`);
                    const loader = document.getElementById(`loader-classementMondial-${t.top_id}`);
                    
                    loader.style.display = 'block';
                    container.style.display = 'none';
                  });
                }
              });

              renderTopsCatContainer.querySelectorAll('.loading-card').forEach(el => el.parentElement.remove());
              renderTopsCatContainer.insertAdjacentHTML('beforeend', `
                <div class="col-md-3 col-sm-4 col-6">
                  <div class="card loading-card">
                    <div class="card-1 load-more"></div>
                    <div class="card-2 load-more p-4">
                      <div class="row">
                        <div class="col-4">
                          <div class="inner-card"></div>
                        </div>
                        <div class="col-8">
                          <div class="inner-card"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              `);
            } else {
              hasMoreData = false; // Il n'y a plus de données à charger
              window.removeEventListener('scroll', handleScroll); 
              
              const loadingCard = document.getElementsByClassName('loading-card');
              if (loadingCard.length > 0) {
                  Array.from(loadingCard).forEach(el => el.parentElement.remove());
              }
            }
            applyTodoFilter();
            isFetching = false;
          })
          .catch(error => {
            window.removeEventListener('scroll', handleScroll);
            renderTopsCatContainer.querySelectorAll('.loading-card').forEach(el => el.parentElement.remove());
            isFetching = false;
          });
    }

    function handleScroll() {
      if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100 && !isFetching) {
        loadMoreData();
      }
    }
    window.addEventListener('scroll', handleScroll);


    function fetchTerms() {
    const urlt = new URL(`${SITE_BASE_URL}wp-admin/admin-ajax.php`);
    urlt.searchParams.set('action', 'vkzr_fetch_toplist_data_list_terms');
    urlt.searchParams.set('current_cat_id', current_cat_id);

    const selectElement = document.getElementById('selectpickerLiveSearch');

    fetch(urlt)
        .then(response => response.json())
        .then(data => {
            if (data.success && Array.isArray(data.data) && data.data.length > 0) {
                selectElement.innerHTML = ''; // Vide les options avant d'ajouter les nouvelles

                // Ajouter une option vide (non sélectionnée)
                // Ajouter une option vide (non sélectionnée)
                const defaultOption = document.createElement('option');
                defaultOption.setAttribute('data-tokens', 'all');
                defaultOption.value = ""; // Garder une valeur vide pour éviter la sélection forcée
                defaultOption.textContent = "Rubriques populaires"; 
                defaultOption.selected = true; // La rendre sélectionnée par défaut
                selectElement.appendChild(defaultOption);
                // Ajouter les nouvelles options depuis les données récupérées
                data.data.forEach(term => {
                    const option = document.createElement('option');
                    option.textContent = term.term_name;
                    option.setAttribute('data-tokens', term.term_name);
                    option.value = term.term_name;
                    selectElement.appendChild(option);
                });


                // Rafraîchir Bootstrap Selectpicker si utilisé
                if ($(selectElement).hasClass('selectpicker')) {
                    $(selectElement).selectpicker('refresh');
                }
            } else {
                console.warn("Aucune donnée trouvée ou erreur dans la réponse.");
            }
        })
        .catch(error => {
            console.error("Erreur lors de la récupération des données:", error);
        });
}


      function applyTodoFilter() {
          let userData = localStorage.getItem('inventaire_user');
          let listToplistDone = [];

          if (userData) {
              let parsedData = JSON.parse(userData);
              listToplistDone = parsedData.list_top_done || []; // Récupérer les ID des toplists déjà faites
          }

          const isChecked = document.querySelector('.switch-input').checked; // Vérifier si le bouton est activé
          
          document.querySelectorAll('.render-tops-cat .grid-item').forEach(item => {
              const idTop = Number(item.getAttribute('data-id-top')); // Convertir en nombre

              if (!idTop) return; // Vérification pour éviter les erreurs

              if (isChecked) {
                  if (listToplistDone.includes(idTop)) { // Comparaison correcte avec des nombres
                      item.style.display = 'none';
                  } else {
                      item.style.display = 'block';
                  }
              } else {
                  item.style.display = 'block';
              }
          });
      }
    // Appel de la fonction pour charger les catégories du select
    fetchTerms();
    loadMoreData();
    applyTodoFilter()
  });

  let userData = localStorage.getItem("inventaire_user"); 

if (userData) {
    let parsedData = JSON.parse(userData);
}
</script>
<?php get_footer(); ?>