<?php
namespace ui\menu\frame;

function get_tell_number()
{
	return "090-6959-1112";
}

function view_footer()
{
?>
<div class='yoyaku_area'>
	<div class='yoyaku_inner_wrap'>
		<div class='yoyaku_midasi'>
			<span>お電話・LINEからのご予約</span>
		</div>
		<div class='yoyaku_discription'>
			<span>上記フォームより、「メニュー」・「セラピスト」をお選びいただきますと、サロンの
			空き状況がカレンダーでご覧いただけます。</span>
		</div>
		<div class='yoyaku_btn_area'>
			<div class='yoyaku_btn_wrap'>
				<a href = 'http://localhost/wordpress/search/publish/menu' class="yoyaku_btn tell">
				電話予約(<?php echo get_tell_number();?>)
				</a>
			</div>
			<div class='yoyaku_btn_wrap'>
				<a href = 'http://localhost/wordpress/search/publish/menu_regist' class="yoyaku_btn line">
				LINE予約 >
				</a>
			</div>
		</div>
	</div>
</div>	
<?php
}
	

?>