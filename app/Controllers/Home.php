<?php

namespace App\Controllers;

use App\Models\HostingPackageModel;
use App\Models\MessageModel;

class Home extends BaseController
{
    /**
     * Resources
     * 001. Home
     * 002. Software Development
     * 003. Web Development
     * 004. Domain Registration
     * 005. Domain Transfer
     * 006. Hosting Package
     * 007. Hosting Registration
     * 008. Contact Us Form
     * 009. About Us
     * 010. Newsletter
     * 011. Terms and Conditions
     * 012. Privacy Policy
     * 013. Login
     */
    /* 001. Home */

    public function index()
    {
        $package_model = new HostingPackageModel();
        $packages = $package_model->find();
        $this->cachePage($this->data['settings']['website_cache']);
        $data = array();
        $data['settings'] = $this->data['settings'];
        $data['all_packages'] = $packages;
        return view('website/home', $data);
    }

    /* 002. Software Development */

    public function software_development()
    {
        $data = array();
        $data['settings'] = $this->data['settings'];
        $data['content'] = view('website/software_development', $data);
        return view('website/master', $data);
    }

    /* 003. Web Development */

    public function web_development()
    {
        $data = array();
        $data['settings'] = $this->data['settings'];
        $data['content'] = view('website/web_development', $data);
        return view('website/master', $data);
    }

    /* 004. Domain Registration */

    public function domain_registration()
    {
        $data = array();
        $data['settings'] = $this->data['settings'];
        $data['content'] = view('website/domain_registration', $data);
        return view('website/master', $data);
    }

    public function domain_availability()
    {
        helper(['form']);
        $validation = \Config\Services::validation();
        $rules = [
            'domain_name' => [
                'label' => 'Domain Name',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Write Your Desire Domain Name.'
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
            $domain_name = $this->request->getPost('domain_name');

            $pattern = '/^(https?:\/\/)?((?:[a-z0-9-]+\.)+(?:com|net|org))(?:\/|$)/i';
            $isValidDomainName = preg_match($pattern, $domain_name);

            if (!$isValidDomainName) {
                echo "<b>" . $domain_name . "</b> Invalid Domain Name! Please make sure you put an extension";
                exit();
            }

            if (gethostbyname($domain_name) != $domain_name) {
                echo "<b>" . $domain_name . "</b> is Already Taken! Please choose another domain name</div>";
                exit();
            } else {
                echo 'success';
                exit();
            }
        } else {
            $validation = $validation->getErrors();
            $errorMessage = implode('<br>', $validation);
            echo $errorMessage;
            exit();
        }
    }

    public function domain_order()
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
            'mobile' => [
                'label' => 'Your Mobile',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Enter Your Mobile.'
                ]
            ],
            'address' => [
                'label' => 'Your Address',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Enter Your Address.'
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
            $domain_name = $this->request->getPost('domain_name');
            $name = $this->request->getPost('name');
            $user_email = $this->request->getPost('email');
            $user_mobile = $this->request->getPost('mobile');
            $validity = $this->request->getPost('validity');
            $address = $this->request->getPost('address');

            $message = "Domain Name: $domain_name. The Person Name: $name, Email: $user_email, Mobile: $user_mobile, Domain Validity: $validity, Address: $address, Has Ordered A New Domain";

            /* Send Notification */

            $db = \Config\Database::connect();
            $builder = $db->table('notifications');

            $data = [
                'notification_title' => 'New Domain Order',
                'notification' => $message,
                'create_time' => current_time(),
                'create_date' => current_date(),
                'created_by' => $this->session->get('user_id')
            ];

            $builder->insert($data);

            /* Send Email */

            $email = \Config\Services::email();
            $email->setFrom($user_email, ' From ' . $this->data['settings']['project_name']);
            $email->setTo($this->data['settings']['contact_email']);
            $email->setSubject($this->data['settings']['project_name'] . ' - New Domain Order');
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

    /* 005. Domain Transfer */

    public function domain_transfer()
    {
        helper(['form']);
        $validation = \Config\Services::validation();
        $rules = [
            'transfer_domain' => [
                'label' => 'Transfer Domain Name',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Write Your Domain Name.'
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
            $domain_name = $this->request->getPost('transfer_domain');

            $pattern = '/^(https?:\/\/)?((?:[a-z0-9-]+\.)+(?:com|net|org))(?:\/|$)/i';
            $isValidDomainName = preg_match($pattern, $domain_name);

            if (!$isValidDomainName) {
                echo "<b>" . $domain_name . "</b> Invalid Domain Name! Please make sure you put an extension";
                exit();
            }

            if (gethostbyname($domain_name) != $domain_name) {
                echo 'success';
                exit();
            } else {
                echo 'Domain is not Registered! Please register a Domain name with us';
                exit();
            }
        } else {
            $validation = $validation->getErrors();
            $errorMessage = implode('<br>', $validation);
            echo $errorMessage;
            exit();
        }
    }

    public function domain_transfer_order()
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
            'mobile' => [
                'label' => 'Your Mobile',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Enter Your Mobile.'
                ]
            ],
            'address' => [
                'label' => 'Your Address',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Enter Your Address.'
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
            $domain_name = $this->request->getPost('domain_name');
            $name = $this->request->getPost('name');
            $user_email = $this->request->getPost('email');
            $user_mobile = $this->request->getPost('mobile');
            $validity = $this->request->getPost('validity');
            $address = $this->request->getPost('address');

            $message = "Domain Name: $domain_name. The Person Name: $name, Email: $user_email, Mobile: $user_mobile, Domain Validity: $validity, Address: $address, Has Requested To Transfer This Domain";

            /* Send Notification */

            $db = \Config\Database::connect();
            $builder = $db->table('notifications');

            $data = [
                'notification_title' => 'New Domain Order',
                'notification' => $message,
                'create_time' => current_time(),
                'create_date' => current_date(),
                'created_by' => $this->session->get('user_id')
            ];

            $builder->insert($data);

            /* Send Email */

            $email = \Config\Services::email();
            $email->setFrom($user_email, ' From ' . $this->data['settings']['project_name']);
            $email->setTo($this->data['settings']['contact_email']);
            $email->setSubject($this->data['settings']['project_name'] . ' - Domain Transfer Request');
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

    /* 006. Hosting Package */

    public function hosting_package()
    {
        $package_model = new HostingPackageModel();
        $packages = $package_model->find();
        $data = array();
        $data['settings'] = $this->data['settings'];
        $data['all_packages'] = $packages;
        $data['content'] = view('website/hosting_package', $data);
        return view('website/master', $data);
    }

    /* 007. Hosting Registration */

    public function hosting_registration()
    {
        $data = array();
        $data['settings'] = $this->data['settings'];
        $data['content'] = view('website/hosting_registration', $data);
        return view('website/master', $data);
    }

    public function hosting_order()
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
            'mobile' => [
                'label' => 'Your Mobile',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Enter Your Mobile.'
                ]
            ],
            'website' => [
                'label' => 'Your Website URL',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Enter Your Website URL.'
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

        $website = $this->request->getPost('website');
        $pattern = '/^(https?:\/\/)?((?:[a-z0-9-]+\.)+(?:com|net|org))(?:\/|$)/i';
        $isValidWebsiteName = preg_match($pattern, $website);
        if (!$isValidWebsiteName) {
            echo 'Invalid Website Name! Please make sure you put an extension';
            exit();
        }

        if ($this->validate($rules)) {
            $package_name = $this->request->getPost('package_name');
            $name = $this->request->getPost('name');
            $mobile = $this->request->getPost('mobile');
            $note = $this->request->getPost('note');
            $user_email = $this->request->getPost('email');

            $message = "The person Name: $name, Mobile: $mobile, Package Name: $package_name, Hosting Note: $note, Website: $website, Email: $user_email";

            /* Send Notification */

            $db = \Config\Database::connect();
            $builder = $db->table('notifications');

            $data = [
                'notification_title' => 'New Hosting Order',
                'notification' => $message,
                'create_time' => current_time(),
                'create_date' => current_date(),
                'created_by' => $this->session->get('user_id')
            ];

            $builder->insert($data);

            /* Send Email */

            $email = \Config\Services::email();
            $email->setFrom($user_email, ' From ' . $this->data['settings']['project_name']);
            $email->setTo($this->data['settings']['contact_email']);
            $email->setSubject($this->data['settings']['project_name'] . ' - New Hosting Package Order');
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

    /* 008. Contact Us Form */

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

    /* 009. About Us */

    public function about_us()
    {
        $data = array();
        $data['settings'] = $this->data['settings'];
        $data['content'] = view('website/about_us', $data);
        return view('website/master', $data);
    }

    /* 010. Newsletter */

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

    /* 011. Terms and Conditions */

    public function terms_and_conditions()
    {
        $data = array();
        $data['settings'] = $this->data['settings'];
        $data['content'] = view('website/terms_and_conditions', $data);
        return view('website/master', $data);
    }

    /* 012. Privacy Policy */

    public function privacy_policy()
    {
        $data = array();
        $data['settings'] = $this->data['settings'];
        $data['content'] = view('website/privacy_policy', $data);
        return view('website/master', $data);
    }

    /* 013. Login */

    public function login()
    {
        $data = array();
        $data['settings'] = $this->data['settings'];
        $data['content'] = view('website/login', $data);
        return view('website/master', $data);
    }
}
