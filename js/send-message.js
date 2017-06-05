function toggle_show(op_text, clse_text, area_id, btn_id, input_id, hdn_id)
{
    var area = document.getElementById(area_id);
    var btn = document.getElementById(btn_id);
    var input = document.getElementById(input_id);
    var hdn = document.getElementById(hdn_id);
    if(hdn.value == 1){
        area.className = "critera_input_area";
        btn.innerText = op_text;
        hdn.value=0;
    }else{
        area.className = "critera_input_area hide";
        btn.innerText = clse_text;
        hdn.value=1;
    }
}