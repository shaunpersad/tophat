<?php
/**
 * TagsController class file.
 *
 * PHP Version 5.3
 *
 * @package  TopHat
 * @author   Shaun Persad <shaunpersad@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://shaunpersad.com
 */

namespace TopHat\Admin;

use TopHat\Controller;
use TopHat\Core;

class TagsController extends Controller {

    public function indexAction() {

        $query = $this->request->paramsGet()->get('query', false);

        $tags= $this->getTags($query);

        $this->response->json($tags);

    }


    public function getTags($query = false) {

        $db = Core::getDb();

        $sql = 'SELECT title FROM tags';
        $data = array();
        if ($query) {

            $sql.= ' WHERE title LIKE :query';
            $data['query'] = '%'.$query.'%';
        }

        $sql.= ' ORDER BY id DESC LIMIT 500';

        $tags = $db->fetchAll($sql, $data);

        return $tags;
    }

}
 