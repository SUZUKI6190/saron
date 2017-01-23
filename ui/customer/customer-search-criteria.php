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
			$param = $this->get_post(KanjiNameItem::$post_key_last);
			$query = $this->create_decparam(KanjiNameItem::$post_key_last);
			$ret[] = "$query = '$param'";
		}

		if(!$this->is_empty_post(KanjiNameItem::$post_key_first))
		{
			$param = $this->get_post(KanjiNameItem::$post_key_first);
			$query = $this->create_decparam(KanjiNameItem::$post_key_first);
			$ret[] = "$query = '$param'";
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
			$param = $this->get_post(KanaNameItem::$post_key_last);
			$query = $this->create_decparam(KanaNameItem::$post_key_last);
			$ret[] = "$query = '$param'";
		}

		if(!$this->is_empty_post(KanaNameItem::$post_key_first))
		{
			$param =$this->get_post(KanaNameItem::$post_key_first);
			$query = $this->create_decparam(KanaNameItem::$post_key_first);
			$ret[] = "$query = '$param'";
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
			$query= $this->create_decparam(PhoneNumItem::$post_key);
			$param = $this->get_post(PhoneNumItem::$post_key);
			$ret[] = "$query = '$param'";
		}
		
		return $ret;
	}
}


class EmailItem extends SearchItem
{
	private static $post_key = 'email';
	
	public function view()
	{
		?>
			<span>email:</span>
			<input type = 'text' name='<?php echo EmailItem::$post_key; ?>' />
		<?php
	}

	public function exist_criteria()
	{
		return !$this->is_empty_post(EmailItem::$post_key);
	}

	public function get_criteria_query()
	{
		$ret = [];

		if(!$this->is_empty_post(EmailItem::$post_key))
		{
			$query= $this->create_decparam(EmailItem::$post_key);
			$param = $this->get_post(EmailItem::$post_key);
			$ret[] = "$query = '$param'";
		}
		
		return $ret;
	}
}

class OldItem extends SearchItem
{
	private static $post_key = 'old';
	
	public function view()
	{
		?>
			<span>年代:</span>
			<select name='<?php echo OldItem::$post_key; ?>' id="ageId" class="">
				<option value="none"></option>
				<option value="10">10代</option>
				<option value="20">20代</option>
				<option value="30">30代</option>
				<option value="40">40代</option>
				<option value="50">50代</option>
				<option value="60">60代</option>
				<option value="70">70代</option>
				<option value="80">80代</option>
				<option value="90">90代</option>
				<option value="100">100代</option>
			</select>
		<?php
	}

	public function exist_criteria()
	{
		return $this->get_post(OldItem::$post_key) != "none";
	}

	public function get_criteria_query()
	{
		$ret = [];

		$query= $this->create_decparam_unsigned(OldItem::$post_key);
		$param = $this->get_post(OldItem::$post_key);
		$max = $param + 10;
		$ret[] = "$param <= $query";
		$ret[] = "$query < $max";
		return $ret;
	}
}


class SexItem extends SearchItem
{
	private static $post_key = 'sex';
	
	public function view()
	{
		?>
			<span>性別:</span>
			<select name="sex" id="sex">
				<option value='None'></option>
				<option value='M'>男性</option>
				<option value='F'>女性</option>
			</select>
		<?php
	}

	public function exist_criteria()
	{
		return $this->get_post(SexItem::$post_key) != "None";
	}

	public function get_criteria_query()
	{
		$ret = [];

		$query= $this->create_decparam(SexItem::$post_key);
		$param = $this->get_post(SexItem::$post_key);
		$ret[] = "$query = '$param'";
		
		return $ret;
	}
}

?>