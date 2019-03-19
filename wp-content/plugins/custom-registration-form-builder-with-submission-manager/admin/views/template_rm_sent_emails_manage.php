<?php
//var_dump(admin_url("admin.php?page=rm_sent_emails_manage"));

//die;

?>
<div class="rmagic">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.min.css"/>

<!-- mother form for all kind of searches.  It never shows but does it all.-->
            <form method="post" action="" name="rm_sent_emails_manage" id="rm_sent_emails_search_form">
                
                <input type="hidden" name="rm_form_id" value="<?php echo $data->filter->form_id; ?>" id="rm_form_id_input_field" />
                <input type="hidden" name="rm_interval" id="rm_interval_input_field" value="<?php echo $data->filter->filters['rm_interval']; ?>" />
                <input type="hidden" name="rm_fromdate" id="rm_fromdate_input_field" value="<?php echo $data->filter->filters['rm_fromdate']; ?>" />
                <input type="hidden" name="rm_dateupto" id="rm_uptodate_input_field" value="<?php echo $data->filter->filters['rm_dateupto']; ?>" />
                <input type="hidden" name="rm_field_to_search" id="rm_field_to_search_input_field" value="<?php echo $data->filter->filters['rm_field_to_search']; ?>" />
                <input type="hidden" name="rm_value_to_search" id="rm_value_to_search_input_field" value="<?php echo $data->filter->filters['rm_value_to_search']; ?>" />
                <input type="hidden" name="rm_search_initiated" value="yes">
            </form>
<!-- Mother form end here. -->


    <!-----Operations bar Starts----->
    <div class="operationsbar">
        <div class="rmtitle"><?php echo RM_UI_Strings::get("TITLE_SENT_EMAILS_MANAGER"); ?></div>
        <div class="icons">
            <a href="?page=rm_options_manage"><img alt="" src="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . 'images/global-settings.png'; ?>"></a>

        </div>
        <div class="nav">
            <ul>
                
                <li onclick="window.history.back()"><a href="javascript:void(0)"><?php echo RM_UI_Strings::get("LABEL_BACK"); ?></a></li>
                
                <li onclick="jQuery.rm_do_action('rm_sent_emails_action_form', 'rm_sent_emails_remove')"><a href="javascript:void(0)"><?php echo RM_UI_Strings::get("LABEL_DELETE"); ?></a></li>

                <li class="rm-form-toggle">
                    <?php if (count($data->forms) !== 0)
                    {
                        echo RM_UI_Strings::get('LABEL_DISPLAYING_FOR');
                        ?>
                        <select id="rm_form_dropdown" name="form_id" onchange = "reset_search()">
                            <?php
                            foreach ($data->forms as $form_id => $form)
                                if ($data->filter->form_id == $form_id)
                                    echo "<option value=$form_id selected>$form</option>";
                                else
                                    echo "<option value=$form_id>$form</option>";
                            ?>
                        </select>
                        <?php
                    } 
                    ?>
                </li>
            </ul>
        </div>

    </div>
    <!--  Operations bar Ends----->


    <!-------Content area Starts----->

    <?php
    if(count($data->forms) === 0){
        ?><div class="rmnotice-container">
            <div class="rmnotice">
        <?php echo RM_UI_Strings::get('MSG_NO_FORM_SUB_MAN'); ?>
            </div>
        </div><?php
    }
    elseif ($data->mails || $data->filter->filters['rm_interval'] != 'all' || $data->filter->searched)
    {
        ?>
        <div class="rmagic-table">

            <div class="sidebar">
                <div class="sb-filter">
                    <?php echo RM_UI_Strings::get("LABEL_TIME"); ?>
                    <div class="filter-row"><input type="radio" onclick='resubmit_search()' name="filter_between_dispf" value="all"   <?php if ($data->filter->filters['rm_interval'] == "all") echo "checked"; ?>><?php echo RM_UI_Strings::get("LABEL_ALL"); ?> </div>
                    <div class="filter-row"><input type="radio" onclick='resubmit_search()' name="filter_between_dispf" value="today" <?php if ($data->filter->filters['rm_interval'] == "today") echo "checked"; ?>><?php echo RM_UI_Strings::get("LABEL_TODAY"); ?> </div>
                    <div class="filter-row"><input type="radio" onclick='resubmit_search()' name="filter_between_dispf" value="week"  <?php if ($data->filter->filters['rm_interval'] == "week") echo "checked"; ?>><?php echo RM_UI_Strings::get("LABEL_THIS_WEEK"); ?></div>
                    <div class="filter-row"><input type="radio" onclick='resubmit_search()' name="filter_between_dispf" value="month" <?php if ($data->filter->filters['rm_interval'] == "month") echo "checked"; ?>><?php echo RM_UI_Strings::get("LABEL_THIS_MONTH"); ?></div>
                    <div class="filter-row"><input type="radio" onclick='resubmit_search()' name="filter_between_dispf" value="year"  <?php if ($data->filter->filters['rm_interval'] == "year") echo "checked"; ?>><?php echo RM_UI_Strings::get("LABEL_THIS_YEAR"); ?></div>
                    <div class="filter-row"><input type="radio" onclick='resubmit_search()' name="filter_between_dispf" value="custom"  <?php if ($data->filter->filters['rm_interval'] == "custom") echo "checked"; ?>><?php echo RM_UI_Strings::get("LABEL_CUSTOM_RANGE"); ?></div>
                    <?php if($data->filter->filters['rm_interval'] == "custom") 
                            {
                                ?>
                              <div id="rm_date_box">
                              <?php
                            }
                            else
                                {
                                ?>
                              <div id="rm_date_box" style="display:none">
                              <?php
                            }  
                    ?>
                        <div class="filter-row"><span><?php echo RM_UI_Strings::get("LABEL_CUSTOM_RANGE_FROM_DATE"); ?></span><input type="text" onchange='resubmit_search()' class="rm_custom_subfilter_dates" id="rm_id_custom_subfilter_date_from" name="rm_custom_subfilter_date_from_dispf" value="<?php echo $data->filter->filters['rm_fromdate']; ?>"<?php if ($data->filter->filters['rm_interval'] != "custom") echo "disabled"; ?>></div>
                        <div class="filter-row"><span><?php echo RM_UI_Strings::get("LABEL_CUSTOM_RANGE_UPTO_DATE"); ?></span> <input type="text" onchange='resubmit_search()' class="rm_custom_subfilter_dates" id="rm_id_custom_subfilter_date_upto" name="rm_custom_subfilter_date_upto_dispf" value="<?php echo $data->filter->filters['rm_dateupto']; ?>"<?php if ($data->filter->filters['rm_interval'] != "custom") echo "disabled"; ?>></div>
                    </div>
                </div>
                
               
                
                <div class="sb-filter">
                    <?php echo RM_UI_Strings::get("LABEL_MATCH_FIELD"); ?>
                        <div class="filter-row">
                            <select name="rm_field_to_search_dispf">
                                <option value="to" <?php if($data->filter->filters['rm_field_to_search'] === 'to')echo "selected";?>><?php echo RM_UI_Strings::get("LABEL_EMAIL_TO"); ?></option>
                                <option value="sub" <?php if($data->filter->filters['rm_field_to_search'] === 'sub')echo "selected";?>><?php echo RM_UI_Strings::get("LABEL_EMAIL_SUB"); ?></option>
                                <option value="body" <?php if($data->filter->filters['rm_field_to_search'] === 'body')echo "selected";?>><?php echo RM_UI_Strings::get("LABEL_EMAIL_BODY"); ?></option>
                            </select>
                        </div>

                        <div class="filter-row"><input type="text" name="rm_value_to_search_dispf" class="sb-search" value="<?php echo $data->filter->filters['rm_value_to_search']; ?>"></div>
                        <div class="filter-row"><input type="button" value="Search" onclick="resubmit_search(0)"></div>
                </div>


            </div>

            <!--*******Side Bar Ends*********-->
<form method="post" action="" name="rm_sent_emails_manage" id="rm_sent_emails_action_form">
    <input type="hidden" name="rm_search_state" value="<?php echo $data->search_state_query; ?>" id="rm_search_state_input_field" />
                <input type="hidden" name="rm_slug" value="" id="rm_slug_input_field" />
                <table>
                    <?php 
                    if ($data->mails)
                    {
                        ?>
                        <tr>
<!--                            <th>&nbsp;</th>-->
                            <th>&nbsp;</th>
                            <th><?php echo RM_UI_Strings::get("LABEL_EMAIL_TO"); ?></th>
                            <th><?php echo RM_UI_Strings::get("LABEL_EMAIL_SUB"); ?></th>
                            <th><?php echo RM_UI_Strings::get("LABEL_EMAIL_BODY"); ?></th>
                            <th><?php echo RM_UI_Strings::get("ACTION"); ?></th></tr>

                        <?php
                       
                        if (is_array($data->mails))
                            foreach ($data->mails as $mail):
                        ?>
                                <tr>
                                    <td>
                                        <input class="rm_checkbox_group" type="checkbox" value="<?php echo $mail->mail_id; ?>" name="rm_selected[]">
                                    </td>
<!--                                    <td>
                                        <img  class="rm_submission_icon" alt="" src="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . 'images/pending_payment.png'; ?>">
                                    </td>-->
                                    <td class="rm_data">
                                        <?php
                                            echo $mail->to;
                                        ?>
                                    </td>
                                    <td class="rm_data">
                                        <?php
                                            echo strip_tags(htmlspecialchars_decode($mail->sub));
                                        ?>
                                    </td>
                                    <td class="rm_data">
                                        <?php
                                            echo strip_tags(htmlspecialchars_decode($mail->body));
                                        ?>
                                    </td>
                                    <td>
                                        <a href="?page=rm_sent_emails_view&rm_search_state=<?php echo urlencode($data->search_state_query); ?>&rm_sent_email_id=<?php echo $mail->mail_id; ?>"><?php echo RM_UI_Strings::get("VIEW"); ?></a>
                                    </td>
                                </tr>

                                <?php
                            endforeach;
                        ?>
                        <?php
                    }elseif ($data->filter->searched)
                    {
                        ?>
                        <tr><td>
                        <?php echo RM_UI_Strings::get('MSG_NO_SENT_EMAIL_MATCHED'); ?>
                            </td></tr>
                    <?php
                    } else
                    {
                        ?>
                        <tr><td>
                        <?php echo RM_UI_Strings::get('MSG_NO_SENT_EMAIL_INTERVAL'); ?>
                            </td></tr>
    <?php }
    ?>
                </table>
</form>
        </div>
        <?php
        echo $data->filter->render_pagination();
    }else
    {
        ?><div class="rmnotice-container">
            <div class="rmnotice">
        <?php echo RM_UI_Strings::get('MSG_NO_SENT_EMAILS_MAN'); ?>
            </div>
        </div>
    <?php
}
?>
    <?php     
    //$rm_promo_banner_title = "Unlock export submissions and more by upgrading";
    include RM_ADMIN_DIR.'views/template_rm_promo_banner_bottom.php';
    ?>
    
    
</div>
    

<pre class='rm-pre-wrapper-for-script-tags'><script>
function resubmit_search()
{
    var interval_filter = jQuery('input[name=filter_between_dispf]:checked').val();
    if(typeof interval_filter != "undefined")
    {
        jQuery('#rm_interval_input_field').val(interval_filter);
        
        if(interval_filter == 'custom')
        {
            jQuery('#rm_fromdate_input_field').val(jQuery('input[name=rm_custom_subfilter_date_from_dispf]').val());
            jQuery('#rm_uptodate_input_field').val(jQuery('input[name=rm_custom_subfilter_date_upto_dispf]').val());
        }            
    }
    jQuery('#rm_field_to_search_input_field').val(jQuery('[name=rm_field_to_search_dispf]').val());
    jQuery('#rm_value_to_search_input_field').val(jQuery('input[name=rm_value_to_search_dispf]').val());
    jQuery('#rm_form_id_input_field').val(jQuery('#rm_form_dropdown').val());
    jQuery("#rm_sent_emails_search_form").submit();
}

function reset_search()
{
    jQuery('#rm_interval_input_field').val('all');
    jQuery('#rm_fromdate_input_field').val('');
    jQuery('#rm_uptodate_input_field').val('');
    jQuery('#rm_field_to_search_input_field').val('to');
    jQuery('#rm_value_to_search_input_field').val('');
    jQuery('#rm_form_id_input_field').val(jQuery('#rm_form_dropdown').val());
    jQuery("#rm_sent_emails_search_form").submit();
}
</script></pre>