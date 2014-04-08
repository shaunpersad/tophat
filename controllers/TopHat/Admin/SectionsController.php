<?php
/**
 * SectionsController class file.
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
use TopHat\Section;

class SectionsController extends Controller {

    public function indexAction() {

        $this->vars->_site_title.= ' - View All Sections';

        if ($section_id = $this->request->param('id', false)) {

            if ($section = Core::getSection($section_id)) {

                $this->vars->section = $section;
            }
        }

        $this->render($this->layout);
    }

    public function saveAction() {

        $section_data = $this->request->paramsPost()->all(array('id', 'title', 'slug'));

        if (!empty($section_data)) {

            $section = new Section($section_data);

            if ($section_id = $section->save()) {

                Core::addAlert('Section saved.', Core::ALERT_TYPE_SUCCESS);
            }
        }
        $this->response->header('Location', '/admin/sections');
    }

    public function listAction() {



        $get = $this->request->paramsGet();

        $order_by = $get->get('order_by', 'sections.date_updated');
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

        $all_sections_count = Core::getSections(array_merge($args, array('count_only' => true)));

        $total_num_pages = ceil($all_sections_count / $per_page);

        $num_pages_to_display = 10;

        $this->vars->order_by = $order_by;
        $this->vars->order_dir = $order_dir;
        $this->vars->current_page = $current_page;
        $this->vars->s = $s;
        $this->vars->args = $args;
        $this->vars->page_list = Core::getPageList($current_page, $total_num_pages, $num_pages_to_display);
        $this->vars->sections = Core::getSections($args);

        $this->render($this->view);

    }

    public function curateAction() {

        $section_id = $this->request->param('id', false);

        if ($section_id && $section = Core::getSection($section_id)){

            $this->vars->section = $section;

            $this->render($this->layout);

        } else {

            $this->response->header('Location', '/admin/sections');
        }

    }

    public function saveCuratedPostsAction() {

        $section_id = $this->request->param('id', false);

        if ($section_id && $section = Core::getSection($section_id)){

            $post_ids = $this->request->paramsPost()->get('post_ids', array());

            if ($section->save($post_ids)) {

                Core::addAlert('Section posts saved.', Core::ALERT_TYPE_SUCCESS);
            } else {

                Core::addAlert('An error occurred.', Core::ALERT_TYPE_ERROR);
            }
            $this->render('_globals/alerts');

        } else {

            $this->response->header('Location', '/admin/sections');
        }

    }

    public function postAction() {

        if ($post_id = $this->request->paramsGet()->get('post_id', false)) {

            if ($post = Core::getPost($post_id)) {

                $this->vars->post = $post;
            }

        }
        $this->render($this->view);
    }
}