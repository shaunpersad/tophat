<?php
/**
 * Meta class file
 *
 * PHP Version 5.3
 *
 * @package  TopHat
 * @author   Shaun Persad <shaunpersad@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://shaunpersad.com
 */
namespace TopHat;

/**
 * Class Meta
 *
 * A Meta of a given title is an array of associative arrays.
 *
 * To elaborate, say for example, the Admin added a meta field to a Post titled "phone".
 * The data entered into that field (the title, type, and value) would be stored as an associative array.
 * e.g. array('title' => 'phone', 'type' => TYPE_TEXT, 'value' => '555-555-5555')
 *
 * However, the Admin is able to create an arbitrary number of meta fields also titled "phone".
 * Therefore, calling $meta->get('phone') returns an array of associative arrays,
 * corresponding to how many meta fields named "phone" exist for that post.
 *
 * Handily, calling $meta->getFirst('phone') will return just the first row, instead of an array of them all.
 *
 * @package TopHat
 */
class Meta {

    const TYPE_TEXT = 'text';
    const TYPE_FANCY_TEXT = 'fancy-text';
    const TYPE_DATE = 'date';
    const TYPE_DATE_TIME = 'date-time';
    const TYPE_POST = 'post';
    const TYPE_MEDIA = 'media';

    public static $types = array(
        self::TYPE_TEXT,
        self::TYPE_FANCY_TEXT,
        self::TYPE_DATE,
        self::TYPE_DATE_TIME,
        self::TYPE_POST,
        self::TYPE_MEDIA
    );

    private $_collection;

    public function __construct() {

        $this->_collection = array();
    }

    /**
     * @param array $meta_data Associative array of structure array('title' => '', 'type' => TYPE, 'value' => '').
     */
    public function add($meta_data) {

        $title = $meta_data['title'];
        $this->_collection[$title][] = $meta_data;
    }

    /**
     * @param string $title Title of the meta field whose existence you want to check.
     * @return bool
     */
    public function has($title) {
        return isset($this->_collection[$title]);
    }

    /**
     * Gets the first row of meta data for a given title.
     *
     * @param string $title Title of the meta field whose first row of data you wish to get.
     * @return bool|array  Associative array of structure array('title' => '', 'type' => TYPE, 'value' => '').
     */
    public function getFirst($title) {

        if (isset($this->_collection[$title][0])) {

            return $this->_collection[$title][0];
        }
        return false;
    }

    /**
     * @param string $title Title of the meta field whose array of data you wish to get.
     * @return bool|array Array of associative arrays of structure array('title' => '', 'type' => TYPE, 'value' => '').
     */
    public function get($title) {
        if (isset($this->_collection[$title])) {

            return $this->_collection[$title];
        }
        return false;
    }

    /**
     * @return array Associative array of all Meta data, keyed by title.
     */
    public function all() {
        return $this->_collection;
    }



}
 