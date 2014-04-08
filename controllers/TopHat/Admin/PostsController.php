<?php
/**
 * PostsController class file
 *
 * PHP Version 5.3
 *
 * @package  TopHat
 * @author   Shaun Persad <shaunpersad@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://shaunpersad.com
 */

namespace TopHat\Admin;

use Doctrine\DBAL\Portability\Connection;
use TopHat\Controller;
use TopHat\Core;
use TopHat\Post;
use TopHat\User;

class PostsController extends Controller {

    public function indexAction() {

        $post_id = $this->request->param('id', false);

        if ($post_id) {

            $this->response->header('Location', '/admin/posts/'.$post_id.'/edit');

        } else {

            $this->response->header('Location', '/admin/posts/view-all');
        }
    }

    public function viewAllAction() {

        $this->vars->_site_title.= ' - View All Posts';


        $get = $this->request->paramsGet();

        $order_by = $get->get('order_by', 'posts.date_updated');
        $order_dir = $get->get('order_dir', 'DESC');
        $per_page = $get->get('per_page', 30);
        $current_page = $get->get('page', 1);
        $category_id_in = $get->get('category_id_in', array());
        $status = $get->get('status', false);
        $s = $get->get('s', '');

        $args = array(
            'page' => $current_page,
            'per_page' => $per_page,
            'category_id_in' => $category_id_in,
            'status' => $status,
            'order_by' => $order_by,
            'order_dir' => $order_dir,
            's' => $s
        );
        //var_dump($args);
        if ($status != Core::STATUS_DELETED) {

            $args['status_not_in'] = array(Core::STATUS_DELETED);
        }


        $all_posts_count = Core::getPosts(array_merge($args, array('count_only' => true)));

        $total_num_pages = ceil($all_posts_count / $per_page);

        $num_pages_to_display = 10;

        $this->vars->order_by = $order_by;
        $this->vars->order_dir = $order_dir;
        $this->vars->current_page = $current_page;
        $this->vars->category_id_in = $category_id_in;
        $this->vars->status = $status;
        $this->vars->s = $s;
        $this->vars->args = $args;
        $this->vars->page_list = Core::getPageList($current_page, $total_num_pages, $num_pages_to_display);
        $this->vars->posts = Core::getPosts($args);



        $this->render($this->layout);
    }

    public function selectorAction() {

        $this->render($this->view);
    }

    public function listAction() {

        $get = $this->request->paramsGet();

        $order_by = $get->get('order_by', 'posts.date_updated');
        $order_dir = $get->get('order_dir', 'DESC');
        $per_page = $get->get('per_page', 30);
        $current_page = $get->get('page', 1);
        $category_id_in = $get->get('category_id_in', array());
        $s = $get->get('s', '');

        $args = array(
            'page' => $current_page,
            'per_page' => $per_page,
            'category_id_in' => $category_id_in,
            'order_by' => $order_by,
            'order_dir' => $order_dir,
            's' => $s
        );

        $all_posts_count = Core::getPosts(array_merge($args, array('count_only' => true)));

        $total_num_pages = ceil($all_posts_count / $per_page);

        $num_pages_to_display = 10;

        $this->vars->order_by = $order_by;
        $this->vars->order_dir = $order_dir;
        $this->vars->current_page = $current_page;
        $this->vars->category_id_in = $category_id_in;
        $this->vars->s = $s;
        $this->vars->args = $args;
        $this->vars->page_list = Core::getPageList($current_page, $total_num_pages, $num_pages_to_display);
        $this->vars->posts = Core::getPosts($args);

        $this->render($this->view);

    }

    public function previewAction() {

        $post_id = $this->request->param('id', false);

        if ($post_id) {

            $post = Core::getPost($post_id);

            if ($post) {

                $this->vars->post = $post;
            }
        }

        $this->render($this->view);
    }

    public function editAction() {

        $post_id = $this->request->param('id', false);

        if ($post_id) {

            $post = Core::getPost($post_id);

            if ($post) {

                $this->vars->post = $post;
                $this->render($this->layout);
            } else {
                $this->response->header('Location', '/admin/posts/add');
            }

        } else {
            $this->response->header('Location', '/admin/posts/view-all');
        }

    }

    public function addAction() {

        $this->vars->_site_title.= ' - Add New Post';
        $this->render($this->layout);
    }

    public function saveAction() {

        $current_user = Core::getCurrentUser();
        $post_data = $this->request->paramsPost()->get('post', false);

        $category_ids = $this->request->paramsPost()->get('category_ids', array());
        $meta_data = $this->request->paramsPost()->get('meta', array());
        $tags = $this->request->paramsPost()->get('tags', '');
        $tag_titles = explode(',', $tags);
        $tag_ids = self::convertTagTitlesToIds($tag_titles);

        $other_data = array(
            'new_category_ids' => $category_ids,
            'new_meta_data' => $meta_data,
            'new_tag_ids' => $tag_ids
        );

        if ($current_user && $current_user->type >= User::TYPE_AUTHOR && $post_data) {

            $post = new Post($post_data);

            if ($post_id = $post->save($other_data)) {

                Core::addAlert('Post saved.', Core::ALERT_TYPE_SUCCESS);

                $this->response->header('Location', '/admin/posts/'.$post_id.'/edit');
                return true;
            }

        }

        $this->response->header('Location', '/admin/posts/add');
    }

    public static function convertTagTitlesToIds($tag_titles = array()) {

        $db = Core::getDb();

        $ids = array();

        $tag_titles = array_filter(
            array_map(
                function($str) {

                    return strtolower(trim($str));
                }, $tag_titles
            )
        );

        if (empty($tag_titles)) {

            return $ids;
        }

        foreach ($tag_titles as $title) {

            $ids[$title] = 0;
        }

        $sql = 'SELECT id,title FROM tags WHERE title IN (?)';

        $result = $db->executeQuery($sql, array($tag_titles), array(Connection::PARAM_STR_ARRAY));

        $existing_titles = array();

        while ($row = $result->fetch()) {

            $existing_titles[] = $row['title'];
            $ids[$row['title']] = $row['id'];
        }

        $nonexisting_titles = array_diff($tag_titles, $existing_titles);

        foreach ($nonexisting_titles as $title) {

            if (strlen($title)) {

                $db->insert('tags', array('title' => $title));
                $ids[$title] = $db->lastInsertId();
            }

        }

        return $ids;
    }

    public function metaFieldAction() {

        $attrs = $this->request->paramsPost()->all();

        if (empty($attrs)) {

            $attrs = array();
        }
        $this->render($this->view, $attrs);
    }

}
 