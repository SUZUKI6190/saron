<?php
namespace ui\yoyaku\menu;
use ui\yoyaku\frame\YoyakuMenu;
use ui\yoyaku\controll\MenuTable;
use ui\yoyaku\YoyakuContext;
USE ui\util\InputBase;
use ui\util\SubmitButton;

class Finish extends YoyakuMenu
{
	public function __construct()
	{
        $this->_is_view_footer = false;
	}

	protected function init_inner()
	{
		$yc = YoyakuContext::get_instance();

		$yc->session_destroy();
	}

	protected function get_css_list() : array
	{
		return [
		"finish.css"
		];
	}

	public function get_title() : string
	{
		return "送信完了画面";
	}

	public function view()
	{
        ?>
        <div class='yoyaku_midashi'>
            <span class='page_midasi'>予約完了</span>
        </div>
        <div class='finish_message'>
            ご予約ありがとうございます。<br>
            サロンでお客様にお会いできる日を楽しみにしています。
        </div>
        <div class='note_area'>
            <span>※ご予約メール（自動返信）をご記入いただきましたメールアドレス宛に送信しました。</span><br>
            <span class='note'>※１０分以内に自動返信メールが届かない場合は、</span>
            <span class='note bold'>迷惑メールフォルダ</span>
            <span class='note'>もご確認ください。</span><br>
            <span>※迷惑メールフォルダにもメールが届いていない場合は、お手数ですがcontact@redear.jpまでご連絡ください。</span>
        </div>
        <?php
  	}


}

?>