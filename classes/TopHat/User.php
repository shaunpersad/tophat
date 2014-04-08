<?php
/**
 * User class file
 *
 * PHP Version 5.3
 *
 * @package  TopHat
 * @author   Shaun Persad <shaunpersad@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://shaunpersad.com
 */
namespace TopHat;

use Phpass\Hash;

/**
 * Class User
 * @package TopHat
 */
class User {

    const TYPE_PUBLIC = 0;
    const TYPE_AUTHOR = 1;
    const TYPE_ADMIN = 2;
    const TYPE_DEV = 3;

    private $_meta;

    public $id;
    public $email;
    public $first_name;
    public $last_name;
    public $display_name;
    public $type;
    public $date_created;
    public $date_updated;

    /**
     * Creates a User object from supplied data.
     *
     * Data typically comes from the database, or a form.
     *
     * @param array $user_data The data to populate the User's properties
     */
    public function __construct ($user_data = array()) {

        foreach ($user_data as $property => $value) {

            $this->{$property} = $value;
        }
    }

    /**
     * Saves User.
     *
     * Does not save passwords!
     * Use changePassword() instead.
     *
     * @return bool|int user's id
     */
    public function save() {

        $db = Core::getDb();
        $cache = Core::getCache();

        $now = new \DateTime('now', new \DateTimeZone(TIMEZONE));
        $now = $now->format(MYSQL_DATETIME_FORMAT);

        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {

            Core::addAlert('A valid email address is required.');

            return false;
        }

        if ($this->emailExists()) {

            Core::addAlert('This email already exists.', Core::ALERT_TYPE_ERROR);

            return false;
        }

        $this->date_updated = $now;

        $data = array(
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'display_name' => $this->display_name,
            'type' => $this->type,
            'date_updated' => $this->date_updated
        );

        if (empty($this->id)) {

            $this->date_created = $now;
            $data['date_created'] = $this->date_created;

            $db->insert('users', $data);

            $this->id = $db->lastInsertId();
        } else {
            $db->update('users', $data, array('id' => $this->id));
        }

        // invalidate the cache
        if ($cache && $cache->contains('user/'.$this->id)) {

            $cache->delete('user/'.$this->id);
        }
        Core::incrementGeneration('user');

        return $this->id;
    }

    /**
     * Will add more rules in the future.
     *
     * @param string $new_password
     * @return bool
     */
    public static function isAcceptablePassword($new_password) {

        return strlen(trim($new_password)) >= 6;
    }

    /**
     * Changes/adds a User's password.
     *
     * Hashes using bcrypt.
     *
     * @param string $new_password User's new password.
     * @return bool
     */
    public function changePassword($new_password) {

        $db = Core::getDb();

        if (!empty($this->id) && User::isAcceptablePassword($new_password)) {

            $hasher = new Hash();
            $hashed_password = $hasher->hashPassword($new_password);


            if ($db->update(
                'users',
                array('password' => $hashed_password),
                array('id' => $this->id),
                array(\PDO::PARAM_STR)
            )) {
                return $this->id;
            }

        }
        return false;
    }

    /**
     * Checks if the User's email already exists in the database.
     *
     * @return bool
     */
    private function emailExists() {

        $db = Core::getDb();

        $sql = 'SELECT COUNT(id) FROM users WHERE email = :email';
        $params = array('email' => $this->email);
        if (!empty($this->id)) {

            $sql.= ' AND id != :id';
            $params['id'] = $this->id;
        }
        $exists = intval($db->fetchColumn($sql, $params));

        return $exists;
    }

    /**
     * @param bool $fetch_new Determines if to query again.
     * @return Meta Meta object associated with this User.
     */
    public function meta($fetch_new = false) {

        $db = Core::getDb();

        if (!empty($this->_meta) && !$fetch_new) {

            return $this->_meta;
        }

        $this->_meta = new Meta();

        if (!empty($this->id)) {

            $this->_meta = Core::getUserMeta($this->id);
        }

        return $this->_meta;

    }

    /**
     * @param array $new_meta_data Array of associative arrays which is new meta data to be associated with this User.
     * @return bool
     */
    protected function changeMeta($new_meta_data = array()) {

        $db = Core::getDb();
        $cache = Core::getCache();

        if (!empty($this->id)) {

            $db->beginTransaction();
            try{

                $db->delete('users_meta', array('user_id' => $this->id));

                foreach ($new_meta_data as $meta_data) {

                    if (!empty($meta_data['title']) &&
                        isset($meta_data['value']) &&
                        !empty($meta_data['type'])) {

                        $data = array(
                            'user_id' => $this->id,
                            'title' => $meta_data['title'],
                            'value' => $meta_data['value'],
                            'type' => $meta_data['type']
                        );

                        $db->insert('users_meta', $data);
                    }
                }
                $db->commit();
                if ($cache) {
                    $cache->delete('user/'.$this->id.'/meta');
                }
                unset($this->_meta);
                return true;

            } catch(\Exception $e) {
                $db->rollback();
            }

        }
        return false;

    }


}
 