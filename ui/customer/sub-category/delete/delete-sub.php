<?php
namespace ui\customer;
use \business\entity\Config;
use \business\facade;

class DeleteSub extends CustomerSubBase
{	
	private static $month_list = [3,6,9,12,15];
	private function setup_cron()
	{
	}

	public function view()
	{
		$c = Config::get_instance();

		if(!empty($_POST["confirm_cron"]))
		{
			$value = $_POST["selected_month"];
			$c->IntervalDeleateCustomers->save_value($value);
		}
		$saved_month = $c->IntervalDeleateCustomers->get_value();
		?>

		<form method="post" action=""　>
		<div class="input_form centering">
			<div class = "delete_item">
				<span>
					最終来店日から
				</span><br>
				<select name='selected_month'>
				<?php
				foreach(DeleteSub::$month_list as $month)
				{
					if($month == $saved_month)
					{
						echo "<option value='$month' selected>$month</option>";	
					}else{
						echo "<option value='$month'>$month</option>";	
					}
				}
				?>
				</select>か月<br>
				<span>
					経過したお客様情報を自動で削除
				</span>
			<div>
			
			<div class = "bottom_button_area">
				<?php \ui\util\submit_button('確定する', "confirm_cron"); ?>
			</div>
		</div>
		</form>
		<?php
	
	}
	
	public function get_name()
	{
		return "delete";
	}
	
	public function get_title_name()
	{
		return "一括削除";
	}
}


?>