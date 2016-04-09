;(function($){
	var ErrorElement = '', ErrorFindStatement = '', handleValidateError, submitValidate;
	handleValidateError = function(e,parent,message){
		alert(message);
	}
	submitValidate = function(f){
		var result = true, checked = [], $f = $(f),Error;
		Error = function(t,r,m){
			handleValidateError(t.parent(),true,t.attr('title') + m);
			t.focus();
			result = false;
			return result;
		};
		if(ErrorFindStatement != '')
			$f.find(ErrorFindStatement).remove();
		$('div.error',$f).remove();
		$('[validate="validate"]',$f).each(function() {
			var $this = $(this),
				$val =  $.trim($this.val()),
				$type = $this.attr('type'),
				$name = $this.attr('name'),
				$parent = $this.parent(),
				$required = false,
				required_by, required_by_value, required_by_element, required_by_type, target,
				$min, $max, required_except_by, required_except_by_value, required_except_by_element, required_no_allow,
				length,
				type_check_valid,
				sYear, sMonth, sDay, month_limit_days;
			if( !$name || $name == 'undefined' || checked[$name] ) return;
			checked[$name] = true;
			required_by = $this.attr('requiredby');
			required_by_value = $this.attr('requiredbyvalue');
			if( required_by != '' && required_by != 'undefined' && required_by_value != 'undefined' ){
				required_by_element = $("[name='"+required_by+"']",$f);
				if( required_by_element.length > 0 ){
					required_by_type = required_by_element.eq(0).attr('type');
					required_by_type = (!required_by_type || required_by_type == '') ? required_by_element[0].tagName : required_by_type;
					switch(required_by_type){
						case 'radio':
						case 'checkbox':
							target = $("input[name='"+required_by+"'][value='"+required_by_value+"']");
							if( !target.attr('checked') ) return ;
							break;
						case 'select-one':
							target = required_by_element.eq(0);
							if( target.val() != required_by_value ) return ;
							break;
						default:
							break;
					}
				}
			}
			if($this.attr('required')){
				$required = true;
				$type = (!$type || $type == 'undefined') ? this.tagName : $type;
				$min = parseInt($this.attr('requiredmin'),10);
				$max = parseInt($this.attr('requiredmax'),10);
				$min = (!$min || $min == 'undefined') ? 1 : $min;
				$max = (!$max || $max == 'undefined') ? 0 : $max;
				switch($type){
					case 'text':
					case 'textarea':
						if( !$val || $val == 'undefined' || (length = $val.length) == 0 )
							return Error($this, false, '需要填寫。');
						if(  length < $min )
							return Error($this, false, '至少輸入'+$min+'個字。');
						if( $max != 0 && length > $max )
							return Error($this, false, '最多輸入'+$max+'個字。');
						break;
					case 'select-one':
						required_except_by = $this.attr('requiredexceptby');
						required_except_by_value = $this.attr('requiredexceptbyvalue');
						if( required_except_by != '' && required_except_by != 'undefined' && required_except_by_value != 'undefined' ){
							required_except_by_element = $("[name='"+required_except_by+"']",$f);
							if( required_except_by_element.length > 0 ){
								if( required_except_by_element.eq(0).val() == required_except_by_value )
									return ;
							}
						}
						if( !$val || $val == 'undefined' )
							return Error($this, false, '需要選擇。');
						required_no_allow = $this.attr('requirednoallow');
						required_no_allow = (!required_no_allow || required_no_allow == 'undefined') ? '' : required_no_allow;
						if( $val == required_no_allow )
							return Error($this, false, (required_no_allow == '') ? '需要選擇。' : '不允許為：' + required_no_allow + '。');
						break;
					case 'radio':
						if( $("input:radio[name='"+$name+"']:checked",$parent).length != 1 )
							return Error($this, false, '需要選擇1項。');
						break;
					case 'checkbox':
						length = $("input:checkbox[name='"+$name+"']:checked",$parent).length;
						if(  length < $min )
							return Error($this, false, '至少選擇'+$min+'項。');
						if( $max != 0 && length > $max )
							return Error($this, false, '最多選擇'+$max+'項。');
						break;
					case 'file':
						if( !$val || $val == 'undefined' || $val.length == 0 )
							return Error($this, false, '需要選擇檔案。');
						break;
					default:
						break;
				}
			}
			type_check_valid = true;
			switch($this.attr('requiredtype')){
				case 'date':
					if(! (type_check_valid = /^\d{4}[-\/]\d{2}[-\/]\d{2}$/.test($val)))
						break;
					sYear = parseInt($val.substr(0,4),10);
					sMonth = parseInt($val.substr(5,2),10);
					sDay = parseInt($val.substr(8,2),10);
					month_limit_days = 31;
					if(sMonth == 2)
						month_limit_days = ( sYear%100 != 0 && sYear%4 == 0 || sYear%400 == 0) ? 29 : 28;
					else if($.inArray(sMonth,[1,3,5,7,8,10,12]) >= 0)
						month_limit_days = 31;
					else
						month_limit_days = 30;
					type_check_valid = (sDay >= 1 && sDay <= month_limit_days) ? true : false;
					break;
				case 'alnum':
					type_check_valid = (/^[A-Za-z0-9]+$/.test($val));
					break;
				case 'alpha':
					type_check_valid = (/^[A-Za-z]+$/.test($val));
					break;
				case 'digit':
					type_check_valid = (/^\d+$/.test($val));
					break;
				case 'tel':
					type_check_valid = ( (/^0[0-9]{1,2}[-]?[0-9-]{6,9}$/.test($val)) || (/^09[0-9]{2}[-]?[0-9]{3}[-]?[0-9]{3}$/.test($val)) );
					break;
				case 'phone':
					type_check_valid = (/^0[0-9]{1,2}[-]?[0-9-]{6,9}$/.test($val));
					break;
				case 'mobile':
					type_check_valid = (/^09[0-9]{2}[-]?[0-9]{3}[-]?[0-9]{3}$/.test($val));
					break;
				case 'email':
					type_check_valid = (/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i.test($val));
					break;
				default:
					break;
			}
			if( ( !$required || type_check_valid ) === false)
				return Error($this, false, '格式錯誤。');
			
			return ;
		});
		return result;
	}
	$(function($){
		$('#submit-form').bind('submit',function(){ return submitValidate(this); }).bind('reset',function(){ 
			if(ErrorFindStatement != '')
				$(this).find(ErrorFindStatement).remove(); 
		});
	});
})(jQuery);