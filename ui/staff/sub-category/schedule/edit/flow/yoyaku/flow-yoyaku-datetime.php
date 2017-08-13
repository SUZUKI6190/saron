<?php
namespace ui\staff;

class FlowYoyakuDateTime extends FlowYoyakuBase
{

    protected function init_inner()
    {
       
    }

    protected function input_check_inner()
    {
        $fc = FlowYoyakuContext::get_instance();
        $param_list = [
            $fc->yoyaku_date,
            $fc->yoyaku_date,
            $fc->yoyaku_time,
            $fc->yoyaku_time
        ];

        return count(array_filter($param_list, function($p){
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
?>
        <div class='line'>
            <h2>開始日</h2>
            <input type='date' name='<?php echo $date_name; ?>' value='<?php echo $date_value; ?>'>
            <h2>開始時刻</h2>
            <input type='time' name='<?php echo $time_name; ?>' value='<?php echo $time_value; ?>'>
        </div>
<?php
    }
}
?>