<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\ConfigModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{

    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['Evis'];

    /**
     * Constructor.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param LoggerInterface   $logger
     */
    protected $data = [];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        $this->session = \Config\Services::session();

        /* Grub Settings */
        $config_model = new ConfigModel();
        foreach ($config_model->findAll() as $value) {
            $setting[$value['config_name']] = $value['config_setting'];
        }
        $this->data['settings'] = $setting;

        /* Set Time Zone */
        date_default_timezone_set($setting['time_zone']);
    }

    protected function check_permission($permission_name)
    {
        try {
            $session = \Config\Services::session();
            $user_permissions = $session->get('permissions');
            if ($user_permissions != 'superadmin') :
                $permission_status = array_search($permission_name ?? [] , $user_permissions ?? []);
                if (!$permission_status) :
                    return $permission_status = 'Access Denied!';
                endif;
            endif;
        } catch (\Exception $e) {
            return view('404');
        }
    }
}
