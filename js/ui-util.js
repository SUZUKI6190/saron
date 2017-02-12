
function check(msg) {


    if (window.confirm(msg)) { // 確認ダイアログを表示

        return true; 

    }
    else { // 「キャンセル」時の処理

        return false; // 送信を中止

    }

}
