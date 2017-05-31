function toggle_show(op_text, cl_text, area_id)
{
    var area = document.getElementById(area_id);
    area.disabled = true;

    if(area.style.display == "none")
    {
        area.style.display= "";
    }else{
        area.style.display= "none";
    }
}