<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RM_Frontend_Field_File extends RM_Frontend_Field_Base
{
    protected $cached_att_ids = array();

    public function __construct($id, $label, $options, $page_no = 1, $is_primary = false, $extra_opts = null)
    {
        parent::__construct($id, 'File', $label, $options, $page_no, $is_primary, $extra_opts);
    }

    public function get_pfbc_field()
    {
       return null;
    }

    public function get_prepared_data($request)
    {
        $att_ids = $this->attach();
        
        $this_field_name = $this->get_field_name();

        $value = null;

        if(is_array($att_ids)||is_object($att_ids))
        foreach ($att_ids as $field_name => $att_id)
        {
            $value = array();

            if ($field_name == $this_field_name)
            {
                $value['rm_field_type'] = 'File';

                if (is_array($att_id))
                    foreach ($att_id as $abc)
                        $value[] = $abc;
                else
                    $value[] = $att_id;
            }
        }

        $data = new stdClass;
        $data->field_id = $this->get_field_id();
        $data->type = 'File';
        $data->label = $this->get_field_label();
        $data->value = $value;
        return $data;
    }
    
    protected function attach()
    {
        if(count($this->cached_att_ids) > 0)
        {
            return $this->cached_att_ids;
        }
        $attachment_ids = array();
        $attachment = new RM_Attachment_Service();
        $this_field_name = $this->get_field_name();
        
        if(!isset($_FILES[$this_field_name]) || !$_FILES[$this_field_name])
            return null;
        
        $files = $_FILES[$this_field_name];
        
        //Check for multifile field
        if(is_array($_FILES[$this_field_name]['name']))
        {
            $original_files = $_FILES;
            foreach ($files['name'] as $key => $value)
            {            
                if ($files['name'][$key])
                { 
                    $file = array( 
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key], 
                        'tmp_name' => $files['tmp_name'][$key], 
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    );

                    $_FILES = array ($this_field_name => $file); 
                    foreach ($_FILES as $file => $array)
                    {
                        $aid =  $attachment->media_handle_attachment($file, 0);             
                        if (is_wp_error($aid))
                            break;
                        else
                            $attachment_ids[$this_field_name][] = $aid;
                    }
                } 
            }
            $_FILES = $original_files;
        }
        else
        {
            $aid =  $attachment->media_handle_attachment($this_field_name, 0);

            if (is_wp_error($aid))
                return null;
            else
                $attachment_ids[$this_field_name] = $aid;
        }
        
        $this->cached_att_ids = $attachment_ids;
        return $attachment_ids;
    }

}
