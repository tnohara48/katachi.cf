<!-- 質問入力/編集/表示/　Modal -->

<div class="modal fade" id="ModalDialogBoxQA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabe3" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalDialogBoxQALabe">質問詳細</h5>
        <button type="button" id="btn_close_qa" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      

      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <form name="form1" method="post" action="insert_update_qa.php">
              <div class="form-group">
                <input type="hidden" name="code_qa" id="code_qa">
                <input type="hidden" name="member_id_qa" id="member_id_qa">
                <input type="hidden" name="member_name_qa" id="member_name_qa">
                <label for="answerer">種別</label>
                <select class="form-control" name="category" id="category">
                  <option value="">(質問の種類)</option>
                  <option value="プログラミングゼミについて">プログラミングゼミについて</option>
                  <option value="JAVA/JAVA試験について">JAVA/JAVA試験について</option>
                  <option value="WEB関連について（HTML/CSS/Javascript）">WEB関連について（HTML/CSS/Javascript）</option>
                  <option value="英語/IT英語について">英語/IT英語について</option>
                  <option value="プログラミング全般について">プログラミング全般について</option>
                  <option value="生活全般について">生活全般について</option>
                  <option value="「未来のかたち」について">「未来のかたち」について</option>
                  <option value="「未来のかたち」について">/</option>
                  <!--<option value="大橋" <?=/*isset($rec)?is_selected($rec['subject5'],"その他"):''*/?>>その他</option>-->
                </select>
              </div>
              <div class="form-group">
                <label for="display-date">題名を付けてください</label>
                <input type="text" name="title" class="form-control " id="title">
              </div>
              <div class="form-group">
                <label for="exampleFormControlInput0">質問内容を入力してください</label>
                <textarea class="form-control" name="question" id="question" rows="3" cols="40"></textarea>
              </div>
              <div class="form-group">
                <label for="answerer">希望する回答者</label>
                <select class="form-control" name="answerer" id="answerer">
                  <option value="">(回答してほしいスタッフを選んでください)</option>
                  <option value="斎藤">斎藤</option>
                  <option value="田中">田中</option>
                  <option value="大橋">大橋</option>
                  <option value="山本">山本</option>
                  <option value="諏訪">諏訪</option>
                  <option value="その他">その他</option>
                  <!--<option value="大橋" <?=/*isset($rec)?is_selected($rec['subject5'],"その他"):''*/?>>その他</option>-->
                </select>
              </div>
              <div class="form-group">
                <input type="hidden" name="postdata" id="postdata" value="">
              </div>
              <div class="form-group">
                <p>
                  <button type="button" class="btn btn-primary" name="btn_entry_qa" id="btn_entry_qa">保存する</button>
                  <button type="button" class="btn btn-secondary btn-sm" name="btn_cancel_qa" id="btn_cancel_qa">戻る</button>
                </p>
              </div>
            </form>
            <!--
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                  </div>
            -->
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<script>
  function disp_modal_qa( code ) {
    var member_id = get_member_id();
    var member_name = get_member_name();
    $( '#code_qa' ).val( code );
    $( '#member_id_qa' ).val( member_id );
    $( '#member_name_qa' ).val( member_name );
    $( '#ModalDialogBoxQA' ).modal( "show" );
  }

  $( '#ModalDialogBoxQA' ).on( 'show.bs.modal', function ( event ) {
    var member_id = get_member_id();
    var member_name = get_member_name();
    $.ajax( {
        url: './read-qa.php',
        type: 'POST',
        data: {
          'code_qa': $( '#code_qa' ).val(),
          'member_id_qa': member_id,
          'member_name_qa': member_name
        }
      } )
      // Ajaxリクエストが成功した時発動
      .done( ( data ) => {
        var result = data.split( '<AND>' );
        i = 0;
        while ( result[ i ] != null && result[ i ] != "" ) {
          if ( result[ i ] != 'member_id_qa' && result[ i ] != 'member_name_qa' ) {
            $( '#' + result[ i ] ).val( replaceAll( result[ i + 1 ].trim(), "\"", "" ) );
          }
          i += 2;
        }
      } )
      // Ajaxリクエストが失敗した時発動
      .fail( ( data ) => {
        $( '.result' ).html( data );
        console.log( data );
      } )
      // Ajaxリクエストが成功・失敗どちらでも発動
      .always( ( data ) => {} );
  } )

  $( '#ModalDialogBoxQA' ).on( 'hidden.bs.modal', function () {
    draw_table_qa();  
  } )
  
  function draw_table_qa() {
    var member_id = get_member_id();
    var member_name = get_member_name();
    //alert($('#result_qa_table').html());
    $.ajax( {
        url: './create_table_qa.php',
        type: 'POST',
        data: {
          'code_qa': $( '#code_qa' ).val(),
          'member_id_qa': member_id,
          'member_name_qa': member_name
        }
      } )
      // Ajaxリクエストが成功した時発動
      .done( ( data ) => {
        $( '#result_qa_table' ).html(data);
      } )
      // Ajaxリクエストが失敗した時発動
      .fail( ( data ) => {
        $( '#result_qa_table' ).html( data );
      } )
      // Ajaxリクエストが成功・失敗どちらでも発動
      .always( ( data ) => {} );
  }
</script>


<script>
  var member_id = "",
      member_name = "";
  var btn = document.getElementById( 'btn_entry_qa' );

  btn.addEventListener( 'click', function () {
    document.form1.postdata.value = "";
    for ( var i = 0; document.form1.elements[ i ].name != "postdata"; ++i ) {
      if ( document.form1.elements[ i ].name == 'member_id_qa' ) {
        member_id = document.form1.elements[ i ].value;
      }
      if ( document.form1.elements[ i ].name == 'member_name_qa' ) {
        member_name = document.form1.elements[ i ].value;
      }
      //alert(document.form1.elements[i].name+"="+document.form1.elements[i].value);
      document.form1.postdata.value = document.form1.postdata.value +
        document.form1.elements[ i ].name + ':' + '\'' + document.form1.elements[ i ].value + '\',';
    }
    //alert(document.form1.postdata.value);
    //submit()でフォームの内容を送信
    //document.form1.submit();
    $.ajax( {
        url: './update_qa_history.php',
        type: 'POST',
        async: false,
        data: {
          'db': 'membersapp',
          'tbl': 'qa_history',
          'member_id_qa': member_id,
          'member_name_qa': member_name,
          'postdata': document.form1.postdata.value
        }
      } )
      // Ajaxリクエストが成功した時発動
      .done( ( data ) => {
        alert("data="+data);
        $( '#result_qa_table' ).html( data );
        //$('#result_qa_table').innerHTML = data;
      } )
      // Ajaxリクエストが失敗した時発動
      .fail( ( data ) => {
        $( '.result' ).html( data );
        console.log( data );
      } )
      // Ajaxリクエストが成功・失敗どちらでも発動
      .always( ( data ) => {

      } );

    $( '#ModalDialogBoxQA' ).modal( 'hide' );

  } );

  btn = document.getElementById( 'btn_close_qa' );
  btn.addEventListener( 'click', function () {
    $( '#ModalDialogBoxQA' ).modal( 'hide' );
  } );

  btn = document.getElementById( 'btn_cancel_qa' );
  btn.addEventListener( 'click', function () {
    $( '#ModalDialogBoxQA' ).modal( 'hide' );
  } );
</script>