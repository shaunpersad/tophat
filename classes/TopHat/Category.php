<?php
/**
 * Category class file
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
 * Class Category
 * @package TopHat
 */
class Category {

    const URL = '/category/';
    const SLUG_UNCATEGORIZED = 'uncategorized';

    public $id;
    public $title;
    public $slug;
    public $date_created;
    public $date_updated;


    /**
     * Creates a Category object from supplied data.
     *
     * Data typically comes from the database, or a form.
     *
     * @param array $category_data The data to populate the Category's properties
     */
    public function __construct ($category_data = array()) {

        foreach ($category_data as $property => $value) {

            $this->{$property} = $value;
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

        $sql = 'SELECT slug FROM categories WHERE slug LIKE ":slug%"';

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
     * Saves the Category to the database.
     *
     * @return int|bool Returns id of the Category on success.
     */
    public function save() {

        $db = Core::getDb();
        $cache = Core::getCache();

        $user = Core::getCurrentUser();

        if ($user && $user->type >= User::TYPE_ADMIN) {

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

            $uncategorized = self::getUncategorizedCategory();

            if (!empty($this->id) && $this->id == $uncategorized->id && $this->slug != Category::SLUG_UNCATEGORIZED) {

                $this->slug = Category::SLUG_UNCATEGORIZED;
                Core::addAlert('Slug for this category cannot be changed.', Core::ALERT_TYPE_WARNING);
            }

            //append suffix if necessary
            /*
             * UPDATE: non-unique slugs are OK.
             * REASON: URLS will contain id: /category/{id}/{slug} slug will be optional.
             *
            $suffix = $this->getSlugSuffix();

            if (strlen($suffix)) {

                $this->slug.= $suffix;
                Core::addAlert('Slug already exists. Appended a suffix for uniqueness.', Core::ALERT_TYPE_WARNING);
            }
            */

            $this->date_updated = $now;

            $data = array(
                'title' => $this->title,
                'slug' => $this->slug,
                'date_updated' => $this->date_updated
            );

            if (!empty($this->id)) {

                $db->update('categories', $data, array('id' => $this->id));

            } else {

                $this->date_created = $now;
                $data['date_created'] = $this->date_created;

                $db->insert('categories', $data);
                $this->id = $db->lastInsertId();
            }

            if ($cache && $cache->contains('category/'.$this->id)) {

                $cache->delete('category/'.$this->id);
            }

            //Core::incrementGeneration('post');
            Core::incrementGeneration('category');

            return $this->id;

        }

        return false;
    }

    /**
     * Deletes the Category from the database, as well as associations to Posts.
     *
     * @return bool
     */
    public function delete() {

        $db = Core::getDb();

        $user = Core::getCurrentUser();

        if ($user && $user->type >= User::TYPE_ADMIN && !empty($this->id)) {

            $db->delete('categories', array('id' => $this->id));
            $db->delete('posts_categories', array('category_id' => $this->id));
            //Core::incrementGeneration('post');
            Core::incrementGeneration('category');
            return true;
        }

        return false;
    }

    /**
     * Checks for a Post that is in this Category.
     *
     * @param int|string $post_identifier The id or slug of the Post.
     * @return bool
     */
    public function hasPost($post_identifier) {

        $db = Core::getDb();

        $post = Core::getPost($post_identifier);

        if (!empty($post->id)) {

            $sql = 'SELECT COUNT(id) FROM posts_categories WHERE post_id = ? AND category_id = ?';

            return intval($db->fetchColumn($sql, array($post->id, $this->id), 0));
        }

        return false;
    }

    /**
     * The public url for this Category.
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
     * @return bool|Category
     */
    public static function getUncategorizedCategory() {

        return Core::getCategory(self::SLUG_UNCATEGORIZED);
    }


}
 