function setEraOption() {
    var era = $("#date_of_birth_era");
    era.append($('<option>').html('---').val(0));
    era.append($('<option>').html('明治').val(1));
    era.append($('<option>').html('大正').val(2));
    era.append($('<option>').html('昭和').val(3));
    era.append($('<option>').html('平成').val(4));
}
function setYearOption() {
    var year = $("#date_of_birth_year");
    var selectEra = $("#date_of_birth_era").val();

    year.children().remove();
        var maxYear = 0;
    switch (selectEra) {
        case "1": maxYear = 45; break;
        case "2": maxYear = 15; break;
        case "3": maxYear = 64; break;
        case "4": maxYear = new Date().getFullYear()-1988; break;
        default: maxYear = 0; break;
    }
    year.append($('<option>').html('---').val(0));
    for (var i = 1; i <= maxYear; i++) {
        year.append($('<option>').html(i).val(i));
    }
}
function setMonthOption() {
    var month = $("#date_of_birth_month");

    month.append($('<option>').html('---').val(0));
    for (i = 1; i <= 12; i++) {
        month.append($('<option>').html(i).val(i));
    }
}

function setDayOption() {
    var day = $("#date_of_birth_day");
    var selectYear = $("#date_of_birth_year").val();
    var selectMonth = $("#date_of_birth_month").val();
    var selectDay = day.val();

    //閏年に対応するため和暦から西暦に変換
    var seirekiYear = warekiToSeireki($("#date_of_birth_era").val(), selectYear);
    var dateobj = new Date(seirekiYear, selectMonth, 0);

    day.children().remove();
    $("#date_of_birth_day").append($('<option>').html('---').val(0));
    for (var i = 1; i <= dateobj.getDate(); i++) {
        day.append($('<option>').html(i).val(i));
    }
    function warekiToSeireki(era, year) {
      if (era == 1) {
          return parseInt(year) + 1867;
      } else if(era == 2) {
          return parseInt(year) + 1911;
      } else if(era == 3) {
          return parseInt(year) + 1925;
      } else if(era == 4) {
          return parseInt(year) + 1988;
      }
    }
  }

function changeDayOption() {
    var day = $("#date_of_birth_day");
    var selectDay = day.val();

    setDayOption();
    //日が選択済みの場合、再度選択状態にする
    (selectDay == null) ? day.val(day.val()[0]) : day.val(selectDay);
}

// DOM要素の構築完了時にセレクトボックスを初期化する
$(function() {
    $(document).ready(
        function() {
            setEraOption();
            setYearOption();
            setMonthOption();
            setDayOption();
        });
});

// 元号を変更したら年のセレクトボックスの<option>をセットする
$(function() {
    $("#date_of_birth_era").on("change", function() {
        setYearOption();
    });
});

// 年を変更し、月が選択済みかつ2の場合、日のセレクトボックスの<option>を調整する（閏年対応）
$(function() {
    $("#date_of_birth_year").on("change", function() {
        if ($("#date_of_birth_month").val() == 2) {
            changeDayOption();
        }
    });
});

// 月を変更したら日のセレクトボックスの<option>を調整する
$(function() {
    $("#date_of_birth_month").on("change", function() {
        changeDayOption();
    });
});
