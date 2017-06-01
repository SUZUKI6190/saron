function toggle_show(op_text, clse_text, area_id, btn_id, hdn_id, input_id)
{
    var area = document.getElementById(area_id);
    var btn = document.getElementById(btn_id);
    var hdn= document.getElementById(hdn_id);
    var hdn= document.getElementById(input_id);

    if(area.style.display == "none"){
        area.style.display= "";
        btn.innerText = op_text;
        hdn.value = "true";
    }else{
        area.style.display= "none";
        btn.innerText = clse_text;
        hdn.vlue = "false";
    }
}