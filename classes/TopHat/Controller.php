<?php
/**
 * Controller class file
 *
 * This is the base class for all Controllers.
 * It requires a Request and Response object from Klein
 * Documentation on these objects can be found here: https://github.com/chriso/klein.php#api
 *
 * PHP Version 5.3
 *
 * @package  TopHat
 * @author   Shaun Persad <shaunpersad@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://shaunpersad.com
 */

namespace TopHat;

use Klein\Request;
use Klein\Response;

/**
 * Class Controller
 * @package TopHat
 */
class Controller {

    public $request;
    public $response;
    public $layout;
    public $view;
    public $view_subdirectory;
    public $vars;

    /**
     * @param Request $request Request object from Klein
     * @param Response $response Response object from Klein
     */
    public function __construct (Request $request, Response $response) {

        /*
         * Handles all things regarding the request made.
         *
         * Of note are the paramsGet(), paramsPost(), and paramsNamed() methods.
         * These methods return a DataCollection object which is simply a handy wrapper for arrays.
         * The DataCollection is useful because it can determine if a variable exists (using (exists()),
         * and provide default values if it doesn't.
         *
         * e.g. $status = $this->request->paramsPost()->get('status', 'draft') will get the "status" parameter
         * from $_POST, or if it is not found, set it to the default value of 'draft', in one line of code.
         *
         * If you prefer to work with the array directly, you can use the all() method,
         * e.g. paramsGet()->all() is equivalent to the array $_GET
         *
         * Using these methods instead of working with $_GET and $_POST directly is preferred,
         * but not mandatory.
         */
        $this->request = $request;

        /*
         * Handles all things regarding the response to send.
         * However, this is not frequently used, as most responses are rendered/echoed.
         */
        $this->response = $response;


        /*
         * location of the default layout
         * this is simply a handy string to the expected location
         * this can be changed accordingly in your Actions
         */
        $this->layout = '_layouts/default';

        /*
         * location of the view related to the action being requested.
         * this view is not guaranteed to exist!
         * this is simply a handy string to the expected location.
         */
        $this->view = $request->controller.DIRECTORY_SEPARATOR.$request->action;

        /*
         * the subdirectory of VIEWS_DIR that contains the views specific to this Controller's namespace.
         * it is the slug version of the namespace.
         */
        $this->view_subdirectory = Core::slugify($request->namespace);

        /*
         * vars stores variables used in templates
         * storing a variable in vars means it will then be accessible to ALL views rendered
         * to limit a variable to just one view, see the comments for the render() function
         */
        $this->vars = new \stdClass();

        /*
         * In this case, there is a default site title that is set for each page.
         * This can then be changed in an action as necessary.
         * This title variable will be accessible in all views as $vars->_site_title (or $this->vars->_site_title)
         */
        $this->vars->_site_title = SITE_TITLE;
        $this->vars->_meta = array(
            'viewport' => 'width=device-width, initial-scale=1'
        );
        $this->vars->_fb_meta = array();

        /*
         * Checks if session_start() has been called.
         * If not, it starts the session.
         */
        Core::startSession();

    }


    /*
     * Translates the requested action to a method in the class.
     */
    public function execute() {

        $action = Core::slugToCamelCase($this->request->action);

        $method = $action.'Action';

        if (method_exists($this, $method)) {

            $this->$method();
        }
    }

    /*
     * Each controller has a default action, which will either:
     * render the view found in {controller}/index/index.php or
     * render a "no content found" message
     * These will be rendered inside of the default layout.
     */

    public function indexAction () {

        if ($this->viewExists($this->view)) {

            $content = $this->renderToString($this->view);
        } else {
            $content = 'Oops, no content found.';
        }

        $this->render($this->layout, array ('content' => $content));
    }


    /**
     * Renders views.
     *
     * "Render" simply means having a PHP file included, with some variables.
     * Any variables set to $this->vars will be accessible to all views rendered, in the shortened $vars object.
     * To limit/overwrite variables to a specific view, use the second argument associative array.
     * e.g. say $this->vars->something = "i can be accessed in all views",
     * to overwrite this for a specific view, pass array('something' => "I am specific to this view")
     * as the $data argument.
     *
     * As shown below, the $vars variables are the global variables + overwritten/inserted by $data.
     *
     * Also, because render() is in the scope of the Controller, $this inside a view is still the controller
     *
     * @param string $view Location of view, in the format {controller-slug}/{action-slug}.
     * @param array $data (optional), overwrites/inserts data into the global template vars for the specific view.
     */
    public function render ($view, $data = array()) {

        if ( $this->viewExists($view) ) {

            $vars = clone $this->vars; //get original global template variables

            foreach ($data as $name => $value) {

                $vars->{$name} = $value; //override/insert new template variables with provided data
            }

            /*
             * view_subdirectory is the slug version of the namespace
             */
            $path = VIEWS_DIR.$this->view_subdirectory.DIRECTORY_SEPARATOR.$view;


            //It is expected that all view files end with .php
            if (!Core::endsWith($view, '.php')) {

                $path.= '.php';
            }

            $this->includeWithVariables($path, $vars);
        }
    }


    /**
     * Renders a view to a string.
     *
     * Useful for caching.
     *
     * @param string $view Same as $view arg for render()
     * @param array $data Same as $data arg for render()
     * @return string Output of rendering
     */
    public function renderToString ($view, $data = array()) {

        $output = '';

        ob_start();
        $this->render($view, $data);
        $output = ob_get_clean();

        return $output;
    }

    /**
     * Fetches a view string from cache if exists, else renders the view again to a string and caches it.
     *
     * @param string $view Same as $view arg for render()
     * @param array $data Same as $data arg for render()
     * @return string Output of rendering
     */
    public function renderToStringFromCache ($view, $data = array()) {

        $output = '';
        $cache = Core::getCache();

        $generation = Core::getGenerationForDataType('post');
        $key = 'views/'.$generation.'/'.$view.'/'.md5(json_encode($data));

        if ($cache) {

            $output = $cache->fetch($key);

            if ($output) {

                return $output;
            }

        }
        $output = $this->renderToString($view, $data);

        if ($cache) {

            $cache->save($key, $output);
        }

        return $output;
    }

    public function makeKeyFromRequest() {

        $request = $this->request->params();
        $generation = Core::getGenerationForDataType('post');

        return '/request/'.$generation.'/params/'.md5(json_encode($request));

    }

    /**
     * Includes a file with an object containing variables.
     *
     * @param string $path File path of the file.
     * @param \stdClass $vars Object containing variables to use in the included file.
     */
    public function includeWithVariables($path, $vars) {

        include $path;
    }

    /**
     * Checks if a view file exists.
     *
     * @param string $view Same as $view arg for render()
     * @return bool
     */
    public function viewExists($view) {

        /*
         * view_subdirectory is the slug version of the namespace
         */
        $path = VIEWS_DIR.$this->view_subdirectory.DIRECTORY_SEPARATOR.$view;

        //It is expected that all view files end with .php
        if (!Core::endsWith($view, '.php')) {

            $path.= '.php';
        }

        return file_exists($path);
    }

}
