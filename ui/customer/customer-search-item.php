<?php
namespace ui\customer;
require_once('customer-view-table.php');
abstract class SearchItem
{
	public abstract function exist_criteria();
	public abstract function get_criteria_query();
	public abstract function view();
	protected function get_post($key)
	{
		return $_POST[$key];
	}
	
	protected function is_empty_post($key)
	{
		return empty($_POST[$key]);
	}
	
	protected function create_aesparam($param)
	{
		$password = \business\entity\Customer::GetPassword();
		return "CONVERT(AES_ENCRYPT($param, '$password') USING utf8)";
	}
}

class SearchitemRepeater
{
	private $_item_list;
	private $_controlContext;
	public function __construct($item_list, $c)
	{
		$this->_item_list = $item_list;
		$this->_controlContext = $c;
	}
	
	public function create_where_query()
	{
				
		if(count($this->_item_list) == 0)
		{
			return '';
		}

		$exits_list = array_filter($this->_item_list, function($item){
			return $item->exist_criteria();
		});
		
		if(count($exits_list) == 0)
		{
			return '';
		}

		$add = 'where ';
		$strWhere = "";

		foreach($exits_list as $item)
		{
			foreach($item->get_criteria_query() as $q)
			{
				echo "$strWhere</br>";
				$strWhere = $strWhere.$add.$q;
				$add = ' and ';
			}
		}
		
		return $strWhere;
	}
	
	public function view_search_result()
	{
		$newUrl = $this->_controlContext->GetCustomerUrl()."/detail/new/";
		?>
		<form method = 'post' action='<?php echo $newUrl; ?>'>
			<input type='submit' value="新規登録" /></br>
		<form>
		<?php

		create_customer_view($this->_controlContext,  $this->create_where_query());

	}
	
	public function view_search_form()
	{
		$search_result_url = $this->_controlContext->GetCustomerUrl()."/search/result/";
		?>
		<form method="post" name='customer_search' value="customer_search" action='<?php echo $search_result_url; ?>' >
		<div>
			<input type='submit'　 value="検索する" />
		</div>
		<?php $this->repeat(); ?>
		</form>
		<?php
	}
	
	private function repeat(){
	?>
		<div class='area'>
		<?php

		foreach($this->_item_list as $item)
		{
			?>
			<div class='search_item_line'>
			<?php
			$item->view();
			?>
			</div>
			<?php
		}

		?>
		</div>
		<?php
	}
}

?>