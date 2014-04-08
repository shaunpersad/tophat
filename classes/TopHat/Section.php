<?php
/**
 * Section class file
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

class Section {

    const URL = '/section';

    public $id;
    public $title;
    public $slug;
    public $date_created;
    public $date_updated;

    public function __construct ($section_data = array()) {

        foreach ($section_data as $property => $value) {

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

        $sql = 'SELECT slug FROM sections WHERE slug LIKE ":slug%"';

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
     * Saves the Section to the database.
     *
     * @param array $new_post_ids If provided, will replace the Post associations to this Section.
     * @return bool|int
     */
    public function save($new_post_ids = array()) {

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
            //append suffix if necessary
            /*
             * UPDATE: non-unique slugs are OK.
             * REASON: URLS will contain id: /section/{id}/{slug} slug will be optional.
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

                $db->update('sections', $data, array('id' => $this->id));

            } else {

                $this->date_created = $now;
                $data['date_created'] = $this->date_created;

                $db->insert('sections', $data);
                $this->id = $db->lastInsertId();
            }


            $this->changePosts($new_post_ids);

            if ($cache && $cache->contains('section/'.$this->id)) {

                $cache->delete('section/'.$this->id);
            }

            //Core::incrementGeneration('post');
            Core::incrementGeneration('section');

            return $this->id;

        }

        return false;
    }

    public function delete() {

        $db = Core::getDb();

        $user = Core::getCurrentUser();

        if ($user && $user->type >= User::TYPE_ADMIN && !empty($this->id)) {

            $db->delete('sections', array('id' => $this->id));
            $db->delete('posts_sections', array('sections_id' => $this->id));

            //Core::incrementGeneration('post');
            Core::incrementGeneration('section');

            return true;
        }

        return false;
    }

    protected function changePosts($new_post_ids = array()) {

        $db = Core::getDb();
        $cache = Core::getCache();

        if (is_array($new_post_ids)) {

            $new_post_ids = array_filter($new_post_ids);
        } else {
            $new_post_ids = array();
        }


        if (!empty($this->id)) {

            $db->beginTransaction();
            try{

                $db->delete('posts_sections', array('section_id' => $this->id));

                foreach ($new_post_ids as $index => $post_id) {

                    $position = $index + 1;

                    $data = array('post_id' => $post_id, 'section_id' => $this->id, 'position' => $position);
                    $db->insert('posts_sections', $data);

                    $key = 'section/'.$this->id.'/position-of-post/'.$post_id;

                    if ($cache && $cache->contains($key)) {

                        $cache->delete($key);
                    }

                }

                $db->commit();
                return true;

            } catch(\Exception $e) {
                $db->rollback();
            }
        }
        return false;

    }

    public function getPosts($args = array()) {

        $posts = array();

        if (!empty($this->id)) {

            $args['section_id'] = $this->id;
            $args['order_by'] = 'posts_sections.position';
            $args['order_dir'] = 'ASC';
            $args['page'] = 1;
            $args['per_page'] = 999;

            $posts = Core::getPosts($args);
        }

        return $posts;
    }

    public function positionOfPost($post_id) {

        $db = Core::getDb();
        $cache = Core::getCache();
        $position = 0;

        $key = 'section/'.$this->id.'/position-of-post/'.$post_id;

        if ($cache) {

            $position = $cache->fetch($key);
        }

        if (!$position) {

            $sql = 'SELECT `position` FROM posts_sections WHERE post_id = ?';
            $position = intval($db->fetchColumn($sql, array($post_id)));
        }

        if ($cache) {

            $cache->save($key, $position);
        }
        return $position;
    }

    /**
     * The public url for this Section.
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




}
 