<?php
namespace ui\publish;

interface IEdit
{
	function view();
	function save();
	function is_save() : bool;
}
?>