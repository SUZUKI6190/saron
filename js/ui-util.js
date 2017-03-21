
function check(msg) {


    if (window.confirm(msg)) { // 確認ダイアログを表示

        return true; 

    }
    else { // 「キャンセル」時の処理

        return false; // 送信を中止

    }

}

function SortSubmit(formid, name, value) {
    var target = document.getElementById(formid);
    // エレメントを作成
    var ele = document.createElement('input');
    // データを設定
    ele.setAttribute('type', 'hidden');
    ele.setAttribute('name', name);
    ele.setAttribute('value', value);
    // 要素を追加
    target.appendChild(ele);
    target.submit();
}
