<?php
namespace ui\frame;

class EmptyFrameImplementor extends ManageFrameImplementor
{
    public function get_sub_category_list()
    {
        return [];
    }

    public function get_selected_main_category()
    {
        return new \ui\frame\MainCategory('', '', '');
    }

    public function is_empty():bool
    {
        return true;
    }

    public function view_main()
    {

    }
}

?>