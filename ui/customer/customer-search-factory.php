<?php
namespace ui\customer;

require_once('customer-search-item.php');

class KanjiNameItem extends SearchItem
{
	private static $post_key = 'name_kanji_last';

	protected function view()
	{
		?>
			<input type = 'text' name='kanji_name_last' />
		<?php
	}

	protected function exist_criteria()
	{
		return is_empty_post($post_key);
	}

	protected function get_criteria_query()
	{
		$param = $this->get_post($post_key);
		return "name_kanji_last = '$param'";
	}
}

class CustomerSearchItemFactory
{
	public static function CreateKanjiName()
	{
			return new KanjiNameItem();
	}
}

?>