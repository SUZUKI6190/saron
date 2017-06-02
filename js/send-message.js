function toggle_show(op_text, clse_text, area_id, btn_id, input_id)
{
    var area = document.getElementById(area_id);
    var btn = document.getElementById(btn_id);
    var input = document.getElementById(input_id);
    
    if(input.hasAttribute("disabled")){
        area.className = "critera_input_area";
        area.style.display= "";
        btn.innerText = op_text;
        input.value = input.tempValue;
        input.removeAttribute("disabled");
    }else{
        area.className = "critera_input_area hide";
        btn.innerText = clse_text;
        input.tempValue = input.value;
        input.value = "";
        input.setAttribute("disabled", "disabled");
    }
}