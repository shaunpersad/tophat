<?php
/**
 * Media class file.
 *
 * PHP Version 5.3
 *
 * @package  TopHat
 * @author   Shaun Persad <shaunpersad@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://shaunpersad.com
 */

namespace TopHat;

use TopHat\Core;

abstract class Media {

    const URL = '/media';

    const TYPE_IMAGE = 'image';
    const TYPE_AUDIO = 'audio';
    const TYPE_VIDEO = 'video';
    const TYPE_DOCUMENT = 'document';
    const TYPE_DATA = 'data';
    const TYPE_UNKNOWN = 'unknown';

    const SOURCE_FILE = 'file';
    const SOURCE_URL = 'url';
    const SOURCE_EMBED = 'embed';

    public static $media_types = array(
        self::TYPE_IMAGE,
        self::TYPE_AUDIO,
        self::TYPE_VIDEO,
        self::TYPE_DOCUMENT,
        self::TYPE_DATA,
        self::TYPE_UNKNOWN
    );

    public static $image_extensions = array(
        'bmp', 'gif', 'jpg', 'jpeg', 'png', 'tif', 'tiff'
    );
    public static $audio_extensions = array(
        'aif', 'iff', 'm3u', 'm4a', 'mid', 'mp3', 'mpa', 'ra', 'wav', 'wma'
    );
    public static $video_extensions = array(
        '3g2', '3gp', 'avi', 'flv', 'm4v', 'mov', 'mp4', 'mpg', 'wmv'
    );
    public static $document_extensions = array(
        'doc','docx', 'log', 'msg', 'odt','pages', 'rtf', 'tex', 'txt', 'wpd', 'wps', 'ppt', 'pptx', 'xls', 'xlsx', 'pdf'
    );
    public static $data_extensions = array(
        'csv', 'json', 'xml'
    );

    public $id;
    public $title;
    public $slug;
    public $description;
    public $type;
    public $source;
    public $file_name;
    public $extension;
    public $upload_dir;
    public $url;
    public $embed_code;
    public $uploader_id;
    public $date_created;
    public $date_updated;

    protected $_uploader;


    public function __construct($media_data = array()) {

        $default = array(
            'uploader_id' => 0,
            'description' => '',
            'type' => self::TYPE_UNKNOWN,
            'file_name' => '',
            'extension' => '',
            'upload_dir' => '',
            'url' => '',
            'embed_code' => ''
        );

        foreach ($media_data as $property => $value) {

            $this->{$property} = $value;
        }

        foreach ($default as $key => $value) {

            if (empty($this->{$key})) {

                $this->{$key} = $value;
            }
        }


    }


    public function convertUrlSourceToFileSource() {


        if (empty($this->file_name) && $this->source == self::SOURCE_URL && !empty($this->url)) {

            $name_only = uniqid('image_');
            $extension = Core::extensionFromFilename($this->url);

            $file_name = time().'_'.rand().'_'.$name_only.'.'.$extension;

            $url = UPLOADS_URL.$file_name;
            $path = UPLOADS_DIR.$file_name;

            // download file from url
            Core::downloadFile($url, $path);

            if (file_exists($path)) {

                $user_id = 0;
                if ($current_user = Core::getCurrentUser()) {

                    $user_id = $current_user->id;
                }

                $now = new \DateTime('now', new \DateTimeZone(TIMEZONE));
                $now = $now->format(MYSQL_DATETIME_FORMAT);

                $this->type = Media::getTypeFromExtension($extension);
                $this->source = Media::SOURCE_FILE;
                $this->file_name = $file_name;
                $this->extension = $extension;
                $this->upload_dir = UPLOADS_DIR;
                $this->url = UPLOADS_URL.$file_name;
                $this->uploader_id = $user_id;
                $this->date_created = $now;
                $this->date_updated = $now;


                if (!empty($this->id)) {

                    $data = array(
                        'type' => $this->type,
                        'source' => $this->source,
                        'file_name' => $this->file_name,
                        'extension' => $this->extension,
                        'upload_dir' => $this->upload_dir,
                        'url' => $this->url,
                        'uploader_id' => $this->uploader_id,
                        'date_updated' => $now

                    );

                    $db = Core::getDb();
                    $cache = Core::getCache();

                    $db->update('media', $data, array('id' => $this->id));


                    if ($cache && $cache->contains('media/'.$this->id)) {

                        $cache->delete('media/'.$this->id);
                    }

                    //Core::incrementGeneration('post');
                    Core::incrementGeneration('media');

                }

            }

        }
        return $this->path();
    }


    /**
     * The User who uploaded this Media.
     *
     * @return bool|User
     */
    public function uploader() {

        if (!empty($this->_uploader)) {
            return $this->_uploader;
        }
        if (!empty($this->uploader_id)) {

            $this->_uploader = Core::getUser($this->uploader_id);
        }
        return $this->_uploader;
    }

    /**
     * Saves the Media to the database.
     *
     * All Media must have a URL before saving, either by uploading, or using a link to external Media.
     *
     * @return int|bool Returns id of the Media on success.
     */
    public function save() {

        $db = Core::getDb();
        $cache = Core::getCache();

        $user = Core::getCurrentUser();

        $now = new \DateTime('now', new \DateTimeZone(TIMEZONE));
        $now = $now->format(MYSQL_DATETIME_FORMAT);

        if (empty($this->title)) {

            Core::addAlert('A title is required.', Core::ALERT_TYPE_ERROR);
            return false;
        }

        if (empty($this->url) && ($this->source == Media::SOURCE_FILE || $this->source == Media::SOURCE_URL)) {

            Core::addAlert('Media has no associated URL.', Core::ALERT_TYPE_ERROR);
            return false;
        }


        //generate a slug if necessary
        if (empty($this->slug)) {

            $this->slug = Core::slugify($this->title);

        } elseif(!Core::isProperSlug($this->slug)) {

            $this->slug = Core::slugify($this->title);
            Core::addAlert('Slug was improper. Created another based on title.', Core::ALERT_TYPE_WARNING);
        }
        //append suffix if necessary
        /*
         * UPDATE: non-unique slugs are OK.
         * REASON: URLS will contain id: /media/{id}/{slug} slug will be optional.
         *
        $suffix = $this->getSlugSuffix();

        if (strlen($suffix)) {

            $this->slug.= $suffix;
            Core::addAlert('Slug already exists. Appended a suffix for uniqueness.', Core::ALERT_TYPE_WARNING);
        }
        */


        if ($this->source == Media::SOURCE_FILE) {

            $path = $this->path();

            if (!$path || !file_exists($path)) {

                Core::addAlert('Media does not exist at specified location.', Core::ALERT_TYPE_WARNING);
            }
        }




        if ($user) {

            $this->uploader_id = $user->id;
        }

        $this->date_updated = $now;

        $data = array(
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'source' => $this->source,
            'file_name' => $this->file_name,
            'extension' => $this->extension,
            'upload_dir' => $this->upload_dir,
            'url' => $this->url,
            'embed_code' => $this->embed_code,
            'uploader_id' => $this->uploader_id,
            'date_updated' => $this->date_updated

        );

        if (!empty($this->id)) {

            $db->update('media', $data, array('id' => $this->id));

        } else {

            $this->date_created = $now;
            $data['date_created'] = $this->date_created;

            $db->insert('media', $data);

            $this->id = $db->lastInsertId();
        }

        if ($cache && $cache->contains('media/'.$this->id)) {

            $cache->delete('media/'.$this->id);
        }

        //Core::incrementGeneration('post');
        Core::incrementGeneration('media');


        return $this->id;

    }

    /**
     * Deletes the Media.
     *
     * @param bool $remove_from_filesystem If true, removes the file from the filesystem as well.
     * @return bool
     */
    public function delete($remove_from_filesystem = true) {

        $db = Core::getDb();

        if (!empty($this->id)) {

            if ($remove_from_filesystem) {

                $path = $this->path();

                if (!empty($path)) {

                    unlink($path);
                }
            }

            $db->delete('media', array($this->id));
            Core::incrementGeneration('media');

            return true;

        }
        return false;
    }


    /**
     * Gets the full path of the Media in the filesystem.
     *
     * @return bool|string Full Media path.
     */
    public function path() {

        if (!empty($this->upload_dir) && !empty($this->file_name)) {

            return $this->upload_dir.$this->file_name;
        }
        return false;
    }

    public function url($embedded = false) {

        if (!$embedded) {

            if ($this->source == Media::SOURCE_URL && !empty($this->url)) {

                return $this->url;
            }

            if ($this->path()) {

                return UPLOADS_URL.$this->file_name;
            }
        }

        $url = self::URL;

        if (!empty($this->id)) {

            $url.= '/'.$this->id;
        }

        if (!empty($this->slug)) {

            $url.= '/'.$this->slug;
        }

        return $url;

    }

    /**
     * @param array $media_data
     * @return MediaImage|MediaAudio|MediaVideo|mixed|bool
     */
    public static function createFromData($media_data = array()) {

        if (!empty($media_data['type']) && $media_type = $media_data['type']) {

            $class = '\\TopHat\\Media'.Core::slugToCamelCase($media_type, false);

            if (class_exists($class)) {

                return new $class($media_data);
            }
        }
        return false;
    }

    public static function getTypeFromExtension($extension) {

        $type = Media::TYPE_UNKNOWN;

        $ext = strtolower($extension);

        if (in_array($ext, Media::$image_extensions)) {

            $type = Media::TYPE_IMAGE;

        } elseif (in_array($ext, Media::$audio_extensions)) {

            $type = Media::TYPE_AUDIO;

        } elseif (in_array($ext, Media::$video_extensions)) {

            $type = Media::TYPE_VIDEO;

        } elseif (in_array($ext, Media::$document_extensions)) {

            $type = Media::TYPE_DOCUMENT;

        } elseif (in_array($ext, Media::$data_extensions)) {

            $type = Media::TYPE_DATA;
        }

        return $type;
    }

    abstract public function embed();


}
 