<?php
namespace ui;

interface IEdit
{
	function view();
	function save();
	function is_save() : bool;
}
?>