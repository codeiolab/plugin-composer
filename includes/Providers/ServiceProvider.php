<?php

namespace WeLabs\PluginComposer\Providers;

use WeLabs\PluginComposer\DependencyManagement\BaseServiceProvider;
use WeLabs\PluginComposer\Assets;
use WeLabs\PluginComposer\Contracts\BuilderContract;
use WeLabs\PluginComposer\Contracts\FileSystemContract;
use WeLabs\PluginComposer\Lib\FileSystem;
use WeLabs\PluginComposer\Lib\PluginBuilder;
use WeLabs\PluginComposer\ShortCode;

use function Clue\StreamFilter\fun;

class ServiceProvider extends BaseServiceProvider {
    /**
	 * The classes/interfaces that are serviced by this service provider.
	 *
	 * @var array
	 */
	protected $provides = array(
		Assets::class,
		ShortCode::class,
	);

	/**
     * Register the classes.
     */
	public function register(): void {
		$this->getContainer()->add( FileSystemContract::class, FileSystem::class );
		$this->getContainer()->add(
            BuilderContract::class, function () {
				return new PluginBuilder( $this->getContainer()->get( FileSystemContract::class ) );
			}
        );

		$this->share_with_implements_tags( Assets::class );
		$this->share_with_implements_tags( ShortCode::class );
    }
}
