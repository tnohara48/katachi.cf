<?php
header( 'Content-type: text/plain; charset= UTF-8' );

require_once( './common/common.php' );

require_once( './create_table_qa_sub.php' );

create_tab_qa_sub( "", $_POST[ 'member_id_qa' ], $_POST[ 'member_name_qa' ] );

?>