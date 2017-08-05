<?php
namespace ui\staff;

class FlowYoyakuCustomer extends FlowYoyakuBase
{
    private $_customer_list;

    protected function init_inner()
    {
        $this->_customer_list = \business\facade\GetCustomers('');
    }

    protected function view_inner()
    {
?>
        <table class='customer_tbl'>
            <thead>
                <tr>
                    <th></th>
                    <th>名前</th>
                    <th>email</th>
                </tr>
            </thead>
<?php
        $fc = FlowYoyakuContext::get_instance();
        $input_name =  $fc->customer_id->get_key().'[]';
        foreach($this->_customer_list as $c)
        {?>
            <tr>
                <td><input type='radio' name='<?php echo $input_name;?>'></td>
                <td><?php echo $c->name_kanji; ?></td>
                <td><?php echo $c->email;?></td>
            <tr>
        <?php
        }
?>
        </table>
<?php
    }
}
?>