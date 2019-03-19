<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RM_Frontend_Field_Base
{

    protected $field_id;
    protected $field_type;    //Element type
    protected $field_label;   //Second argument in PFBC field contructor
    //protected $field_value;   //Third argument (array or single val)
    protected $field_options; //Last array in PFBC construct
    protected $field_name;    //Name in the request variable
    protected $pfbc_field;
    protected $is_primary;
    protected $page_no;
    protected $primary_field_indices;
    protected $x_options;

    public function __construct($id, $type, $label, $options, $page_no = 1, $is_primary = false, $extra_opts = null)
    {
        $this->field_id = $id;
        $this->field_type = $type;
        $this->field_label = $label;
        //$this->field_value = $be_field->get_field_value();
        $this->field_options = $options;
        $this->field_name = $this->field_type . "_" . $this->field_id;
        $this->pfbc_field = null;
        $this->is_primary = $is_primary;
        $this->page_no = $page_no;
        $this->x_options = $extra_opts;
    }

    public function get_page_no()
    {
        return $this->page_no;
    }

    public function get_field_id()
    {
        return $this->field_id;
    }

    public function get_field_type()
    {
        return $this->field_type;
    }

    public function get_field_label()
    {
        return $this->field_label;
    }

    public function is_primary()
    {
        return $this->is_primary;
    }

//    public function get_field_value()
//    {
//        return $this->field_value;
//    }

    public function get_field_options()
    {
        return $this->field_options;
    }

    public function get_field_name()
    {
        return $this->field_name;
    }

    public function set_field_name($field_name)
    {
        $this->field_name = $field_name;
    }

    public function set_field_label($field_label)
    {
        $this->field_label = $field_label;
    }

//    public function set_field_value($field_value)
//    {
//        $this->field_value = $field_value;
//    }

    public function set_field_options($field_options)
    {
        $this->field_options = $field_options;
    }

    public function render()
    {
        $this->get_pfbc_field();
        $this->pfbc_field->render();
    }

    public function is_valid()
    {
        $this->get_pfbc_field();
        $this->pfbc_field->isValid();
    }

    //This should be called and added to PFBC form and then rendered.
    public function get_pfbc_field()
    {
        if ($this->pfbc_field)
            return $this->pfbc_field;
        else
        {
            $class_name = "Element_" . $this->field_type;
            
            // Check if this is primary email field (To implement the real time validation)
            if(strtolower($this->field_type)=="email" && (int) $this->is_primary==1) 
                $class_name= "Element_UserEmail";
            
            $label = $this->get_formatted_label();
            $this->pfbc_field = new $class_name($label, $this->field_name, $this->field_options);
            return $this->pfbc_field;
        }
    }

    public function get_prepared_data($request)
    {
        $data = new stdClass;
        $data->field_id = $this->get_field_id();
        $data->type = $this->get_field_type();
        $data->label = $this->get_field_label();
        $data->value = isset($request[$this->field_name]) ? $request[$this->field_name] : null;
        return $data;
    }

    protected function get_formatted_label()
    {
        if (isset($this->x_options->icon) && $this->x_options->icon->codepoint)
        {
            if ($this->x_options->icon->shape == 'square')
                $radius = '0px';
            else if ($this->x_options->icon->shape == 'round')
                $radius = '100px';
            else if ($this->x_options->icon->shape == 'sticker')
                $radius = '4px';

            $bg_r = intval(substr($this->x_options->icon->bg_color, 0, 2), 16);
            $bg_g = intval(substr($this->x_options->icon->bg_color, 2, 2), 16);
            $bg_b = intval(substr($this->x_options->icon->bg_color, 4, 2), 16);
            $bg_a = isset($this->x_options->icon->bg_alpha) ? $this->x_options->icon->bg_alpha : 1;

            $icon_style = "style=\"padding:5px;color:#{$this->x_options->icon->fg_color};background-color:rgba({$bg_r},{$bg_g},{$bg_b},{$bg_a});border-radius:{$radius};\"";
            return '<span><i class="material-icons rm_front_field_icon"' . $icon_style . ' id="id_show_selected_icon">' . $this->x_options->icon->codepoint . '</i></span>' . $this->field_label;
        } else
            return $this->field_label;
    }

}
