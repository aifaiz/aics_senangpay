<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<title>Connecting...</title>
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
		<!--[if lt IE 9]>
		<script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="col-xs-12">
			<h1 class="text-center">Connecting to Payment...</h1>
			<div class="text-center">
				<i class="fa fa-circle-o-notch fa-spin fa-5x fa-fw"></i>
			</div>
			<form id="sngpyfm" action="https://app.senangpay.my/payment/{$mkey}" method="POST">
				<input type="hidden" name="detail" value="{$detail}">
				<input type="hidden" name="amount" value="{$amount}">
				<input type="hidden" name="order_id" value="{$order_id}">
				<input type="hidden" name="hash" value="{$hash}">
				<input type="hidden" name="name" value="{$name}">
				<input type="hidden" name="email" value="{$email}">
				<input type="hidden" name="phone" value="{$phone}">
				
			</form>
		</div><!-- 12 -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		{literal}
		<script>
		$(document).ready(function(){
			$('#sngpyfm').submit();
		});
		</script>
		{/literal}
	</body>
</html>