<?php

// Set the namespace
namespace Rokit\Controllers\Terms;

class TreatmentBodypartTerm extends Term {

    public $TermClass = 'Rokit\Controllers\Taxonomies\TreatmentBodypartTerm';

	public function __toString() {
		return $this->slug;
	}

}
