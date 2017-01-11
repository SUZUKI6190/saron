<?php

	function GetCustomerAll()
	{
		$test1 = new Customer();
		$test1->name_kana = "aaa";
		$test2 = new Customer();
		
		return [$test1,$test2];
	}
?>