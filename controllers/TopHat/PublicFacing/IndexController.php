<?php
/**
 * IndexController class file
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

use TopHat\Core;


class IndexController extends PublicController {

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

        $this->vars->_site_title.= ' | home';

        $this->vars->_fb_meta['og:title'] = $this->vars->_site_title;
        $this->vars->_fb_meta['og:url'] = SITE_URL;

        $blurb = Core::getPost('home-blurb');

        if ($blurb) {
            $this->vars->blurb = $blurb;
        }

        $posts = Core::getPosts(
            array(
                'category_slug' => 'blog',
                'per_page' => 3,
                'status' => Core::STATUS_PUBLISHED,
                'order_by' => 'posts.date_published',
                'order_dir' => 'DESC'
            )
        );

        if (!empty($posts)) {

            $this->vars->posts = $posts;
        }


        $view = $this->renderToString($this->layout);

        if ($cache) {

            $cache->save($key, $view);
        }

        echo $view;

    }


}
 