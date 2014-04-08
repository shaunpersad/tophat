<?php
/**
 * IndexController class file
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

class IndexController extends Controller {

    public function indexAction() {

        $current_user = Core::getCurrentUser();

        if ($current_user) {

            $this->response->header('Location', '/admin/dashboard');
        } else {

            $this->response->header('Location', '/admin/login');
        }
    }

    public function alertsAction() {

        $this->render('_globals/alerts');
    }
}
 