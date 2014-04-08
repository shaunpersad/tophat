<?php
/**
 * This is where all URLs are directed to.
 * URLs are then mapped to a specific Controller and Action,
 * depending on the rules defined here.
 * URL mapping is handled by Klein
 * Klein documentation can be found here: https://github.com/chriso/klein.php
 *
 * The gist is that all rules that match execute a function, in a cascading (think css) way.
 * In our case, all we do for each matching rule is to set the controller, action, and namespace.
 * All of these are "slug" formatted.
 *
 * "controller" maps to a camel-cased class a subdirectory in /controllers/TopHat
 * "action" maps to a camel-cased method within the controller class
 * "namespace" determines whether it is a {PUBLIC_FACING_NAMESPACE} class or an {ADMIN_NAMESPACE} class.
 * Admin classes are found in /controllers/TopHat/{ADMIN_NAMESPACE}
 * PublicFacing classes are found in /controllers/TopHat/{PUBLIC_FACING_NAMESPACE}
 *
 * Any named parameters in the url are stored in the $request object
 */

$start = microtime(true);

include '../includes/includes.php';
use TopHat\Core;


/*
 * Remove trailing slash from URLs
 */
$trailing = $_SERVER['REQUEST_URI'];

$_SERVER['REQUEST_URI'] = rtrim($trailing, '/');

/*
 * Create Klein instance.
 */
$klein = new \Klein\Klein();

/*
 * Default response.
 * This response occurs for ALL URLs.
 */
$klein->respond('*', function ($request, $response, $service, $app) {

        $request->controller = 'index';
        $request->action = 'index';
        $request->namespace = PUBLIC_FACING_NAMESPACE;
    });

/*
 * This response maps any URL that matches the /{controller}/{action} format, with both being optional.
 * Because of the above default response, both controller and action have already been defined,
 * so if, for example, {action} were missing here, it's not a problem.
 * If {action} is defined here, it automatically overwrites the previous $request->action
 */


$klein->respond('/[:controller]?/[:action]?/[i:id]?/[:slug]?', function ($request, $response, $service, $app) {

    });


/* INCLUDE ALL OTHER ROUTES UNDER THIS */



/* INCLUDE ALL OTHER ROUTES OVER THIS */



/*
 * This handles all URLs that start with /admin
 */
$klein->with('/admin', function () use ($klein) {

        /*
         * Resets the default response for /admin urls
         */
        $klein->respond(function ($request, $response, $service, $app) {

                $request->controller = 'index';
                $request->action = 'index';
                $request->namespace = ADMIN_NAMESPACE;

            });

        /*
         * Handles URLs that match /admin/{controller}/{id} (optional)/{action}(optional)
         */
        $klein->respond('/[:controller]?/[i:id]?/[:action]?', function ($request, $response, $service, $app) {


            });

    });





/*
 * The final default response (executed for all URLs).
 * This is placed after all url mapping rules have been defined,
 * as it matches the namespace, controller, and action to a specific controller and method,
 * then executes it if found.
 *
 * If it is not found, a default 404 controller is executed instead.
 *
 * If a PHP exception occurs anywhere in the code, it is caught here and saved as an Alert.
 */
$klein->respond(function ($request, $response, $service, $app) use ($klein) {

        // Handle exceptions
        $klein->onError(function ($klein, $err_msg) {

                Core::addAlert($err_msg, Core::ALERT_TYPE_EXCEPTION);
            });


        // Check for trying to access admin section without logging in.
        if ($request->namespace == ADMIN_NAMESPACE && $request->controller != 'login' && $request->controller != 'index') {

            $current_user = Core::getCurrentUser();

            //you must be logged in and not just a regular user.
            if (!$current_user || $current_user->type == \TopHat\User::TYPE_PUBLIC) {

                Core::addAlert('You do not have permission to access this page.', Core::ALERT_TYPE_WARNING);

                $response->header('Location', '/admin/login');
                return false;
            }

        }

        $class = 'TopHat\\'. $request->namespace.'\\'.Core::slugToCamelCase($request->controller, false).'Controller';

        if (!(class_exists($class) && method_exists($class, Core::slugToCamelCase($request->action).'Action'))) {

            $request->controller = 'not-found';
            $request->action = 'index';
            $request->namespace = PUBLIC_FACING_NAMESPACE;

            $class = 'TopHat\\'. $request->namespace.'\\'.Core::slugToCamelCase($request->controller, false).'Controller';

        }

        $controller = new $class($request, $response);
        $controller->execute();


    });


$klein->dispatch();

Core::startSession();

$diff = microtime(true) - $start;
$_SESSION['execution_time'] = $diff;