<?php
/**
 * MediaController class file.
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

class MediaController extends Controller {

    public function indexAction() {


        $this->response->header('Location', '/admin/media/view-all');
    }

    public function previewAction() {

        $media_id = $this->request->param('id', false);

        if ($media_id) {

            $media = Core::getMedia($media_id);

            if ($media) {

                $this->vars->media = $media;
            }
        }

        $this->render($this->view);
    }

}
 