<?php

function gengo($seireki)
{
	if(1868<=$seireki && $seireki<=1911)
	{
		$gengo='明治';
	}

	if(1912<=$seireki && $seireki<=1925)
	{
		$gengo='大正';
	}

	if(1926<=$seireki && $seireki<=1988)
	{
		$gengo='昭和';
	}

	if(1989<=$seireki)
	{
		$gengo='平成';
	}

	return($gengo);
}

/**********************/
/* セキュリティ対策 */
/**********************/

/* サニタイズ */
function sanitize($before)
{
	foreach($before as $key=>$value)
	{
		$after[$key]=htmlspecialchars($value,ENT_QUOTES,'UTF-8');
	}
	return $after;
}

/* 変数を表示する際にエスケープする*/
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}



function pulldown_year()
{
	print '<select name="year">';
	print '<option value="2017">2017</option>';
	print '<option value="2018">2018</option>';
	print '<option value="2019">2019</option>';
	print '<option value="2020">2020</option>';
	print '</select>';
}

function pulldown_month()
{
	print '<select name="month">';
	print '<option value="01">01</option>';
	print '<option value="02">02</option>';
	print '<option value="03">03</option>';
	print '<option value="04">04</option>';
	print '<option value="05">05</option>';
	print '<option value="06">06</option>';
	print '<option value="07">07</option>';
	print '<option value="08">08</option>';
	print '<option value="09">09</option>';
	print '<option value="10">10</option>';
	print '<option value="11">11</option>';
	print '<option value="12">12</option>';
	print '</select>';
}

function pulldown_day()
{
	print '<select name="day">';
	print '<option value="01">01</option>';
	print '<option value="02">02</option>';
	print '<option value="03">03</option>';
	print '<option value="04">04</option>';
	print '<option value="05">05</option>';
	print '<option value="06">06</option>';
	print '<option value="07">07</option>';
	print '<option value="08">08</option>';
	print '<option value="09">09</option>';
	print '<option value="10">10</option>';
	print '<option value="11">11</option>';
	print '<option value="12">12</option>';
	print '<option value="13">13</option>';
	print '<option value="14">14</option>';
	print '<option value="15">15</option>';
	print '<option value="16">16</option>';
	print '<option value="17">17</option>';
	print '<option value="18">18</option>';
	print '<option value="19">19</option>';
	print '<option value="20">20</option>';
	print '<option value="21">21</option>';
	print '<option value="22">22</option>';
	print '<option value="23">23</option>';
	print '<option value="24">24</option>';
	print '<option value="25">25</option>';
	print '<option value="26">26</option>';
	print '<option value="27">27</option>';
	print '<option value="28">28</option>';
	print '<option value="29">29</option>';
	print '<option value="30">30</option>';
	print '<option value="31">31</option>';
	print '</select>';
}

function get_userid() {
	return 'root';
}

function get_password() {
	return 'shop_tnohara';
}

function get_db_userid() {
	return 'root';
}

function get_db_password() {
//	return 'shop_tnohara';
	return 'shop_tnohara';
}

function checked_str($str,$val) {
	$arr = explode("、", $str);
	foreach ($arr as $key => $value) {
		if ($value == $val)
			return 'checked="checked"';
	}
	return '';
}

function is_selected($str,$var){
	if ($str == $var) {
		return 'selected';
	}
	return '';
}

function is_checked($str,$var){
	if ($str == $var) {
		return 'checked';
	}
	return '';
}
/*
$select_options_job_record = '
	<option value="">選択してください</option>
	<optgroup label="製造業">
	<option value="電機・電子・機械">電機・電子・機械</option>
	<option value="建築・設備・工事業">建築・設備・工事業</option>
	<option value="化学・製薬">化学・製薬</option>
	<option value="繊維・素材">繊維・素材</option>
	<option value="印刷・出版業">建印刷・出版業</option>
	<option value="農林水産業">農林水産業</option>
	<option value="食品">食品</option>
	<option value="その他の製造業">その他の製造業</option>
	</optgroup>
	<optgroup label="物流・通信業">
	<option value="IT・情報通信業">IT・情報通信業</option>
	<option value="電気・ガス・水道業">水道業</option>
	<option value="運輸･物流">運輸･物流</option>
	<option value="卸売・小売">卸売・小売</option>
	<option value="その他の物流・通信業">その他の物流・通信業</option>
	</optgroup>
	<optgroup label="金融・保険・不動産業">
	<option value="銀行・信託・金融業">銀行・信託・金融業</option>
	<option value="投資業">投資業</option>
	<option value="証券・商品取引">証券・商品取引</option>
	<option value="不動産取引業">不動産取引業</option>
	<option value="不動産賃貸業">不動産賃貸業</option>
	<option value="その他の金融・保険・不動産業">その他の金融・保険・不動産業</option>
	</optgroup>
	<optgroup label="サービス業">
	<option value="ホテル・旅館">ホテル・旅館</option>
	<option value="飲食">飲食</option>
	<option value="娯楽">娯楽</option>
	<option value="美容・理容業">美容・理容業</option>
	<option value="病院・医療・ヘルスケア">病院・医療・ヘルスケア</option>
	<option value="教育・研究・学会">教育・研究・学会</option>
	<option value="その他のサービス業">その他のサービス業</option>
	</optgroup>
	<optgroup label="各種団体">
	<option value="官公庁･政府機関･公益法人">官公庁･政府機関･公益法人</option>
	<option value="法人団体">法人団体</option>
	<option value="自治体">自治体</option>
	<option value="その他の団体">その他の団体</option>
	</optgroup>
	<option value="その他の業種">その他の業種</option>
	';

	$select_options_duration = '
		<option value="選択してください">選択してください</option>
		<option value="１カ月未満">１カ月未満</option>
		<option value="１カ月">１カ月</option>
		<option value="２カ月">２カ月</option>
		<option value="３カ月">３カ月</option>
		<option value="６カ月">６カ月</option>
		<option value="１年">１年</option>
		<option value="２年">２年</option>
		<option value="３年">３年</option>
		<option value="それ以上">それ以上</option>
		';
*/
function pref_no_2_name($pref_no) {
	switch($pref_no){
      case 0: $pref = ''; break;
      case 1: $pref = '北海道'; break;
      case 2: $pref = '青森県'; break;
      case 3: $pref = '岩手県'; break;
      case 4: $pref = '宮城県'; break;
      case 5: $pref = '秋田県'; break;
      case 6: $pref = '山形県'; break;
      case 7: $pref = '福島県'; break;
      case 8: $pref = '茨城県'; break;
      case 9: $pref = '栃木県'; break;
      case 10: $pref = '群馬県'; break;
      case 11: $pref = '埼玉県'; break;
      case 12: $pref = '千葉県'; break;
      case 13: $pref = '東京都'; break;
      case 14: $pref = '神奈川県'; break;
      case 15: $pref = '新潟県'; break;
      case 16: $pref = '富山県'; break;
      case 17: $pref = '石川県'; break;
      case 18: $pref = '福井県'; break;
      case 19: $pref = '山梨県'; break;
      case 20: $pref = '長野県'; break;
      case 21: $pref = '岐阜県'; break;
      case 22: $pref = '静岡県'; break;
      case 23: $pref = '愛知県'; break;
      case 24: $pref = '三重県'; break;
      case 25: $pref = '滋賀県'; break;
      case 26: $pref = '京都府'; break;
      case 27: $pref = '大阪府'; break;
      case 28: $pref = '兵庫県'; break;
      case 29: $pref = '奈良県'; break;
      case 30: $pref = '和歌山県'; break;
      case 31: $pref = '鳥取県'; break;
      case 32: $pref = '島根県'; break;
      case 33: $pref = '岡山県'; break;
      case 34: $pref = '広島県'; break;
      case 35: $pref = '山口県'; break;
      case 36: $pref = '徳島県'; break;
      case 37: $pref = '香川県'; break;
      case 38: $pref = '愛媛県'; break;
      case 39: $pref = '高知県'; break;
      case 40: $pref = '福岡県'; break;
      case 41: $pref = '佐賀県'; break;
      case 42: $pref = '長崎県'; break;
      case 43: $pref = '熊本県'; break;
      case 44: $pref = '大分県'; break;
      case 45: $pref = '宮崎県'; break;
      case 46: $pref = '鹿児島県'; break;
      case 47: $pref = '沖縄県'; break;
      default : $pref = '都道府県の値が不正です';
		}
		return $pref;
	}
?>
