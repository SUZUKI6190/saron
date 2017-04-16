function onclick_upload(id, textid)
{
	var area = document.getElementById(id);
	var css_default = 'image_upload_area close';
	var css_open = 'image_upload_area';
	var text_area = document.getElementById(textid);
	if(area.className == css_default){
		area.className = css_open;
		text_area.innerHTML = "アップロードを取り消す";
	}else{
		var old = area.innerHTML;
		area.innerHTML = old;
		area.className = css_default;
		text_area.innerHTML = "画像をアップロードする";
	}
	
}