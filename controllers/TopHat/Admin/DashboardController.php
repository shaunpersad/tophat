<?php
/**
 * DashboardController class file
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

class DashboardController extends Controller {

    public function indexAction() {

        $current_user = Core::getCurrentUser();

        if (!$current_user) {

            $this->response->header('Location', '/admin/login');

        } else {

            $this->vars->_site_title.= ' - Dashboard';

            $this->vars->current_user = $current_user;

            $this->render($this->layout);
        }

    }

    public function cacheStatsAction() {

        $stats = array();

        $cache = Core::getCache();

        if ($cache) {

            try {

                $stats = $cache->getStats();

            } catch (\Exception $e) {


            }
        }

        $this->response->json($stats);
    }

    public function incrementCacheGenerationAction() {

        Core::incrementGeneration('post');

        $this->response->header('Location', '/admin/dashboard');
    }

    public function flushCacheAction() {

        $cache = Core::getCache();

        if ($cache) {

            $cache->deleteAll();
        }
        $this->response->header('Location', '/admin/dashboard');

    }


}
 