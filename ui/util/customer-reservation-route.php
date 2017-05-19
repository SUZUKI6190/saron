<?php
namespace ui\util;

class RouteSelect
{
    private $_name, $_selected_id;
    const route_table = [
        "電話",
        "Line",
        "メール"
    ];

    public function set_selected_id($i)
    {
        $this->_selected_id = $i;
    }

    public function set_name(string $name)
    {
        $this->_name = $name;
    }

    public function get_value() : string
    {
        return $_POST[$this->_name];
    }

    public function view()
    {
        ?>
            <select name = '<?php echo $this->_name; ?>'>
            <?php
            $i = 0;
            foreach(self::route_table as $r)
            {
                if($this->_selected_id == $i){
                    echo "<option value='$i' selected>$r</option>";
                }else{
                    echo "<option value='$i'>$r</option>";
                }
                $i = $i + 1;
            }
            ?>
            </select>
        <?php
    }
}

?>