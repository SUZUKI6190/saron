function on_check_menu( row_id, chk_id ) {
	var row = document.getElementById(row_id);
	var chk = document.getElementById(chk_id);
	if( chk.checked ) {
		row.className = "course_row selected";
	} else {
		row.className = "course_row";
	}
}

function select_check(hidden_id)
{
	var id_list = document.getElementById(hidden_id).value.split(",");

	for(var i = 0 ; i < id_list.length ; i++)
	{
		var chkbox = document.getElementById(id_list[i]);
		if(chkbox.checked)
		{
			return true;
		}
	}

	alert('コースへチェックを入れてください');
	return false;
}