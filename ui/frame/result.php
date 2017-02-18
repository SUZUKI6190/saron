<?php
namespace ui\frame;

class Result
{
	public $id;
	private $_regist_finish = false;
	public $message;
	
	public function set_regist_state(bool $value )
	{
		$this->_regist_finish  = $value;
	}
	
	public function is_regist_finished() : bool
	{
		return $this->_regist_finish;
	}
}

function view_result(Result $r)
{
?>
	<div class="result_wrap">
		<span>
			<?php echo $r->message; ?>
		</span>
	</div>
<?php
}

?>