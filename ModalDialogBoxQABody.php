<div class="modal-header">
  <h5 class="modal-title" id="ModalDialogBoxQALabe">質問詳細</h5>
  <button type="button" id="btn_close_qa" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-sm-12">
      <form name="form1" method="post" action="update_qa_list.php">
        <div class="form-group">
          <input type="hidden" name="code_qa" id="code_qa" %code%>
          <input type="hidden" name="member_id_qa" id="member_id_qa" %member_id%>
          <input type="hidden" name="member_name_qa" id="member_name_qa" %member_name%>
          <label for="answerer">種別</label>
          <select class="form-control" name="category" id="category" %category%>
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
          <input type="text" name="title" class="form-control " id="title" %title%>
        </div>
        <div class="form-group">
          <label for="exampleFormControlInput0">質問内容を入力してください</label>
          <textarea class="form-control" name="question" id="question" rows="3" cols="40" %question%></textarea>
        </div>
        <div class="form-group">
          <label for="answerer">希望する回答者</label>
          <select class="form-control" name="answerer" id="answerer" %answerer%>
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
<script>
  var btn = document.getElementById('btn_entry_qa');

  btn.addEventListener('click', function() {
    document.form1.postdata.value = "";
    for (var i=0; document.form1.elements[i].name!="postdata"; ++i) {
      alert(document.form1.elements[i].name+"="+document.form1.elements[i].value);
      document.form1.postdata.value = document.form1.postdata.value +
        document.form1.elements[i].name + ':' + '\"' + document.form1.elements[i].value + '\",';
    }
    alert(document.form1.postdata.value);
    //submit()でフォームの内容を送信
    document.form1.submit();
  });
</script>
