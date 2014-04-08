<?php
/**
 * AboutController class file.
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


class AboutController extends PublicController {

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

        $this->vars->_site_title.= ' | about';

        $this->vars->_fb_meta['og:title'] = $this->vars->_site_title;
        $this->vars->_fb_meta['og:url'] = SITE_URL.'/about';

        $posts = Core::getPosts(
            array(
                'section_slug' => 'about',
                'order_by' => 'posts_sections.position',
                'order_dir' => 'ASC'
            )
        );

        if (!empty($posts)) {

            $this->vars->blurb = $posts[0];
        }
        unset($posts[0]);

        $this->vars->posts = $posts;

        $view = $this->renderToString($this->layout);

        if ($cache) {

            $cache->save($key, $view);
        }

        echo $view;


    }


}
 