<?php
namespace ui\customer;

require_once('customer-search-item.php');
require_once(dirname(__FILE__)."/../util/control-util.php");

class KanjiNameItem extends SearchItem
{
	private static $post_key_last = 'name_kanji_last';
	private static $post_key_first = 'name_kanji_first';
	
	public function view()
	{
		?>
			<div class='name'>名前(漢字):</div>
			<div>
			<input type = 'text' name='name_kanji_last' />
			<input type = 'text' name='name_kanji_first' />
			</div>
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
			<div class='name'>名前(カナ):</div>
			<div>
				<input type = 'text' name='name_kana_last' />
				<input type = 'text' name='name_kana_first' />
			</div>
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
			<div class='name'>電話番号:</div>
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
			<div class='name'>email:</div>
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
			<div class='name'>年代:</div>
			<div>
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
			</div>
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
			<div class='name'>性別:</div>
			<div>
			<select name="sex" id="sex">
				<option value='None'></option>
				<option value='M'>男性</option>
				<option value='F'>女性</option>
			</select>
			</div>
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

abstract class DayFromTo extends SearchItem
{
	protected $_from_day;
	protected $_to_day;
	protected $_text;
	public function __construct($name, $text)
	{
		$this->_text = $text;
		$this->_from_day = new \ui\util\view_date_input($name."_from");
		$this->_to_day = new \ui\util\view_date_input($name."_to");
	}
	public function view()
	{
		?>
		<div class='name'><?php echo $this->_text; ?>：</div>
		<div>
			<?php echo $this->_from_day->view(); ?>
			<span>から</span></br>
	
		<?php echo $this->_to_day->view(); ?>
		</div>
		<?php
		
	}

	public function exist_criteria()
	{
		return !$this->_from_day->is_empty() and !$this->_to_day->is_empty();
	}

}

class BirthdayItem extends DayFromTo
{
	public function __construct()
	{
		 parent::__construct("birth", "誕生日");

	}
	
	public function get_criteria_query()
	{
		$ret = [];

		$birthday_col = $this->create_decparam('birthday');
		$param_from= $this->_from_day->get_selected_value();
		$ret[] = "$birthday_col  >= '$param_from'";
		
		$param_to= $this->_to_day->get_selected_value();
		$ret[] = "$birthday_col  <= '$param_to'";
		
		return $ret;
	}
}

class LastVisitItem extends DayFromTo
{
	public function __construct()
	{
		 parent::__construct("last_visit_date", "最終来店日");

	}
	
	public function get_criteria_query()
	{
		$ret = [];

		$birthday_col = $this->create_decparam('last_visit_date');
		$param_from= $this->_from_day->get_selected_value();
		$ret[] = "$birthday_col  >= '$param_from'";
		
		$param_to= $this->_to_day->get_selected_value();
		$ret[] = "$birthday_col  <= '$param_to'";
		
		return $ret;
	}
}

class NextVisitItem extends DayFromTo
{
	public function __construct()
	{
		 parent::__construct("next_visit_reservation_date", "次回来店予定日");

	}
	
	public function get_criteria_query()
	{
		$ret = [];

		$birthday_col = $this->create_decparam('next_visit_reservation_date');
		$param_from= $this->_from_day->get_selected_value();
		$ret[] = "$birthday_col  >= '$param_from'";
		
		$param_to= $this->_to_day->get_selected_value();
		$ret[] = "$birthday_col  <= '$param_to'";
		
		return $ret;
	}
}

class OccupationItem extends SearchItem
{
	private static $post_occupation = 'occupation';

	public function view()
	{
		?>
		<div class='name'>職業：</div>
		<div>
		<input type = 'text' name='<?php echo OccupationItem::$post_occupation; ?>' />
		</div>
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
		<div class='name'>DM可：</div>

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