<?php

// Set the namespace
namespace Rokit\Controllers\Terms;

class SurgeryDayTypeTerm extends Term {

    public $TermClass = 'Rokit\Controllers\Taxonomies\SurgeryDayTypeTerm';

    var $_intro;

    var $_items;

    public function intro() {

        if( ! $this->_intro ) {
            $this->_intro = $this->get_field('surgery_day_taxonomy_intro', $this->acf_id());
        }

        return $this->_intro;
    }

    public function items() {
        if( ! $this->_items ) {

            $data = [];
            $meta_value = $this->lang_id() == 183 ? 'surgery_day_date_end' : 'surgery_day_date';

            $items = $this->posts([
                'posts_per_page' => -1,
                'meta_key' => $meta_value,
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'meta_query' =>  [
                    [
                        'key' => $meta_value,
                        'value' => date('Ymd'),
                        'type' => 'DATE',
                        'compare' => '>='
                    ]
                ],
            ]);

            foreach ($items as $item) {
                if (!array_key_exists($item->treatment->slug, $data)) {
                    $data[$item->treatment->slug]['treatment'] = $item->treatment;
                }
                $data[$item->treatment->slug]['items'][$item->id] = $item;
            }

            $this->_items = $data;
        }

        return $this->_items;
    }

}
