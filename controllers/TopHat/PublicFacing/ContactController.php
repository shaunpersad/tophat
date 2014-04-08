<?php
/**
 * ContactController class file.
 *
 * PHP Version 5.3
 *
 * @package  TopHat
 * @author   Shaun Persad <shaunpersad@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://shaunpersad.com
 */

namespace TopHat\PublicFacing;

use TopHat\Core;


class ContactController extends PublicController {

    public function indexAction() {

        $view = false;
        $cache = Core::getCache();

        if ($cache) {

            $key = $this->makeKeyFromRequest();

            $view = $cache->fetch($key);

            if ($view) {

                echo $view;
                return true;
            }
        }

        $this->vars->_site_title.= ' | contact';

        $this->vars->_fb_meta['og:title'] = $this->vars->_site_title;
        $this->vars->_fb_meta['og:url'] = SITE_URL.'/contact';

        $blurb = Core::getPost('contact-blurb');

        if (!empty($blurb)) {

            $this->vars->blurb = $blurb;
        }

        $view = $this->renderToString($this->layout);

        if ($cache) {

            $cache->save($key, $view);
        }

        echo $view;
    }


}
 