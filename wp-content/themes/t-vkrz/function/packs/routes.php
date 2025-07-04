<?php

add_action('rest_api_init', function () {

  // Init classement 
  register_rest_route('v1', '/getrankingoftop/(?P<id_top>\d+)/(?P<orderby>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'get_ranking_of_top',
    'args' => [
      'id_top' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
      'orderby' => [
        'validate_callback' => function ($param, $request, $key) {
          return preg_match('/^[a-zA-Z0-9-]+$/', $param);
        }
      ]
    ],
    'permission_callback' => '__return_true'
  ));

  // Create contender FROM create-top
  register_rest_route('vkrz/v1', '/addcontenderfromcreatetop/', array(
    'methods' => 'POST',
    'callback' => 'add_contender_from_api_create_top',
    'permission_callback' => '__return_true'
  ));

  // Créer un Top FROM create-top
  register_rest_route('vkrz/v1', '/addtop/', array(
    'methods' => 'POST',
    'callback' => 'add_top_from_api',
    'permission_callback' => '__return_true'
  ));
  
  // update top
  register_rest_route('v1', '/update_top/', array(
    'methods' => 'POST',
    'callback' => 'update_top',
    'permission_callback' => '__return_true'
  ));

  // update contender
  register_rest_route('v1', '/update_contender/', array(
    'methods' => 'POST',
    'callback' => 'update_contender',
    'permission_callback' => '__return_true'
  ));

  // update contender name
  register_rest_route('v1', '/update_contender_name/', array(
    'methods' => 'POST',
    'callback' => 'update_contender_name',
    'permission_callback' => '__return_true'
  ));

  // Info Top
  register_rest_route('v1', '/infotop/(?P<id_top>[\d]+)/(?P<type>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'get_the_top_info',
    'args' => [
      'id_top' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
      'type' => [
        'validate_callback' => function ($param, $request, $key) {
          return preg_match('/^[a-zA-Z0-9-]+$/', $param);
        }
      ]
    ],
    'permission_callback' => '__return_true'
  ));
  
  // Delete contender
  register_rest_route('v1', '/deletecontender/(?P<id_contender>[\d]+)', array(
    'methods' => 'GET',
    'callback' => 'delete_contender',
    'args' => [
      'id_contender' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
    ],
    'permission_callback' => '__return_true'
  ));
  
  // Edition Top
  register_rest_route('v1', '/editiontop/(?P<id_top>[\d]+)', array(
    'methods' => 'GET',
    'callback' => 'get_top_edition',
    'args' => [
      'id_top' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
    ],
    'permission_callback' => '__return_true'
  ));
  
  // Top slug
  register_rest_route('v1', '/gettopmeta/(?P<id_top>[\d]+)', array(
    'methods' => 'GET',
    'callback' => 'get_top_meta',
    'args' => [
      'id_top' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
    ],
    'permission_callback' => '__return_true'
  ));
  
  // Info sponso //test
  register_rest_route('v1', '/infosponso/(?P<id_top>[\d]+)', array(
    'methods' => 'GET',
    'callback' => 'get_the_sponso_info',
    'args' => [
      'id_top' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
    ],
    'permission_callback' => '__return_true'
  ));
  
    register_rest_route('v1', '/allinfosponso', array(
        'methods'             => 'GET',
        'callback'            => 'get_all_sponso_info',
        'permission_callback' => '__return_true'
    ));
  // Info produit
  register_rest_route('v1', '/infoproduit/(?P<id_produit>[\d]+)', array(
    'methods' => 'GET',
    'callback' => 'get_the_produit_info',
    'args' => [
      'id_produit' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
    ],
    'permission_callback' => '__return_true'
  ));
  
  // All produits
  register_rest_route('v1', '/allproduit/', array(
    'methods' => 'GET',
    'callback' => 'get_all_produits',
    'args' => [
      'id_produit' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
    ],
    'permission_callback' => '__return_true'
  ));

// Endpoint pour supprimer un produit
register_rest_route('v1', '/delete_produit/(?P<id_produit>\d+)', array(
  'methods' => 'DELETE',
  'callback' => 'delete_produit_endpoint',
  'permission_callback' => function () {
      return current_user_can('delete_posts'); // Vérifie si l'utilisateur peut supprimer des articles
  }
));

// update produit
// Endpoint pour mettre à jour un produit
register_rest_route('v1', '/update_produit/(?P<id_produit>\d+)', array(
  'methods' => 'PUT',
  'callback' => 'update_produit_endpoint',
  'permission_callback' => function () {
      return current_user_can('edit_posts'); // Vérifie si l'utilisateur peut modifier des articles
  }
));


register_rest_route('v1', '/allproducts', array(
    'methods' => 'GET',
    'callback' => 'get_all_products_info',
    'permission_callback' => '__return_true'
));


  register_rest_route('v1', '/getcontenderinfo/(?P<id_contender>\w+)(/(?P<type>[a-zA-Z0-9-]+))?', array(
    'methods' => 'GET',
    'callback' => 'get_contender',
    'args' => [
        'id_contender' => [
            'validate_callback' => function ($param, $request, $key) {
                return is_numeric($param); // Adjust this validation based on your expected input
            }
        ],
        'type' => [
            'validate_callback' => function ($param, $request, $key) {
                // Optionally add validation for type if necessary
                return true;
            }
        ]
    ],
    'permission_callback' => '__return_true'
  ));

  // Info about Toplist for banner
  register_rest_route('v1', '/getrankingforbanner', array(
      'methods' => 'POST',
      'callback' => 'get_ranking_for_banner',
      'args' => [
        'list_id_contender' => [
          'validate_callback' => function ($param, $request, $key) {
            return preg_match('/^\d+(,\d+)*$/', $param); // The parameter can be a single number or comma-separated numbers
          }
        ],
        'id_top_rank' => [
          'validate_callback' => function ($param, $request, $key) {
            return is_numeric($param);
          }
        ],
      ],
      'permission_callback' => '__return_true',
    )
  );

  // Twitter Monitor - Get top tendance
  register_rest_route('v1', '/getstops/(?P<tendance>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'get_tops_tendance',
    'args' => [
      'tendance'
    ]
  ));
  
  // Get similar Top
  register_rest_route('v1', '/getsimilartop/(?P<id_top>[\d]+)/(?P<id_cat>[\d]+)/(?P<limit>[\d]+)/(?P<uuid_user>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'get_all_similar_top',
    'args' => [
      'id_top' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
      'id_cat' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
      'limit' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
      'uuid_user' => [
        'validate_callback' => function ($param, $request, $key) {
          return preg_match('/^[a-z0-9-]+$/i', $param); // validate uuid_user format
        }
      ]
    ],
    'permission_callback' => '__return_true'
  ));

  // Get all Tops of a category
  register_rest_route('v1', '/getcattops/(?P<id_cat>[\d]+)/(?P<limit>[\d]+)', array(
    'methods' => 'GET',
    'callback' => 'get_all_cat_top',
    'args' => [
      'id_cat' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
      'limit' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ]
    ],
    'permission_callback' => '__return_true'
  ));
  
  register_rest_route('v1', '/getcattopspopular/(?P<id_cat>[\d]+)/(?P<limit>[\d]+)', array(
    'methods' => 'GET',
    'callback' => 'get_all_cat_top_popular',
    'args' => [
      'id_cat' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
      'limit' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ]
    ],
    'permission_callback' => '__return_true'
  ));
  // Get all Tops ID of a category
  register_rest_route('v1', '/getcattopsid/(?P<id_cat>[\d]+)/(?P<limit>[\d]+)', array(
    'methods' => 'GET',
    'callback' => 'get_all_cat_top_id',
    'args' => [
      'id_cat' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
      'limit' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ]
    ],
    'permission_callback' => '__return_true'
  ));
  
  // Get tops of a sub category
  register_rest_route('v1', '/gettopssubcat/(?P<id_cat>[\d]+)/(?P<limit>[\d]+)', array(
    'methods' => 'GET',
    'callback' => 'get_tops_of_a_sub_cat',
    'args' => [
      'limit' => [
          'validate_callback' => function ($param, $request, $key) {
              return is_numeric($param);
          }
      ],
      'id_cat' => [
          'validate_callback' => function ($param, $request, $key) {
              return is_numeric($param) || is_null($param); // Validate if numeric or null (for optional)
            },
            'default' => null, // Set default value as null since it's optional
            'required' => false, // Explicitly mark as not required
        ]
    ],
    'permission_callback' => '__return_true'
  ));

  
  
  // Get last tops
  register_rest_route('v1', '/getlasttops/(?P<limit>[\d]+)', array(
    'methods' => 'GET',
    'callback' => 'get_last_tops',
    'args' => [
        'limit' => [
            'validate_callback' => function ($param, $request, $key) {
                return is_numeric($param);
            }
        ],
        'id_cat' => [
            'validate_callback' => function ($param, $request, $key) {
                return is_numeric($param) || is_null($param); // Validate if numeric or null (for optional)
            },
            'default' => null, // Set default value as null since it's optional
            'required' => false, // Explicitly mark as not required
        ]
    ],
    'permission_callback' => '__return_true'
  ));

  // Generate JSON of cat
  register_rest_route('v1', '/generatejsoncat', array(
    'methods' => 'GET',
    'callback' => 'generate_json_data'
  ));

  register_rest_route('v1', '/generatejsoncatpopular', array(
    'methods' => 'GET',
    'callback' => 'generate_json_data_popular'
  ));
 
  // Get all popular Tops
  register_rest_route('v1', '/getpopulartops/(?P<limit>[\d]+)/(?P<uuid_user>[a-zA-Z0-9-]+)',
    array(
      'methods' => 'GET',
      'callback' => 'get_popular_top',
      'args' => [
        'limit' => [
          'validate_callback' => function ($param, $request, $key) {
            return is_numeric($param);
          }
        ],
        'uuid_user' => [
          'validate_callback' => function ($param, $request, $key) {
            return preg_match('/^[a-z0-9-]+$/i', $param); // validate uuid_user format
          }
        ]
      ],
      'permission_callback' => '__return_true'
    )
  );

  // Get mondial ranking 
  register_rest_route('v1', '/mondialranking/(?P<id_top>[\d]+)', array(
    'methods' => 'GET',
    'callback' => 'get_contenders_ranking_from_wp',
    'args' => [
      'id_top' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
    ],
    'permission_callback' => '__return_true'
  ));
  
  // Get all popular Tops
  register_rest_route('v1', '/getvedettetops/(?P<id_cat>[\d]+)/(?P<limit>[\d]+)/',
    array(
      'methods' => 'GET',
      'callback' => 'get_vedette_top',
      'args' => [
        'limit' => [
          'validate_callback' => function ($param, $request, $key) {
            return is_numeric($param);
          }
        ],
        'id_cat' => [
          'validate_callback' => function ($param, $request, $key) {
            return is_numeric($param);
          }
        ]
      ],
      'permission_callback' => '__return_true'
    )
  );
  
  // Tops from searchbar
  register_rest_route('v1', '/getalltopsfromsearch/(?P<recherche>[a-zA-Z0-9-%20]+)', array(
    'methods' => 'GET',
    'callback' => 'get_all_search_top',
    'args' => [
      'recherche' => [
        'validate_callback' => function ($param, $request, $key) {
          return preg_match('/^[a-zA-Z0-9-%20]+$/', $param);
        }
      ],
    ],
    'permission_callback' => '__return_true'
  ));

  // Get creator Tops
  register_rest_route('v1', '/gettopofacreator/(?P<uuid>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'get_tops_of_a_creator',
    'args' => [
      'uuid' => [
        'validate_callback' => function ($param, $request, $key) {
          return preg_match('/^[a-zA-Z0-9-]+$/', $param);
        }
      ]
    ],
    'permission_callback' => '__return_true'
  ));

  // Get creator valide Tops
  register_rest_route('v1', '/getvalidetopofacreator/(?P<uuid>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'get_valide_tops_of_a_creator',
    'args' => [
      'uuid' => [
        'validate_callback' => function ($param, $request, $key) {
          return preg_match('/^[a-zA-Z0-9-]+$/', $param);
        }
      ]
    ],
    'permission_callback' => '__return_true'
  ));
  
  // Get creator ids Tops
  register_rest_route('v1', '/gettopidofacreator/(?P<uuid>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'get_tops_id_of_a_creator',
    'args' => [
      'uuid' => [
        'validate_callback' => function ($param, $request, $key) {
          return preg_match('/^[a-zA-Z0-9-]+$/', $param);
        }
      ]
    ],
    'permission_callback' => '__return_true'
  ));
  
  // Get creator of a top
  register_rest_route('v1', '/getcreatorofatop/(?P<id_top>[\d]+)', array(
    'methods' => 'GET',
    'callback' => 'get_creator_of_a_top',
    'args' => [
      'id_top' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
    ],
    'permission_callback' => '__return_true'
  ));

  // Get all contenders
  register_rest_route('v1', '/getallcontenders/', array(
    'methods' => 'GET',
    'callback' => 'get_all_contenders',
    'permission_callback' => '__return_true'
  ));

  // Get all Top from Room
  register_rest_route('v1', '/gettopfromroom/(?P<id_room>[\d]+)', array(
    'methods' => 'GET',
    'callback' => 'get_top_from_room',
    'args' => [
      'id_room' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
    ],
    'permission_callback' => '__return_true'
  ));
  
  // Get all Top IDS of a Room
  register_rest_route('v1', '/gettopidsfromroom/(?P<id_room>[\d]+)', array(
    'methods' => 'GET',
    'callback' => 'get_top_ids_from_room',
    'args' => [
      'id_room' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
    ],
    'permission_callback' => '__return_true'
  ));

  // Delete Top
  register_rest_route('v1', '/deletetop/(?P<id_top>[\d]+)/(?P<uuid_user>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'delete_top',
    'args' => [
      'id_top' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
      'uuid_user' => [
        'validate_callback' => function ($param, $request, $key) {
          return preg_match('/^[a-z0-9-]+$/i', $param); // validate uuid_user format
        }
      ],
    ],
    'permission_callback' => '__return_true'
  ));
  
  // Get Lot
  register_rest_route('v1', '/getlot/(?P<id_top>[\d]+)', array(
    'methods' => 'GET',
    'callback' => 'get_lot',
    'args' => [
      'id_top' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
    ],
    'permission_callback' => '__return_true'
  ));
  
  // Valide Top
  register_rest_route('v1', '/validetop/(?P<id_top>[\d]+)/(?P<uuid_user>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'valide_top',
    'args' => [
      'id_top' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
      'uuid_user' => [
        'validate_callback' => function ($param, $request, $key) {
          return preg_match('/^[a-z0-9-]+$/i', $param); // validate uuid_user format
        }
      ],
    ],
    'permission_callback' => '__return_true'
  ));
  
  // Archive Top
  register_rest_route('v1', '/archivetop/(?P<id_top>[\d]+)/(?P<uuid_user>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'archive_top',
    'args' => [
      'id_top' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
      'uuid_user' => [
        'validate_callback' => function ($param, $request, $key) {
          return preg_match('/^[a-z0-9-]+$/i', $param); // validate uuid_user format
        }
      ],
    ],
    'permission_callback' => '__return_true'
  ));
  
  // Validation Top
  register_rest_route('v1', '/validationtop/(?P<id_top>[\d]+)/(?P<uuid_user>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'validation_top',
    'args' => [
      'id_top' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
      'uuid_user' => [
        'validate_callback' => function ($param, $request, $key) {
          return preg_match('/^[a-z0-9-]+$/i', $param); // validate uuid_user format
        }
      ],
    ],
    'permission_callback' => '__return_true'
  ));
  
  // Refuse Top
  register_rest_route('v1', '/refusetop/(?P<id_top>[\d]+)/(?P<uuid_user>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'refuse_top',
    'args' => [
      'id_top' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
      'uuid_user' => [
        'validate_callback' => function ($param, $request, $key) {
          return preg_match('/^[a-z0-9-]+$/i', $param); // validate uuid_user format
        }
      ],
    ],
    'permission_callback' => '__return_true'
  ));

  // Get all Tops
  register_rest_route('v1', '/getalltops/(?P<state>[a-zA-Z0-9-]+)',
    array(
      'methods' => 'GET',
      'callback' => 'get_all_top',
      'args' => [
        'state' => [
          'validate_callback' => function ($param, $request, $key) {
            return preg_match('/^[a-zA-Z0-9-]+$/', $param);
          }
        ]
      ],
      'permission_callback' => '__return_true'
    )
  );

  // Get all Tops data
  register_rest_route('v1', '/getalltopsdata/',
    array(
      'methods' => 'GET',
      'callback' => 'get_tops_data',
      'permission_callback' => '__return_true'
    )
  );

  // ALL VKRZ content
  register_rest_route('v1', '/getcontent/', array(
    'methods' => 'GET',
    'callback' => 'get_all_content',
    'permission_callback' => '__return_true'
  ));
  
  // JSON
  register_rest_route('v1', '/getjson/', array(
    'methods' => 'GET',
    'callback' => 'get_json_1',
    'permission_callback' => '__return_true'
  ));

  
  // TopList Home
  register_rest_route('v1', '/gethomecontent/(?P<nb_jours>\d+)/(?P<limit>\d+)', array(
    'methods' => 'GET',
    'callback' => 'get_home_content',
    'args' => [
      'nb_jours' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
      'limit' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
    ],
    'permission_callback' => '__return_true'
  ));
  
  // Update stock
  register_rest_route('v1', '/updatestock/(?P<id_produit>[\d]+)/(?P<operation>[a-zA-Z0-9-]+)/(?P<quantity>[\d]+)', array(
    'methods' => 'GET',
    'callback' => 'update_stock',
    'args' => [
      'id_produit' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
      'operation' => [
        'validate_callback' => function ($param, $request, $key) {
          return preg_match('/^[a-zA-Z0-9-]+$/', $param);
        }
      ],
      'quantity' => [
        'validate_callback' => function ($param, $request, $key) {
          return is_numeric($param);
        }
      ],
    ],
    'permission_callback' => '__return_true'
  ));
  
  // Test Endpoint
  register_rest_route('v1', '/testendpoint/', array(
    'methods' => 'GET',
    'callback' => 'get_popular_top',
    'permission_callback' => '__return_true'
  ));

  // Get all Tops from Vedette
  register_rest_route('v1', '/getalltopsfromvedetteconvention/', array(
    'methods' => 'GET',
    'callback' => 'get_all_tops_from_vedette',
    'permission_callback' => '__return_true'
  ));
  
});