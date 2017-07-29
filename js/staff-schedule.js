function edit_schedule(hiden_name, hidden_value, form_id)
{
    var frm = document.getElementById(form_id);
    frm.innerHTML += '<input type="hidden" name="' + hiden_name + '" value="' + hidden_value +'">';
    frm.submit();
}

function on_check_menu( row_id, chk_id ) {
	var row = document.getElementById(row_id);
	var chk = document.getElementById(chk_id);
	if( chk.checked ) {
		row.className = "course_row selected";
	} else {
		row.className = "course_row";
	}
}
