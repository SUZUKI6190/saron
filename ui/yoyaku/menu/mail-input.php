<?php
namespace ui\yoyaku\menu;

use ui\yoyaku\frame\YoyakuMenu;
use ui\yoyaku\YoyakuContext;
USE ui\util\InputBase;
use ui\util\SubmitButton;
require_once(dirname(__FILE__).'/../controll/course-table.php');
use ui\yoyaku\controll\CourseTable;


class MailInput extends YoyakuMenu
{
    private $course_table;
	private $_course_id_list;

	public function __construct()
	{
		$this->_course_id_list = $this->get_course_id_list();
		$course_list = \business\facade\get_menu_course_by_idlist($this->_course_id_list);
		$this->course_table = new CourseTable($course_list);
	}

	protected function get_css_list() : array
	{
		return [
		"course-table.css",
        "mail-input.css"
		];
	}

    public function view()
    {
        ?>
        <div class='yoyaku_midashi'>
            <span class='page_midasi'>お客様情報を入力してください</span>
        </div>
        <?php $this->course_table->view(); ?>
        <div class='table_area'>
            <table class='mail_inpt_table'>
                <tr>
                    <td class='midasi'>
                        <span class='tag required'>
                        必須
                        </span>
                        お名前(漢字)
                    </td>
                    <td>
                        <input type='text' name='mail_name' >
                    </td>
                </tr>
                <tr>
                    <td class='midasi'>
                        <span class='tag required'>
                        必須
                        </span>
                        お名前(カナ)
                    </td>
                    <td>
                        <input type='text' name='mail_kana' >
                    </td>
                </tr>
                <tr>
                    <td class='midasi'>
                        <span class='tag required'>
                        必須
                        </span>
                        メールアドレス
                    </td>
                    <td>
                        <input type='email' name='email' >
                    </td>
                </tr>
                <tr>
                    <td class='midasi'>
                        <span class='tag required'>
                        必須
                        </span>
                        お電話番号
                    </td>
                    <td>
                        <input type='tell' name='tell' >
                    </td>
                </tr>
                <tr>
                    <td class='midasi'>
                        <span class='tag required'>
                        必須
                        </span>
                        ご来店
                    </td>
                    <td>
                        <input type='radio' name='visit[]' >初めて<br>
                        <input type='radio' name='visit[]' >再来店
                    </td>
                </tr>
                <tr class="consultation_tr">
                    <td class='midasi'>
                        <span class='tag option'>
                        任意
                        </span>
                        ご相談・お問合わせ等
                    </td>
                    <td>
                        <textarea class="consultation" name="consultation" rows="4" cols="40"></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <?php
    		$d = "?date=".(new \DateTime())->format("Ymdhis");
            $yc = YoyakuContext::get_instance();
		    $before_url = get_bloginfo('url')."/".get_query_var( 'pagename' )."/yoyaku/day/".$d;
        ?>
        <div class='back_button_area'>
            <form method='post' action='<?php echo $before_url; ?>'>
                <?php $this->view_yoyaku_frame_hidden(); ?>
                <div class='back_button_area'>
                    <input type ='submit' value="< 戻る" class="back_button">
                </div>
                <div class='back_button_area'>
                    <button type='submit' value='none' name='staff_id' class='next_button'>予約内容を確認する</button>
                </div>
            </form>
        </div>
        <?php
    }

	public function get_title() : string
    {
        return "情報入力";
    }
}

?>