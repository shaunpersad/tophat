<?php
/**
 * Post class file
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

/**
 * The basis for all  content.
 *
 * Class Post
 * @package TopHat
 */
class Post {

    const TEASER_LENGTH = 100;
    const URL = '/post';

    private $_categories;
    private $_sections;
    private $_meta;
    private $_tags;
    private $_image;
    private $_author;

    public $id;
    public $title;
    public $slug;
    public $teaser;
    public $is_fancy_text;
    public $body;
    public $image_id;
    public $author_id;
    public $status;
    public $date_created;
    public $date_updated;
    public $date_published;


    /**
     * Creates a Post object from supplied data.
     *
     * Data typically comes from the database, or a form.
     *
     * @param array $post_data The data to populate the Post's properties
     */
    public function __construct ($post_data = array()) {

        $default = array(
            'is_fancy_text' => 0,
            'body' => '',
            'image_id' => 0,
            'author_id' => 0,
            'status' => Core::STATUS_DRAFT
        );

        foreach ($post_data as $property => $value) {

            $this->{$property} = $value;
        }

        foreach ($default as $key => $value) {

            if (empty($this->{$key})) {

                $this->{$key} = $value;
            }
        }

    }

    /**
     * Checks the database for any conflicting slugs.  If found, the proper suffix is calculated and returned.
     *
     * The database looks for any slugs that match slug%,
     * so this accommodates for conflicting slugs with prefixes as well.
     *
     * @return string suffix
     */
    public function getSlugSuffix() {

        $db = Core::getDb();

        $sql = 'SELECT slug FROM posts WHERE slug LIKE ":slug%"';

        $params = array('slug' => $this->slug);

        if (!empty($this->id)) {

            $sql.= ' AND id != :id';
            $params['id'] = $this->id;
        }

        $result = $db->executeQuery($sql, $params);
        $appends = array();

        while ($row = $result->fetch()) {

            $slug = $row['slug'];

            $suffix = str_replace($this->slug.'-', '', $slug);

            if (is_numeric($suffix)) {

                $appends[] = intval($suffix);
            }
        }
        if (!empty($appends)) {

            $max = max($appends);

            if ($max) {

                return '-'.(intval($max) + 1);
            }
        } else {

            return '-1';
        }


        return '';
    }

    /**
     * Saves the Post to the database.
     *
     * The Post's properties are saved to the posts table,
     * while "other data" is saved in their respective places.
     *
     * Currently, "other data" includes Category ids (to associate this post with particular categories),
     * Tag ids (to associate this post with tags),
     * and Meta data, which is and array of associative arrays with keys "title", "value", and "type",
     * describing the Meta data to associate with this Post.
     *
     * @param array $other_data
     * @return int|bool Returns id of the Post on success.
     */
    public function save($other_data = array()) {

        $db = Core::getDb();
        $cache = Core::getCache();

        $user = Core::getCurrentUser();

        if ($user) {

            $now = new \DateTime('now', new \DateTimeZone(TIMEZONE));
            $now = $now->format(MYSQL_DATETIME_FORMAT);

            if (empty($this->title)) {

                Core::addAlert('A title is required.', Core::ALERT_TYPE_ERROR);
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
             * REASON: URLS will contain id: /post/{id}/{slug} slug will be optional.
             *
            $suffix = $this->getSlugSuffix();

            if (strlen($suffix)) {

                $this->slug.= $suffix;
                Core::addAlert('Slug already exists. Appended a suffix for uniqueness.', Core::ALERT_TYPE_WARNING);
            }
            */

            if (empty($this->teaser) && !empty($this->body)) {

                $this->teaser = self::createTeaser($this->body);
            }

            if (empty($this->author_id)) {
                $this->author_id = $user->id;
            }

            $this->date_updated = $now;

            $data = array(
                'title' => $this->title,
                'slug' => $this->slug,
                'teaser' => $this->teaser,
                'is_fancy_text' => $this->is_fancy_text,
                'body' => $this->body,
                'image_id' => $this->image_id,
                'author_id' => $this->author_id,
                'status' => $this->status,
                'date_updated' => $this->date_updated
            );

            if (!empty($this->date_published)) {

                try {

                    $date_published = new \DateTime($this->date_published, new \DateTimeZone(TIMEZONE));
                    $date_published = $date_published->format(MYSQL_DATETIME_FORMAT);

                } catch (\Exception $e) {

                    $date_published = $now;
                }

                $this->date_published = $date_published;

                $data['date_published'] = $this->date_published;
            }

            /*
             * If an id is present, the database will be updated.
             * If not, a new post will be inserted.
             */
            if (empty($this->id)) {

                $this->date_created = $now;
                $data['date_created'] = $this->date_created;

                if ($this->status == Core::STATUS_PUBLISHED) {

                    if (empty($this->date_published)) {

                        $this->date_published = $now;
                        $data['date_published'] = $this->date_published;
                    }

                }

                $db->insert('posts', $data);

                $this->id = $db->lastInsertId();

            } else {

                //update date published, if necessary

                if ($this->status == Core::STATUS_PUBLISHED) {


                    $sql = 'SELECT status FROM posts WHERE id = ?';

                    $old_status = intval($db->fetchColumn($sql, array($this->id)));

                    if ($old_status != Core::STATUS_PUBLISHED) {

                        $this->date_published = $now;
                        $data['date_published'] = $this->date_published;
                    }

                    if (empty($this->date_published)) {

                        $this->date_published = $now;
                        $data['date_published'] = $this->date_published;
                    }
                }
                $db->update('posts', $data, array('id' => $this->id));

            }

            $archive = array('data' => $data, 'other_data' => $other_data);

            $archive_data = array(
                'post_id' => $this->id,
                'user_id' => $user->id,
                'json_data' => json_encode($archive),
                'date_updated' => $now
            );

            $db->insert('posts_history', $archive_data);

            $new_category_ids = array();
            $new_tag_ids = array();
            $new_meta_data = array();

            extract($other_data);
            $this->changeCategories($new_category_ids);
            $this->changeTags($new_tag_ids);
            $this->changeMeta($new_meta_data);

            // invalidate the cache
            if ($cache && $cache->contains('post/'.$this->id)) {

                $cache->delete('post/'.$this->id);
            }
            if ($cache && $cache->contains('post/'.$this->slug)) {

                $cache->delete('post/'.$this->slug);
            }

            /*
             * Increase post generation.
             * This will cause all calls to cache that are dependent on posts to regenerate upon lookup.
             */
            Core::incrementGeneration('post');

            return $this->id;
        }
        return false;
    }

    public function delete() {

        $this->changeStatus(Core::STATUS_DELETED);
    }


    /**
     * @param int $new_status A STATUS constant
     * @return bool
     */
    public function changeStatus ($new_status) {

        $db = Core::getDb();
        $cache = Core::getCache();

        if ($new_status >= Core::STATUS_DELETED &&
            $new_status <= Core::STATUS_PUBLISHED &&
            !empty($this->id)) {

            $data = array ('status' => $new_status);

            if ($new_status == Core::STATUS_PUBLISHED) {

                $now = new \DateTime('now', new \DateTimeZone(TIMEZONE));
                $now = $now->format(MYSQL_DATETIME_FORMAT);

                $this->date_published = $now;
                $data['date_published'] = $this->date_published;
            }

            $return = $db->update('posts', $data, array('id' => $this->id));
            if ($cache) {
                $cache->delete('post/'.$this->id);
                $cache->delete('post/'.$this->slug);
            }
            Core::incrementGeneration('post');

            return $return;
        }
        return false;
    }

    /**
     * @return bool|Image The Image associated with this Post.
     */
    public function image() {

        if (!empty($this->_image)) {
            return $this->_image;
        }
        if (!empty($this->image_id)) {

            return Core::getMedia($this->image_id);
        }
        return false;
    }

    /**
     * @return bool|User The Author of this Post.
     */
    public function author() {

        if (!empty($this->_author)) {

            return $this->_author;
        }
        if (!empty($this->author_id)) {

            return Core::getUser($this->author_id);
        }
        return false;
    }

    /**
     * @param bool $fetch_new Determines if to query again.
     * @return Section[] Sections associated with this Post.
     */
    public function sections($fetch_new = false) {

        if (!empty($this->_sections) && !$fetch_new) {

            return $this->_sections;
        }

        $this->_sections = array();

        if (!empty($this->id)) {

            $this->_sections = Core::getSections(array('post_id' => $this->id));
        }

        return $this->_sections;

    }

    /**
     * @param bool $fetch_new Determines if to query again.
     * @return Category[] Categories associated with this Post.
     */
    public function categories($fetch_new = false) {

        if (!empty($this->_categories) && !$fetch_new) {

            return $this->_categories;
        }

        $this->_categories = array();

        if (!empty($this->id)) {

            $this->_categories = Core::getCategories(array('post_id' => $this->id));
        }

        return $this->_categories;

    }

    /**
     * @param array $new_category_ids Ids of the new categories to be associated with this Post.
     * @return bool
     */
    protected function changeCategories($new_category_ids = array()) {

        $db = Core::getDb();

        if (is_array($new_category_ids)) {

            $new_category_ids = array_filter($new_category_ids);
        } else {
            $new_category_ids = array();
        }

        if (!empty($this->id)) {

            $db->beginTransaction();
            try{

                $db->delete('posts_categories', array('post_id' => $this->id));

                if (empty($new_category_ids)) {

                    if ($uncategorized = Category::getUncategorizedCategory()) {

                        $new_category_ids[] = $uncategorized->id;
                    }

                }

                foreach ($new_category_ids as $category_id) {

                    $data = array('post_id' => $this->id, 'category_id' => $category_id);
                    $db->insert('posts_categories', $data);
                }

                $db->commit();
                unset($this->_categories);
                return true;

            } catch(\Exception $e) {
                $db->rollback();
            }
        }
        return false;
    }

    /**
     * @param bool $fetch_new Determines if to query again.
     * @return string[] The tags associated with this Post.
     */
    public function tags($fetch_new = false) {

        $db = Core::getDb();

        if (!empty($this->_tags) && !$fetch_new) {

            return $this->_tags;
        }

        $this->_tags = array();

        if (!empty($this->id)) {

            $this->_tags = Core::getTags(array('post_id' => $this->id));
        }

        return $this->_tags;

    }

    /**
     * @param array $new_tag_ids Ids of the new tags to be associated with this Post.
     * @return bool
     */
    protected function changeTags($new_tag_ids = array()) {

        $db = Core::getDb();
        $cache = Core::getCache();

        if (is_array($new_tag_ids)) {

            $new_tag_ids = array_filter($new_tag_ids);
        } else {
            $new_tag_ids = array();
        }


        if (!empty($this->id)) {

            $db->beginTransaction();
            try{

                $db->delete('posts_tags', array('post_id' => $this->id));

                foreach ($new_tag_ids as $tag_id) {

                    $data = array('post_id' => $this->id, 'tag_id' => $tag_id);
                    $db->insert('posts_tags', $data);
                }

                $db->commit();

                if ($cache) {

                    $cache->delete('post/'.$this->id.'/tags');
                }
                unset($this->_tags);

                return true;

            } catch(\Exception $e) {
                $db->rollback();
            }

        }
        return false;
    }

    /**
     * @param bool $fetch_new Determines if to query again.
     * @return Meta Meta object associated with this Post.
     */
    public function meta($fetch_new = false) {

        $db = Core::getDb();

        if (!empty($this->_meta) && !$fetch_new) {

            return $this->_meta;
        }

        $this->_meta = new Meta();

        if (!empty($this->id)) {

            $this->_meta = Core::getPostMeta($this->id);
        }

        return $this->_meta;

    }

    /**
     * @param array $new_meta_data Array of associative arrays which is new meta data to be associated with this Post.
     * @return bool
     */
    protected function changeMeta($new_meta_data = array()) {

        $db = Core::getDb();
        $cache = Core::getCache();

        if (!empty($this->id)) {

            $db->beginTransaction();
            try{
                $db->delete('posts_meta', array('post_id' => $this->id));

                foreach ($new_meta_data as $meta_data) {

                    if (!empty($meta_data['title']) &&
                        isset($meta_data['value']) &&
                        !empty($meta_data['type'])) {

                        $data = array(
                            'post_id' => $this->id,
                            'title' => $meta_data['title'],
                            'value' => $meta_data['value'],
                            'type' => $meta_data['type']
                        );

                        $db->insert('posts_meta', $data);
                    }
                }
                $db->commit();

                if ($cache) {
                    $cache->delete('post/'.$this->id.'/meta');
                }
                unset($this->_meta);
                return true;

            } catch(\Exception $e) {
                $db->rollback();
            }
        }
        return false;

    }

    /**
     * The public url for this Post.
     *
     * @return bool|string
     */
    public function url() {

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
     * @param int|string $category_identifier The id or slug of the Category.
     * @return bool
     */
    public function isInCategory($category_identifier) {

        if (!empty($this->id)) {

            $category = Core::getCategory($category_identifier);

            if($category) {
                return $category->hasPost($this->id);
            }
        }
        return false;
    }

    /**
     * @param int|string $section_identifier The id or slug of the Section.
     * @return bool
     */
    public function isInSection($section_identifier) {

        if (!empty($this->id)) {

            $section = Core::getSection($section_identifier);

            if ($section) {
                return $section->positionOfPost($this->id);
            }
        }
        return false;
    }

    /**
     * @param string $tag_title The tag to look for.
     * @return bool
     */
    public function hasTag($tag_title) {

        $tags = $this->tags();

        return in_array($tag_title, $tags);
    }


    /**
     * @param string $string Text to create the teaser out of.
     * @param int $teaser_length Maximum length to trim the text.
     * @return string The trimmed text, appended with an ellipsis.
     */
    public static function createTeaser($string, $teaser_length = self::TEASER_LENGTH) {
        $string = trim(strip_tags($string));

        if (strlen($string) > $teaser_length) {

            $string = substr($string, 0, $teaser_length - 3);

            while (!ctype_alpha(substr($string, -1))) {

                $string = substr($string, 0, -1);

            }
            $string = $string.'...';

        }
        return $string;

    }

}
 