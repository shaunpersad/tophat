<?php
/**
 * MediaData class file.
 *
 * PHP Version 5.3
 *
 * @package  TopHat
 * @author   Shaun Persad <shaunpersad@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://shaunpersad.com
 */

namespace TopHat;

class MediaData extends Media {

    public function embed($attrs = array()) {

        if (empty($attrs['href'])) {

            $attrs['href'] = $this->url();
        }

        if (empty($attrs['title'])) {

            $attrs['title'] = $this->title;
        }

        $text = $this->title;
        if (!empty($attrs['text'])) {

            $text = $attrs['text'];
            unset($attrs['text']);
        }


        $attr_string = '';
        foreach ($attrs as $key=>$value) {
            $attr_string.= $key.'='.'"'.$value.'" ';
        }

        return '<a '.$attr_string.'>'.$text.'</a>';
    }
}
 