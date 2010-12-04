function decode() {
	if($('#packed').val() != '') {
		var packed = document.getElementById('packed');
		eval("packed.value=String" + packed.value.slice(4));
		$.jGrowl("Decoding File...", { header: "NOTICE:", life: 3000, theme: "ginfo" });
	}
	else {
		$.jGrowl("Cannot Decode File, your Packed Result is Empty", { header: "ERROR:", life: 3000, theme: "gerror" });
	}
}
function validate(){
	$('#submitButton').val('Processing...');
	$('#submitButton').attr({"disabled": true});
	$('#submitButton').blur();
	if(($('#src').val() == 'Upload Source File above, or Paste Code Here ...' || $('#src').val() == '') && $('#srcfile').val() == '') {
		$.jGrowl("Please Choose/Paste Source File", { header: "ERROR:", life: 3000, theme: "gerror" });
		$('#submitButton').removeAttr("disabled");
		$('#submitButton').val('Compact');
		return false;
	}
	else {
		$.jGrowl("Compacting File...", { header: "NOTICE:", life: 3000, theme: "ginfo" });
		return true;
	}
}
function jsvalidate(){
	if($('#packed').val() == '') {
		$.jGrowl("Cannot Download File, your Packed Result is Empty", { header: "ERROR:", life: 3000, theme: "gerror" });
		return false;
	}
	else {
		$.jGrowl("Downloading File...", { header: "NOTICE:", life: 3000, theme: "ginfo" });
		return true;
	}
}

$().ready(function(){
	$('.button').click(function() {
		this.blur();
	});		   
});