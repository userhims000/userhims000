<?php
/**
 * This class adds the required scripts in the front-end to enable alternative loading.
 *
 * @package    Nelio_AB_Testing
 * @subpackage Nelio_AB_Testing/public/helpers
 * @author     David Aguilera <david.aguilera@neliosoftware.com>
 * @since      5.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * This class adds the required scripts in the front-end to enable alternative loading.
 */
class Nelio_AB_Testing_Alternative_Loader {

	protected static $instance;

	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}//end if

		return self::$instance;

	}//end instance()

	public function init() {

		add_action( 'nab_relevant_priority_experiments_loaded', array( $this, 'add_alternative_loading_hooks' ) );
		add_action( 'nab_relevant_regular_experiments_loaded', array( $this, 'add_alternative_loading_hooks' ) );
		add_action( 'wp_head', array( $this, 'maybe_add_overlay' ), 1 );
		add_action( 'get_canonical_url', array( $this, 'fix_canonical_url' ), 50 );
		add_action( 'body_class', array( $this, 'maybe_add_variant_in_body' ) );

	}//end init()

	public function maybe_add_overlay() {
		if ( nab_is_split_testing_disabled() ) {
			return;
		}//end if

		$experiments = $this->get_experiments_that_load_alternative_content();
		if ( empty( $experiments ) ) {
			return;
		}//end if

		nab_print_loading_overlay();
	}//end maybe_add_overlay()

	public function get_post_urls() {
		if ( ! is_singular() ) {
			return array();
		}//end if

		$post_id  = get_the_ID();
		$post_url = array(
			'postId' => $post_id,
			'url'    => get_permalink( $post_id ),
		);

		$experiment = $this->get_relevant_post_experiment( $post_id );
		if ( empty( $experiment ) ) {
			return array( $post_url );
		}//end if

		$control = $experiment->get_alternative( 'control' );
		$control = $control['attributes'];
		if ( empty( $control['testAgainstExistingContent'] ) ) {
			return array( $post_url );
		}//end if

		$alts = $experiment->get_alternatives();
		$alts = wp_list_pluck( wp_list_pluck( $alts, 'attributes' ), 'postId' );
		$urls = array_map( 'get_permalink', $alts );

		$result = array();
		foreach ( $alts as $i => $pid ) {
			$result[] = array(
				'postId' => $pid,
				'url'    => $urls[ $i ],
			);
		}//end foreach
		return $result;
	}//end get_post_urls()

	public function fix_canonical_url( $url ) {
		$runtime   = Nelio_AB_Testing_Runtime::instance();
		$post_urls = $this->get_post_urls();
		if ( ! empty( $post_urls ) ) {
			return get_permalink();
		}//end if
		$requested_alt = $runtime->get_alternative_from_request();
		return $requested_alt ? $runtime->get_untested_url() : $url;
	}//end fix_canonical_url()

	public function maybe_add_variant_in_body( $classes ) {
		$runtime = Nelio_AB_Testing_Runtime::instance();
		$count   = $this->get_number_of_alternatives();
		$alt     = $runtime->get_alternative_from_request();
		if ( ! empty( $count ) ) {
			$classes[] = 'nab';
			$classes[] = "nab-{$alt}";
		}//end if
		return $classes;
	}//end maybe_add_variant_in_body()

	public function add_alternative_loading_hooks( $experiments ) {

		if ( ! is_array( $experiments ) ) {
			$experiments = array( $experiments );
		}//end if

		$runtime       = Nelio_AB_Testing_Runtime::instance();
		$requested_alt = $runtime->get_alternative_from_request();

		foreach ( $experiments as $experiment ) {

			$experiment_type = $experiment->get_type();

			$control      = $experiment->get_alternative( 'control' );
			$alternatives = $experiment->get_alternatives();
			$alternative  = $alternatives[ $requested_alt % count( $alternatives ) ];

			/**
			 * Fires when a certain alternative is about to be loaded as part of a split test.
			 *
			 * Use this action to add any hooks that your experiment type might require in order
			 * to properly load the alternative.
			 *
			 * @param array  $alternative    attributes of the active alternative.
			 * @param array  $control        attributes of the control version.
			 * @param int    $experiment_id  experiment ID.
			 * @param string $alternative_id alternative ID.
			 *
			 * @since 5.0.0
			 */
			do_action( "nab_{$experiment_type}_load_alternative", $alternative['attributes'], $control['attributes'], $experiment->get_id(), $alternative['id'] );

		}//end foreach

	}//end add_alternative_loading_hooks()

	public function get_number_of_alternatives() {

		$gcd = function( $n, $m ) use ( &$gcd ) {
			if ( 0 === $n || 0 === $m ) {
				return 1;
			}//end if
			if ( $n === $m && $n > 1 ) {
				return $n;
			}//end if
			return $m < $n ? $gcd( $n - $m, $n ) : $gcd( $n, $m - $n );
		};

		$lcm = function( $n, $m ) use ( &$gcd ) {
			return $m * ( $n / $gcd( $n, $m ) );
		};

		$experiments  = $this->get_experiments_that_load_alternative_content();
		$alternatives = array_unique(
			array_map(
				function( $experiment ) {
					return count( $experiment->get_alternatives() );
				},
				$experiments
			)
		);

		if ( empty( $alternatives ) ) {
			return 0;
		}//end if

		return array_reduce( $alternatives, $lcm, 1 );

	}//end get_number_of_alternatives()

	public function get_experiments_that_load_alternative_content() {

		$runtime     = Nelio_AB_Testing_Runtime::instance();
		$experiments = $runtime->get_relevant_running_experiments();

		return array_values(
			array_filter(
				$experiments,
				function( $experiment ) {

					$control         = $experiment->get_alternative( 'control' );
					$experiment_id   = $experiment->get_id();
					$experiment_type = $experiment->get_type();

					/**
					 * Whether the experiment should be excluded from adding a `nab` query arg in the current request or not.
					 *
					 * @param boolean $is_excluded   whether the experiment should be excluded from the current request or not.
					 *                               Default: `false`.
					 * @param array   $control       original version.
					 * @param int     $experiment_id id of the experiment.
					 *
					 * @since 5.0.4
					 */
					return ! apply_filters( "nab_{$experiment_type}_exclude_experiment_from_loading", false, $control['attributes'], $experiment_id );

				}
			)
		);

	}//end get_experiments_that_load_alternative_content()

	private function get_relevant_post_experiment( $post_id ) {
		$runtime = Nelio_AB_Testing_Runtime::instance();
		$exps    = $runtime->get_relevant_running_experiments();

		foreach ( $exps as $exp ) {
			$control    = $exp->get_alternative( 'control' );
			$control    = $control['attributes'];
			$control_id = ! empty( $control['postId'] ) ? $control['postId'] : 0;
			if ( $post_id === $control_id ) {
				return $exp;
			}//end if

			if ( ! empty( $control['testAgainstExistingContent'] ) ) {
				$alts = $exp->get_alternatives();
				$pids = wp_list_pluck( wp_list_pluck( $alts, 'attributes' ), 'postId' );
				$pids = array_values( array_filter( $pids ) );
				foreach ( $pids as $pid ) {
					if ( $pid === $post_id ) {
						return $exp;
					}//end if
				}//end foreach
			}//end if
		}//end foreach

		return false;
	}//end get_relevant_post_experiment()

}//end class
