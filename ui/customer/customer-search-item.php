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
	
	protected function create_decparam($param)
	{
		$password = \business\entity\Customer::GetPassword();
		return "CONVERT(AES_DECRYPT($param, '$password') USING utf8)";
	}
	protected function create_decparam_unsigned($param)
	{
		$password = \business\entity\Customer::GetPassword();
		return "cast(CONVERT(AES_DECRYPT($param, '$password') USING utf8) as SIGNED)";
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

		$meaged_list = [];
		foreach($this->_item_list as $list)
		{
			$meaged_list = array_merge($meaged_list, $list);
		}
		
		$exits_list = array_filter($meaged_list, function($item){
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
		create_customer_view($this->_controlContext,  $this->create_where_query());

	}
	
	public function view_search_form()
	{
		$search_result_url = $this->_controlContext->GetCustomerUrl()."/search/result/";
		?>
		<div class="wrap_search">
			<form method="post" name='customer_search' value="customer_search" action='<?php echo $search_result_url; ?>' >
			<?php \ui\util\submit_button("検索する"); ?>
			<?php $this->repeat(); ?>
			</form>
		</div>
		<?php
	}
	
	private function repeat(){
	
		?>
		<div class="search_detail">
		<?php
		foreach($this->_item_list as $items)
		{
			?>
			<div class='area'>
			<?php
			foreach($items as $item)
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
		?>
		</div>
		<?php
	}
}
?>