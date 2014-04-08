<?php
/**
 * MediaEditorController class file.
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
use TopHat\User;

class MediaEditorController extends Controller {

    public function indexAction() {

        $this->response->header('Location', '/admin/media-editor/selector');
    }

    public function selectorAction() {

        $get = $this->request->paramsGet();

        $order_by = $get->get('order_by', 'media.date_updated');
        $order_dir = $get->get('order_dir', 'DESC');
        $per_page = $get->get('per_page', 30);
        $current_page = $get->get('page', 1);
        $media_type = $get->get('media_type', false);
        $s = $get->get('s', '');

        $args = array(
            'page' => $current_page,
            'per_page' => $per_page,
            'media_type' => $media_type,
            'order_by' => $order_by,
            'order_dir' => $order_dir,
            's' => $s
        );

        $all_medias_count = Core::getMedias(array_merge($args, array('count_only' => true)));

        $total_num_pages = ceil($all_medias_count / $per_page);

        $num_pages_to_display = 10;

        $this->vars->order_by = $order_by;
        $this->vars->order_dir = $order_dir;
        $this->vars->current_page = $current_page;
        $this->vars->media_type = $media_type;
        $this->vars->s = $s;
        $this->vars->args = $args;
        $this->vars->page_list = Core::getPageList($current_page, $total_num_pages, $num_pages_to_display);
        $this->vars->medias = Core::getMedias($args);

        $this->render($this->view);
    }

    public function editAction() {

        $media_id = $this->request->param('id', false);

        if ($media_id) {

            $media = Core::getMedia($media_id);

            if ($media) {

                $url = "/admin/{$media->type}-editor/{$media->id}/edit";

                $this->response->header('Location', $url);
                return true;
            }
        }

        $this->response->header('Location', '/admin/media-editor/selector');
    }

    public function createNewAction() {

        $media_type = $this->request->paramsGet()->get('media_type', false);

        if ($media_type) {

            $url = "/admin/{$media_type}-editor";

            $this->response->header('Location', $url);
            return true;
        }

        $this->render($this->view);
    }

}
 