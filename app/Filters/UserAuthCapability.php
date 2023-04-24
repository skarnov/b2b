<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class UserAuthCapability implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // if user logged in
        if (session()->get('logged_in')) {
            // then redirct to dashboard page
            return redirect()->to('/client');
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}
