<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
<!-- 
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
 -->
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">New message</h5>
				<button type="button" class="close" id="btn_close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
			</div>
			<div class="modal-body p-4">
				<!--<form id="form_1" action="member-entry.php" method="post"  return false>-->
				<form id="form_1">
					<div class="result" id="login_result_disp" style="color:red; font-weight:bold;"></div>
					<div id="info"></div>
					<div class="form-group">
						<input type="hidden" class="form-control" name="process" id="process" value="@login">
					</div>
					<div class="form-group" id="name_div">
						<label for="recipient-name" class="col-form-label">お名前を入力してください。</label>
						<input type="text" class="form-control mr-5" name="name" id="name" required>
					</div>
					<div class="form-group" id="password_div">
						<label for="message-text" class="col-form-label">暗証番号を入力してください。（４桁の数字）</label>
						<input type="text" pattern="\d*" class="form-control" name="password" id="password" required>
						<input type="hidden" class="form-control mr-5" name="is_staff" id="is_staff" value="一般利用者">
					</div>
					<div class="form-group mt-5 text-right">
						<p>
              <button type="button" class="btn btn-primary" name="entry" id="btn_entry">登録</button>
							<button type="button" class="btn btn-secondary btn-sm" id="btn_cancel" data-dismiss="modal">取消</button>
						</p>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	
	// ログインモーダルの表示時の処理
	$( '#loginModal' ).on( 'show.bs.modal', function ( event ) {
    var button = $( event.relatedTarget );
		var recipient = button.data( 'whatever' );
		var modal = $( this )
		var name_div_str = '<label for=\"recipient-name\" class=\"col-form-label\">お名前を入力してください。</label><input type=\"text\" class=\"form-control\" name=\"name\" id=\"name\">';
		var password_div_str = '<label for="message-text" class="col-form-label">暗証番号を入力してください。（４桁の数字）</label><input type="text" class="form-control" name="password" id="password"><input type="hidden" class="form-control"name="is_staff" id="is_staff" value="一般利用者">';
		if ( recipient == "@logout" ) {
			modal.find( '#name_div' ).html( '<label class="col-form-label">ログアウトしますか？</label>' );
			modal.find( '#password_div' ).html( '' );
			modal.find( '.modal-title' ).text( 'ログアウト' )
			modal.find( '#btn_entry' ).text( 'ログアウト' );
		} else {
			modal.find( '#name_div' ).html( name_div_str );
			modal.find( '#password_div' ).html( password_div_str );
			modal.find( '.modal-title' ).text( 'ログイン' );
			modal.find( '#btn_entry' ).text( 'ログイン/新規' );
		}
		modal.find( '#process' ).val( recipient );
	} )

	function replaceAll( strBuffer, strBefore, strAfter ) {
		return strBuffer.split( strBefore ).join( strAfter );
	}

	// クッキーにログイン状態をセットする
	function set_login_status( name ) {
		$.ajax( {
				url: './get_member_entry.php',
				type: 'POST',
				async: false,
				data: {
					'member_name': name
				}
			} )
			// Ajaxリクエストが成功した時発動
			.done( ( data ) => {
				if ( data == '<NOENTRY>' ) {
					return false;
				} else {
					var result = data.split( '<AND>' );
					var member_id = replaceAll( result[ 0 ].trim(), "\"", "" );
					var member_name = replaceAll( result[ 1 ].trim(), "\"", "" );
					var is_staff = replaceAll( result[ 2 ].trim(), "\"", "" );
					document.cookie = 'login=' + 'YES';
					document.cookie = 'member_id=' + member_id + '; ' + 'max-age=' + "max-age=" + 60 * 60 * 24 + ';';
					document.cookie = 'member_name=' + member_name + '; ' + 'max-age=' + "max-age=" + 60 * 60 * 24 + ';';
					document.cookie = 'is_staff=' + is_staff + '; ' + 'max-age=' + "max-age=" + 60 * 60 * 24 + ';';
					return true;
				}
			} )
			// Ajaxリクエストが失敗した時発動
			.fail( ( data ) => {
				return false;
			} )
			// Ajaxリクエストが成功・失敗どちらでも発動
			.always( ( data ) => {
			
			} );
	}

	// クッキーのログイン状態をクリアする
	function reset_login_status( ) {
		if ( is_logined_now() == true ) {
			document.cookie = 'login="NO"; ' + 'max-age=' + '0' + ';';
			document.cookie = 'member_id="' + '0' + '"; ' + 'max-age=' + '0' + ';';
			document.cookie = 'member_name="' + '' + '"; ' + 'max-age=' + '0' + ';';
			document.cookie = 'is_staff="' + '' + '"; ' + 'max-age=' + '0' + ';';
      document.cookie = 'current_tab="' + '' + '"; ' + 'max-age=' + '0' + ';';
		}
	}
	
	// そのメンバーが存在するかどうかを返す
	function exist_the_member( member_name ) {
		var flag = false;
		$.ajax( {
				url: 'exist_the_member.php',
				type: 'POST',
				async: false,
				data: {
					'member_name': member_name
				},
			} )
			// Ajaxリクエストが成功した時発動
			.done( ( data ) => {
        if ( data == '<EXIST>' ) {
					flag = true;
				} else {
					flag = false;
				}
			} )
			// Ajaxリクエストが失敗した時発動
			.fail( ( data ) => {
        flag = false;
			} )
			// Ajaxリクエストが成功・失敗どちらでも発動
			.always( ( data ) => {
      
			} );
		return flag;
		
	}

	// メンバーをDBに登録する処理
	function member_entry( member_name, password, is_staff ) {

		$.ajax( {
				url: 'member_entry.php',
				type: 'POST',
				async: false,
				data: {
					'member_name': member_name,
					'password': password,
					'is_staff': is_staff
				}
			} )
			// Ajaxリクエストが成功した時発動
			.done( ( data ) => {
				if (data == '0') {
					alert( "申し訳ございません。お名前の登録に失敗しました。 " + member_name + " 様(done)" + data);
					return false;
				} else {
					return true;
				}
			} )
			// Ajaxリクエストが失敗した時発動
			.fail( ( data ) => {
        alert( "申し訳ございません。お名前の登録に失敗しました。 " + member_name + " 様(fail)" + data );
				return false;
			} )
			// Ajaxリクエストが成功・失敗どちらでも発動
			.always( ( data ) => {

			} );
		return false;
	}

	// クッキーに現在ログイン状態？
	function is_logined_now() {
		var result = document.cookie.indexOf( 'login' );
		if ( result !== -1 ) {
			var r = document.cookie.split( ';' );
			for ( var i = 0; i < r.length; ++i ) {
				var content = r[ i ].split( '=' );
				if ( content[ 0 ].indexOf( 'login' ) >= 0 ) {
					return ( content[ 1 ] == 'YES' );
				}
			}
		}
		return false;
	}
	
	// クッキーのメンバーIDをGET
	function get_member_id() {
		var result = document.cookie.indexOf( 'login' );
		if ( result !== -1 ) {
			var r = document.cookie.split( ';' );
			for ( var i = 0; i < r.length; ++i ) {
				var content = r[ i ].split( '=' );
				if ( content[ 0 ].indexOf( 'member_id' ) >= 0 ) {
					return content[ 1 ];
				}
			}
		}
		return "";
	}

	// クッキーのメンバーNAMEをGET
	function get_member_name() {
		var result = document.cookie.indexOf( 'login' );
		if ( result !== -1 ) {
			var r = document.cookie.split( ';' );
			for ( var i = 0; i < r.length; ++i ) {
				var content = r[ i ].split( '=' );
				if ( content[ 0 ].indexOf( 'member_name' ) >= 0 ) {
					return content[ 1 ];
				}
			}
		}
		return "";
	}
  
  // クッキーのアクティブなタブをGET
	function get_current_tab() {
		var result = document.cookie.indexOf( 'current_tab' );
		if ( result !== -1 ) {
			var r = document.cookie.split( ';' );
			for ( var i = 0; i < r.length; ++i ) {
				var content = r[ i ].split( '=' );
				if ( content[ 0 ].indexOf( 'current_tab' ) >= 0 ) {
					return ( content[ 1 ] );
				}
			}
		}
		return "";
	}
  // クッキーにアクティブなタブを保存
	function save_current_tab(tab_name) {
    document.cookie = 'current_tab=' + tab_name + '; ' + 'max-age=' + "max-age=" + 60 * 60 * 24 + ';';
	}
	
	// ログイン/ログアウト　ボタン押下時の処理
	$( function () {
		$( '#btn_entry' ).on( 'click', function () {
			if ( is_logined_now() == true ) {	// ログイン中の場合はクッキーをクリアしてログイン状態を解除する
				reset_login_status( );	// ログイン状態をリセット
			}	
			else {			// ログインしていない場合はクッキーを設定する
        if ($( '#password' ).val().length != 4) {
          alert("暗証番号は４桁で入力してください" + $( '#password' ).val().length);
          return;
        }
				if ( exist_the_member( $( '#name' ).val() ) == false ) {	// その名前がすでにあるか検証　－　ない場合新規に登録するか？を訊く
					var answer = confirm( 'ユーザー名が見つかりません。新規登録しますか？' );
					if ( answer ) {
						member_entry( $( '#name' ).val(), $( '#password' ).val(), $( '#is_staff' ).val() );		// データベースに新規登録
					}
				}
				set_login_status( $( '#name' ).val() );	// ログイン状態にセット
			}
			location.reload();	// 親画面をリロード
			$( '#loginModal' ).modal( 'hide' );	// ダイアログを消す
		} )
	} );


</script>