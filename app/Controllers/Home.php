<?php

namespace App\Controllers;

use App\Models\HostingPackageModel;
use App\Models\MessageModel;

class Home extends BaseController
{
    /**
     * Resources
     * 001. Home
     * 002. Login
     * 003. Contact Us Form
     * 004. About Us
     * 005. Newsletter
     * 006. Terms and Conditions
     * 007. Privacy Policy
     */
    /* 001. Home */

    public function index()
    {
        $cache = $this->data['settings']['website_cache'];
        if ($cache):
            $this->cachePage($cache);
        endif;
        $data = array();
        $data['settings'] = $this->data['settings'];
        return view('website/home', $data);
    }

    /* 002. Login */

    public function login()
    {
        $data = array();
        $data['settings'] = $this->data['settings'];
        $data['content'] = view('website/login', $data);
        return view('website/master', $data);
    }

    /* 003. Contact Us Form */

    public function contact_email()
    {
        helper(['form']);
        $validation = \Config\Services::validation();
        $rules = [
            'name' => [
                'label' => 'Your Name',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Enter Your Name.'
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Please Enter Your Email.',
                    'valid_email' => 'Please Check The Email Field. It Does Not Appear To Be Valid.'
                ]
            ],
            'subject' => [
                'label' => 'Your Subject',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Enter Your Subject.'
                ]
            ],
            'message' => [
                'label' => 'Your Message',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Enter Your Message To Us.'
                ]
            ],
            'recaptcha_response' => [
                'label' => 'Recaptcha',
                'rules' => 'required|verifyrecaptchaV3',
                'errors' => [
                    'required' => 'Please Verify Captcha.'
                ]
            ]
        ];

        if ($this->validate($rules)) {
            $message_model = new MessageModel();

            $name = $this->request->getPost('name');
            $user_email = $this->request->getPost('email');
            $subject = $this->request->getPost('subject');
            $user_message = $this->request->getPost('message');

            $userName = trim($name);
            $userEmail = trim($user_email);
            $userMessage = trim($user_message);

            try {
                $message_model->save([
                    'name' => $userName,
                    'email' => $userEmail,
                    'message' => $userMessage,
                    'create_time' => current_time(),
                    'create_date' => current_date(),
                ]);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            $message = "The Person Name: $userName, Email: $userEmail, Subject: $subject, Message: $userMessage";

            /* Send Notification */

            $db = \Config\Database::connect();
            $builder = $db->table('notifications');

            $data = [
                'notification_title' => 'Contact Form Filled Up',
                'notification' => $message,
                'create_time' => current_time(),
                'create_date' => current_date(),
                'created_by' => $this->session->get('user_id')
            ];

            $builder->insert($data);

            /* Send Email */

            $email = \Config\Services::email();
            $email->setFrom($user_email, 'Message From ' . $this->data['settings']['project_name']);
            $email->setTo($this->data['settings']['contact_email']);
            $email->setSubject($this->data['settings']['project_name'] . ' Message - Contact Us Form ' . $subject);
            $email->setMessage($message);
            $email->send();

            echo 'success';
            exit();
        } else {
            $validation = $validation->getErrors();
            $errorMessage = implode('<br>', $validation);
            echo $errorMessage;
            exit();
        }
    }

    /* 004. About Us */

    public function about_us()
    {
        $data = array();
        $data['settings'] = $this->data['settings'];
        $data['content'] = view('website/about_us', $data);
        return view('website/master', $data);
    }

    /* 005. Newsletter */

    public function save_newsletter()
    {
        helper(['form']);
        $validation = \Config\Services::validation();
        $rules = [
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Please Enter Your Email.',
                    'valid_email' => 'Please Check The Email Field. It Does Not Appear To Be Valid.'
                ]
            ],
            'recaptcha_response' => [
                'label' => 'Recaptcha',
                'rules' => 'required|verifyrecaptchaV3',
                'errors' => [
                    'required' => 'Please Verify Captcha.'
                ]
            ]
        ];

        if ($this->validate($rules)) {
            $user_email = $this->request->getPost('email');

            $db = \Config\Database::connect();
            $builder = $db->table('newsletter');

            $data = [
                'newsletter_email' => $user_email,
                'create_time' => current_time(),
                'create_date' => current_date(),
                'created_by' => $this->session->get('user_id')
            ];

            $builder->insert($data);

            $message = 'A Person Subscribed Our Newsletter From - ' . ip_info('Visitor', 'Country') . ' Email - ' . $user_email;

            /* Send Notification */

            $db = \Config\Database::connect();
            $builder = $db->table('notifications');

            $data = [
                'notification_title' => 'Newsletter Subscription',
                'notification' => $message,
                'create_time' => current_time(),
                'create_date' => current_date(),
                'created_by' => $this->session->get('user_id')
            ];

            $builder->insert($data);

            echo 'success';
            exit();
        } else {
            $validation = $validation->getErrors();
            $errorMessage = implode('<br>', $validation);
            echo $errorMessage;
            exit();
        }
    }

    /* 006. Terms and Conditions */

    public function terms_and_conditions()
    {
        $data = array();
        $data['settings'] = $this->data['settings'];
        $data['content'] = view('website/terms_and_conditions', $data);
        return view('website/master', $data);
    }

    /* 007. Privacy Policy */

    public function privacy_policy()
    {
        $data = array();
        $data['settings'] = $this->data['settings'];
        $data['content'] = view('website/privacy_policy', $data);
        return view('website/master', $data);
    }
}