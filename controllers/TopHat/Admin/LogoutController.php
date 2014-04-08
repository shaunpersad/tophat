<?php
/**
 * LogoutController class file
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

class LogoutController extends Controller {

    public function indexAction() {

        Core::logoutUser();
        $this->response->header('Location', '/admin/login');
    }
}
 