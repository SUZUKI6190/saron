function edit_schedule(hiden_id, schedule_id, form_id)
{
    var hdn = document.getElementById(hiden_id);
    hdn.value = schedule_id;
    document.getElementById(form_id).submit();
}