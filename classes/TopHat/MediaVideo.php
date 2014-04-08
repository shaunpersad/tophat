<?php
/**
 * MediaVideo class file.
 *
 * PHP Version 5.3
 *
 * @package  TopHat
 * @author   Shaun Persad <shaunpersad@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://shaunpersad.com
 */

namespace TopHat;

class MediaVideo extends Media {


    public function embed($attrs = array()) {

        if ($this->source == Media::SOURCE_EMBED) {

            return $this->embed_code;
        }

        $defaults = array(
            'id' => 'video-'.@$this->id,
            'class' => 'video-js vjs-default-skin vjs-big-play-centered embedded-video',
            'controls' => '',
            'preload' => 'auto',
            'width' => 640,
            'height' => 480
        );

        foreach ($defaults as $key => $value) {

            if (empty($attrs[$key])) {

                $attrs[$key] = $value;
            }
        }

        $attr_string = '';

        foreach ($attrs as $key => $value) {

            $attr_string.= $key.'='.'"'.$value.'" ';
        }


        if ($url = $this->url()) {

            return '<video '.$attr_string.'>
                        <source src="'.$url.'" type="video/'.$this->extension.'" />
                   </video>';
        }

    }
}
 