;(function($) {

	window.main = {
		vars: {},
		init: function(){

			var header = main.vars.header = $('#header'),
				mainNavigation = header.mainNavigation = $('.main-navigation', header);


			$('.share-popup-btn').on('click', function(){
				var url = $(this).attr('href'),
					width = 640,
					height = 305,
					left = ($(window).width() - width) / 2,
					top = ($(window).height() - height) / 2;
				window.open(url, 'sharer', 'toolbar=0,status=0,width='+width+',height='+height+',left='+left+', top='+top);
				return false;
			});

			$('.print-btn').on('click', function(e){
				e.preventDefault();
				window.print();
			});

			$('.mobile-navigation-btn', header).on('click', function(){
				mainNavigation.slideToggle(200);
			});

			$('.menu-item .sub-menu', mainNavigation).parent().addClass('has-sub-menu');
			
			this.lightbox.init();
			this.ajaxPage.init();
			this.scroller.init();
			this.accordion.init();
		

			$(window).resize(this.resize);
			this.resize();

		},

		loaded: function(){
			$('body').addClass('loaded');
			this.equalHeight();
		},

		lightbox: {
			init: function(){
				var container = main.lightbox.container = $('#lightbox'),
					overlay = main.lightbox.overlay = $('.overlay', container),
					content = main.lightbox.content = $('.content', container),
					loader = main.lightbox.loader = $('.loader', container);

				$('.lightbox-btn').on('click', main.lightbox.open);
				overlay.on('click', main.lightbox.close);
				$(document).on('click', '#lightbox .close-btn', main.lightbox.close);
			},
			open: function(e){
				e.preventDefault();
				main.lightbox.load($(this).attr('href'));
			},
			load: function(url){
				var container = main.lightbox.container,
					overlay = main.lightbox.overlay,
					content = main.lightbox.content,
					loader = main.lightbox.loader,
					documentHeight = $(document).height(),
					windowHeight = $(window).height(),
					scrollTop = $(window).scrollTop(),
					ajaxUrl = main.addToUrl(url, 'ajax'),
					ajaxUrl = main.addToUrl(ajaxUrl, 'lightbox');

				container.height(documentHeight);
				container.show();
				loader.fadeIn();
				content.hide();
				overlay.fadeIn('slow', function(){
					
					$.get(ajaxUrl, function(data) {
						content.html(data)
						loader.fadeOut(function(){
							
							if($.fn.imagesLoaded){
								content.imagesLoaded(function(){
									var top = scrollTop + (windowHeight - content.height()) / 2;
									if(top + content.height() > documentHeight - 60){
										top = documentHeight - content.height() - 60;
									}
									content.animate({top: top}, function(){
										content.fadeIn();
									});
								});
							} else {
								var top = scrollTop + (windowHeight - content.height()) / 2;
								if(top + content.height() > documentHeight - 60){
									top = documentHeight - content.height() - 60;
								}
								container.animate({top: top}, function(){
									content.fadeIn();
								});
							}	
						});	
						
					});
				});	

			},
			close: function(){
				var container = main.lightbox.container,
					overlay = main.lightbox.overlay,
					content = main.lightbox.content;

				content.fadeOut(function(){
					overlay.fadeOut(function(){
						container.hide();
					});
					content.html();
				});
			}
		},

		accordion: {
			init: function(){
				if($.fn.accordion){
					$('.accordion').each(function(){
						var accordion = $(this),
							width = accordion.width(),
							totalItems = accordion.children().size(),
							tabWidth = (accordion.data('tab-width')) ? accordion.data('tab-width') : 32
							resizeChildren = (accordion.data('resize-children')) ? accordion.data('resize-children') : true,
							options = {
							//	easing: 'easeOutBounce',
							//	timeout: 5500,
								slideClass: 'item',
								tabWidth: tabWidth,
								width: width,
								height: 330,
								animationComplete: function(){
									var item = $(this);
									item.addClass(options.slideClass + '-opened')
								},
								animationStart: function(){
									var slideClass = options.slideClass;
									accordion.addClass('opened');
									$('.'+ slideClass, accordion).removeClass(slideClass + '-opened');
								},
								close: function(){
									var slideClass = options.slideClass;
									$('.'+ slideClass, accordion).removeClass(slideClass + '-opened');
								},
								closed: function(){
									accordion.removeClass('opened');
								}
							};

						accordion.accordion(options);

					});
				}
			}
		},

		scroller: {
			init: function(){

				if($.fn.scroller){
					$('.scroller').each(function(){
						var scroller = $(this);
						var options = {};

						if(scroller.hasClass('gallery-scroller') || scroller.data('scroll-all') === true) options.scrollAll = true;
						if(scroller.data('auto-scroll') === true ) options.autoScroll = true;
						if(scroller.data('resize') === true ) options.resize = true;
						if(scroller.data('callback')) {
							scroller.bind('onChange', function(e, nextItem){
								var func = window[scroller.data('callback')];
								func($(this), nextItem);
							});
						}

						scroller.scroller(options);
					});
				}
			}
		},


		ajaxPage: {
			init: function(){
				var container = main.ajaxPage.container = $('#ajax-page'),
					//currUrl = main.ajaxPage.currUrl = window.location.href;
					pageUrl = main.ajaxPage.pageUrl = window.location.href;
				
				$('.ajax-btn').on('click', function(e){
					main.ajaxPage.load($(this).attr('href'));
					return false;
				});

			},
			load: function(url){

				var container = main.ajaxPage.container,
					ajaxUrl = main.addToUrl(url, 'ajax');

				
				container.slideDown(2000);
			    if($('.content', container).length == 0){

					loader = $('<div class="loader"></div>').hide();
					container.animate({height: loader.actual('outerHeight')}, function(){
						loader.fadeIn();

						$.get(ajaxUrl, function(data) {
							var content = $('<div class="content"></div>').hide();

							container.html(content);
							content.html(data);
							loader.fadeOut(function(){
								if($.fn.imagesLoaded){
									content.imagesLoaded(function(){
										container.animate({'height': content.height()}, function(){
											container.css({'height': 'auto'});
											content.fadeIn();
											container.slideDown('slow');
										});
									});
								} else {
									container.animate({'height': content.actual('height')}, function(){
										container.css({'height': 'auto'});
										content.fadeIn();
									});
								}	
							});

						});
					});
				} else {
					var content = $('.content', container),
						loader = $('<div class="loader"></div>').hide();
					container.prepend(loader);
					content.fadeTo(300, 0, function(){
						loader.fadeIn();
						$.get(ajaxUrl, function(data) {
							content.html(data);
							loader.fadeOut(function(){
								container.animate({'height': content.actual('height')}, function(){
									content.fadeTo(300, 1);
									container.css({'height': 'auto'});
								});
							});
						});
					});
				}

				//main.ajaxPage.currUrl = url;
			}, 
			close: function(){
				var container = main.ajaxPage.container;

				container.slideUp(function(){
					container.html('');
				});

				//if(Modernizr.history) history.pushState(null, null, main.ajaxPage.pageUrl);
			}
		},

		addToUrl: function(url, query){
			var regex = new RegExp('(\\?|\\&)'+query+'=.*?(?=(&|$))'),
		        qstring = /\?.+$/;

			if (regex.test(url)){
		        url = url.replace(regex, '$1'+query+'=true');
		    } else if (qstring.test(url)) {
		        url = url + '&'+query+'=true';
		    } else {
		        url =  url + '?'+query+'=true';
		    }

		    return url;		
		},

		equalHeight: function(){
			if($('.equal-height').length !== 0){
		
				var currTallest = 0,
				currRowStart = 0,
				rowDivs = new Array(),
				topPos = 0;

				$('.equal-height').each(function() {

					var element = $(this);
					topPos = element.position().top;
					if (currRowStart != topPos) {

						for (i = 0 ; i < rowDivs.length ; i++) {
							rowDivs[i].height(currTallest);
						}

						rowDivs.length = 0;
						currRowStart = topPos;
						currTallest = element.height();
						rowDivs.push(element);

					} else {
						rowDivs.push(element);
						currTallest = (currTallest < element.height()) ? (element.height()) : (currTallest);
					}

					for (i = 0 ; i < rowDivs.length ; i++) {
						rowDivs[i].height(currTallest);
					}

				});
			}
		},

		resize: function(){
			var windowWidth = $(window).width(),
				mainNavigation = main.vars.header.mainNavigation;
			
			if(windowWidth <= 600 && mainNavigation.is(':visible')){
				mainNavigation.hide();
			} else if(windowWidth > 600 && !mainNavigation.is(':visible')) {
				mainNavigation.show();
			}
		}
	}

	$(function(){
		main.init();
	});

	$(window).load(function(){
		main.loaded();
	});
})(jQuery);