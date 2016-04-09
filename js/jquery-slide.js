;(function($) {
	$.fn.slide = function(settings) {
		var _defaultSettings = {
			move_time:50,
			move_step:3,
			move_type:'fadeinout',
			start_one:true,
			start_wait:0,
			zindex_base:10000,
			navigate_ol:'',
			no_hover:false
		};
		var _settings = $.extend(_defaultSettings, settings);
		var _handler = function(index,element) {
			var _old_action, _action = function(){
				var sliding_go = 1,
					slide_timeout = null,
					slideShowFunction,
					$element = $(element),
					element_width = $(element).width(),
					element_height = $(element).height(),
					$child = $('li',element);
				var child_num,current_child=0;
				child_num = $child.length ;
				if( child_num <= 0 || child_num == 1 && !_settings.start_one)
					return ;
				$element.css({'overflow':'hidden','white-space':'nowrap'});
				switch(_settings.move_type){
					case 'slideshow':
						$child.css({'display':'block','float':'left','width':element_width+'px','height':element_height+'px'});
						$element.scrollLeft(element_width * current_child);
						$child.eq(current_child).clone().appendTo($('ul',element));
						if( _settings.navigate_ol != '' ){
							$(_settings.navigate_ol,$element.parent()).find('a').bind('click',function(){
								clearTimeout(slide_timeout);
								$(_settings.navigate_ol,$element.parent()).find('a').removeClass('slide-active');
								$(this).addClass('slide-active');
								current_child = $(this).attr('sliderindex') - 1;
								$element.scrollLeft(element_width * current_child);
								return false;
							});
						}
						break;
					case 'fadeinout':
						$element.css({'position':'relative'});
						$child.addClass('slide').css({'display':'block','position':'absolute','top':'0','left':'0','float':'none','z-index':'-1','width':element_width+'px','height':element_height+'px'});
						$child = $('li.slide',element);
						$child.eq(current_child).clone().prependTo($('ul',element)).removeClass('slide').addClass('slide-current').css('z-index',_settings.zindex_base);
						if( _settings.navigate_ol != '' ){
							$(_settings.navigate_ol,$element.parent()).find('a').bind('click',function(){
								clearTimeout(slide_timeout);
								$(_settings.navigate_ol,$element.parent()).find('a').removeClass('slide-active');
								$(this).addClass('slide-active');
								$('li.slide-current',element).stop(true, true).remove();
								current_child = ( $(this).attr('sliderindex') - 1 ) % child_num;
								$child.eq(current_child).clone().prependTo($('ul',element)).removeClass('slide').addClass('slide-current').css('z-index',_settings.zindex_base);
								return false;
							});
						}
						break;
					default:
						return ;
				}
				slideShowFunction = function(){
					if(slide_timeout)
						clearTimeout(slide_timeout);
					if(!sliding_go)
						return ;
					switch(_settings.move_type){
						case 'slideshow':
							$element.animate({'scrollLeft': element_width * (current_child + 1)}, 'normal',function(){
								current_child += 1;
								if(current_child == child_num)
									$element.scrollLeft((current_child=0));
								if( _settings.navigate_ol != '' ){
									$(_settings.navigate_ol,$element.parent()).find('a').removeClass('slide-active').end()
										.find('a[sliderindex="'+(current_child+1)+'"]').addClass('slide-active');
								}
							});
							break;
						case 'fadeinout':
							$child.eq((current_child + 1) % child_num).clone().prependTo($('ul',element)).removeClass('slide').addClass('slide-current').css('z-index',_settings.zindex_base - 1);
							$('li.slide-current:last',element).fadeTo('normal', 0, function(){
								current_child = (current_child + 1) % child_num;
								if( _settings.navigate_ol != '' ){
									$(_settings.navigate_ol,$element.parent()).find('a').removeClass('slide-active').end()
										.find('a[sliderindex="'+(current_child+1)+'"]').addClass('slide-active');
								}
								$(this).remove();
								$('li.slide-current:first',element).css('z-index',_settings.zindex_base);
							});
							break;
						default:
							return ;
					}
					slide_timeout = setTimeout(slideShowFunction,_settings.move_time);
				};
				$element.contents().filter(function () {
					return this.nodeType == 3;
				}).replaceWith('');
				if(!_settings.no_hover){
					$element.parent().mouseenter(function(){
						sliding_go = 0;
					}).mouseleave(function(){
						sliding_go = 1;
						slideShowFunction();
					});
				}
				slideShowFunction();
			};
			if( _settings.start_wait > 0 ){
				_old_action = _action;
				_action = function(){
					setTimeout(_old_action,_settings.start_wait);
				}
			}
			_action();
		};
		return this.each(_handler);
	};
})(jQuery);
