<?php

namespace WeLabs\PluginStub;

/**
 * PluginStub class
 *
 * @class PluginStub The class that holds the entire PluginStub plugin
 */
final class PluginStub {

    /**
     * Plugin version
     *
     * @var string
     */
    public $version = '0.0.1';

    /**
     * Instance of self
     *
     * @var PluginStub
     */
    private static $instance = null;

    /**
     * Holds various class instances
     *
     * @since 2.6.10
     *
     * @var array
     */
    private $container = [];

    /**
     * Constructor for the PluginStub class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( PLUGIN_STUB_FILE, [ $this, 'activate' ] );
        register_deactivation_hook( PLUGIN_STUB_FILE, [ $this, 'deactivate' ] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
        add_action( 'woocommerce_flush_rewrite_rules', [ $this, 'flush_rewrite_rules' ] );
    }

    /**
     * Initializes the PluginStub() class
     *
     * Checks for an existing PluginStub instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        if ( self::$instance === null ) {
			self::$instance = new self();
		}

        return self::$instance;
    }

    /**
     * Magic getter to bypass referencing objects
     *
     * @since 2.6.10
     *
     * @param string $prop
     *
     * @return Class Instance
     */
    public function __get( $prop ) {
		if ( array_key_exists( $prop, $this->container ) ) {
            return $this->container[ $prop ];
		}
    }

    /**
     * Placeholder for activation function
     *
     * Nothing being called here yet.
     */
    public function activate() {
        // Rewrite rules during plugin_stub activation
        if ( $this->has_woocommerce() ) {
            $this->flush_rewrite_rules();
        }
    }

    /**
     * Flush rewrite rules after plugin_stub is activated or woocommerce is activated
     *
     * @since 3.2.8
     */
    public function flush_rewrite_rules() {
        // fix rewrite rules
        flush_rewrite_rules();
    }

    /**
     * Placeholder for deactivation function
     *
     * Nothing being called here yet.
     */
    public function deactivate() {     }

    /**
     * Define all constants
     *
     * @return void
     */
    public function define_constants() {
        $this->define( 'PLUGIN_STUB_PLUGIN_VERSION', $this->version );
        $this->define( 'PLUGIN_STUB_DIR', dirname( PLUGIN_STUB_FILE ) );
        $this->define( 'PLUGIN_STUB_INC_DIR', PLUGIN_STUB_DIR . '/includes' );
        $this->define( 'PLUGIN_STUB_TEMPLATE_DIR', PLUGIN_STUB_DIR . '/templates' );
        $this->define( 'PLUGIN_STUB_PLUGIN_ASSET', plugins_url( 'assets', PLUGIN_STUB_FILE ) );

        // give a way to turn off loading styles and scripts from parent theme
        $this->define( 'PLUGIN_STUB_LOAD_STYLE', true );
        $this->define( 'PLUGIN_STUB_LOAD_SCRIPTS', true );
    }

    /**
     * Define constant if not already defined
     *
     * @param string      $name
     * @param string|bool $value
     *
     * @return void
     */
    private function define( $name, $value ) {
        if ( ! defined( $name ) ) {
            define( $name, $value );
		}
    }

    /**
     * Load the plugin after WP User Frontend is loaded
     *
     * @return void
     */
    public function init_plugin() {
        $this->includes();
        $this->init_hooks();

        do_action( 'plugin_stub_loaded' );
    }

    /**
     * Initialize the actions
     *
     * @return void
     */
    public function init_hooks() {
        // initialize the classes
        add_action( 'init', [ $this, 'init_classes' ], 4 );
        add_action( 'plugins_loaded', [ $this, 'after_plugins_loaded' ] );
    }

    /**
     * Include all the required files
     *
     * @return void
     */
    public function includes() {
        // include_once STUB_PLUGIN_DIR . '/functions.php';
    }

    /**
     * Init all the classes
     *
     * @return void
     */
    public function init_classes() {
        $this->container['scripts'] = new Assets();
    }

    /**
     * Executed after all plugins are loaded
     *
     * At this point plugin_stub Pro is loaded
     *
     * @since 2.8.7
     *
     * @return void
     */
    public function after_plugins_loaded() {
        // Initiate background processes and other tasks
    }

    /**
     * Check whether woocommerce is installed and active
     *
     * @since 2.9.16
     *
     * @return bool
     */
    public function has_woocommerce() {
        return class_exists( 'WooCommerce' );
    }

    /**
     * Check whether woocommerce is installed
     *
     * @since 3.2.8
     *
     * @return bool
     */
    public function is_woocommerce_installed() {
        return in_array( 'woocommerce/woocommerce.php', array_keys( get_plugins() ), true );
    }
}
