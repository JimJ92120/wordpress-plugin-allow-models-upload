<?php
/**
 * Plugin Name:         Allow Models Upload
 * 
 * Description:         Allow users to upload <em>.gltf</em> and <em>.glb</em> files into WordPress Media Library.
 * Author:              JimJ92120
 * Author URI:          https://github.com/JimJ92120
 * 
 * Version:             0.1.0
 * Requires at least:   5.9
 * Requires PHP:        7.4
 */

add_filter('upload_mimes', function($mime_types) {
    $mime_types['gltf'] = 'model/gltf+json';
    $mime_types['glb'] = 'model/gltf-binary';

    return $mime_types;
});

add_filter('wp_check_filetype_and_ext', function($data, $file, $filename, $mime_types, $real_mime_type) {
    if (empty($data['ext'])
        || empty($data['type'])
    ) {
        $file_type = wp_check_filetype($filename, $mime_types);

        if ('gltf' === $file_type['ext']) {
            $data['ext']  = 'gltf';
            $data['type'] = 'model/gltf+json';
        }

        if ('glb' === $file_type['ext']) {
            $data['ext']  = 'glb';
            $data['type'] = 'model/glb-binary';
        }
    }

    return $data;
}, 10, 5);
