<?php
namespace ui\staff;

class FlowYoyakuCustomer extends FlowYoyakuBase
{
    private $_customer_list;

    protected function init_inner()
    {
        $this->_customer_list = \business\facade\GetCustomers('');
    }

    protected function input_check_inner()
    {
        $fc = FlowYoyakuContext::get_instance();
        $param_list = [
            $fc->customer_id
        ];

        return count(array_filter($param_list, function($p){
            return !$p->is_set();
        })) == 0;
    }

    protected function enable_save_inner() : bool
    {
        $fc = FlowYoyakuContext::get_instance();
        return $fc->customer_id->is_set();
    }

    protected function view_inner()
    {
?>
        <div class='line'>
        <h2>お客様の選択</h2>
        <table class='customer_table'>
            <thead>
                <tr>
                    <th class='input'></th>
                    <th>名前</th>
                    <th>email</th>
                </tr>
            </thead>
<?php
        $fc = FlowYoyakuContext::get_instance();
        $input_name =  $fc->customer_id->get_key();
        foreach($this->_customer_list as $c)
        {
            $selected_id = $fc->customer_id->get_value();
            $checked = '';
            if($selected_id == $c->id){
                $checked = 'checked';
            }
        ?>
            <tr>
                <td><input type='radio' name='<?php echo $input_name;?>' value='<?php echo $c->id;?>' <?php echo $checked; ?>></td>
                <td><?php echo $c->name_kanji; ?></td>
                <td><?php echo $c->email;?></td>
            <tr>
        <?php
        }
?>
        </table>
        </div>
<?php
    }
}
?>