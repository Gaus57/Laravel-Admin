function catalogContent(elem){
	//var url = $(elem).attr('href');
	//sendAjax(url, {}, function(html){
	//	$('#catalog-content').html(html);
	//}, 'html');
	//return false;
}

function catalogSave(form, e){
	var url = $(form).attr('action');
	var data = $(form).serialize();
	sendAjax(url, data, function(json){
		if (typeof json.row != 'undefined') {
			if ($('#users-list tr[data-id='+json.id+']').length) {
				$('#users-list tr[data-id='+json.id+']').replaceWith(urldecode(json.row));
			} else {
				$('#users-list').append(urldecode(json.row));
			}
		}
		if (typeof json.errors != 'undefined') {
			applyFormValidate(form, json.errors);
			var errMsg = [];
			for (var key in json.errors) { errMsg.push(json.errors[key]);  }
			$(form).find('[type=submit]').after(autoHideMsg('red', urldecode(errMsg.join(' '))));
		}
		if (typeof json.redirect != 'undefined') document.location.href = urldecode(json.redirect);
		if (typeof json.msg != 'undefined') $(form).find('[type=submit]').after(autoHideMsg('green', urldecode(json.msg)));
		if (typeof json.success != 'undefined' && json.success == true) {
			
		}
	});
	return false;
}

function catalogDel(elem){
	if (!confirm('Удалить раздел?')) return false;
	var url = $(elem).attr('href');
	sendAjax(url, {}, function(json){
		if (typeof json.msg != 'undefined') alert(urldecode(json.msg));
		if (typeof json.success != 'undefined' && json.success == true) {
			$(elem).closest('li').fadeOut(300, function(){ $(this).remove(); });
		}
	});
	return false;
}

function productSave(form, e){
	var url = $(form).attr('action');
	var data = $(form).serialize();
	sendAjax(url, data, function(json){
		if (typeof json.errors != 'undefined') {
			applyFormValidate(form, json.errors);
			var errMsg = [];
			for (var key in json.errors) { errMsg.push(json.errors[key]);  }
			$(form).find('[type=submit]').after(autoHideMsg('red', urldecode(errMsg.join(' '))));
		}
		if (typeof json.redirect != 'undefined') document.location.href = urldecode(json.redirect);
		if (typeof json.msg != 'undefined') $(form).find('[type=submit]').after(autoHideMsg('green', urldecode(json.msg)));
	});
	return false;
}

function productDel(elem){
	if (!confirm('Удалить товар?')) return false;
	var url = $(elem).attr('href');
	sendAjax(url, {}, function(json){
		if (typeof json.msg != 'undefined') alert(urldecode(json.msg));
		if (typeof json.success != 'undefined' && json.success == true) {
			$(elem).closest('tr').fadeOut(300, function(){ $(this).remove(); });
		}
	});
	return false;
}

function productImageUpload(elem, e){
	var url = $(elem).data('url');
	files = e.target.files;
	var data = new FormData();
    $.each(files, function(key, value)
    {
        data.append('images[]', value);
    });
    $(elem).val('');

    sendFiles(url, data, function(json){
    	if (typeof json.html != 'undefined') {
        	$('.images_list').append(urldecode(json.html));
        	if (!$('.images_list img.active').length) {
        		$('.images_list .img_check').eq(0).trigger('click');
        	}
        }
    });
}

function productCheckImage(elem){
	$('.images_list img').removeClass('active');
	$('.images_list .img_check .glyphicon').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
	
	$(elem).find('.glyphicon').removeClass('glyphicon-unchecked').addClass('glyphicon-check');
	$(elem).siblings('img').addClass('active');

	$('#product-image').val($(elem).siblings('img').data('image'));
	return false;
}

function productImageDel(elem){
	if (!confirm('Удалить изображение?')) return false;
	var url = $(elem).attr('href');
	sendAjax(url, {}, function(json){
		if (typeof json.msg != 'undefined') alert(urldecode(json.msg));
		if (typeof json.success != 'undefined' && json.success == true) {
			$(elem).closest('.images_item').fadeOut(300, function(){ $(this).remove(); });
		}
	});
	return false;
}