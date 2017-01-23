<?php
namespace ui\customer;

require_once('customer-search-item.php');

class KanjiNameItem extends SearchItem
{
	private static $post_key_last = 'name_kanji_last';
	private static $post_key_first = 'name_kanji_first';
	
	public function view()
	{
		?>
			<span>名前(漢字):</span>
			<input type = 'text' name='name_kanji_last' />
			<input type = 'text' name='name_kanji_first' />
		<?php
	}

	public function exist_criteria()
	{
		return !$this->is_empty_post(KanjiNameItem::$post_key_last) or !$this->is_empty_post(KanjiNameItem::$post_key_first);
	}

	public function get_criteria_query()
	{
		$ret = [];

		if(!$this->is_empty_post(KanjiNameItem::$post_key_last))
		{
			$param = $this->create_aesparam($this->get_post(KanjiNameItem::$post_key_last));
			$ret[] = "name_kanji_last = $param";
		}

		if(!$this->is_empty_post(KanjiNameItem::$post_key_first))
		{
			$param = $this->create_aesparam($this->get_post(KanjiNameItem::$post_key_first));
			$ret[] = "name_kanji_first = $param";
		}
		
		return $ret;
	}
}


class KanaNameItem extends SearchItem
{
	private static $post_key_last = 'name_kana_last';
	private static $post_key_first = 'name_kana_first';
	
	public function view()
	{
		?>
			<span>名前(カナ):</span>
			<input type = 'text' name='name_kana_last' />
			<input type = 'text' name='name_kana_first' />
		<?php
	}

	public function exist_criteria()
	{
		return !$this->is_empty_post(KanaNameItem::$post_key_last) or !$this->is_empty_post(KanaNameItem::$post_key_first);
	}

	public function get_criteria_query()
	{
		$ret = [];

		if(!$this->is_empty_post(KanaNameItem::$post_key_last))
		{
			$param = $this->create_aesparam($this->get_post(KanaNameItem::$post_key_last));
			$ret[] = "name_kana_last = $param";
		}

		if(!$this->is_empty_post(KanaNameItem::$post_key_first))
		{
			$param = $this->create_aesparam($this->get_post(KanaNameItem::$post_key_first));
			$ret[] = "name_kana_first = $param";
		}
		
		return $ret;
	}
}


class PhoneNumItem extends SearchItem
{
	private static $post_key = 'phone_number';
	
	public function view()
	{
		?>
			<span>電話番号:</span>
			<input type = 'text' name='<?php echo PhoneNumItem::$post_key; ?>' />
		<?php
	}

	public function exist_criteria()
	{
		return !$this->is_empty_post(PhoneNumItem::$post_key);
	}

	public function get_criteria_query()
	{
		$ret = [];

		if(!$this->is_empty_post(PhoneNumItem::$post_key))
		{
			$query= $this->create_aesparam(PhoneNumItem::$post_key);
			$param = $this->get_post(PhoneNumItem::$post_key);
			$ret[] = "$query = '$param'";
		}
		
		return $ret;
	}
}


class CustomerSearchItemFactory
{
	public static function create_kanjiname()
	{
			return new KanjiNameItem();
	}
	
	public static function create_kananame()
	{
			return new KanaNameItem();
	}
	
	public static function create_phonenum()
	{
		return new PhoneNumItem();
	}
}

?>