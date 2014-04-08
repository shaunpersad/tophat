<?php
/**
 * LoginController class file
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
use TopHat\User;
use Valitron\Validator;

class LoginController extends Controller {

    public function indexAction() {

        $this->vars->_site_title.= ' - Login';
        $this->layout = '_layouts/login';
        $this->render($this->layout);
    }

    public function processAction() {

        if ($this->request->method('post')) {

            Validator::addRule('password', function($field, $value, array $params) {

                    return User::isAcceptablePassword($value);

                }, 'Password must be at least 6 characters long');

            $validator = Core::getValidator($this->request->params());
            $validator->rule('required', array('email', 'password'));
            $validator->rule('email', 'email');
            $validator->rule('password', 'password');


            if ($validator->validate()) {

                $email = $this->request->paramsPost()->get('email', '');
                $password = $this->request->paramsPost()->get('password', '');
                $ip_address = $this->request->ip();
                $user_agent = $this->request->userAgent();

                if ($user = Core::loginUser($email, $password, $ip_address, $user_agent)) {

                    $this->response->header('Location', '/admin/dashboard');
                    return true;
                }
            } else {

                Core::addValidationAlerts($validator->errors());
            }

        }

        $this->response->header('Location', '/admin/login');
    }
}
 