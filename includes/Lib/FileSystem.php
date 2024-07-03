<?php

namespace WeLabs\PluginComposer\Lib;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use WeLabs\PluginComposer\Contracts\FileSystemContract;
use ZipArchive;

class FileSystem implements FileSystemContract {
    public function __construct()
    {
        error_log('instantiates the filesystem -->' );
    }

    /**
     * @inheritDoc
     */
    public function copy( string $src, string $dest ): void {
        $files = $this->get_files( $src );

        foreach ( $files as $file_path ) {
            $dest_path = str_replace( $src, $dest, $file_path );
            $dir = dirname( $dest_path );

            if ( ! is_dir( $dir ) ) {
                mkdir( $dir, 0777, true );
            }

            copy( $file_path, $dest_path );
        }
    }

    /**
     * @inheritDoc
     */
    public function rename( string $src, string $dest ): bool {
        return rename( $src, $dest );
    }

    /**
     * @inheritDoc
     */
    public function replace( string $src, array $patterns ): void {
        $files = $this->get_files( $src );

        foreach ( $files as $file ) {
            $content = file_get_contents( $file );
            foreach ( $patterns  as $search => $value ) {
                $content = str_replace( $search, $value, $content );
            }

            file_put_contents( $file, $content );
        }
    }

    /**
     * @inheritDoc
     */
    public function get_files( string $src ): array {
        if ( ! is_dir( $src ) && is_file( $src ) ) {
            return (array) $src;
        }

        $files = [];

        $iterator = new FilesystemIterator( $src );

        foreach ( $iterator as $entry ) {
            $relative_path = $entry->getFilename();
            $name = $src . '/' . $relative_path;
            if ( ! is_dir( $name ) ) {
                $files[] = $name;
            } else {
                array_push( $files, ...$this->get_files( $name, $files ) );
            }
        }

        return $files;
    }

    /**
     * @inheritDoc
     */
    public function zip( string $source, string $destination ): bool {
        if ( ! extension_loaded( 'zip' ) || ! file_exists( $source ) ) {
            return false;
        }

        $zip = new ZipArchive();
        if ( ! $zip->open( $destination, ZIPARCHIVE::CREATE ) ) {
            return false;
        }

        $source = str_replace( '\\', '/', realpath( $source ) );

        if ( is_dir( $source ) === true ) {
            $files = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $source ), RecursiveIteratorIterator::SELF_FIRST );
            foreach ( $files as $file ) {
                $file = str_replace( '\\', '/', $file );

                if ( in_array( substr( $file, strrpos( $file, '/' ) + 1 ), array( '.', '..' ), true ) ) {
                    continue;
                }

                $file = realpath( $file );

                if ( is_dir( $file ) === true ) {
                    $zip->addEmptyDir( str_replace( $source . '/', '', $file . '/' ) );
                } elseif ( is_file( $file ) === true ) {
                    $zip->addFromString( str_replace( $source . '/', '', $file ), file_get_contents( $file ) );
                }
            }
        } elseif ( is_file( $source ) === true ) {
            $zip->addFromString( basename( $source ), file_get_contents( $source ) );
        }

        return $zip->close();
    }

    /**
     * @inheritDoc
     */
    public function remove( string $dir ): bool {
        $files = array_diff( scandir( $dir ), array( '.', '..' ) );

        foreach ( $files as $file ) {
            $path = "$dir/$file";
            if ( is_dir( $path ) ) {
                $this->remove( $path );
            } else {
                unlink( $path );
            }
        }

        return rmdir( $dir );
    }
}
