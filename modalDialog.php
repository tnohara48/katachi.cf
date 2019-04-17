
  <!-- 日記入力　Modal -->
  <div class="modal fade" id="modalDialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabe2" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabe2">本日の学び</h5>
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
                  <input type="text" name="date" class="form-control" id="display-date" placeholder="$updated_at" disabled value=$updated_at >
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput0">● 本日の課題内容</label>
                  <input type="text" name="subject1" id="subject1" class="form-control" <?=($badge=="既存")?"disabled":""?> id="exampleFormControlInput0" placeholder="作業や読んだ本の名前など．．．" value="<?=isset($rec['subject1'])?h($rec['subject1']):''?>">
                </div>
                <div class="form-group">
                  <label for="exampleFormControlTextarea0">● 本日の課題で難しかったこと、できたこと</label>
                  <textarea class="form-control" name="subject2" <?=($badge=="既存")?"disabled":""?> id="subject2" rows="3" value="<?=isset($rec['subject2'])?h($rec['subject2']):''?>"><?=isset($rec['subject2'])?h($rec['subject2']):''?></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlTextarea0">● 気づいたこと、感じたこと</label>
                  <textarea class="form-control" name="subject3" <?=($badge=="既存")?"disabled":""?> id="subject3" rows="3" value="<?=isset($rec['subject3'])?h($rec['subject3']):''?>"><?=isset($rec['subject3'])?h($rec['subject3']):''?></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">● そう感じた自分ついて言えること</label>
                  <textarea class="form-control" name="subject4" <?=($badge=="既存")?"disabled":""?> id="subject4" rows="3" value="<?=isset($rec['subject4'])?h($rec['subject4']):''?>"><?=isset($rec['subject4'])?h($rec['subject4']):''?></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlSelect1">● スタッフへの連絡</label>
                  <select class="form-control" name="subject5" <?=($badge=="既存")?"disabled":""?> id="subject5">
                    <option value="相談したい" <?=isset($rec)?is_selected($rec['subject5'], "相談したい"):''?>>相談したい</option>
                    <option value="つぎの課題が欲しい" <?=isset($rec)?is_selected($rec['subject5'], "つぎの課題が欲しい"):''?>>つぎの課題が欲しい</option>
                    <option value="やったことを報告したい" <?=isset($rec)?is_selected($rec['subject5'], "やったことを報告したい"):''?>>やったことを報告したい</option>
                    <option value="やり方を相談したい" <?=isset($rec)?is_selected($rec['subject5'], "やり方を相談したい"):''?>>やり方を相談したい</option>
                    <option value="その他" <?=isset($rec)?is_selected($rec['subject5'], "その他"):''?>>その他</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlSelect2">● やりたいこと</label>
                  <select multiple class="form-control" name="subject6" <?=($badge=="既存")?"disabled":""?> id="subject6">
                    <option value="本" <?=isset($rec)?is_selected($rec['subject6'], "本"):''?>>本</option>
                    <option value="ビデオ" <?=isset($rec)?is_selected($rec['subject6'], "ビデオ"):''?>>ビデオ</option>
                    <option value="テレビ" <?=isset($rec)?is_selected($rec['subject6'], "テレビ"):''?>>テレビ</option>
                    <option value="ラジオ" <?=isset($rec)?is_selected($rec['subject6'], "ラジオ"):''?>>ラジオ</option>
                    <option value="インターネット" <?=isset($rec)?is_selected($rec['subject6'], "インターネット"):''?>>インターネット</option>
                  </select>
                </div>
                <div class="form-group">
                  <input type="hidden" name="subject7" id="subject7" value="<?=$badge?>">
                  <input type="hidden" name="code_m" id="code_m" value="<?=(isset($rec)?h($rec['code']):$code)?>">
                  <input type="hidden" name="member_id" id="member_id" value="<?=(isset($rec)?h($rec['member_id']):$member_id)?>">
                  <input type="hidden" name="member_name" id="member_name" value="<?=(isset($rec)?h($rec['member_name']):$member_name)?>">
                </div>
                <div class="form-group">
                  <p>
                    <button type="submit" class="btn btn-primary" name="entry" id="btn_entry_m"><?=($badge=="既存"||$badge=="修正中")?"修正する":"保存する"?> </button>
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
