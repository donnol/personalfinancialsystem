<?php
	$output = json_encode($json);
	if( $output == null )
		$output = json_encode(array(
			'code'=>1,
			'msg'=>'输出中含有非UTF8编码',
			'data'=>''
		));
	echo $output;
?>
