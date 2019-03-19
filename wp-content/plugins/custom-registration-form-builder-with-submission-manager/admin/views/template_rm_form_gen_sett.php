<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//var_dump($data);die;
?>

<div class="rmagic">
    
    <!-- Joyride Magic begins -->
    <ol id="rm-form-gensett-joytips" style="display:none">
        <li><h2>Welcome to General Settings</h2>
        <p>This page lets you control basic settings for your form. Advanced settings are available inside the Form dashboard which you can tweak later. Let's start!</p>
        </li>
        <li data-class="rmheader">This is the title of the form which you are currently editing. If you are creating a new form from scratch, it will simply say <b>New Registration Form</b></li>
        <li data-id="rm_form_name">This box lets you input title of your form. It is something that lets you identify the form when you are in Forms Manager section. Your site visitors never see form title. You cannot leave it blank.</li>
        <li data-id="rm_form_description">Description of the form is optional. You can type in details and purpose of the form to remember later. Also useful when the site is managed by multiple admins.</li>
        <li data-class="rm_form_type_label">A registration form generally lets you register visitors on your site. After registration they appear as users inside WP Dashboard. RegistrationMagic lets you do just that. But if you do not want this form to register WP Users, choose <b>Non-WP Registration Form</b> radio box. It will essentially turn the form into a regular form which you can use for multiple purposes. For example, a Contact Form.</li>
        <li data-id="wp-form_custom_text-wrap"> This editor allows you to add content above your form. You can add images, banner, text, notice or help snippet which provide extra information to your site visitors. All your form fields will appear below this content. TIP: If you want to add text <i>between</i> two fields, use <b>Paragraph</b> field type.</li>
        <li data-id="rm_submit_btn"> Hit <b>Save</b> to save all the changes you have made and go back. Or...</li>
        <li data-class="cancel">Click <b>Cancel</b> to undo all the changes you just made and go back.</li>
        <li data-button="Done">That's all there's to know about a form's <b>General Settings</b>. Now you are ready to start building forms. Good luck!</li>
   </ol>
  <!-- Joyride Magic ends -->

    <!--Dialogue Box Starts-->
    <div class="rmcontent">


        <?php
        $form = new RM_PFBC_Form("form_sett_general");
        $form->configure(array(
            "prevent" => array("bootstrap", "jQuery"),
            "action" => ""
        ));
        
        if (isset($data->model->form_id)) {
            $form->addElement(new Element_HTML('<div class="rmheader">' . $data->model->form_name . '</div>'));
            $form->addElement(new Element_HTML('<div class="rmsettingtitle">' . RM_UI_Strings::get('LABEL_F_GEN_SETT') . '</div>'));
            $form->addElement(new Element_Hidden("form_id", $data->model->form_id));
        } else {
            $form->addElement(new Element_HTML('<div class="rmheader">' . RM_UI_Strings::get("TITLE_NEW_FORM_PAGE") . '</div>'));
        }

        $form->addElement(new Element_Textbox("<b>" . RM_UI_Strings::get('LABEL_TITLE') . ":</b>", "form_name", array("id" => "rm_form_name", "required" => "1", "value" => $data->model->form_name, "longDesc" => RM_UI_Strings::get('HELP_ADD_FORM_TITLE'))));
        $form->addElement(new Element_Textarea("<b>" . RM_UI_Strings::get('LABEL_DESC') . ":</b>", "form_description", array("id" => "rm_form_description", "value" => $data->model->form_options->form_description, "longDesc" => RM_UI_Strings::get('HELP_ADD_FORM_DESC'))));
        
        if($data->model->form_type === null)
           $data->model->form_type = RM_REG_FORM;
        $form_type_selection_array = array(RM_REG_FORM => "<span class='rm_form_type_label'>".RM_UI_Strings::get('LABEL_REG_FORM').'</span><div class="rm_formtype_help"><div>'.RM_UI_Strings::get('HELP_SELECT_FORM_TYPE_REG').'</div></div>',
            RM_CONTACT_FORM => "<span class='rm_form_type_label'>".RM_UI_Strings::get('LABEL_NON_REG_FORM').'</span><div class="rm_formtype_help"><div>'.RM_UI_Strings::get('HELP_SELECT_FORM_TYPE_NON_REG').'</div></div>');
        $form->addElement(new Element_Radio("<b>" . RM_UI_Strings::get('LABEL_SELECT_FORM_TYPE') . "</b>:", "form_type", $form_type_selection_array, array("class" => "rm_user_create", "value" => $data->model->form_type)));

        $form->addElement(new Element_TinyMCEWP("<b>" . RM_UI_Strings::get('LABEL_CONTENT_ABOVE') . ":</b>", $data->model->form_options->form_custom_text, "form_custom_text", array('editor_class' => 'rm_TinyMCE', 'editor_height' => '100px'), array("longDesc" => RM_UI_Strings::get('HELP_ADD_FORM_CONTENT_ABOVE_FORM'))));
        
        $form->addElement(new Element_Checkbox("<b>" . RM_UI_Strings::get('LABEL_SHOW_TOTAL_PRICE') . ":</b>", "show_total_price", array(1 => ""), array("id" => "rm_", "value" => $data->model->form_options->show_total_price, "longDesc" => RM_UI_Strings::get('HELP_SHOW_TOTAL_PRICE'))));
         
        if(!isset($data->model->form_id))
        $form->addElement(new Element_HTMLL('&#8592; &nbsp; Cancel', 'javascript:void(0)', array('class' => 'cancel', 'onClick' => 'window.history.back();')));
        else
            $form->addElement (new Element_HTMLL ('&#8592; &nbsp; Cancel', '?page=rm_form_sett_manage&rm_form_id='.$data->model->form_id, array('class' => 'cancel')));
        $form->addElement(new Element_Button(RM_UI_Strings::get('LABEL_SAVE'), "submit", array("id" => "rm_submit_btn", "class" => "rm_btn", "name" => "submit", "onClick" => "jQuery.prevent_field_add(event,'This is a required field.')")));
        $form->render();
        ?>
    </div>
    
    <?php 
    include RM_ADMIN_DIR.'views/template_rm_promo_banner_bottom.php';
    ?>
</div>

<pre class="rm-pre-wrapper-for-script-tags"><script>
    jQuery(document).ready(function(){
       
       //Configure joyride
       //If autostart is false, call again "jQuery("#rm-form-man-joytips").joyride()" to start the tour.
       <?php if($data->autostart_tour): ?>
       jQuery("#rm-form-gensett-joytips").joyride({tipLocation: 'top',
                                               autoStart: true,
                                               postRideCallback: rm_joyride_tour_taken});
        <?php else: ?>
            jQuery("#rm-form-gensett-joytips").joyride({tipLocation: 'top',
                                               autoStart: false,
                                               postRideCallback: rm_joyride_tour_taken});
        <?php endif; ?>
    });
   
   function rm_start_joyride(){
       jQuery("#rm-form-gensett-joytips").joyride();
    }
    
    function rm_joyride_tour_taken(){
        var data = {
			'action': 'joyride_tour_update',
			'tour_id': 'form_gensett_tour',
                        'state': 'taken'
		};

        jQuery.post(ajaxurl, data, function(response) {});
    }
</script></pre>
<?php
