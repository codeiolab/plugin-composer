<?php

namespace WeLabs\PluginComposer\Contracts;

interface BuilderContract {
    /**
     * Build the plugin.
     *
     * @param string $plugin
     * @return string The zip or download file path of the built plugin
     */
    public function build( string $plugin ): string;

    /**
     * Set the placeholders
     *
     * @param array $placeholders
     * @return void
     */
    public function set_placeholders( array $placeholders ): void;
}
