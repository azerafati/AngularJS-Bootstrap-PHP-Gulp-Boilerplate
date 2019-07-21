<?php

class Model {


	function __construct() {
		if (isset($this->id))
			$this->id = intval($this->id);
	}

	function setter($field, $variable, $vKey = null) {

		if (!$vKey) $vKey = $field;
		unset($this->{$field});
		if (isset($variable[$vKey])) {
			if ($variable[$vKey] != "")
				$this->{$field} = $variable[$vKey];
		}
	}

	protected function intVal($field) {
		if (is_array($field)) {
			foreach ($field as $fi) {
				if (isset($this->{$fi})) $this->{$fi} = intval($this->{$fi});
			}
		} else {
			if (isset($this->{$field})) $this->{$field} = intval($this->{$field});
		}
	}

	protected function json($field) {
		if (isset($this->{$field}))
			$this->{$field} = json_decode($this->{$field});
	}

	protected function floatVal($field) {
		if (is_array($field)) {
			foreach ($field as $fi) {
				if (isset($this->{$fi}))
					$this->{$fi} = floatval($this->{$fi});
			}
		} else {
			if (isset($this->{$field}))
				$this->{$field} = floatval($this->{$field});
		}
	}

	protected function boolean($field) {
		if (isset($this->{$field})) {
			$this->{$field} = filter_var($this->{$field}, FILTER_VALIDATE_BOOLEAN);
		}
	}
}
