function common() {
    function disp(msg, url) {

        // 「OK」時の処理開始 ＋ 確認ダイアログの表示
        if (window.confirm(msg)) {

            location.href = "example_confirm.html"; // example_confirm.html へジャンプ

        }

    }

}