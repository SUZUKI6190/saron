<?php
namespace ui\sales;
use business\entity\SalesMail;
use business\facade\SalesMailFacade;

class SalesMailContent implements ISalesMailViewer
{
    public function init()
    {
    }

    public function save()
    {

    }

    public function view()
    {
?>
    <div clas='line'>
        <h2>メールタイトル</h2>
        <input type='text' >
    </div>    
    <div clas='line'>
        <h2>メッセージ</h2>
        <input type='text' >
        
    </div>
<?php
    }
}

?>