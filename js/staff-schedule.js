function edit_schedule(hiden_name, hidden_value, form_id)
{
    var frm = document.getElementById(form_id);
    frm.innerHTML += '<input type="hidden" name="' + hiden_name + '" value="' + hidden_value +'">';
    frm.submit();
}
