$(function(){
	
	$('#id_number').on('input',function(){
		
		$('#result_error').empty();
		$('#result_success').empty();
		
		$.ajax({
			url:'./dbconnect.php',
			type:'POST',
			datatype: 'json',
			data:{
				'id' : $('#id_number').val()
			}
		})
		
		.done(function(data){
			if(data == 1)
			{
				$('#result_error').html("<p>そのログインIDはすでに使われています</p>");
			}else if(data == 0)
			{
				$('#result_success').html("<p>使用可能です</p>");
			}else{
				$('#result_error').html("<p>ログインIDを入力してください</p>");
			}
	
			console.log('通信成功');
			console.log(data);
			})

		.fail(function(data){
			//$('#result_error').html(data);
			console.log('通信失敗');
			cosole.log(data);
		});

	});
});

















