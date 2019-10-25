<?php
/**
* @package     Tag Groups
* @author      Christoph Amthor
* @copyright   2018 Christoph Amthor (@ Chatty Mango, chattymango.com)
* @license     GPL-3.0+
* @since       0.37.0
*/

if ( ! class_exists('TagGroups_REST_API') ) {

  /**
  *   Adds endpoints to the WordPress REST API
  */
  class TagGroups_REST_API {

    public function __construct() {}

      /**
      * Register the REST API endpoints and schemata
      *
      *
      * @param void
      * @return void
      */
      public static function register()
      {

        add_action( 'rest_api_init', function () {
          register_rest_route( 'tag-groups/v1', '/groups/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => array( 'TagGroups_REST_API', 'get_groups' ),
            'args' => array(
              'id' => array(
                'validate_callback' => function( $param, $request, $key ) {
                  return is_numeric( $param );
                  }
                ),
              ),
              'schema' => array( 'TagGroups_REST_API', 'get_group_schema' ),
            ) );
          } );

          add_action( 'rest_api_init', function () {
            register_rest_route( 'tag-groups/v1', '/groups/', array(
              'methods' => 'GET',
              'callback' => array( 'TagGroups_REST_API', 'get_groups' ),
              'schema' => array( 'TagGroups_REST_API', 'get_group_schema' ),
            ) );
          } );

          add_action( 'rest_api_init', function () {
            register_rest_route( 'tag-groups/v1', '/terms/(?P<id>\d+)', array(
              'methods' => 'GET',
              'callback' => array( 'TagGroups_REST_API', 'get_terms' ),
              'args' => array(
                'id' => array(
                  'validate_callback' => function( $param, $request, $key ) {
                    return is_numeric( $param );
                    }
                  ),
                ),
                'schema' => array( 'TagGroups_REST_API', 'get_term_schema' ),
              ) );
            } );

            add_action( 'rest_api_init', function () {
              register_rest_route( 'tag-groups/v1', '/terms/', array(
                'methods' => 'GET',
                'callback' => array( 'TagGroups_REST_API', 'get_terms' ),
                'schema' => array( 'TagGroups_REST_API', 'get_term_schema' ),
              ) );
            } );

            add_action( 'rest_api_init', function () {
              register_rest_route( 'tag-groups/v1', '/taxonomies/', array(
                'methods' => 'GET',
                'callback' => array( 'TagGroups_REST_API', 'get_taxonomies' ),
                'schema' => array( 'TagGroups_REST_API', 'get_taxonomies_schema' ),
              ) );
            } );

          }

          /**
          * Get one ore more groups
          *
          * Returns array consisting of items: tag group ID => tag group label or string of tag group label, if id was provided
          *
          * Arguments:
          *   taxonomy    default: post_tag
          *   hide_empty  default: true
          *   fields      for example: ids, all, names; default: all
          *
          *
          * @param object $request
          * @return array|object
          */
          public static function get_groups( WP_REST_Request $request ) {

            global $tag_group_groups;

            $id = $request->get_param( 'id' ); // don't sanitize here

            $taxonomy = sanitize_title( $request->get_param( 'taxonomy' ) );

            $hide_empty = $request->get_param( 'hide_empty' ) ? true : false;

            $fields = sanitize_title( $request->get_param( 'fields' ) );

            $orderby = sanitize_title( $request->get_param( 'orderby' ) );

            $order = sanitize_title( $request->get_param( 'order' ) );

            if ( isset( $id ) ) {

              $id = (int) $id;

              // particular group
              $tg_group = new TagGroups_Group( $id );

              if ( ! $tg_group->exists() ) {

                return new WP_Error( 'no_group', 'Invalid group', array( 'status' => 404 ) );

              }

              return $tg_group->get_info( $taxonomy, $hide_empty, $fields, $orderby, $order );

            }


            $groups = $tag_group_groups->get_info_of_all( $taxonomy, $hide_empty, $fields, $orderby, $order );

            return $groups;

          }


          /**
          * Get one ore more terms
          *
          * Arguments:
          *   taxonomy    default: post_tag
          *   hide_empty  default: true
          *
          *
          * @param object $request
          * @return array|object
          */
          public static function get_terms( WP_REST_Request $request ) {

            global $tag_group_groups, $tag_group_premium_terms;

            $term_o = new TagGroups_Term();

            $id = $request->get_param( 'id' ); // don't sanitize here

            if ( isset( $id ) ) {

              $id = (int) $id;

              $term_o = new TagGroups_Term( $id );

              return array(
                'id'  => $id,
                'name' => $term_o->get_name(),
                'slug' => $term_o->get_slug(),
                'taxonomy' => $term_o->get_taxonomy(),
                'groups' => $term_o->get_groups(),
              );

            } else {

              $orderby = sanitize_title( $request->get_param( 'orderby' ) );

              if ( empty( $orderby ) ) {

                $orderby = 'name';

              }

              $order = sanitize_title( $request->get_param( 'order' ) );

              if ( empty( $order ) ) {

                $order = 'ASC';

              }

              $taxonomy = sanitize_title( $request->get_param( 'taxonomy' ) );

              if ( empty( $taxonomy ) ) {

                $taxonomy = TagGroups_Taxonomy::get_enabled_taxonomies();

              } elseif ( 'public' == strtolower( $taxonomy) ) {

                $taxonomy = array_values( get_taxonomies(
                  array(
                    'public'  => true
                  ),
                  'names'
                  )
                );

              }

              $hide_empty = $request->get_param( 'hide_empty' ) ? true : false;

              $short = $request->get_param( 'short' ) ? true : false;


              $args = array(
                'taxonomy'    => $taxonomy,
                'hide_empty'  => $hide_empty,
                'orderby'     => $orderby,
                'order'       => $order
              );


              $group = $request->get_param( 'group' );

              if ( isset( $group ) ) {

                $group = (int) $group;

                $tg_group = new TagGroups_Group( $group );

                if ( ! $tg_group->exists() ) {

                  return new WP_Error( 'no_group', 'Invalid group', array( 'status' => 404 ) );

                }

                $group_terms = $tg_group->get_group_terms( $taxonomy, $hide_empty, 'ids' );

                if ( false === $group_terms ) {

                  return new WP_Error( 'no_terms', 'Invalid terms', array( 'status' => 404 ) );

                }

                $args[ 'include' ] = $group_terms;

              }

              $terms = get_terms( $args );

              if ( class_exists( 'TagGroups_Premium_Term' ) ) {

                $post_counts = $tag_group_premium_terms->get_post_counts();

              }

              $result = array();

              foreach ( $terms as $term ) {

                if ( is_object( $term ) ) {

                  $term_o = new TagGroups_Term( $term );

                  $info = array(
                    'id'  => $term->term_id,
                    'name' => html_entity_decode( $term->name ),
                    'slug' => $term->slug,
                    'taxonomy' => $term->taxonomy,
                    'description' => $term->description,
                  );

                  if ( ! $short ) {

                    $info['groups'] = $term_o->get_groups();

                    if ( isset( $post_counts ) && isset( $post_counts[ $term->term_id ] ) ) {

                      $info[ 'post_count' ] = $post_counts[ $term->term_id ];

                    }

                  }

                  $result[] = $info;

                }

              }

              return $result;

            }

          }


          /**
          * Get one ore more terms
          *
          * Arguments:
          *   taxonomy    default: post_tag
          *   hide_empty  default: true
          *
          *
          * @param object $request
          * @return array|object
          */
          public static function get_taxonomies( WP_REST_Request $request ) {

            $type = $request->get_param( 'type' );

            $result = array();

            switch ( $type ) {

              case 'metabox':
              $taxonomy_slugs = TagGroups_Taxonomy::get_taxonomies_for_metabox();
              break;

              case 'enabled':
              default:
              $taxonomy_slugs = TagGroups_Taxonomy::get_enabled_taxonomies();
              break;

            }

            foreach ( $taxonomy_slugs as $taxonomy_slug ) {

              $result[] = array(
                'slug'  => $taxonomy_slug,
                'name'  => TagGroups_Taxonomy::get_name_from_slug( $taxonomy_slug )
              );

            }

            return $result;

          }


          /**
          *
          */
          public static function get_group_schema() {
            $schema = array(
              // This tells the spec of JSON Schema we are using which is draft 4.
              '$schema'              => 'http://json-schema.org/draft-04/schema#',
              'title'                => 'group',
              'type'                 => 'object',
              'properties'           => array(
                'term_group' => array(
                  'type'          => 'integer',
                  'label'         => esc_html__( 'Object ID.', 'tag-groups' ),
                  'readonly'      => true,
                ),
                'label' => array(
                  'description'  => esc_html__( 'The object name.', 'tag-groups' ),
                  'type'         => 'string',
                ),
                'position' => array(
                  'description'  => esc_html__( 'The position of the object in lists, menus and tag clouds.', 'tag-groups' ),
                  'type'         => 'integer',
                ),
                'terms' => array(
                  'description'  => esc_html__( 'The terms that are assigned to this group.', 'tag-groups' ),
                  'type'         => 'array',
                ),
              ),
            );

            return $schema;
          }


          /**
          *
          */
          public static function get_term_schema() {
            $schema = array(
              // This tells the spec of JSON Schema we are using which is draft 4.
              '$schema'              => 'http://json-schema.org/draft-04/schema#',
              'title'                => 'term',
              'type'                 => 'object',
              'properties'           => array(
                'id' => array(
                  'type'          => 'integer',
                  'label'         => esc_html__( 'Object ID.', 'tag-groups' ),
                  'readonly'      => true,
                ),
                'name' => array(
                  'description'  => esc_html__( 'The object name.', 'tag-groups' ),
                  'type'         => 'string',
                ),
                'slug' => array(
                  'description'  => esc_html__( 'The term slug.', 'tag-groups' ),
                  'type'         => 'string',
                ),
                'taxonomy' => array(
                  'description'  => esc_html__( 'The term taxonomy.', 'tag-groups' ),
                  'type'         => 'string',
                ),
                'description' => array(
                  'description'  => esc_html__( 'The term description.', 'tag-groups' ),
                  'type'         => 'string',
                ),
                'groups' => array(
                  'description'  => esc_html__( 'The groups that this term is assigned to.', 'tag-groups' ),
                  'type'         => 'array',
                ),
                'post_count' => array(
                  'description'  => esc_html__( 'The post count per group (published posts).', 'tag-groups' ),
                  'type'         => 'array',
                ),
              ),
            );

            return $schema;
          }


          /**
          *
          */
          public static function get_taxonomy_schema() {
            $schema = array(
              // This tells the spec of JSON Schema we are using which is draft 4.
              '$schema'              => 'http://json-schema.org/draft-04/schema#',
              'title'                => 'taxonomy',
              'type'                 => 'object',
              'properties'           => array(
                'name' => array(
                  'description'  => esc_html__( 'The taxonomy name.', 'tag-groups' ),
                  'type'         => 'string',
                ),
              ),
            );

            return $schema;
          }

        }

      }
