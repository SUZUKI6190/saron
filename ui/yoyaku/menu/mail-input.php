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
    const BackBtnName = "back_button";
    const ConfirmBtnName = "confirm_btn";

	public function __construct()
	{
	}

	protected function init_inner()
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

	public function pre_render()
	{
		$yc = YoyakuContext::get_instance();

        if($this->is_back())
        {
            $before_url = $yc->get_base_url()."/day/";
            $this->transfer($before_url);
        }

        if($this->is_confirm())
        {
            if($this->enable_move_next())
            {
                $next_url = $yc->get_base_url()."/confirm/";
                $this->transfer($next_url);
            }
        }
	}

    private function enable_move_next():bool
    {
        $yc = YoyakuContext::get_instance();
        $mc = $yc->mail_contents;
   
        if(!$mc->name_kana->is_post())
        {
            return false;
        }
        if(!$mc->name_kanji->is_post())
        {
            return false;
        }
        if(!$mc->tell->is_post())
        {
            return false;
        }
        if(!$mc->email->is_post())
        {
            return false;
        }

        return true;
    }

    private function is_back() : bool
    {
        return isset($_POST[self::BackBtnName]);
    }

    private function is_confirm() : bool
    {
        return isset($_POST[self::ConfirmBtnName]);
    }

    public function view()
    {
        $yc = YoyakuContext::get_instance();
        $mc = $yc->mail_contents;
  
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
                        <input type='text' name='<?php echo $mc->name_kanji->get_key(); ?>' value='<?php echo $mc->name_kanji->get_value();?>' >
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
                        <input type='text' name='<?php echo $mc->name_kana->get_key(); ?>' pattern="[\u3041-\u3096]*" value='<?php echo $mc->name_kana->get_value();?>'>
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
                        <input type='email' name='<?php echo $mc->email->get_key(); ?>' value='<?php echo $mc->email->get_value();?>'>
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
                        <input type='tel' name='<?php echo $mc->tell->get_key(); ?>' value='<?php echo $mc->tell->get_value();?>'>
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
                        <?php
                        $visit_name = $mc->visit->get_key()."[]";
                        $checked_first = "";
                        $checked_visited= "";
                        if($mc->visit->is_set()){
                            $value = $mc->visit->get_value()[0];
                            if($value != "1"){
                                $checked_first = "checked";
                            }else{
                                $checked_visited= "checked";
                            }
                        }else{
                            $checked_first = "checked";
                        }
                        ?>
                        <input type='radio' name='<?php echo $visit_name; ?>' <?php echo $checked_first; ?> value='0' required>初めて<br>
                        <input type='radio' name='<?php echo $visit_name; ?>' <?php echo $checked_visited; ?> value='1'>再来店
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
                        <textarea class="consultation" name='<?php echo $mc->consultation->get_key(); ?>' rows="4" cols="40"><?php echo $mc->consultation->get_value();?></textarea>
                    </td>
                </tr>
            </table>
        </div>

        <div class='button_area'>
            <div class='back_button_area'>
                <button type='submit' value='none' name='<?php echo self::BackBtnName; ?>' class='back_button'>< 戻る</button>
            </div>
            <div class='back_button_area'>
                <button type='submit' value='none' name='<?php echo self::ConfirmBtnName; ?>' class='next_button'>予約内容を確認する</button>
            </div>
        </div>
    <?php
    }

	public function get_title() : string
    {
        return "情報入力";
    }
}

?>