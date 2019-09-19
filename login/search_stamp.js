$(function(){
	
	$('#stamp_name').on('input',function(){

		$('#result_error').empty();
		$('#result_success').empty();
		
		$.ajax({
			url:'./search_stamp.php',
			type:'POST',
			datatype: 'json',
			data:{
				'name' : $('#stamp_name').val()
			}
		})
		
		.done(function(data){

			var name = $('#stamp_name').val();
			if(name.search(/[^a-z0-9_]+/)　!== -1)
			{
				$('#result_error').html("<p>英数字、アンダーバー以外の文字が含まれています。</p>");
			}else
			{
				if(data == 1)
				{
					$('#result_error').html("<p>スタンプ名はすでに使われています</p>");
				}else if(data == 0)
				{
					$('#result_success').html("<p>使用可能です</p>");
				}else{
					$('#result_error').html("<p>スタンプ名を入力してください</p>");
					$('#result_success').empty();
				}
				console.log('通信成功');
				console.log(data);
				}
			})

		.fail(function(data){
			//$('#result_error').html(data);
			console.log('通信失敗');
			//cosole.log(data);
		});

	});
});
