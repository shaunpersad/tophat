<?php

namespace TopHat\PublicFacing;
use Klein\Request;
use Klein\Response;
use TopHat\Controller;

class PublicController extends Controller {

    public function __construct (Request $request, Response $response) {

        parent::__construct($request, $response);

        $this->vars->_meta['description'] = 'shaun persad - back-end, front-end, web and mobile developer.';


        /*
         * og:title – The title of your article, excluding any branding.
         * og:site_name - The name of your website. Not the URL, but the name. (i.e. "IMDb" not "imdb.com".)
         * og:url – This URL serves as the unique identifier for your post.
         *          It should match your canonical URL used for SEO, and it should not include any session variables,
         *          user identifying parameters, or counters.
         *          If you use this improperly, likes and shares will not be aggregated for this URL
         *          and will be spread across all of the variations of the URL.
         * og:description – A detailed description of the piece of content, usually between 2 and 4 sentences.
         *                  This tag is technically optional,
         *                  but can improve the rate at which links are read and shared.
         * og:image – This is an image associated with your media.
         *            We suggest that you use an image of at least 1200x630 pixels.
         * fb:app_id – The unique ID that lets Facebook know the identity of your site.
         *              This is crucial for Facebook Insights to work properly.
         *              Please see our Insights documentation to learn more.
         */

        $this->vars->_fb_meta['og:title'] = SITE_TITLE;
        $this->vars->_fb_meta['og:site_name'] = SITE_TITLE;
        $this->vars->_fb_meta['og:url'] = $this->request->uri();
        $this->vars->_fb_meta['og:description'] = $this->vars->_meta['description'];
        $this->vars->_fb_meta['og:image'] = SITE_URL.'/images/default.jpg';
        $this->vars->_fb_meta['fb:app_id'] = FB_APP_ID;
    }

}