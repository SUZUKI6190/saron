<?php
namespace ui\customer;
use ui;
use business\entity;
function CreateCustomerDetailForm(Customer $data)
{
	?>
		<div style="text-align:right;">
            <input type="button" value="お客様情報を新しく登録する" />
        </div>
        <div class="detail">
            <div class="area">
                <div class="line">
                    <div class="name">
                        氏名(漢字)：
                    </div>
                    <div>
                        <input name="name_kanji_last" type="text" value=<?php $data->name_kanji_last ?> />
                        <input name="name_kanji_first" type="text" value=<?php $data->name_kanji_first ?> />
                    </div>
                </div>
                <div class="line">
                    <div class="name">
                        氏名(カナ)：
                    </div>
                    <div>
                        <input name="name_kana_first" type="text" value=<?php $data->name_kana_last ?> />
                        <input name="name_kana_last" type="text" value=<?php $data->name_kana_first ?> />
                    </div>
                </div>
                <div class="line">
                    <div class="name">
                        電話番号：
                    </div>
                    <div>
                        <input type="text" />
                    </div>
                </div>
                <div class="line">
                    <div class="name">
                        E-mail：
                    </div>
                    <div>
                        <input type="text" />
                    </div>
                </div>
                <div class="line">
                    <div class="name">
                        性別：
                    </div>
                    <div>
                        <input type="text" />
                    </div>
                </div>
                <div class="line">
                    <div class="name">
                        年齢：
                    </div>
                    <div>
                        <input type="text" />
                    </div>
                </div>
                <div class="line">
                    <div class="name">
                        誕生日：
                    </div>
                    <div>
                        <input type="text" />
                    </div>
                </div>
            </div>
            <div class="area">
                <div class="line">
                    <div class="name">
                        住所：
                    </div>
                    <div>
                        <input type="text" />
                    </div>
                </div>
                <div class="line">
                    <div class="name">
                        職業：
                    </div>
                    <div>
                        <input type="text" />
                    </div>
                </div>
                <div class="line">
                    <div class="name">
                        電話番号：
                    </div>
                    <div>
                        <input type="text" />
                    </div>
                </div>

                <div class="line">
                    <div class="name">
                        来店回数：
                    </div>
                    <div>
                        <input type="text" />
                    </div>
                </div>
                <div class="line">
                    <div class="name">
                        スタッフ：
                    </div>
                    <div>
                        <input type="text" />
                    </div>
                </div>
                <div class="line">
                    <div class="name">
                        最終来店日：
                    </div>
                    <div>
                        <input type="text" />
                    </div>
                </div>
                <div class="line">
                    <div class="name">
                        次回来店予約日：
                    </div>
                    <div>
                        <input type="text" />
                    </div>
                </div>
                <div class="line">
                    <div class="name">
                        予約経路：
                    </div>
                    <div>
                        <input type="text" />
                    </div>
                </div>
                <div class="line">
                    <div class="name">
                        DM不可：
                    </div>
                    <div>
                        <input type="checkbox" name="riyu" value="1" checked="checked">
                    </div>
                </div>
                <div class="line">
                    <div class="name">
                        備考：
                    </div>
                    <div>
                        <input type="text" />
                    </div>
                </div>
            </div>
        </div>

	<?php
}

?>