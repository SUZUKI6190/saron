<?php
namespace ui\staff;
require_once(dirname(__FILE__).'/../../business/entity/staff.php');
require_once(dirname(__FILE__).'/../frame/manage-frame.php');
require_once(dirname(__FILE__).'/../../business/facade/staff.php');
use \business\entity\Staff;
use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\util\InputBase;
use ui\image\ImageDonwloader;

abstract class StaffInputFormBase
{
	protected $_staff;
	private $_name_first, $_name_last, $_tell, $_email, $_url;
	const upload_name = 'face_image';
	protected $_save_button;
	protected $_form_id = "staff_input_form";
	protected $_up_form_id = "image_send_form";
	public function __construct()
	{
		$this->_staff = $this->create_staff();
		$required_attr = [];
		$required_attr["required"] = "";
		$this->_save_button = new SubmitButton("save_button", "保存する", $this->_form_id);
		$this->_name_first = new InputBase("text", "name_first", $this->_staff->name_first, 'staff_input' ,$required_attr);
		$this->_name_last = new InputBase("text", "name_last", $this->_staff->name_last, 'staff_input', $required_attr);
		$this->_url = new InputBase("url", "url", $this->_staff->introduce_page_url, 'staff_input');
	}

	protected abstract function innser_save(Staff $staff, bool $is_image_upload);
	protected abstract function create_staff() : Staff;
	
	public function save()
	{
		$staff = new Staff();
		$staff->id = StaffContext::get_instance()->staff_id;
		$staff->name_first = $this->_name_first->get_value();
		$staff->name_last = $this->_name_last->get_value();

		$staff->introduce_page_url = $this->_url->get_value();
		
		$files = $_FILES[StaffInputFormBase::upload_name];
		$name = $files['name'];
		
		$is_image_upload = false;
		
		 //一字ファイルができているか（アップロードされているか）チェック
		if(is_uploaded_file($files['tmp_name'])){
			
			// バイナリデータ
			$fp = fopen($files["tmp_name"], "rb");
			$imgdat = fread($fp, filesize($files["tmp_name"]));
			fclose($fp);
			$imgdat = addslashes($imgdat);
	
			// 拡張子
			$dat = pathinfo($name);
			$extension = $dat['extension'];

			// MIMEタイプ
			$mime='';
			if ( $extension == "jpg" || $extension == "jpeg" ){
				$mime = "image/jpeg";
			}elseif( $extension == "gif" ){
				$mime = "image/gif";
			}elseif( $extension == "png" ){
				$mime = "image/png";
			}

			$staff->mime = $mime;
			$staff->imgdat = $imgdat;
			$is_image_upload = true;
		}
		
		$this->innser_save($staff, $is_image_upload);
	}
	
	public function is_save() : bool
	{
		return $this->_save_button->is_submit();
	}
	
	protected function add_button()
	{
	}

	protected function add_image()
	{
	}

	public function view()
	{
		$image_name = StaffInputFormBase::upload_name;
		?>
		<form method="post" id='<?php echo $this->_form_id; ?>' enctype='multipart/form-data'>
			<div class="input_form">
			<div class="staff_form_button">
			<?php
			$this->_save_button->view();
			$this->add_button();
			?>
			</div>
			<div class="line">
				<h2>名前(性)</h2>
				<?php echo $this->_name_last->view(); ?>
			</div>
			<div class="line">
				<h2>名前(名)</h2>
				<?php echo $this->_name_first->view(); ?>
			</div>
			
			<div class="line">
				<h2>紹介ページURL</h2>
				<?php echo $this->_url->view(); ?>
			</div>		
			<div class="line">
				<h2>写真</h2>
				<div class='staff_image_area'>
					<?php $this->add_image(); ?>
				</div>
				<div class="upload_button_area">
					<button class='manage_button upload_button' type="button" onclick='onclick_upload("image_upload_area", "text_area")'>
						<span id='text_area'>画像をアップロードする</span>
					</button>
				</div>
				<div class="image_upload_area close" id='image_upload_area'>
					<input type="file" name='<?php echo $image_name ; ?>' accept='image'　/>
				</div>
			</div>
		</form>
		<?php

	}
}

class StaffInputFormNew extends StaffInputFormBase
{
	protected function innser_save(Staff $staff, bool $is_image_upload)
	{
		if($is_image_upload){
			\business\facade\insert_staff_with_image($staff);
		}else{
			\business\facade\insert_staff($staff);
		}
	}
	
	protected function create_staff() : Staff
	{
		return Staff::get_empty_object();
	}
}


class StaffInputFormEdit extends StaffInputFormBase
{
	private $_delete_button;
	private $_img;

	public function __construct()
	{
		parent::__construct();
		$this->_delete_button = new ConfirmSubmitButton("delete_button", "削除する", $this->_form_id, "削除します。よろしいですか？");
		$this->_img = new ImageDonwloader('staff', $this->_staff->id);
		$this->_img->css_class = 'staff_image';
	}
	
	public function is_save() : bool
	{
		if(parent::is_save())
		{
			return true;
		}
		
		if($this->_delete_button->is_submit())
		{
			return true;
		}
		
		return false;
	}
	
	
	protected function add_button()
	{
		$this->_delete_button->view();
	}
	
	protected function innser_save(Staff $staff, bool $is_image_upload)
	{

		if($this->_save_button->is_submit()){
			\business\facade\update_staff($staff);
			if($is_image_upload){
				\business\facade\update_staff_image($staff->id, $staff->mime, $staff->imgdat);
			}
		}
		
		if($this->_delete_button->is_submit()){
			\business\facade\delete_staff($staff->id);
		}
			
	}
	
	protected function add_image()
	{
		$this->_img->view();
	}
	
	protected function create_staff() : Staff
	{
		$context = StaffContext::get_instance();
		return \business\facade\get_staff_byid($context->staff_id);
	}
}
?>