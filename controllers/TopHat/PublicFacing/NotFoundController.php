<?php
/**
 * NotFoundController class file
 *
 * PHP Version 5.3
 *
 * @category Controllers
 * @package  ShaunPersad\TopHat
 * @author   Shaun Persad <shaunpersad@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://shaunpersad.com
 */

namespace TopHat\PublicFacing;

class NotFoundController extends PublicController {

    public function indexAction() {

        $this->vars->_site_title.= ' | page not found.';
        $this->vars->_content = 'This page does not exist.';
        $this->render($this->layout);
    }
}
 