<?php
/**
 * BlogController class file.
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


class BlogController extends PublicController {

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

        $get = $this->request->paramsGet();

        $current_page = $get->get('page', 1);
        $s = $get->get('s', false);
        $per_page = 5;

        $public_args = array(
            'page' => $current_page
        );

        if ($s) {

            $public_args['s'] = $s;
        }

        $args = array_merge(
            $public_args,
            array(
                'category_slug' => 'blog',
                'per_page' => $per_page,
                'status' => Core::STATUS_PUBLISHED,
                'order_by' => 'posts.date_published',
                'order_dir' => 'DESC'
            )
        );


        $all_posts_count = Core::getPosts(array_merge($args, array('count_only' => true)));

        $total_num_pages = ceil($all_posts_count / $per_page);

        $num_pages_to_display = 5;

        $this->vars->base_url = '/blog';
        $this->vars->current_page = $current_page;
        $this->vars->s = $s;
        $this->vars->args = $public_args;
        $this->vars->page_list = Core::getPageList($current_page, $total_num_pages, $num_pages_to_display);
        $this->vars->posts = Core::getPosts($args);
        $this->vars->tags = $this->getBlogTags();

        $this->vars->_site_title.= ' | blog';

        $this->vars->_fb_meta['og:title'] = $this->vars->_site_title;
        $this->vars->_fb_meta['og:url'] = SITE_URL.'/blog';

        $blurb = Core::getPost('blog-blurb');

        if (!empty($blurb)) {

            $this->vars->blurb = $blurb;
        }

        $view = $this->renderToString($this->layout);

        if ($cache) {

            $cache->save($key, $view);
        }

        echo $view;
    }

    public function tagAction() {

        if ($tag_id = $this->request->param('id', false)) {

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

            $get = $this->request->paramsGet();

            $current_page = $get->get('page', 1);
            $s = $get->get('s', false);
            $per_page = 5;

            $public_args = array(
                'page' => $current_page,
            );

            if ($s) {

                $public_args['s'] = $s;
            }

            $args = array_merge(
                $public_args,
                array(
                    'tag_id' => $tag_id,
                    'category_slug' => 'blog',
                    'per_page' => $per_page,
                    'status' => Core::STATUS_PUBLISHED,
                    'order_by' => 'posts.date_published',
                    'order_dir' => 'DESC'
                )
            );


            $all_posts_count = Core::getPosts(array_merge($args, array('count_only' => true)));

            $total_num_pages = ceil($all_posts_count / $per_page);

            $num_pages_to_display = 5;

            $this->vars->tag_id = $tag_id;
            $this->vars->base_url = '/blog/tag/'.$tag_id;
            $this->vars->current_page = $current_page;
            $this->vars->s = $s;
            $this->vars->args = $public_args;
            $this->vars->page_list = Core::getPageList($current_page, $total_num_pages, $num_pages_to_display);
            $this->vars->posts = Core::getPosts($args);
            $this->vars->tags = $this->getBlogTags();

            $this->vars->_site_title.= ' | blog';

            $this->vars->_fb_meta['og:title'] = $this->vars->_site_title;
            $this->vars->_fb_meta['og:url'] = SITE_URL.'/blog';

            $blurb = Core::getPost('blog-blurb');

            if (!empty($blurb)) {

                $this->vars->blurb = $blurb;
            }

            $view = $this->renderToString($this->layout);

            if ($cache) {

                $cache->save($key, $view);
            }

            echo $view;

        } else {

            $this->response->header('Location', '/blog');

        }

    }

    public function postAction() {


        $post_id = $this->request->param('id', false);

        if ($post_id && $post = Core::getPost($post_id)) {

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

            $blurb = Core::getPost('blog-blurb');

            if (!empty($blurb)) {

                $this->vars->blurb = $blurb;
            }


            $this->vars->_site_title.= ' | '. $post->title;

            $this->vars->_fb_meta['og:title'] = $post->title;
            $this->vars->_fb_meta['og:url'] = SITE_URL.'/blog/post/'.$post->id.'/'.$post->slug;
            $this->vars->_fb_meta['og:description'] = $post->teaser;

            if ($image = $post->image()) {

                $this->vars->_fb_meta['og:image'] = SITE_URL.$image->url();
            }


            $this->vars->post = $post;
            $this->vars->tags = $this->getBlogTags();


            $view = $this->renderToString($this->layout);

            if ($cache) {

                $cache->save($key, $view);
            }

            echo $view;


        } else {

            $this->response->header('Location', '/blog');
        }

    }

    public function getBlogTags() {

        $db = Core::getDb();
        $cache = Core::getCache();
        $blog_tags = false;
        $key = 'blog-tags/'.Core::getGenerationForDataType('post');
        $limit = 30;

        if ($cache) {

            $blog_tags = $cache->fetch($key);
        }

        if (!$blog_tags) {

            $blog_tags = array();

            $sql = 'SELECT tags.id, tags.title
                    FROM tags
                    LEFT OUTER JOIN posts_tags ON tags.id = posts_tags.tag_id
                    LEFT OUTER JOIN posts_categories ON posts_tags.post_id = posts_categories.post_id
                    LEFT OUTER JOIN categories ON posts_categories.category_id = categories.id
                    WHERE categories.slug = ?
                    LIMIT ?';

            $result = $db->executeQuery($sql, array('blog', $limit), array(\PDO::PARAM_STR, \PDO::PARAM_INT));

            while ($tag_data = $result->fetch()) {

                $blog_tags[$tag_data['id']] = $tag_data['title'];
            }

            if ($cache) {

                $cache->save($key, $blog_tags);
            }
        }
        return $blog_tags;
    }



}
 