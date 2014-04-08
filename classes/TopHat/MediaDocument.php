<?php
/**
 * MediaDocument class file.
 *
 * PHP Version 5.3
 *
 * @package  TopHat
 * @author   Shaun Persad <shaunpersad@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://shaunpersad.com
 */

namespace TopHat;


class MediaDocument extends Media {

    public function embed($attrs = array()) {

        if (empty($attrs['src'])) {

            $attrs['src'] = $this->url();
        }

        if (empty($attrs['title'])) {

            $attrs['title'] = $this->title;
        }

        $attr_string = '';
        foreach ($attrs as $key=>$value) {
            $attr_string.= $key.'='.'"'.$value.'" ';
        }

        return '<iframe '.$attr_string.'></iframe>';
    }
}
 