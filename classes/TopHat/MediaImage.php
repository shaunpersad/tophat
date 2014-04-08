<?php
/**
 * MediaImage class file.
 *
 * PHP Version 5.3
 *
 * @package  TopHat
 * @author   Shaun Persad <shaunpersad@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://shaunpersad.com
 */

namespace TopHat;

use WideImage\Exception\Exception;
use WideImage\WideImage;

class MediaImage extends Media {

    const WIDTH = 0;
    const HEIGHT = 1;
    const BREADTH = 0;
    const LENGTH = 1;

    protected $_ratio_data;

    /**
     * For use with cropping tool.
     *
     * @param int $breadth
     * @param int $length
     * @param int $x1
     * @param int $y1
     * @param int $x2
     * @param int $y2
     * @param int $width
     * @param int $height
     * @param int $normalizing_width
     */
    public function saveRatioData($breadth, $length, $x1, $y1, $x2, $y2, $width, $height, $normalizing_width) {

        $db = Core::getDb();

        if (!empty($this->file_name)) {

            $data = array(
                'original_file_name' => $this->file_name,
                'breadth' => $breadth,
                'length' => $length,
                'x1' => $x1,
                'y1' => $y1,
                'x2' => $x2,
                'y2' => $y2,
                'width' => $width,
                'height' => $height,
                'normalizing_width' => $normalizing_width
            );


            $sql = 'SELECT COUNT(id)
                    FROM image_ratio_data
                    WHERE original_file_name = :original_file_name
                    AND breadth = :breadth
                    AND length = :length
                    AND x1 = :x1
                    AND y1 = :y1
                    AND x2 = :x2
                    AND y2 = :y2
                    AND width = :width
                    AND height = :height
                    AND normalizing_width = :normalizing_width';

            $exists = intval($db->fetchColumn($sql, $data));

            if (!$exists) {

                $db->beginTransaction();
                try{

                    $now = new \DateTime('now', new \DateTimeZone(TIMEZONE));
                    $now = $now->format(MYSQL_DATETIME_FORMAT);

                    $data['date_created'] = $now;

                    $db->insert('image_ratio_data', $data);

                    return $db->lastInsertId();

                } catch(\Exception $e) {
                    $db->rollback();
                }

            }
        }
        return false;
    }

    /**
     * @return array
     */
    public function getRatioData() {

        if (!empty($this->_ratio_data)) {
            return $this->_ratio_data;
        }
        if (!empty($this->file_name)) {

            $db = Core::getDb();

            $this->_ratio_data = array();

            $sql = 'SELECT * FROM image_ratio_data WHERE original_file_name = ?';
            $results = $db->executeQuery($sql, array($this->file_name));

            while ($ratio = $results->fetch()) {

                $this->_ratio_data[$ratio['breadth'].':'.$ratio['length']] = $ratio;

            }
        }
        return $this->_ratio_data;
    }

    /**
     * @return bool|\WideImage\Image|\WideImage\PaletteImage|\WideImage\TrueColorImage
     */
    public function getWideImageObject() {


        if ($path = $this->path()) {

            if (!empty($path) && file_exists($path)) {

                return WideImage::load($path);
            }
        }

        if (!empty($this->url)) {

            try {

                return WideImage::load($this->url);

            } catch (Exception $e) {

                Core::addAlert($e->getMessage(), Core::ALERT_TYPE_EXCEPTION);
            }
        }

        return false;
    }

    public function convertUrlSourceToFileSource() {


        if (empty($this->file_name) && $this->source == self::SOURCE_URL) {

            $name_only = uniqid('image_');
            $extension = 'png';

            try {

                $img = WideImage::load($this->url);

                if ($img) {

                    $extension = Core::extensionFromFilename($this->url);

                    if (!in_array($extension, Media::$image_extensions)) {

                        $extension = 'png';
                    }

                    $file_name = time().'_'.rand().'_'.$name_only.'.'.strtolower($extension);

                    $img->saveToFile(UPLOADS_DIR.$file_name);

                    $now = new \DateTime('now', new \DateTimeZone(TIMEZONE));
                    $now = $now->format(MYSQL_DATETIME_FORMAT);

                    $user_id = 0;
                    if ($current_user = Core::getCurrentUser()) {

                        $user_id = $current_user->id;
                    }


                    $this->type = Media::TYPE_IMAGE;
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

            } catch (\WideImage\Exception\Exception $e) {

                Core::addAlert($e->getMessage(), Core::ALERT_TYPE_EXCEPTION);
            }

        }

        return $this->path();

    }


    /**
     * Returns an Image URL, according to the specified parameters.
     *
     * MediaImages
     *
     * Images can be returned for any given dimension and/or ratio.
     * If a corresponding image already exists, its URL is returned.
     * If not, one is created from an original version.
     * By default, the "original version" is the file that was originally uploaded.
     * However, the CMS provides a method to specify any number of ratio crops for an uploaded image,
     * so that if a ratio is required that has been specified in the CMS,
     * that file will be used as the original version instead.
     *
     *
     * @param int|int[]|true $dimensions (optional) array(width, height) OR (int) width | true = get embedded url
     * @param int[] $ratio (optional) array(breadth, length)
     * @return bool|string
     */
    public function url($dimensions = 0, $ratio = array()) {

        if ($dimensions === true) {

            return parent::url(true);
        }

        $path = $this->path();

        if (!$path && $this->source == self::SOURCE_URL) {

            $path = $this->convertUrlSourceToFileSource();
        }


        if ($path) {


            $has_width = false;
            $has_height = false;
            $has_ratio = false;

            $name_only = str_replace('.'.$this->extension, '', $this->file_name);

            $original_path = $path;

            /**
             * If a ratio is specified, check the file system for a cropped version as specified by the CMS.
             */
            if (is_array($ratio) &&
                !empty($ratio[self::BREADTH]) &&
                is_numeric($ratio[self::BREADTH]) &&
                !empty($ratio[self::LENGTH]) &&
                is_numeric($ratio[self::LENGTH])) {

                $has_ratio = true;

                $ratio = Core::reduceRatio($ratio[self::BREADTH], $ratio[self::LENGTH]);


                $breadth = $ratio[self::BREADTH];
                $length = $ratio[self::LENGTH];

                $ratio_path = "{$this->upload_dir}{$name_only}_ratio_{$breadth}_{$length}.{$this->extension}";

                if (file_exists($ratio_path)) {

                    // the original path is now the version cropped to the requested ratio.
                    $original_path = $ratio_path;
                }

            }

            //check for a width dimension
            if (is_array($dimensions) &&
                !empty($dimensions[self::WIDTH]) &&
                is_numeric($dimensions[self::WIDTH])) {

                $has_width = true;
            }

            //check for a height dimension
            if (is_array($dimensions) &&
                !empty($dimensions[self::HEIGHT]) &&
                is_numeric($dimensions[self::HEIGHT])) {

                $has_height = true;
            }

            //check for a width as the only specified dimension
            if (!empty($dimensions) && is_numeric($dimensions)) {

                $has_width = true;
                $dimensions = array($dimensions);
            }

            /*
             * The file name is based on the arguments given.  There are 7 possible combinations,
             * ordered by precedence.
             *
             * Case 1: width and height specified, ratio consequently gets ignored
             * width, height - array(width, height), mixed
             * returned file name format: {name-only}_dimensions_{width}_{height}.{extension}
             *
             * Case 2: width and ratio specified, height gets calculated
             * width, ratio - array(width)|width, array(breadth, length)
             * returned file name format: {name-only}_width_{width}_ratio_{breadth}_{length}.{extension}
             *
             * Case 3: height and ratio specified, width gets calculated
             * height, ratio - array(0|false, height), array(breadth, length)
             * returned file name format: {name-only}_height_{height}_ratio_{breadth}_{length}.{extension}
             *
             * Case 4: width only
             * width - array(width)|width
             * returned file name format: {name-only}_width_{width}.{extension}
             *
             * Case 5: height only
             * height - array(0|false, height)
             * returned file name format: {name-only}_height_{height}.{extension}
             *
             * Case 6: ratio only
             * ratio - array(breadth, length)
             * returned file name format: {name-only}_ratio_{breadth}_{length}.{extension}
             *
             * Case 7:
             * none
             * returned file name format: {name-only}.{extension}
             *
             */


            if ($has_width && $has_height) { //Case 1

                $width = $dimensions[self::WIDTH];
                $height = $dimensions[self::HEIGHT];

                $file_name = "{$name_only}_dimensions_{$width}_{$height}.{$this->extension}";

                if (!file_exists($this->upload_dir.$file_name)) {

                    WideImage::load($original_path)
                        ->resize($width, $height)
                        ->saveToFile($this->upload_dir.$file_name);
                }

            } elseif ($has_width && $has_ratio) { //Case 2

                $width = $dimensions[self::WIDTH];
                $breadth = $ratio[self::BREADTH];
                $length = $ratio[self::LENGTH];

                $file_name = "{$name_only}_width_{$width}_ratio_{$breadth}_{$length}.{$this->extension}";

                if (!file_exists($this->upload_dir.$file_name)) {

                    $height = $width * $length / $breadth;

                    WideImage::load($original_path)
                        ->resize($width, $height)
                        ->saveToFile($this->upload_dir.$file_name);
                }

            } elseif ($has_height && $has_ratio) { //Case 3

                $height = $dimensions[self::HEIGHT];
                $breadth = $ratio[self::BREADTH];
                $length = $ratio[self::LENGTH];

                $file_name = "{$name_only}_height_{$height}_ratio_{$breadth}_{$length}.{$this->extension}";

                if (!file_exists($this->upload_dir.$file_name)) {

                    $width = $height * $breadth / $length;

                    WideImage::load($original_path)
                        ->resize($width, $height)
                        ->saveToFile($this->upload_dir.$file_name);
                }

            } elseif ($has_width) { //Case 4

                $width = $dimensions[self::WIDTH];

                $file_name = "{$name_only}_width_{$width}.{$this->extension}";

                if (!file_exists($this->upload_dir.$file_name)) {

                    WideImage::load($original_path)
                        ->resize($width)
                        ->saveToFile($this->upload_dir.$file_name);
                }

            }elseif ($has_height) { //Case 5

                $height = $dimensions[self::HEIGHT];

                $file_name = "{$name_only}_height_{$height}.{$this->extension}";

                if (!file_exists($this->upload_dir.$file_name)) {

                    WideImage::load($original_path)
                        ->resize(null, $height)
                        ->saveToFile($this->upload_dir.$file_name);
                }

            } elseif ($has_ratio) { //Case 6

                $breadth = $ratio[self::BREADTH];
                $length = $ratio[self::LENGTH];

                $file_name = "{$name_only}_ratio_{$breadth}_{$length}.{$this->extension}";

                if (!file_exists($this->upload_dir.$file_name)) {

                    $original =  WideImage::load($original_path);
                    $width = $original->getWidth();
                    $height = $width * $length / $breadth;

                    $original
                        ->resize($width, $height)
                        ->saveToFile($this->upload_dir.$file_name);
                }

            } else { //Case 7

                $file_name = $this->file_name;
            }

            if (file_exists($this->upload_dir.$file_name)) {

                return UPLOADS_URL.$file_name;

            }

        }

        return $this->url;
    }

    public function embed($attrs = array()) {


        if (empty($attrs['src'])) {

            $attrs['src'] = $this->url();
        }

        if (empty($attrs['title'])) {

            $attrs['title'] = $this->title;
        }

        if (empty($attrs['alt'])) {

            $attrs['alt'] = $this->description;
        }

        $attr_string = '';
        foreach ($attrs as $key=>$value) {
            $attr_string.= $key.'='.'"'.$value.'" ';
        }

        $return = '<img '.$attr_string.'/>';

        $href = $attrs['src'];

        if (isset($attrs['href'])) {

            $href = $attrs['href'];
        }


        if ($href) {

            $return = '<a href="'.$href.'" class="embedded-image view-image">'.$return.'</a>';
        }

        return $return;
    }
}
 