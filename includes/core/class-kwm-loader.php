<?php
/**
 * Plugin Loader Class
 *
 * Handles registration and execution of all actions and filters.
 *
 * @package KaddoraWhatsAppMarketing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'KWM_Loader' ) ) {

	class KWM_Loader {

		/**
		 * Array of registered actions.
		 *
		 * @var array
		 */
		protected $actions;

		/**
		 * Array of registered filters.
		 *
		 * @var array
		 */
		protected $filters;

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->actions = array();
			$this->filters = array();
		}

		/**
		 * Add a new action to the collection.
		 *
		 * @param string   $hook          WordPress action hook name.
		 * @param object   $component     Object instance.
		 * @param string   $callback      Callback method name.
		 * @param int      $priority      Priority (default 10).
		 * @param int      $accepted_args Number of accepted arguments.
		 *
		 * @return void
		 */
		public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
			$this->actions[] = array(
				'hook'          => $hook,
				'component'     => $component,
				'callback'      => $callback,
				'priority'      => $priority,
				'accepted_args' => $accepted_args,
			);
		}

		/**
		 * Add a new filter to the collection.
		 *
		 * @param string   $hook          WordPress filter hook name.
		 * @param object   $component     Object instance.
		 * @param string   $callback      Callback method name.
		 * @param int      $priority      Priority (default 10).
		 * @param int      $accepted_args Number of accepted arguments.
		 *
		 * @return void
		 */
		public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
			$this->filters[] = array(
				'hook'          => $hook,
				'component'     => $component,
				'callback'      => $callback,
				'priority'      => $priority,
				'accepted_args' => $accepted_args,
			);
		}

		/**
		 * Register all actions and filters with WordPress.
		 *
		 * @return void
		 */
		public function run() {

			// Register actions.
			foreach ( $this->actions as $action ) {
				add_action(
					$action['hook'],
					array( $action['component'], $action['callback'] ),
					$action['priority'],
					$action['accepted_args']
				);
			}

			// Register filters.
			foreach ( $this->filters as $filter ) {
				add_filter(
					$filter['hook'],
					array( $filter['component'], $filter['callback'] ),
					$filter['priority'],
					$filter['accepted_args']
				);
			}
		}

		/**
		 * Get all registered actions.
		 *
		 * @return array
		 */
		public function get_actions() {
			return $this->actions;
		}

		/**
		 * Get all registered filters.
		 *
		 * @return array
		 */
		public function get_filters() {
			return $this->filters;
		}
	}
}