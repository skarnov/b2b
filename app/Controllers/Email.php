<?php

namespace App\Controllers;

use App\Models\DomainModel;
use App\Models\HostingModel;

class Email extends BaseController {
    /**
     * Resources
     * 001. Send Email
     * 002. Domain Renew
     * 003. Hosting Renew
     */
    /* 001. Send Email */

    public function index() {
        $permission_status = $this->check_permission('send_email');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Send Email';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('crm/send_email', $data);
        return view('dashboard/master', $data);
    }

    public function send_email() {
        $to = $this->request->getPost('to');
        $subject = $this->request->getPost('subject');
        $email_body = $this->request->getPost('email');

        $email_config = Array(
            'charset' => 'utf-8',
            'mailType' => 'html'
        );

        $message = '<!DOCTYPE html>
        
        <html>
            <head>
                <meta name="viewport" content="width=device-width">
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <title>' . $this->data['settings']['project_name'] . '</title>
                <style>
                    /* -------------------------------------
                        INLINED WITH htmlemail.io/inline
                    ------------------------------------- */
                    /* -------------------------------------
                        RESPONSIVE AND MOBILE FRIENDLY STYLES
                    ------------------------------------- */
                    @media only screen and (max-width: 620px) {
                        table[class=body] h1 {
                            font-size: 28px !important;
                            margin-bottom: 10px !important;
                        }
                        table[class=body] p,
                        table[class=body] ul,
                        table[class=body] ol,
                        table[class=body] td,
                        table[class=body] span,
                        table[class=body] a {
                            font-size: 16px !important;
                        }
                        table[class=body] .wrapper,
                        table[class=body] .article {
                            padding: 10px !important;
                        }
                        table[class=body] .content {
                            padding: 0 !important;
                        }
                        table[class=body] .container {
                            padding: 0 !important;
                            width: 100% !important;
                        }
                        table[class=body] .main {
                            border-left-width: 0 !important;
                            border-radius: 0 !important;
                            border-right-width: 0 !important;
                        }
                        table[class=body] .btn table {
                            width: 100% !important;
                        }
                        table[class=body] .btn a {
                            width: 100% !important;
                        }
                        table[class=body] .img-responsive {
                            height: auto !important;
                            max-width: 100% !important;
                            width: auto !important;
                        }
                    }
                    /* -------------------------------------
                        PRESERVE THESE STYLES IN THE HEAD
                    ------------------------------------- */
                    @media all {
                        .ExternalClass {
                            width: 100%;
                        }
                        .ExternalClass,
                        .ExternalClass p,
                        .ExternalClass span,
                        .ExternalClass font,
                        .ExternalClass td,
                        .ExternalClass div {
                            line-height: 100%;
                        }
                        .apple-link a {
                            color: inherit !important;
                            font-family: inherit !important;
                            font-size: inherit !important;
                            font-weight: inherit !important;
                            line-height: inherit !important;
                            text-decoration: none !important;
                        }
                        .btn-primary table td:hover {
                            background-color: #34495e !important;
                        }
                        .btn-primary a:hover {
                            background-color: #34495e !important;
                            border-color: #34495e !important;
                        }
                    }
                </style>
            </head>
            <body class="" style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;">
                    <tr>
                        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
                        <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
                            <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">
                                <!-- START CENTERED WHITE CONTAINER -->
                                <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">' . $this->data['settings']['project_name'] . '</span>
                                <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">
                                    <!-- START MAIN CONTENT AREA -->
                                    <tr>
                                        <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                                            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                                <tr>
                                                    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                                                       ' . $email_body . '
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <!-- END MAIN CONTENT AREA -->
                                </table>
                               
                                <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">
                                    <!-- START MAIN CONTENT AREA -->
                                    <tr>
                                        <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                                            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                                <tr>
                                                    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                                                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Thank you for being our client.</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <!-- END MAIN CONTENT AREA -->
                                </table>
                                <!-- START FOOTER -->
                                <div class="footer" style="clear: both; width: 100%;">
                                    <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">
                                        <tr>
                                            <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                                                <span class="apple-link" style="color: #999999; font-size: 14px; text-align: center;">' . $this->data['settings']['project_name'] . '.</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="footer" style="clear: both; Margin-top: 10px; text-align: left; width: 100%;">
                                    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                        <tr>
                                            <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: left;">
                                                <span class="apple-link" style="color: #999999; font-size: 12px; text-align: left;">
                                                    This message is for the use of the intended recipient(s) only and may contain confidential information. If you have received this message in error, please notify the sender and delete it. The Evis Technology accepts no liability for loss or damage caused by viruses and other malware and you are advised to carry out a virus and malware check on any attachments contained in this message. 
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- END FOOTER -->
                                <!-- END CENTERED WHITE CONTAINER -->
                            </div>
                        </td>
                        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
                    </tr>
                </table>
            </body>
        </html>';

        $email = \Config\Services::email();
        $email->initialize($email_config);
        $email->setNewline("\r\n");
        $email->setCRLF("\r\n");
        $email->setFrom($this->data['settings']['admin_email'], $this->data['settings']['project_name']);
        $email->setTo($to);
        $email->setBCC($this->data['settings']['contact_email']);
        $email->setSubject($subject);
        $email->setMessage($message);
        $email->send();
        echo 'success';
        exit();
    }

    /* 002. Domain Renew */

    public function domain_renew($domain_id) {
        $domain_model = new DomainModel();
        $domain_info = $domain_model->where('domain_id', $domain_id)->first();

        $email_config = Array(
            'charset' => 'utf-8',
            'mailType' => 'html'
        );

        $message = '<!DOCTYPE html>
        
        <html>
            <head>
                <meta name="viewport" content="width=device-width">
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <title>' . $this->data['settings']['project_name'] . '</title>
                <style>
                    /* -------------------------------------
                        INLINED WITH htmlemail.io/inline
                    ------------------------------------- */
                    /* -------------------------------------
                        RESPONSIVE AND MOBILE FRIENDLY STYLES
                    ------------------------------------- */
                    @media only screen and (max-width: 620px) {
                        table[class=body] h1 {
                            font-size: 28px !important;
                            margin-bottom: 10px !important;
                        }
                        table[class=body] p,
                        table[class=body] ul,
                        table[class=body] ol,
                        table[class=body] td,
                        table[class=body] span,
                        table[class=body] a {
                            font-size: 16px !important;
                        }
                        table[class=body] .wrapper,
                        table[class=body] .article {
                            padding: 10px !important;
                        }
                        table[class=body] .content {
                            padding: 0 !important;
                        }
                        table[class=body] .container {
                            padding: 0 !important;
                            width: 100% !important;
                        }
                        table[class=body] .main {
                            border-left-width: 0 !important;
                            border-radius: 0 !important;
                            border-right-width: 0 !important;
                        }
                        table[class=body] .btn table {
                            width: 100% !important;
                        }
                        table[class=body] .btn a {
                            width: 100% !important;
                        }
                        table[class=body] .img-responsive {
                            height: auto !important;
                            max-width: 100% !important;
                            width: auto !important;
                        }
                    }
                    /* -------------------------------------
                        PRESERVE THESE STYLES IN THE HEAD
                    ------------------------------------- */
                    @media all {
                        .ExternalClass {
                            width: 100%;
                        }
                        .ExternalClass,
                        .ExternalClass p,
                        .ExternalClass span,
                        .ExternalClass font,
                        .ExternalClass td,
                        .ExternalClass div {
                            line-height: 100%;
                        }
                        .apple-link a {
                            color: inherit !important;
                            font-family: inherit !important;
                            font-size: inherit !important;
                            font-weight: inherit !important;
                            line-height: inherit !important;
                            text-decoration: none !important;
                        }
                        .btn-primary table td:hover {
                            background-color: #34495e !important;
                        }
                        .btn-primary a:hover {
                            background-color: #34495e !important;
                            border-color: #34495e !important;
                        }
                    }
                </style>
            </head>
            <body class="" style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;">
                    <tr>
                        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
                        <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
                            <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">
                                <!-- START CENTERED WHITE CONTAINER -->
                                <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">' . $this->data['settings']['project_name'] . '</span>
                                <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">
                                    <!-- START MAIN CONTENT AREA -->
                                    <tr>
                                        <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                                            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                                <tr>
                                                    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                                                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Dear Sir/Madam.</p>
                                                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Greetings from ' . $this->data['settings']['project_name'] . '. Please renew your domain to avoid service interruption.</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <!-- END MAIN CONTENT AREA -->
                                </table>
                                
                                <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px; padding: 20px">
                                  <tr>
                                    <td align="left">Domain Name</td>
                                    <td align="center">Expiry Date</td>
                                    <td align="center">Status</td>
                                  </tr>
                                  <tr>
                                    <td align="left">' . $domain_info['domain_name'] . '</td>
                                    <td align="center">' . date($this->data['settings']['date_format'], strtotime($domain_info['expiry_date'])) . '</td>
                                    <td align="center">' . ucfirst($domain_info['domain_status']) . '</td>
                                  </tr>
                                </table>

                                <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">
                                    <!-- START MAIN CONTENT AREA -->
                                    <tr>
                                        <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                                            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                                <tr>
                                                    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                                                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Thank you for being our client.</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <!-- END MAIN CONTENT AREA -->
                                </table>
                                <!-- START FOOTER -->
                                <div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;">
                                    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                        <tr>
                                            <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                                                <span class="apple-link" style="color: #999999; font-size: 14px; text-align: center;">' . $this->data['settings']['project_name'] . '.</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="footer" style="clear: both; Margin-top: 10px; text-align: left; width: 100%;">
                                    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                        <tr>
                                            <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: left;">
                                                <span class="apple-link" style="color: #999999; font-size: 12px; text-align: left;">
                                                    This message is for the use of the intended recipient(s) only and may contain confidential information. If you have received this message in error, please notify the sender and delete it. The Evis Technology accepts no liability for loss or damage caused by viruses and other malware and you are advised to carry out a virus and malware check on any attachments contained in this message. 
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- END FOOTER -->
                                <!-- END CENTERED WHITE CONTAINER -->
                            </div>
                        </td>
                        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
                    </tr>
                </table>
            </body>
        </html>';

        $email = \Config\Services::email();
        $email->initialize($email_config);
        $email->setNewline("\r\n");
        $email->setCRLF("\r\n");
        $email->setFrom($this->data['settings']['admin_email'], $this->data['settings']['project_name']);
        $email->setTo($domain_info['domain_email']);
        $email->setBCC($this->data['settings']['contact_email']);
        $email->setSubject($domain_info['domain_name'] . ' - Domain Renew Notice');
        $email->setMessage($message);
        $email->send();
        return redirect()->back()->with('success', 'Email Sent');
    }

    /* 003. Hosting Renew */

    public function hosting_renew($hosting_id) {
        $hosting_model = new HostingModel();
        $hosting_info = $hosting_model->where('hosting_id', $hosting_id)->first();

        $email_config = Array(
            'charset' => 'utf-8',
            'mailType' => 'html'
        );

        $message = '<!DOCTYPE html>
        
        <html>
            <head>
                <meta name="viewport" content="width=device-width">
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <title>' . $this->data['settings']['project_name'] . '</title>
                <style>
                    /* -------------------------------------
                        INLINED WITH htmlemail.io/inline
                    ------------------------------------- */
                    /* -------------------------------------
                        RESPONSIVE AND MOBILE FRIENDLY STYLES
                    ------------------------------------- */
                    @media only screen and (max-width: 620px) {
                        table[class=body] h1 {
                            font-size: 28px !important;
                            margin-bottom: 10px !important;
                        }
                        table[class=body] p,
                        table[class=body] ul,
                        table[class=body] ol,
                        table[class=body] td,
                        table[class=body] span,
                        table[class=body] a {
                            font-size: 16px !important;
                        }
                        table[class=body] .wrapper,
                        table[class=body] .article {
                            padding: 10px !important;
                        }
                        table[class=body] .content {
                            padding: 0 !important;
                        }
                        table[class=body] .container {
                            padding: 0 !important;
                            width: 100% !important;
                        }
                        table[class=body] .main {
                            border-left-width: 0 !important;
                            border-radius: 0 !important;
                            border-right-width: 0 !important;
                        }
                        table[class=body] .btn table {
                            width: 100% !important;
                        }
                        table[class=body] .btn a {
                            width: 100% !important;
                        }
                        table[class=body] .img-responsive {
                            height: auto !important;
                            max-width: 100% !important;
                            width: auto !important;
                        }
                    }
                    /* -------------------------------------
                        PRESERVE THESE STYLES IN THE HEAD
                    ------------------------------------- */
                    @media all {
                        .ExternalClass {
                            width: 100%;
                        }
                        .ExternalClass,
                        .ExternalClass p,
                        .ExternalClass span,
                        .ExternalClass font,
                        .ExternalClass td,
                        .ExternalClass div {
                            line-height: 100%;
                        }
                        .apple-link a {
                            color: inherit !important;
                            font-family: inherit !important;
                            font-size: inherit !important;
                            font-weight: inherit !important;
                            line-height: inherit !important;
                            text-decoration: none !important;
                        }
                        .btn-primary table td:hover {
                            background-color: #34495e !important;
                        }
                        .btn-primary a:hover {
                            background-color: #34495e !important;
                            border-color: #34495e !important;
                        }
                    }
                </style>
            </head>
            <body class="" style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;">
                    <tr>
                        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
                        <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
                            <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">
                                <!-- START CENTERED WHITE CONTAINER -->
                                <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">' . $this->data['settings']['project_name'] . '</span>
                                <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">
                                    <!-- START MAIN CONTENT AREA -->
                                    <tr>
                                        <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                                            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                                <tr>
                                                    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                                                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Dear Sir/Madam.</p>
                                                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Greetings from ' . $this->data['settings']['project_name'] . '. Please renew your hosting to avoid service interruption.</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <!-- END MAIN CONTENT AREA -->
                                </table>
                                
                                <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px; padding: 20px">
                                  <tr>
                                    <td style="font-family: sans-serif; font-size: 12px; vertical-align: top;" align="left">Primary Domain</td>
                                    <td style="font-family: sans-serif; font-size: 12px; vertical-align: top;" align="center">Expiry Date</td>
                                    <td style="font-family: sans-serif; font-size: 12px; vertical-align: top;" align="center">Space</td>
                                  </tr>
                                  <tr>
                                    <td style="font-family: sans-serif; font-size: 12px; vertical-align: top;" align="left">' . $hosting_info['primary_domain'] . '</td>
                                    <td style="font-family: sans-serif; font-size: 12px; vertical-align: top;" align="center">' . date($this->data['settings']['date_format'], strtotime($hosting_info['expiry_date'])) . '</td>
                                    <td style="font-family: sans-serif; font-size: 12px; vertical-align: top;" align="center">' . ucfirst($hosting_info['hosting_space']) . '</td>
                                  </tr>
                                </table>

                                <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">
                                    <!-- START MAIN CONTENT AREA -->
                                    <tr>
                                        <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                                            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                                <tr>
                                                    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                                                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Thank you for being our client.</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <!-- END MAIN CONTENT AREA -->
                                </table>
                                <!-- START FOOTER -->
                                <div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;">
                                    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                        <tr>
                                            <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                                                <span class="apple-link" style="color: #999999; font-size: 14px; text-align: center;">' . $this->data['settings']['project_name'] . '.</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="footer" style="clear: both; Margin-top: 10px; text-align: left; width: 100%;">
                                    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                        <tr>
                                            <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: left;">
                                                <span class="apple-link" style="color: #999999; font-size: 12px; text-align: left;">
                                                    This message is for the use of the intended recipient(s) only and may contain confidential information. If you have received this message in error, please notify the sender and delete it. The Evis Technology accepts no liability for loss or damage caused by viruses and other malware and you are advised to carry out a virus and malware check on any attachments contained in this message. 
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- END FOOTER -->
                                <!-- END CENTERED WHITE CONTAINER -->
                            </div>
                        </td>
                        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
                    </tr>
                </table>
            </body>
        </html>';

        $email = \Config\Services::email();
        $email->initialize($email_config);
        $email->setNewline("\r\n");
        $email->setCRLF("\r\n");
        $email->setFrom($this->data['settings']['admin_email'], $this->data['settings']['project_name']);
        $email->setTo($hosting_info['hosting_email']);
        $email->setBCC($this->data['settings']['contact_email']);
        $email->setSubject($hosting_info['primary_domain'] . ' - Hosting Renew Notice');
        $email->setMessage($message);
        $email->send();
        return redirect()->back()->with('success', 'Email Sent');
    }
}