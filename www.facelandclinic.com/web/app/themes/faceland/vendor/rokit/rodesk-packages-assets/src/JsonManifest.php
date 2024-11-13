<?php

// Set the namespace
namespace Rokit\Assets;

// Pull in the Illuminate config package
use Illuminate\Config\Repository as BaseConfig;

/**
 *
 * Rokit asset loading Class
 *
 * Class to load cachebusted assets via a manifest file
 *
 * @author  Jasper Rooduijn
 * @since   1.0
 */

class JsonManifest implements ManifestInterface {

    /** @var array */
    public $manifest;

    /** @var string */
    public $dist;

    /**
     * JsonManifest constructor
     *
     * @param string    $manifestPath   Local filesystem path to JSON-encoded manifest
     * @param string    $distUri        Remote URI to assets root
     */

    public function __construct($manifestPath, $distUri) {

        $this->manifest = file_exists($manifestPath) ? json_decode(file_get_contents($manifestPath), true) : [];
        $this->dist = $distUri;

    }

    /** @inheritdoc */

    public function get($asset) {

        $directory  = dirname( $asset ) . '/';
        $filename   = basename( $asset );


        return isset( $this->manifest[$filename] ) ? $directory . $this->manifest[$filename] : $asset;
    }

    /** @inheritdoc */

    public function getUri($asset) {
        return "{$this->dist}/{$this->get($asset)}";
    }

}

