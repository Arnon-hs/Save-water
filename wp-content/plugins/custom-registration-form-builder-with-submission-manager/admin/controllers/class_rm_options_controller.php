<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_options_controller
 *
 * @author CMSHelplive
 */
class RM_Options_Controller
{

    public $mv_handler;

    function __construct()
    {
        $this->mv_handler = new RM_Model_View_Handler();
    }

    public function add()
    {
        $this->service->add();
        $this->view->render();
    }

    public function get_options()
    {
        $data = $this->service->get_options();
        $this->view->render($data);
    }

    public function user($model, $service, $request, $params)
    {
        if ($this->mv_handler->validateForm("options_users"))
        {
            $options = array();

            $options['auto_generated_password'] = isset($request->req['auto_generated_password']) ? "yes" : null;
            $options['send_password'] = isset($request->req['send_password']) ? "yes" : null;

            $service->set_model($model);
            $service->save_options($options);
            RM_Utilities::redirect(admin_url('/admin.php?page=' . $params['xml_loader']->request_tree->success));
        } else
        {
            $view = $this->mv_handler->setView('options_user');
            $service->set_model($model);
            $data = $service->get_options();
            $view->render($data);
        }
    }

    public function manage($model, RM_Setting_Service $service, $request, $params)
    {
        $view = $this->mv_handler->setView('options_manager');
        $view->render();
    }

    public function general(RM_Options $model, RM_Setting_Service $service, $request, $params)
    {
        if ($this->mv_handler->validateForm("options_general"))
        {
            $options = array();

            $options['theme'] = $request->req['theme'];

            $options['allowed_file_types'] = isset($request->req['allowed_file_types']) ? $request->req['allowed_file_types']: null;
            $options['default_registration_url'] = $request->req['default_registration_url'];
            $options['post_submission_redirection_url'] = $request->req['post_submission_redirection_url'];
            $options['post_logout_redirection_page_id'] = $request->req['post_logout_redirection_page_id'];
            $options['user_ip'] = isset($request->req['user_ip']) ? "yes" : null;
            $options['allow_multiple_file_uploads'] = isset($request->req['allow_multiple_file_uploads']) ? "yes" : null;
            $options['form_layout'] = $request->req['form_layout'];
            $options['display_progress_bar'] = isset($request->req['display_progress_bar']) ? "yes" : null;
            $options['submission_on_card'] = $request->req['submission_on_card'];
            $options['show_asterix'] = isset($request->req['show_asterix']) ? "yes" : null;
            $service->set_model($model);

            $service->save_options($options);
            RM_Utilities::redirect(admin_url('/admin.php?page=' . $params['xml_loader']->request_tree->success));
        } else
        {
            $view = $this->mv_handler->setView('options_general');
            $service->set_model($model);
            $data = $service->get_options();

            //Add an extra space around the extensions for better visibility for end user.
            //While saving they are automatically stripped off.
            $data['allowed_file_types'] = str_replace("|"," | ",$data['allowed_file_types']);
            
            $view->render($data);
        }
    }
    
    public function fab(RM_Options $model, RM_Setting_Service $service, $request, $params)
    {
        if ($this->mv_handler->validateForm("options_fab"))
        {
            $options = array();
            $options['display_floating_action_btn'] = isset($request->req['display_floating_action_btn']) ? "yes" : null;
            $options['fab_icon'] = $request->req['fab_icon'];
           
            $service->set_model($model);

            $service->save_options($options);
            RM_Utilities::redirect(admin_url('/admin.php?page=' . $params['xml_loader']->request_tree->success));
        } else
        {
            $view = $this->mv_handler->setView('options_fab');
            $service->set_model($model);
            $data = $service->get_options();            
            $view->render($data);
        }
    }

    public function security($model, RM_Setting_Service $service, $request, $params)
    {
        if ($this->mv_handler->validateForm("options_security"))
        {
            $options = array();

            $options['enable_captcha'] = isset($request->req['enable_captcha']) ? "yes" : null;
           // $options['captcha_language'] = $request->req['captcha_language'];
            $options['public_key'] = isset($request->req['public_key'])?$request->req['public_key']:null;
            $options['private_key'] = isset($request->req['private_key'])?$request->req['private_key']:null;
            $options['sub_limit_antispam'] = $request->req['sub_limit_antispam'];
            $options['enable_captcha_under_login'] = isset($request->req['enable_captcha_under_login']) ? "yes" : null;
           // $options['captcha_req_method'] = $request->req['captcha_req_method'];

            $service->set_model($model);

            $service->save_options($options);
           RM_Utilities::redirect(admin_url('/admin.php?page=' . $params['xml_loader']->request_tree->success));
        } else
        {
            $view = $this->mv_handler->setView('options_security');
            $service->set_model($model);
            $data = $service->get_options();
            $view->render($data);
        }
    }

    public function autoresponder($model, $service, $request, $params)
    {
        if ($this->mv_handler->validateForm("options_autoresponder"))
        {
            $options = array();

            $options['admin_notification'] = isset($request->req['admin_notification']) ? "yes" : null;
            if (isset($request->req['resp_emails']))
                $options['admin_email'] = implode(",", $request->req['resp_emails']);
            //var_dump($options['admin_email']);die;
            $options['senders_display_name'] = $request->req['senders_display_name'];
            $options['senders_email'] = $request->req['senders_email'];

            $options['enable_smtp'] = isset($request->req['enable_smtp']) ? "yes" : null;
            $options['smtp_encryption_type'] = $request->req['smtp_encryption_type'];
            $options['smtp_host'] = $request->req['smtp_host'];
            $options['smtp_port'] = $request->req['smtp_port'];
            
            $options['smtp_auth'] = isset($request->req['smtp_auth']) ? "yes" : null;
            $options['smtp_user_name'] = $request->req['smtp_user_name'];
            $options['smtp_password'] = $request->req['smtp_password'];

            $service->set_model($model);

            $service->save_options($options);
            RM_Utilities::redirect(admin_url('/admin.php?page=' . $params['xml_loader']->request_tree->success));
        } else
        {
            $view = $this->mv_handler->setView('options_autoresponder');
            $service->set_model($model);
            $data = $service->get_options();
            $view->render($data);
        }
    }

    public function thirdparty($model, RM_Setting_Service $service, $request, $params)
    {
        if ($this->mv_handler->validateForm("options_thirdparty"))
        {
            $options = array();

            $options['enable_facebook'] = isset($request->req['enable_facebook']) ? "yes" : null;
            $options['facebook_app_id'] = $request->req['facebook_app_id'];
            $options['facebook_app_secret'] = $request->req['facebook_app_secret'];
            $options['enable_mailchimp'] = isset($request->req['enable_mailchimp']) ? "yes" : null;
            $options['mailchimp_key'] = $request->req['mailchimp_key'];

            $service->set_model($model);

            $service->save_options($options);
            RM_Utilities::redirect(admin_url('/admin.php?page=' . $params['xml_loader']->request_tree->success));
        } else
        {

            $view = $this->mv_handler->setView('options_thirdparty');
            $service->set_model($model);
            $data = $service->get_options();
            $view->render($data);
        }
    }

    public function payment($model, RM_Setting_Service $service, $request, $params)
    {
        if ($this->mv_handler->validateForm("options_payment"))
        {
            $options = array();

            $options['payment_gateway'] = isset($request->req['payment_gateway']) ? 'paypal' : null;
            $options['paypal_test_mode'] = isset($request->req['paypal_test_mode']) ? "yes" : null;
            if(isset($request->req['paypal_page_style']))
                $options['paypal_page_style'] = $request->req['paypal_page_style'];
            
            if(isset($request->req['paypal_email']))
                $options['paypal_email'] = $request->req['paypal_email'];
            $options['currency'] = $request->req['currency'];
            $options['currency_symbol_position'] = $request->req['currency_symbol_position'];

            $service->set_model($model);

            $service->save_options($options);
            RM_Utilities::redirect(admin_url('/admin.php?page=' . $params['xml_loader']->request_tree->success));
        } else
        {

            $view = $this->mv_handler->setView('options_payment');
            $service->set_model($model);
            $data = $service->get_options();
            
            
            $options_s_api = array("id" => "rm_s_api_key_tb", "longDesc" => RM_UI_Strings::get('HELP_OPTIONS_PYMNT_STRP_API_KEY'), "disabled" => true);
            $options_s_pub = array("id" => "rm_s_publish_key_tb", "longDesc" => RM_UI_Strings::get('MSG_BUY_PRO_INLINE'), "disabled" => true);
            $options_pp_test_cb = array("id" => "rm_pp_test_cb", "longDesc" => RM_UI_Strings::get('HELP_OPTIONS_PYMNT_TESTMODE'));
            $options_pp_email = array("id" => "rm_pp_email_tb", "value" => $data['paypal_email'], "longDesc" => RM_UI_Strings::get('HELP_OPTIONS_PYMNT_PP_EMAIL'));
            $options_pp_pstyle = array("id" => "rm_pp_style_tb", "value" => $data['paypal_page_style'], "longDesc" => RM_UI_Strings::get('HELP_OPTIONS_PYMNT_PP_PAGESTYLE'));

            if($data['paypal_test_mode'] == 'yes')
                $options_pp_test_cb['value'] = 'yes';
            
            $pay_procs_options = array("paypal" => "<img src='" . RM_IMG_URL . "/paypal-logo.png" . "'></img>",
                                      "stripe" => "<img src='" . RM_IMG_URL . "/stripe-logo.png" . "'></img>",
                                    "asim" => "<strong>Authorize.Net</strong>","offline"=>"<strong>Offline</strong>");
            
            $pay_procs_configs = array("paypal" => array(
                                            new Element_Checkbox(RM_UI_Strings::get('LABEL_TEST_MODE'), "paypal_test_mode", array("yes" => ''), $options_pp_test_cb),
                                            new Element_Email(RM_UI_Strings::get('LABEL_PAYPAL_EMAIL'), "paypal_email", $options_pp_email),
                                            new Element_Textbox(RM_UI_Strings::get('LABEL_PAYPAL_STYLE'), "paypal_page_style", $options_pp_pstyle)
                                            ),
                                      "stripe" => array(
                                            new Element_Textbox(RM_UI_Strings::get('LABEL_STRIPE_API_KEY'), "", $options_s_api),
                                            new Element_Textbox(RM_UI_Strings::get('LABEL_STRIPE_PUBLISH_KEY'), "", $options_s_pub)
                                            ),
                                        "asim" => array(new Element_HTML('<div><p class="rm_buy_pro_wrap">'.RM_UI_Strings::get('MSG_BUY_PRO_INLINE').'</p></div>')),
                                        "offline" => array(new Element_HTML('<div><p class="rm_buy_pro_wrap">'.RM_UI_Strings::get('MSG_BUY_PRO_INLINE').'</p></div>'))
                                     );
            $data['pay_procs_options'] = $pay_procs_options;
            $data['pay_procs_configs'] = $pay_procs_configs;
            $view->render($data);
        }
    }

}

/*
$options = array();
            if (!isset($request->req['options_category']))
                return false;
            //$form='';

            switch ($request->req['options_category'])
            {
                case "general":
                    $options['theme'] = $request->req['theme'];
                    $options['allowed_file_types'] = $request->req['allowed_file_types'];
                    $options['default_registration_url'] = $request->req['default_registration_url'];
                    $options['post_submission_redirection_url'] = $request->req['post_submission_redirection_url'];
                    $options['user_ip'] = isset($request->req['user_ip']) ? "yes" : null;
                    $options['allow_multiple_file_uploads'] = isset($request->req['allow_multiple_file_uploads']) ? "yes" : null;
                    $form = 'options_general';
                    break;

                case "users":
                    $options['auto_generated_password'] = isset($request->req['auto_generated_password']) ? "yes" : null;
                    $options['send_password'] = isset($request->req['send_password']) ? "yes" : null;
                    $options['user_auto_approval'] = isset($request->req['user_auto_approval']) ? "yes" : null;
                    break;

                case "security":
                    $options['enable_captcha'] = isset($request->req['enable_captcha']) ? "yes" : null;
                    $options['captcha_language'] = $request->req['captcha_language'];
                    $options['public_key'] = $request->req['public_key'];
                    $options['private_key'] = $request->req['private_key'];
                    $options['enable_captcha_under_login'] = isset($request->req['enable_captcha_under_login']) ? "yes" : null;
                    $options['captcha_req_method'] = $request->req['captcha_req_method'];
                    $form = 'options_security';
                    break;

                case "autoresponder":
                    //var_dump($request);die;

                    $options['admin_notification'] = isset($request->req['admin_notification']) ? "yes" : null;
                    $options['user_notification_for_notes'] = isset($request->req['user_notification_for_notes']) ? "yes" : null;
                    if (isset($request->req['resp_emails']))
                        $options['admin_email'] = implode(",", $request->req['resp_emails']);
                    //var_dump($options['admin_email']);die;
                    $options['senders_email'] = $request->req['senders_email'];
                    break;

                case "thirdparty":
                    $options['enable_facebook'] = isset($request->req['enable_facebook']) ? "yes" : null;
                    $options['facebook_app_id'] = $request->req['facebook_app_id'];
                    $options['facebook_app_secret'] = $request->req['facebook_app_secret'];
                    $options['enable_mailchimp'] = isset($request->req['enable_mailchimp']) ? "yes" : null;
                    $options['mailchimp_key'] = $request->req['mailchimp_key'];
                    $form = "options_thirdparty";
                    break;

                case "payment":
                    $options['payment_gateway'] = $request->req['payment_gateway'];
                    $options['paypal_test_mode'] = isset($request->req['paypal_test_mode']) ? "yes" : null;
                    $options['paypal_email'] = $request->req['paypal_email'];
                    $options['currency'] = $request->req['currency'];
                    $options['currency_symbol_position'] = $request->req['currency_symbol_position'];
                    $options['paypal_page_style'] = $request->req['paypal_page_style'];
                    break;

                default: return false;
            }


            $service->set_model($model);


            $service->save_options($options);
            RM_Utilities::redirect(admin_url('/admin.php?page=' . $params['xml_loader']->request_tree->success));*/
