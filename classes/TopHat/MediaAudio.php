<?php
/**
 * MediaAudio class file.
 *
 * PHP Version 5.3
 *
 * @package  TopHat
 * @author   Shaun Persad <shaunpersad@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://shaunpersad.com
 */

namespace TopHat;


class MediaAudio extends Media {


    public function embed($attrs = array()) {

        if ($this->source == Media::SOURCE_EMBED) {

            return $this->embed_code;
        }

        $defaults = array(
            'id' => 'audio-'.@$this->id,
            'class' => 'embedded-audio',
            'controls' => '',
            'preload' => 'auto'
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

            return '<audio controls '.$attr_string.'>
                        <source src="'.$url.'" type="audio/'.Core::extensionFromFilename($url).'" />
                    </audio>';

        }
    }
}
 