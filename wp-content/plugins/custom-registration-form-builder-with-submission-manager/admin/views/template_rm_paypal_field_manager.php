<?php
/**
 * @internal Plugin Template File [Price Field Manager]
 *
 * This is the plugin view file for fields manager. The view of forms field manager
 * is rendered from this file.
 *
 * use $data for data related to the view
 */
?>

<div class="rmagic">

    <!-----Operations bar Starts----->
    <form method="post" id="rm_payapal_field_mananger_form">
        <input type="hidden" name="rm_slug" value="" id="rm_slug_input_field">
        <div class="operationsbar">
            <div class="rmtitle"><?php echo RM_UI_Strings::get("TITLE_PAYPAL_FIELD_PAGE"); ?></div>
            <div class="icons">
                <a href="?page=rm_options_payment"><img alt="" src="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . 'images/rm-payments.png'; ?>"></a>
            </div>
            <div class="nav">
                <ul>
                    <li><a href="?page=rm_paypal_field_add&rm_field_type"><?php echo RM_UI_Strings::get('LABEL_ADD_NEW_PRICE_FIELD'); ?></a></li>
                    <li onclick="jQuery.rm_do_action('rm_payapal_field_mananger_form', 'rm_paypal_field_remove')"><a href="javascript:void(0)"><?php echo RM_UI_Strings::get('LABEL_REMOVE'); ?></a></li>
                </ul>
            </div>

        </div>
        <!--------Operationsbar Ends----->

        <!----Field Selector Starts---->

        <div class="rm-field-selector">
            <div class="">
                <ul class="field-tabs">
                    <li class="field-tabs-row"><a href="javascript:void(0)" class="rm_tab_links" id="rm_special_fields_tab_link"><?php echo RM_UI_Strings::get("LABEL_TYPES"); ?></a></li>
                </ul>
            </div>
            <div class="field-selector-pills">
                <div id="rm_price_fields_tab">
                    <div class="rm_button_like_links"><a href="?page=rm_paypal_field_add&rm_field_type=fixed"><?php echo RM_UI_Strings::get("P_FIELD_TYPE_FIXED"); ?></a></div>  
                    <div class="rm_button_like_links"><a class="rm_deactivated" href="javascript:void(0)"><?php echo RM_UI_Strings::get("P_FIELD_TYPE_MULTISEL"); ?></a></div>
                    <div class="rm_button_like_links"><a class="rm_deactivated" href="javascript:void(0)"><?php echo RM_UI_Strings::get("P_FIELD_TYPE_DROPDOWN"); ?></a></div>  
                    <div class="rm_button_like_links"><a class="rm_deactivated" href="javascript:void(0)"><?php echo RM_UI_Strings::get("P_FIELD_TYPE_USERDEF"); ?></a></div>  
                </div>
            </div>
        </div>

        <!----Slab View---->
        <ul class="rm-field-container" id="rm_sortable_paypal_fields">
            <?php
            if ($data->fields_data)
            {
                $i = 0;
                foreach ($data->fields_data as $field_data)
                {
                    ?>
                    <li id="<?php echo $field_data->field_id ?>">
                        <div class="rm-slab">
                            <div class="rm-slab-grabber">
                                <span class="rm_sortable_handle">
                                    <img alt="" src="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . 'images/rm-drag.png'; ?>">
                                </span>
                            </div>
                            <div class="rm-slab-content">
                                <input type="checkbox" name="rm_selected[]" value="<?php echo $field_data->field_id; ?>">
                                <span><?php echo $field_data->name; ?></span>
                                <span><?php echo RM_UI_Strings::get('LABEL_TYPE'); ?> = <?php echo RM_UI_Strings::get('P_FIELD_TYPE_' . strtoupper($field_data->type)); ?></span>

                            </div>
                            <div class="rm-slab-buttons">

                                <a href="<?php echo '?page=rm_paypal_field_add&rm_field_id=' . $field_data->field_id . '&rm_field_type=' . $field_data->type; ?>"><?php echo RM_UI_Strings::get("LABEL_EDIT"); ?></a>
                                <a href="<?php echo '?page=rm_paypal_field_manage&rm_field_id=' . $field_data->field_id . '&rm_action=delete"'; ?>"><?php echo RM_UI_Strings::get("LABEL_DELETE"); ?></a>
                            </div>
                        </div>
                    </li>

                    <?php
                }
            } else
            {
                echo "<div class='rmnotice'>" . RM_UI_Strings::get('NO_PRICE_FIELDS_MSG') . "</div>";
            }
            ?>
        </ul>
    </form>
    <?php 
    $rm_promo_banner_title = "Unlock multiple pricing configurations by upgrading";
    include RM_ADMIN_DIR.'views/template_rm_promo_banner_bottom.php';
    ?>
</div>

