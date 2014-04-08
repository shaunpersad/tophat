<?php
/**
 * PortfolioController class file.
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


class PortfolioController extends PublicController {

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

        $this->vars->_site_title.= ' | portfolio';

        $this->vars->_fb_meta['og:title'] = $this->vars->_site_title;
        $this->vars->_fb_meta['og:url'] = SITE_URL.'/portfolio';

        $posts = Core::getPosts(
            array(
                'section_slug' => 'portfolio',
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

    public function projectAction() {

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

        $blurb = Core::getPost('portfolio-blurb');

        if (!empty($blurb)) {

            $this->vars->blurb = $blurb;
        }


        $post_id = $this->request->param('id', false);

        if ($post_id && $post = Core::getPost($post_id)) {

            $this->vars->_site_title.= ' | '. $post->title;

            $this->vars->_fb_meta['og:title'] = $post->title;
            $this->vars->_fb_meta['og:url'] = SITE_URL.'/portfolio/project/'.$post->id.'/'.$post->slug;
            $this->vars->_fb_meta['og:description'] = $post->teaser;

            if ($image = $post->image()) {

                $this->vars->_fb_meta['og:image'] = SITE_URL.$image->url();
            }

            $this->vars->post = $post;



            $view = $this->renderToString($this->layout);

            if ($cache) {

                $cache->save($key, $view);
            }

            echo $view;


        } else {

            $this->response->header('Location', '/portfolio');
        }

    }

}
 