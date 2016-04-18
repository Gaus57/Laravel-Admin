function pageContent(elem){
	// Раскоментировать если нужно чтобы страницы грузились аяксом
	//var url = $(elem).attr('href');
	//sendAjax(url, {}, function(html){
	//	$('#page-content').html(html);
	//}, 'html');
	//return false;
}

function pageSave(form, e){
	var url = $(form).attr('action');
	var data = new FormData();
	$.each($(form).serializeArray(), function(key, value){
	    data.append(value.name, value.value);
	});
	$.each(settingFiles, function(key, value){
	    data.append(key, value);
	});
	sendFiles(url, data, function(json){
		if (typeof json.errors != 'undefined') {
			applyFormValidate(form, json.errors);
			var errMsg = [];
			for (var key in json.errors) { errMsg.push(json.errors[key]);  }
			$(form).find('[type=submit]').after(autoHideMsg('red', urldecode(errMsg.join(' '))));
		}
		if (typeof json.redirect != 'undefined') document.location.href = urldecode(json.redirect);
		if (typeof json.msg != 'undefined') $(form).find('[type=submit]').after(autoHideMsg('green', urldecode(json.msg)));
		if (typeof json.row != 'undefined') {
			var id = $('#page-id').val();
			$('#pages-tree li[data-id='+id+'] .tree-item').replaceWith(urldecode(json.row));
			var parent = $('#page-content [name=parent_id]').val();
			var cur_parent = $('#pages-tree li[data-id='+id+']').closest('ul').closest('li').data('id') || 0;
			if (cur_parent != parent) {
				var item = $('#pages-tree li[data-id='+id+']').clone();
				$('#pages-tree li[data-id='+id+']').remove();
				if (parent == 0) {
					$('#pages-tree > .tree-lvl').append(item);
				} else {
					$('#pages-tree li[data-id='+parent+'] > ul').append(item);
				}
			}
			console.log('id = '+id+', parent = '+parent+', cur_parent = '+cur_parent);
		}
		if (typeof json.success != 'undefined' && json.success == true) {
			settingFiles = {};
		}
	});
	return false;
}

function pageDel(elem){
	if (!confirm('Удалить страницу?')) return false;
	var url = $(elem).attr('href');
	sendAjax(url, {}, function(json){
		if (typeof json.msg != 'undefined') alert(urldecode(json.msg));
		if (typeof json.success != 'undefined' && json.success == true) {
			$(elem).closest('li').fadeOut(300, function(){ $(this).remove(); });
		}
	});
	return false;
}