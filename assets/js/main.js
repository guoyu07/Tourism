$(function () {
    $('body').scrollspy({target: '#menu'});
    $("#menu a").click(function (e) {
	if ($(this).attr('href').indexOf('#') !== -1) {
	    var $target = $($(this).attr('href'));
	    if ($target.length && $target.hasClass('page')) {
		var offset = $target.offset().top;
		$("html, body").animate({"scrollTop": offset}, 700, 'easeInCubic');
	    }
	    e.preventDefault();
	}
    });

    if ($(".slideshow").length) {
	var $slideshowHome = $(".slideshow").not(".panorama");
	$slideshowHome.imagesLoaded(function () {
	    $slideshowHome.find("ul.items").caroufredsel({
		items: 1
		, auto: false
		, responsive: true
		, pagination: $slideshowHome.find(".pages")
		, next: $slideshowHome.find(".controls .next")
		, prev: $slideshowHome.find(".controls .prev")
		, scroll: {
		    items: 1
		    , fx: 'crossfade'
		}
	    });
	});
    }
    
    $(".contact-form").on('submit', function(e) {
//	console.log($(".contact-form").serialize());
	var er = [];
	var $f = $(".contact-form");
	if  ($f.find("[required]").length) {
	    $f.find("[required]").each(function () {
		if ($(this).val() === '') {
		    er.push($(this));
		}
	    });
	}
	if (er.length > 0) {
	    $.each(er, function (i, o) {
		er[i].parent().addClass('has-error');
	    });
	    return false;
	}
	$.ajax({
	    url: base + 'contacts'
	    , type: 'post'
	    , data: $f.serializeObject()
	    , success: function(d) {
		var response = d.split(':');
		if (response[0] !== "success")
		    alert(response[1]);
		else {
		    $(".results-container").fadeIn('fast');
		    $(".results-container").find(".inner").empty().text(response[1]).animate({'height': '100px', 'margin-top': '-50px'});
		    window.setTimeout(function() {
			$(".results-container").fadeOut('fast', function() {
			    $(".results-container").find(".inner").css({'height': '0', 'margin-top': '0'});
			});
		    }, 5000);
		}
	    }
	});
	e.preventDefault();
	return false;
    });
    $(document).on('click', ".results-container, .results-container .inner", function(e) {
	$(".results-container").fadeOut('fast', function() {
	    $(".results-container").find(".inner").css({'height': '0', 'margin-top': '0'});
	});
	e.preventDefault();
    });

    // Live Search
    $(".search form input[name=q]").keyup(function (e) {
	var $input = $(this);
	var $form = $input.parents("form:first");
	var $results = $form.parent().find(".search-resluts");
	console.log($results);
	if ($input.val().length > 3 && e.key !== 'enter') {
	    $input.addClass('loading');
	    $results.empty();
	    if (!$results.is(":hidden"))
		$results.fadeOut('fast');
	    $form.find('input[name=t]').val($.now());
	    $form.find('input[name=format]').val('raw');
	    $.ajax({
		url: 'index.php?option=com_k2&view=itemlist&task=search'
		, type: 'get'
		, data: $form.serialize()
		, success: function (d) {
		    $input.removeClass('loading');
		    $results.html(d).fadeIn('fast');
		}
	    });
	} else {
	    $results.empty();
	    if (!$results.is(":hidden"))
		$results.fadeOut('fast');
	}
    });
    $(document).on('focusout', ".search form", function() {
	$(".search .search-resluts").fadeOut('fast');
    }).on('focusin', ".search form", function() {
	if (!$(".search .search-resluts").is(":empty"))
	    $(".search .search-resluts").fadeIn('fast');
    });
    
    // Tiles
    $(".panel.tiles").on('click', ".tiles a", function(e) {
	var speed = [300, 500, 600, 600];
	var $tiles = $(".panel.tiles").find(".tiles li");
	var $container = $(".panel.tiles").children(".tiles");
	var $this = $(this);
	var $itemlist = $(".panel.tiles").find(".itemlist");
	var j = 0;
	for (var i = 1; i < 4; i++) {
	    $tiles.eq(i - 1).fadeOut(speed[j]);
	    $tiles.eq(7 - i).fadeOut(speed[j]);
	    j++;
	}
	$tiles.eq(0).promise().done(function() {
	    $tiles.eq(3).fadeOut(speed[1], function() {
		$container.hide(1, function() {
		    $itemlist.find(".inner").empty();
		    $itemlist.animate({'margin-top': -50});
		    $itemlist.slideDown(function() {
			$.ajax({
			    url: $this.attr('href')
			    , type: 'get'
			    , success: function(r) {
				$itemlist.find(".inner").empty().html(r).slideDown();
			    }
			});
		    });
		});
	    });
	});
	e.preventDefault();
	
	$(".panel.tiles").on('click', ".close", function(e) {
	    $itemlist.slideUp(function() {
		$container.show(1, function() {
		    $tiles.fadeIn(speed[0]);
		});
	    });
	    $itemlist.animate({'margin-top': 0}, function() {
		$itemlist.find(".inner").hide(1);
	    });
	});
    });
    $(document).on('click', ".panel.tiles .itemlist a", function(e) {
	var href = $(this).attr('href');
	$.ajax({
	    url: href
	    , type: 'get'
	    , data: 'format=raw'
	    , success: function(r) {
		$("#item-modal").find(".modal-body").empty().html(r);
		$("#item-modal").modal('show');
	    }
	});
	e.preventDefault();
    });
    

    var $content = $(".panel.content");
    $.fn.pages = function (options) {
	var o = $.extend({
	    next: $(this).find(".tools .next")
	    , prev: $(this).find(".tools .prev")
	}, options);
	return this.each(function () {
	    var $i = $(this);
	    o.next.on('click', function (e) {
		console.log('next');
		if ($i.find(".items li.active").next().is("li")) {
		    var $a = $i.find(".items li.active");
		    var $n = $a.next();
		    $n.animate({'height': '100%'}, 1000, 'easeOutExpo', function () {
			$n.addClass('active');
			$a.removeClass('active');
		    });
		}
		e.preventDefault();
	    });
	    o.prev.on('click', function (e) {
		console.log('prev');
		if ($i.find(".items li.active").prev().is("li")) {
		    var $a = $i.find(".items li.active");
		    var $p = $a.prev();
		    $p.animate({'height': '100%'}, 1000, 'easeOutExpo', function () {
			$p.addClass('active');
			$a.removeClass('active');
		    });
		}
		e.preventDefault();
	    });
	});
    };
    $content.each(function () {
	$(this).pages({
	    next: $(this).find(".next")
	    , prev: $(this).find(".prev")
	});
    });
});

/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 */
// t: current time, b: begInnIng value, c: change In value, d: duration
jQuery.easing['jswing'] = jQuery.easing['swing'];
jQuery.extend(jQuery.easing, {
    def: 'easeOutQuad',
    swing: function (x, t, b, c, d) {
	//alert(jQuery.easing.default);
	return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
    },
    easeInQuad: function (x, t, b, c, d) {
	return c * (t /= d) * t + b;
    },
    easeOutQuad: function (x, t, b, c, d) {
	return -c * (t /= d) * (t - 2) + b;
    },
    easeInOutQuad: function (x, t, b, c, d) {
	if ((t /= d / 2) < 1)
	    return c / 2 * t * t + b;
	return -c / 2 * ((--t) * (t - 2) - 1) + b;
    },
    easeInCubic: function (x, t, b, c, d) {
	return c * (t /= d) * t * t + b;
    },
    easeOutCubic: function (x, t, b, c, d) {
	return c * ((t = t / d - 1) * t * t + 1) + b;
    },
    easeInOutCubic: function (x, t, b, c, d) {
	if ((t /= d / 2) < 1)
	    return c / 2 * t * t * t + b;
	return c / 2 * ((t -= 2) * t * t + 2) + b;
    },
    easeInQuart: function (x, t, b, c, d) {
	return c * (t /= d) * t * t * t + b;
    },
    easeOutQuart: function (x, t, b, c, d) {
	return -c * ((t = t / d - 1) * t * t * t - 1) + b;
    },
    easeInOutQuart: function (x, t, b, c, d) {
	if ((t /= d / 2) < 1)
	    return c / 2 * t * t * t * t + b;
	return -c / 2 * ((t -= 2) * t * t * t - 2) + b;
    },
    easeInQuint: function (x, t, b, c, d) {
	return c * (t /= d) * t * t * t * t + b;
    },
    easeOutQuint: function (x, t, b, c, d) {
	return c * ((t = t / d - 1) * t * t * t * t + 1) + b;
    },
    easeInOutQuint: function (x, t, b, c, d) {
	if ((t /= d / 2) < 1)
	    return c / 2 * t * t * t * t * t + b;
	return c / 2 * ((t -= 2) * t * t * t * t + 2) + b;
    },
    easeInSine: function (x, t, b, c, d) {
	return -c * Math.cos(t / d * (Math.PI / 2)) + c + b;
    },
    easeOutSine: function (x, t, b, c, d) {
	return c * Math.sin(t / d * (Math.PI / 2)) + b;
    },
    easeInOutSine: function (x, t, b, c, d) {
	return -c / 2 * (Math.cos(Math.PI * t / d) - 1) + b;
    },
    easeInExpo: function (x, t, b, c, d) {
	return (t == 0) ? b : c * Math.pow(2, 10 * (t / d - 1)) + b;
    },
    easeOutExpo: function (x, t, b, c, d) {
	return (t == d) ? b + c : c * (-Math.pow(2, -10 * t / d) + 1) + b;
    },
    easeInOutExpo: function (x, t, b, c, d) {
	if (t == 0)
	    return b;
	if (t == d)
	    return b + c;
	if ((t /= d / 2) < 1)
	    return c / 2 * Math.pow(2, 10 * (t - 1)) + b;
	return c / 2 * (-Math.pow(2, -10 * --t) + 2) + b;
    },
    easeInCirc: function (x, t, b, c, d) {
	return -c * (Math.sqrt(1 - (t /= d) * t) - 1) + b;
    },
    easeOutCirc: function (x, t, b, c, d) {
	return c * Math.sqrt(1 - (t = t / d - 1) * t) + b;
    },
    easeInOutCirc: function (x, t, b, c, d) {
	if ((t /= d / 2) < 1)
	    return -c / 2 * (Math.sqrt(1 - t * t) - 1) + b;
	return c / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + b;
    },
    easeInElastic: function (x, t, b, c, d) {
	var s = 1.70158;
	var p = 0;
	var a = c;
	if (t == 0)
	    return b;
	if ((t /= d) == 1)
	    return b + c;
	if (!p)
	    p = d * .3;
	if (a < Math.abs(c)) {
	    a = c;
	    var s = p / 4;
	}
	else
	    var s = p / (2 * Math.PI) * Math.asin(c / a);
	return -(a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b;
    },
    easeOutElastic: function (x, t, b, c, d) {
	var s = 1.70158;
	var p = 0;
	var a = c;
	if (t == 0)
	    return b;
	if ((t /= d) == 1)
	    return b + c;
	if (!p)
	    p = d * .3;
	if (a < Math.abs(c)) {
	    a = c;
	    var s = p / 4;
	}
	else
	    var s = p / (2 * Math.PI) * Math.asin(c / a);
	return a * Math.pow(2, -10 * t) * Math.sin((t * d - s) * (2 * Math.PI) / p) + c + b;
    },
    easeInOutElastic: function (x, t, b, c, d) {
	var s = 1.70158;
	var p = 0;
	var a = c;
	if (t == 0)
	    return b;
	if ((t /= d / 2) == 2)
	    return b + c;
	if (!p)
	    p = d * (.3 * 1.5);
	if (a < Math.abs(c)) {
	    a = c;
	    var s = p / 4;
	}
	else
	    var s = p / (2 * Math.PI) * Math.asin(c / a);
	if (t < 1)
	    return -.5 * (a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b;
	return a * Math.pow(2, -10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p) * .5 + c + b;
    },
    easeInBack: function (x, t, b, c, d, s) {
	if (s == undefined)
	    s = 1.70158;
	return c * (t /= d) * t * ((s + 1) * t - s) + b;
    },
    easeOutBack: function (x, t, b, c, d, s) {
	if (s == undefined)
	    s = 1.70158;
	return c * ((t = t / d - 1) * t * ((s + 1) * t + s) + 1) + b;
    },
    easeInOutBack: function (x, t, b, c, d, s) {
	if (s == undefined)
	    s = 1.70158;
	if ((t /= d / 2) < 1)
	    return c / 2 * (t * t * (((s *= (1.525)) + 1) * t - s)) + b;
	return c / 2 * ((t -= 2) * t * (((s *= (1.525)) + 1) * t + s) + 2) + b;
    },
    easeInBounce: function (x, t, b, c, d) {
	return c - jQuery.easing.easeOutBounce(x, d - t, 0, c, d) + b;
    },
    easeOutBounce: function (x, t, b, c, d) {
	if ((t /= d) < (1 / 2.75)) {
	    return c * (7.5625 * t * t) + b;
	} else if (t < (2 / 2.75)) {
	    return c * (7.5625 * (t -= (1.5 / 2.75)) * t + .75) + b;
	} else if (t < (2.5 / 2.75)) {
	    return c * (7.5625 * (t -= (2.25 / 2.75)) * t + .9375) + b;
	} else {
	    return c * (7.5625 * (t -= (2.625 / 2.75)) * t + .984375) + b;
	}
    },
    easeInOutBounce: function (x, t, b, c, d) {
	if (t < d / 2)
	    return jQuery.easing.easeInBounce(x, t * 2, 0, c, d) * .5 + b;
	return jQuery.easing.easeOutBounce(x, t * 2 - d, 0, c, d) * .5 + c * .5 + b;
    }
});

$.fn.serializeObject = function () { // serializeArray - serialize form as an array instead of default object
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
	if (o[this.name] !== undefined) {
	    if (!o[this.name].push) {
		o[this.name] = [o[this.name]];
	    }
	    o[this.name].push(this.value || '');
	} else {
	    o[this.name] = this.value || '';
	}
    });
    return o;
};