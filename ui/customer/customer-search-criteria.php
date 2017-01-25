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
			<span class='search_item_name'>名前(漢字):</span>
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
			<span class='search_item_name'>名前(カナ):</span>
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
			<span class='search_item_name'>電話番号:</span>
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
		$query= $this->create_decparam(PhoneNumItem::$post_key);
		$param = $this->get_post(PhoneNumItem::$post_key);
		$ret[] = "$query = '$param'";		
		return $ret;
	}
}


class EmailItem extends SearchItem
{
	private static $post_key = 'email';
	
	public function view()
	{
		?>
			<span class='search_item_name'>email:</span>
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
			<span class='search_item_name'>年代:</span>
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
			<span class='search_item_name'>性別:</span>
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

class BirthdayItem extends SearchItem
{
	private static $post_from_day = 'from_day';
	private static $post_to_day = 'to_day';

	public function view()
	{
		?>
		<span class='search_item_name'>誕生日：</span>
		<input type = 'date' name='<?php echo BirthdayItem::$post_from_day; ?>' />
		<span>から</span>
		<input type = 'date' name='<?php echo BirthdayItem::$post_to_day; ?>' />
		<?php
	}

	public function exist_criteria()
	{
		return !$this->is_empty_post(BirthdayItem::$post_from_day) and !$this->is_empty_post(BirthdayItem::$post_to_day);
	}

	public function get_criteria_query()
	{
		$ret = [];

		$birthday_col = $this->create_decparam('birthday');
		$param_from= $this->get_post(BirthdayItem::$post_from_day);
		$ret[] = "$birthday_col  >= '$param_from'";
		
		$param_to= $this->get_post(BirthdayItem::$post_from_day);
		$ret[] = "$birthday_col  >= '$param_to'";
		
		return $ret;
	}
}


class OccupationItem extends SearchItem
{
	private static $post_occupation = 'occupation';

	public function view()
	{
		?>
		<span class='search_item_name'>職業：</span>
		<input type = 'text' name='<?php echo OccupationItem::$post_occupation; ?>' />
		<?php
	}

	public function exist_criteria()
	{
		return !$this->is_empty_post(OccupationItem::$post_occupation);
	}

	public function get_criteria_query()
	{
		$ret = [];
		$query= $this->create_decparam(OccupationItem::$post_occupation);
		$param = $this->get_post(OccupationItem::$post_occupation);
		$ret[] = "$query = '$param'";		
		return $ret;
	}
}


class EnabeleDMItem extends SearchItem
{
	private static $post_enable_dm = 'enable_dm';

	public function view()
	{
		?>
		<span class='search_item_name'>DM可：</span>
			<input type = 'radio' name='<?php echo EnabeleDMItem::$post_enable_dm; ?>' value="" checked/>指定なし
			<input type = 'radio' name='<?php echo EnabeleDMItem::$post_enable_dm; ?>' value="enable"/>可
			<input type = 'radio' name='<?php echo EnabeleDMItem::$post_enable_dm; ?>' value="disable"/>不可
		<?php
	}

	public function exist_criteria()
	{
		return $this->get_post(EnabeleDMItem::$post_enable_dm) != "";
	}

	public function get_criteria_query()
	{
		$ret = [];
		$param = $this->get_post(EnabeleDMItem::$post_enable_dm);
		if($param == "enable"){
			$ret[] = "enable_dm = '0'";	
		}else{
			$ret[] = "$enable_dm = '1'";	
		}
		return $ret;
	}
}


?>