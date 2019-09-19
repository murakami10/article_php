if(window.performance.navigation.type == 1)
{
	var url = location.protocol + "//" + location.host + location.pathname;
	location.href = url;
   }

   if(location.hash == "#pass")
   {
	console.log("success");
	$("#msg").fadeIn(3000);
}else{
	$("#msg").hide();
   }

function submitChk(){
	var flag =confirm("本当に削除してよろしいですか");
	if(flag == false){
		alert("キャンセルされました");
	} 
	return flag;
}