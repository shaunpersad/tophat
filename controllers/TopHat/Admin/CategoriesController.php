<?php
/**
 * CategoriesController class file.
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
use TopHat\Category;

class CategoriesController extends Controller {


    public function indexAction() {

        $this->vars->_site_title.= ' - View All Categories';

        if ($category_id = $this->request->param('id', false)) {

            if ($category = Core::getCategory($category_id)) {

                if ($category->slug != Category::SLUG_UNCATEGORIZED) {

                    $this->vars->category = $category;
                }
            }
        }

        $this->render($this->layout);
    }

    public function saveAction() {

        $category_data = $this->request->paramsPost()->all(array('id', 'title', 'slug'));

        if (!empty($category_data)) {

            $category = new Category($category_data);

            if ($category_id = $category->save()) {

                Core::addAlert('Category saved.', Core::ALERT_TYPE_SUCCESS);
            }
        }
        $this->response->header('Location', '/admin/categories');
    }

    public function deleteAction() {

        $category_id = $this->request->param('id', false);

        if ($category_id && $category = Core::getCategory($category_id)) {

            if ($category->delete()) {

                Core::addAlert('Category deleted.', Core::ALERT_TYPE_SUCCESS);
            }
        }
        $this->response->header('Location', '/admin/categories');
    }

    public function listAction() {



        $get = $this->request->paramsGet();

        $order_by = $get->get('order_by', 'categories.date_updated');
        $order_dir = $get->get('order_dir', 'DESC');
        $per_page = $get->get('per_page', 30);
        $current_page = $get->get('page', 1);
        $s = $get->get('s', '');

        $args = array(
            'page' => $current_page,
            'per_page' => $per_page,
            'order_by' => $order_by,
            'order_dir' => $order_dir,
            's' => $s
        );

        $all_categories_count = Core::getCategories(array_merge($args, array('count_only' => true)));

        $total_num_pages = ceil($all_categories_count / $per_page);

        $num_pages_to_display = 10;

        $this->vars->order_by = $order_by;
        $this->vars->order_dir = $order_dir;
        $this->vars->current_page = $current_page;
        $this->vars->s = $s;
        $this->vars->args = $args;
        $this->vars->page_list = Core::getPageList($current_page, $total_num_pages, $num_pages_to_display);
        $this->vars->categories = Core::getCategories($args);

        $this->render($this->view);

    }
}
 