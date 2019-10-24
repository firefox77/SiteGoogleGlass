<?php
/**
 * Variable model.
 *
 * Replace '%variables%' in strings based on context.
 *
 * @since      1.0.33
 * @package    RankMath
 * @subpackage RankMath\Replace_Variables
 * @author     Rank Math <support@rankmath.com>
 */

namespace RankMath\Replace_Variables;

defined( 'ABSPATH' ) || exit;

/**
 * Variable class.
 */
class Variable {

	/**
	 * Allowed properties.
	 *
	 * @var array
	 */
	private static $allowed = [ 'name', 'description', 'variable', 'example' ];

	/**
	 * The unique id.
	 *
	 * @var string
	 */
	protected $id;

	/**
	 * The name of the variabe.
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * The description of the variable.
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * The variable to use.
	 *
	 * @var string
	 */
	protected $variable;

	/**
	 * The example for the variable.
	 *
	 * @var string
	 */
	protected $example;

	/**
	 * The callback to get the replacement value.
	 *
	 * @var mixed
	 */
	protected $callback;

	/**
	 * Create variable from array.
	 *
	 * @throws \InvalidArgumentException If `$id` is empty.
	 *
	 * @param string $id   Unique id of variable.
	 * @param array  $args Array of values.
	 *
	 * @return Variable
	 */
	public static function from( $id, $args ) {
		if ( empty( $id ) ) {
			throw new \InvalidArgumentException( __( 'The $id variable is required.', 'rank-math' ) );
		}

		$variable     = new Variable;
		$variable->id = $id;

		foreach ( self::$allowed as $key ) {
			if ( ! isset( $args[ $key ] ) ) {
				/* translators: variable name */
				throw new \InvalidArgumentException( sprintf( __( 'The $%1$s is required for variable %2$s.', 'rank-math' ), $key, $id ) );
			}

			$variable->$key = $args[ $key ];
		}

		return $variable;
	}

	/**
	 * Returns the id.
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Returns the name.
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * Returns the description.
	 *
	 * @return string
	 */
	public function get_description() {
		return $this->description;
	}

	/**
	 * Returns the variable.
	 *
	 * @return string
	 */
	public function get_variable() {
		return $this->variable;
	}

	/**
	 * Returns the example.
	 *
	 * @return string
	 */
	public function get_example() {
		return $this->example;
	}

	/**
	 * Set example.
	 *
	 * @param string $example New example.
	 */
	public function set_example( $example ) {
		$this->example = $example;
	}

	/**
	 * Set callback.
	 *
	 * @param mixed $callback New callback.
	 */
	public function set_callback( $callback ) {
		$this->callback = $callback;
	}

	/**
	 * Run callback.
	 *
	 * @param array $args Array of arguments.
	 *
	 * @return mixed
	 */
	public function run_callback( $args ) {
		if ( ! empty( $this->callback ) ) {
			return call_user_func( $this->callback, $args );
		}

		return do_action( 'rank_math/vars/' . $this->get_id(), $args, $this );
	}

	/**
	 * Convert object to array.
	 *
	 * @return array Object as array.
	 */
	public function to_array() {
		$arr = [];
		foreach ( self::$allowed as $key ) {
			$arr[ $key ] = $this->$key;
		}

		return $arr;
	}
}
