<!-- 日記入力　Modal -->
<div class="modal fade" id="ModalDialogBoxDiary" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabe2" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabe2">本日の学び(学習の記録)</h5>
        <span id="disp_id_m" invisible></span>
        <span id="disp_name_m" invisible></span>
        <button type="button" id="btn_close_m" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-1">
          </div>
          <div class="col-sm-10">
            <form method="post">
              <div class="form-group">
                <label for="display-date">● 登録した日時、または前回保存した日時</label>
                <input type="text" name="date" class="form-control" id="display-date" disabled>
              </div>
              <div class="form-group">
                <label for="exampleFormControlInput0">● 本日の課題内容</label>
                <input type="text" name="subject1" id="subject1" class="form-control" placeholder="作業や読んだ本の名前など．．．">
              </div>
              <div class="form-group">
                <label for="exampleFormControlTextarea0">● 本日の課題で難しかったこと、できたこと</label>
                <textarea class="form-control" name="subject2" id="subject2" rows="3"></textarea>
              </div>
              <div class="form-group">
                <label for="exampleFormControlTextarea0">● 気づいたこと、感じたこと</label>
                <textarea class="form-control" name="subject3" id="subject3" rows="3"></textarea>
              </div>
              <div class="form-group">
                <label for="exampleFormControlTextarea1">● そう感じた自分ついて言えること</label>
                <textarea class="form-control" name="subject4" id="subject4" rows="3"></textarea>
              </div>
              <div class="form-group">
                <label for="exampleFormControlSelect1">● スタッフへの連絡</label>
                <select class="form-control" name="subject5" id="subject5">
                  <option value="特になし">相談したい</option>
                  <option value="相談したい">相談したい</option>
                  <option value="つぎの課題が欲しい">つぎの課題が欲しい</option>
                  <option value="やったことを報告したい">やったことを報告したい</option>
                  <option value="やり方を相談したい">やり方を相談したい</option>
                  <option value="その他">その他</option>
                </select>
              </div>
              <div class="form-group">
                <label for="exampleFormControlSelect2">● 次にやりたいこと</label>
                <select class="form-control" name="subject6" id="subject6">
                  <option value="決めていない">決めていない</option>
                  <option value="本">本</option>
                  <option value="オンライン">ビデオ</option>
                  <option value="テレビ">テレビ</option>
                  <option value="ラジオ">ラジオ</option>
                  <option value="インターネット">インターネット</option>
                  <option value="わからない">わからない</option>
                </select>
              </div>
              <div class="form-group">
                <input type="hidden" name="subject7" id="subject7">
                <input type="hidden" name="code_m" id="code_m">
                <input type="hidden" name="member_id" id="member_id">
                <input type="hidden" name="member_name" id="member_name">
              </div>
              <div class="form-group">
                <p>
                  <button type="submit" class="btn btn-primary" name="entry" id="btn_entry_m">保存</button>
                  <button type="submit" class="btn btn-secondary btn-sm" id="btn_cancel_m">戻る</button>
                </p>
              </div>
            </form>
          </div>
          <div class="col-sm-1">
          </div>
        </div>
      </div>
      <!--
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
          </div>
  -->
    </div>
  </div>
</div>

<script>
  // 日報入力ダイアログを表示する
  function disp_input_diary_modal( code ) {
    $( "#code_m" ).val( code );
    $( "#ModalDialogBoxDiary" ).modal( "show" );
  }

  // 日報入力ダイアログデータを保存する
  $( function () {
    $( '#btn_entry_m' ).on( 'click', function () {
      var member_id = get_member_id();
      var member_name = get_member_name();
      $.ajax( {
          url: './update-diary.php',
          type: 'POST',
          data: {
            'code': $( '#code_m' ).val(), // 0
            'member_id': member_id, // 1
            'member_name': member_name, // 2
            'subject1': $( '#subject1' ).val(), // 3
            'subject2': $( '#subject2' ).val(), // 4
            'subject3': $( '#subject3' ).val(), // 5
            'subject4': $( '#subject4' ).val(), // 6
            'subject5': $( '#subject5' ).val(), // 7
            'subject6': $( '#subject6' ).val(), // 8
            'subject7': $( '#subject7' ).val(), // 9
            'updated_at': $( '#display-date' ).val() // 10
          }
        } )
        // Ajaxリクエストが成功した時発動
        .done( ( data ) => {
          console.log( "done[" + data + "]" );
          //alert("done["+data+"]");
          //alert("subject6=["+$('#subject6').val() + "]\n");
          $( '#ModalDialogBoxDiary' ).modal( 'hide' );
          location.reload();
        } )
        // Ajaxリクエストが失敗した時発動
        .fail( ( data ) => {
          console.log( "fail[" + data + "]" );
          //alert("subject6=["+$('#subject6').val() + "]\n");
          $( '.result' ).html( data );
        } )
        // Ajaxリクエストが成功・失敗どちらでも発動
        .always( ( data ) => {
          console.log( "always[" + data + "]" );
          //alert("subject6=["+$('#subject6').val() + "]\n");

        } );

      $( '#ModalDialogBoxDiary' ).modal( 'hide' );

    } )
  } );
  
  // 日報入力ダイアロ出現時に各項目を設定する
  $( '#ModalDialogBoxDiary' ).on( 'show.bs.modal', function ( event ) {
    var member_id = get_member_id();
    var member_name = get_member_name();
    $.ajax( {
        url: './read-diary.php',
        type: 'POST',
        /*async: false,*/
        data: {
          'code': $( '#code_m' ).val(),
          'member_id': member_id
        }
      } )
      // Ajaxリクエストが成功した時発動
      .done( ( data ) => {
        var result = data.split( '<AND>' );
        $( '#code_m' ).val( replaceAll( result[ 0 ].trim(), "\"", "" ) );
        $( '#member_id' ).val( replaceAll( result[ 1 ].trim(), "\"", "" ) );
        $( '#member_name' ).val( replaceAll( result[ 2 ].trim(), "\"", "" ) );
        $( '#subject1' ).val( result[ 3 ].trim() );
        $( '#subject2' ).val( result[ 4 ].trim() );
        $( '#subject3' ).val( result[ 5 ].trim() );
        $( '#subject4' ).val( result[ 6 ].trim() );
        //$( '#subject5' ).value = result[ 7 ].trim();
        //$( '#subject6' ).value = result[ 8 ].trim();
        $( '#subject5' ).val( result[ 7 ].trim() );
        $( '#subject6' ).val( result[ 8 ].trim() );
        $( '#subject7' ).val( result[ 9 ].trim() );
        $( '#display-date' ).val( result[ 10 ].trim() );

        if ( result[ 11 ].trim() == 'UPDATE' ) {
          $( '#subject1' ).disabled = "true";
          $( '#subject2' ).disabled = "true";
          $( '#subject3' ).disabled = "true";
          $( '#subject4' ).disabled = "true";
          $( '#subject5' ).disabled = "true";
          $( '#subject6' ).disabled = "true";
          $( '#subject7' ).disabled = "true";
        } else {
          $( '#subject1' ).disabled = "";
          $( '#subject2' ).disabled = "";
          $( '#subject3' ).disabled = "";
          $( '#subject4' ).disabled = "";
          $( '#subject5' ).disabled = "";
          $( '#subject6' ).disabled = "";
          $( '#subject7' ).disabled = "";
        }
      } )
      // Ajaxリクエストが失敗した時発動
      .fail( ( data ) => {
        $( '.result' ).html( data );
        console.log( data );
      } )
      // Ajaxリクエストが成功・失敗どちらでも発動
      .always( ( data ) => {

      } );
  } )
  
  $( '#ModalDialogBoxDiary' ).on( 'hidden.bs.modal', function () {
    draw_table_dialy();
  } )

  function draw_table_dialy() {
    var member_id = get_member_id();
    var member_name = get_member_name();
    $.ajax( {
        url: './create_table_dialy.php',
        type: 'POST',
        data: {
          'code_qa': $( '#code_qa' ).val(),
          'member_id_qa': member_id,
          'member_name_qa': member_name
        }
      } )
      // Ajaxリクエストが成功した時発動
      .done( ( data ) => {
        $( '#result_dialy_table' ).html(data);
      } )
      // Ajaxリクエストが失敗した時発動
      .fail( ( data ) => {
        $( '#result_dialy_table' ).html( data );
      } )
      // Ajaxリクエストが成功・失敗どちらでも発動
      .always( ( data ) => {} );
  }
  
  // 日報入力ダイアロ出現時に各項目を設定する
  $( '#ModalDialogBoxDiary' ).on( 'hidden.bs.modal', function ( event ) {
    var member_id = get_member_id();
    var member_name = get_member_name();
  } )
  
  // 日報入力ダイアログをクローズする
  $( function () {
    $( '#btn_close_m' ).on( 'click', function () {
      console.log( "CLOSE" );
      $( '#ModalDialogBoxDiary' ).modal( 'hide' );
    } )
  } );

  // 日報入力ダイアログをキャンセルする
  $( function () {
    $( '#btn_cancel_m' ).on( 'click', function () {
      console.log( "CANCEL" );
      $( '#ModalDialogBoxDiary' ).modal( 'hide' );
    } )
  } );

</script>