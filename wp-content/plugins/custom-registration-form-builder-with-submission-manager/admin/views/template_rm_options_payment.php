<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//$data [] = 
$curr_arr = array('USD' => 'US Dollars',
    'EUR' => 'Euros',
    'GBP' => 'Pounds Sterling',
    'AUD' => 'Australian Dollars',
    'BRL' => 'Brazilian Real',
    'CAD' => 'Canadian Dollars',
    'CZK' => 'Czech Koruna',
    'DKK' => 'Danish Krone',
    'HKD' => 'Hong Kong Dollar',
    'HUF' => 'Hungarian Forint',
    'ILS' => 'Israeli Shekel',
    'JPY' => 'Japanese Yen',
    'MYR' => 'Malaysian Ringgits',
    'MXN' => 'Mexican Peso',
    'NZD' => 'New Zealand Dollar',
    'NOK' => 'Norwegian Krone',
    'PHP' => 'Philippine Pesos',
    'PLN' => 'Polish Zloty',
    'SGD' => 'Singapore Dollar',
    'SEK' => 'Swedish Krona',
    'CHF' => 'Swiss Franc',
    'TWD' => 'Taiwan New Dollars',
    'THB' => 'Thai Baht',
    'INR' => 'Indian Rupee',
    'TRY' => 'Turkish Lira',
    'RIAL' => 'Iranian Rial',
    'RUB' => 'Russian Rubles');
    
?>

<div class="rmagic">

    <!--Dialogue Box Starts-->
    <div class="rmcontent">


        <?php
//PFBC form
        $form = new RM_PFBC_Form("options_payment");
        $form->configure(array(
            "prevent" => array("bootstrap", "jQuery"),
            "action" => ""
        ));
        $data['payment_gateway'] = in_array('paypal',$data['payment_gateway'])?array('paypal') : array();
        $form->addElement(new Element_HTML('<div class="rmheader">' . RM_UI_Strings::get('GLOBAL_SETTINGS_PAYMENT') . '</div>'));
        $config_field = new Element_HTML('<a href=javascript:void(0) onclick="rm_open_payproc_config(this)">configure</a>');
        $form->addElement(new Element_Checkbox(RM_UI_Strings::get('LABEL_PAYMENT_PROCESSOR'), "payment_gateway", $data['pay_procs_options'], array("value" => $data['payment_gateway'], "longDesc" => RM_UI_Strings::get('HELP_OPTIONS_PYMNT_PROCESSOR')), array('exclass_row'=>'rm_pricefield_checkbox','sub_element'=>$config_field)));
        ////////////////// Payment Processor configuration popup /////////////////
        $form->addElement(new Element_HTML('<div id="rm_pproc_config_parent_backdrop" style="display:none" class="rm_config_pop_wrap">'));
        $form->addElement(new Element_HTML('<div id="rm_pproc_config_parent" style="display:block" class="rm_config_pop">'));
        foreach($data['pay_procs_configs'] as $pproc_name => $form_elems):
            $form->addElement(new Element_HTML('<div class="rm_pproc_config_single" id="rm_pproc_config_'.$pproc_name.'" style="display:none">'));
                $form->addElement(new Element_HTML("<div class='rm_pproc_config_single_titlebar'><div class='rm_pproc_title'>{$data['pay_procs_options'][$pproc_name]}</div><span onclick='jQuery(\"#rm_pproc_config_parent_backdrop\").hide();' class='rm-popup-close'>&times;</span></div>"));
                $form->addElement(new Element_HTML('<div class="rm_pproc_config_single_elems">'));
            foreach($form_elems as $elem):
                $form->addElement($elem);
            endforeach;
                $form->addElement(new Element_HTML('</div>'));
            $form->addElement(new Element_HTML('</div>'));
        endforeach;
        
        $form->addElement(new Element_HTML('</div>'));
        $form->addElement(new Element_HTML('</div>'));
        ////////////////// End: Payment Processor configuration popup ////////////        
        $form->addElement(new Element_Select(RM_UI_Strings::get('LABEL_CURRENCY'), "currency", $curr_arr, array("value" => $data['currency'], "longDesc" => RM_UI_Strings::get('HELP_OPTIONS_PYMNT_CURRENCY'))));
        $form->addElement(new Element_Select(RM_UI_Strings::get('LABEL_CURRENCY_SYMBOL'), "currency_symbol_position", array("before" => "Before amount (Eg.: $10)", "after" => "After amount (Eg.: 10$)"), array("value" => $data['currency_symbol_position'], "longDesc" => RM_UI_Strings::get("LABEL_CURRENCY_SYMBOL_HELP"))));

        $form->addElement(new Element_HTMLL('&#8592; &nbsp; Cancel', '?page=rm_options_manage', array('class' => 'cancel')));
        $form->addElement(new Element_Button(RM_UI_Strings::get('LABEL_SAVE')));

        $form->render();
        ?>

    </div>
    <?php 
    include RM_ADMIN_DIR.'views/template_rm_promo_banner_bottom.php';
    ?>
</div>
<pre class="rm-pre-wrapper-for-script-tags"><script type="text/javascript">
    
    function rm_open_payproc_config(ele) {        
        var jqele = jQuery(ele);
        
        if(jqele.closest(".rmrow").hasClass("rm_deactivated"))
            return;
        
        var jq_pproc = jqele.parents("li").children("input").val();
        
        if(typeof jq_pproc == 'undefined')
            return;
        
        jQuery("#rm_pproc_config_parent").children().hide();
        jQuery("#rm_pproc_config_parent").children("#rm_pproc_config_"+jq_pproc).show();
        jQuery("#rm_pproc_config_parent_backdrop").show();        
    }
    
    jQuery(document).mouseup(function (e) {
        var container = jQuery("#rm_pproc_config_parent");
        if (!container.is(e.target) // if the target of the click isn't the container... 
                && container.has(e.target).length === 0 && container.is(":visible")) // ... nor a descendant of the container 
        {
            jQuery("#rm_pproc_config_parent_backdrop").hide();
        }
    });
    
    jQuery(document).ready(function () {
        jQuery('#options_payment-element-1-0').click(function () {
            checkbox_disable_elements(this, 'rm_pp_test_cb-0,rm_pp_email_tb,rm_pp_style_tb', 0);
        });
        jQuery('#options_payment-element-1-1').attr("disabled", true);
        
        var pgws_jqel = jQuery("input[name='payment_gateway[]']");
        
        pgws_jqel.each(function(){
            var cbox_jqel = jQuery(this);
            if(cbox_jqel.prop('checked'))
                cbox_jqel.siblings(".rmrow").removeClass("rm_deactivated");
            else
                cbox_jqel.siblings(".rmrow").addClass("rm_deactivated");
        });
        
        pgws_jqel.change(function(){
            var cbox_jqel = jQuery(this);
            if(cbox_jqel.val() == 'paypal'){
                if(cbox_jqel.prop('checked'))
                    cbox_jqel.siblings(".rmrow").removeClass("rm_deactivated");
                else
                    cbox_jqel.siblings(".rmrow").addClass("rm_deactivated");
            } else {
                cbox_jqel.prop('checked',false);
                jQuery("#rm_pproc_config_parent").children().hide();
                jQuery("#rm_pproc_config_parent").children("#rm_pproc_config_asim").show();
                jQuery("#rm_pproc_config_parent_backdrop").show();
            }
        });
    });
</script></pre>

<?php   
