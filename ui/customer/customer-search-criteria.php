<?php
namespace ui\customer;

require_once('customer-search-item.php');
require_once(dirname(__FILE__)."/../util/control-util.php");

class KanjiNameItem extends SearchItem
{
	private static $post_key = 'name_kanji';
	
	public function view()
	{
		?>
			<h2>名前(漢字):</h2>
			<div>
			<input type = 'text' name='name_kanji' />
			</div>
		<?php
	}

	public function exist_criteria()
	{
		return !$this->is_empty_post(self::$post_key);
	}

	public function get_criteria_query()
	{
		$ret = [];

		if(!$this->is_empty_post(self::$post_key))
		{
			$param = $this->get_post(self::$post_key);
			$query = $this->create_decparam(self::$post_key);
			$ret[] = "$query = '$param'";
		}

		return $ret;
	}
}

class KanaNameItem extends SearchItem
{
	private static $post_key = 'name_kana';
	
	public function view()
	{
		?>
			<h2>名前(カナ):</h2>
			<div>
				<input type = 'text' name='name_kana' />
			</div>
		<?php
	}

	public function exist_criteria()
	{
		return !$this->is_empty_post(self::$post_key);
	}

	public function get_criteria_query()
	{
		$ret = [];

		if(!$this->is_empty_post(self::$post_key))
		{
			$param = $this->get_post(self::$post_key);
			$query = $this->create_decparam(self::$post_key);
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
			<h2>電話番号:</h2>
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
			<h2>email:</h2>
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
			<h2>年代:</h2>
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
			<h2>性別:</h2>
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
		<h2><?php echo $this->_text; ?>：</h2>
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
		<h2>職業：</h2>
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
		<h2>DM可：</h2>

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