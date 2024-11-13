<?php
class AcfBidirectionalRelation {

    private $_allowed_fields;

    private $_is_running;

    function __construct() {
        add_action('admin_init', [$this, 'init']);
    }

    public function init() {
        $this->set_allowed_fields();
        $this->run_filters();
    }

    private function run_filters() {
        if(is_iterable($this->_allowed_fields)) {

            array_walk($this->_allowed_fields, function($filter) {
                add_filter("acf/update_value/name={$filter}", [$this, 'manage_relationship'], 10, 3);
            });

        }
    }

    public function manage_relationship($value, $post_id, $field) {

        // If allready running
        if(!empty($this->is_running())) return $value;

        // Set running to true
        $this->_is_running = true;

        // Add new relationships (if needed)
        $this->check_add_relationship($value, $post_id, $field);

        // Remove old relationships (if needed)
        $this->check_remove_relationship($value, $post_id, $field);

        // Set running to false
        $this->_is_running = false;

        // Return the value to the field
        return $value;

    }

    private function is_running() {

        if(!empty($this->_is_running)) {
            return true;
        }

        return false;
    }

    private function set_allowed_fields() {
        $this->_allowed_fields = apply_filters('rokit/acf/bidirectional/fields', []);
    }

    private function check_add_relationship($org_value, $org_post_id, $org_field) {

        // Loop over selected posts and add related post ID
        if(is_array($org_value)) {
            foreach($org_value as $related_post_id) {
                $this->add_multiple_relationship($org_value, $org_post_id, $org_field, $related_post_id);
            }
        } else {
            $this->add_singular_relationship($org_value, $org_post_id, $org_field, $org_value);
        }
    }

    private function check_remove_relationship($org_value, $org_post_id, $org_field) {

        // Get the old value of the original field
        // This is needed to see if any relations are removed
        $org_old_value = get_field($org_field['name'], $org_post_id, false);

        if(is_array($org_old_value)) {
            foreach($org_old_value as $related_post_id) {
                $this->remove_multiple_relationship($org_value, $org_post_id, $org_field, $related_post_id);
            }
        } else {
            $this->remove_singular_relationship($org_value, $org_post_id, $org_field, $org_old_value);
        }
    }

    private function add_singular_relationship($org_value, $org_post_id, $org_field, $related_post_id) {

        $org_post_type = get_post_type($org_post_id);

        // Load posttype from from related post
        $related_post_type  = get_post_type($related_post_id);

        // Format field name for related post field
        $related_field_name = $this->get_field_name($related_post_type, $org_post_type);

        // Load existing field value from related post
        $related_post_value = get_field($related_field_name, $related_post_id, false);

        // // If $related_post_value is empty create an array for it
        // $related_post_value = !empty($related_post_value) ? $related_post_value : [];

        // Continue early if the current $org_post_id is already found in $related_post_value
        if($related_post_id == $related_post_value) return;

        // Append the current $org_post_id to $related_post_value
        // $related_post_value = $org_post_id;

        // Update the selected post's value
        update_field($related_field_name, $org_post_id, $related_post_id);

    }

    private function add_multiple_relationship($org_value, $org_post_id, $org_field, $related_post_id) {

        $org_post_type = get_post_type($org_post_id);

        // Load posttype from from related post
        $related_post_type  = get_post_type($related_post_id);

        // Format field name for related post field
        $related_field_name = $this->get_field_name($related_post_type, $org_post_type);

        // Load existing field value from related post
        $related_post_value = get_field($related_field_name, $related_post_id, false);

        // If $related_post_value is empty create an array for it
        $related_post_value = !empty($related_post_value) ? $related_post_value : [];

        // Continue early if the current $org_post_id is already found in $related_post_value
        if(in_array($org_post_id, $related_post_value)) return;

        // Append the current $org_post_id to $related_post_value
        $related_post_value[] = $org_post_id;

        // Update the selected post's value
        update_field($related_field_name, $related_post_value, $related_post_id);

    }

    private function remove_multiple_relationship($org_value, $org_post_id, $org_field, $related_post_id) {

        $org_post_type = get_post_type($org_post_id);

        // Return if $related_post_id is not removed from $org_old_value
        if(is_array($org_value) && in_array($related_post_id, $org_value) ) return;

        // Load posttype from from related post
        $related_post_type  = get_post_type($related_post_id);

        // Format field name for related post field
        $related_field_name = $this->get_field_name($related_post_type, $org_post_type);

        // Load existing field value from related post
        $related_post_value = get_field($related_field_name, $related_post_id, false);

        // Return is if $related_post_value is empty
        if(empty($related_post_value)) return;

        // Find the position of $related_post_id within $related_post_value
        // This is needed so we can remove it
        $related_post_id_pos = array_search($org_post_id, $related_post_value);

        // Remove $related_post_id from $related_post_value
        unset($related_post_value[$related_post_id_pos]);

        // Update the $related_post_value
        update_field($related_field_name, $related_post_value, $related_post_id);

    }

    private function remove_singular_relationship($org_value, $org_post_id, $org_field, $related_post_id) {

        $org_post_type = get_post_type($org_post_id);

        // Return if $related_post_id is not removed from $org_old_value
        if($related_post_id == $org_value) return;

        // Load posttype from from related post
        $related_post_type  = get_post_type($related_post_id);

        // Format field name for related post field
        $related_field_name = $this->get_field_name($related_post_type, $org_post_type);

        // Load existing field value from related post
        $related_post_value = get_field($related_field_name, $related_post_id, false);

        // Return is if $related_post_value is empty
        if(empty($related_post_value)) return;

        // Update the $related_post_value
        update_field($related_field_name, '', $related_post_id);

    }

    private function get_field_name($related_post_type, $org_post_type) {
        return sprintf('%s_%s_relation', $related_post_type, $org_post_type);
    }
}

// Init the bidirectional relationship class
$AcfBidirectionalRelation = new AcfBidirectionalRelation();