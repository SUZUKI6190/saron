function on_check_menu( row_id, chk_id ) {
	var row = document.getElementById(row_id);
	var chk = document.getElementById(chk_id);
	if( chk.checked ) {
		row.className = "course_row selected";
	} else {
		row.className = "course_row";
	}
}