<?php
namespace ui\sales;

class DataSet
{
     //凡例
    public $label;
    //背景色
    public $backgroundColor;
    //枠線の色
    public $borderColor;
    //グラフのデータ
    public $data = [];
}

class GraphData
{
    public $dataset_list = [];
    public $labels = [];

    public function serialize_json() : string
    {
        return json_encode($this);
    }
}

?>