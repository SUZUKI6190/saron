<?php
namespace ui\staff;

class FlowYoyakuDateTime extends FlowYoyakuBase
{

    protected function init_inner()
    {
       
    }

	private function param_list()
	{
		$fc = FlowYoyakuContext::get_instance();
		return [
            $fc->yoyaku_date,
            $fc->yoyaku_date,
            $fc->yoyaku_time,
            $fc->yoyaku_time
        ];
	}

    public function clear_temp_data()
    {
		foreach($this->param_list() as $p){    
			if(!isset($_POST[$p->get_key()])){
				$p->clear();
			}
        }
    }

    protected function input_check_inner()
    {
        return count(array_filter($this->param_list(), function($p){
            if(!isset($_POST[$p->get_key()])){
                $p->clear();
            }

            return !$p->is_set();
        })) == 0;
    }

    protected  function enable_save_inner() : bool
    {
        $fc = FlowYoyakuContext::get_instance();
        return $fc->yoyaku_date->is_set() && $fc->yoyaku_time->is_set();
    }

    protected function view_inner()
    {
        $fc = FlowYoyakuContext::get_instance();
        $date_name = $fc->yoyaku_date->get_key();
        $date_value = $fc->yoyaku_date->get_value();
        $time_name = $fc->yoyaku_time->get_key();
        $time_value = $fc->yoyaku_time->get_value();
        $bikou_name = $fc->consultation->get_key();
        $bikou_value = $fc->consultation->get_value();

        $view_is_firsit_visit_radio = function($text, $value){
            $fc = FlowYoyakuContext::get_instance();
            $is_first_visit_name = $fc->is_first_visit_check->get_key();
            $checked = '';
            if( $fc->is_first_visit_check->get_value() == $value){
                $checked= 'checked';
            }
            ?>
            <input type='radio' name='<?php echo $is_first_visit_name; ?>' value='<?php echo $value; ?>' <?php echo $checked; ?>><?php echo $text; ?>
            <?php
        };
        

        $min_date = new \DateTime();
        $min_time = new \DateTime('9:00');
?>
        <div class='line'>
            <h2>開始日</h2>
            <input type='date' name='<?php echo $date_name; ?>' value='<?php echo $date_value; ?>' min='<?php echo $min_date->format("Y-m-d"); ?>'>
            <h2>開始時刻</h2>
            <input type='time' name='<?php echo $time_name; ?>' value='<?php echo $time_value; ?>' min='<?php echo $min_time->format("H:i"); ?>'>
            <h2>ご来店</h2>
            <?php
            $view_is_firsit_visit_radio('初めて', 1);
            $view_is_firsit_visit_radio('再来店', 0);
            ?>
            <h2>ご相談・お問合わせ等</h2>
            <textarea class='edit_comment' name='<?php echo $bikou_name; ?>'><?php echo $bikou_value; ?></textarea>
        </div>
<?php
    }
}
?>