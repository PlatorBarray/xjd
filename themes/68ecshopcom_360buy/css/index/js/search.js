$(function () {
    //通用头部搜索切换
    $('#search-hd .search-input').on('input propertychange', function () {
        var val = $(this).val();
        if (val.length > 0) {
            $('#search-hd .pholder').hide(0);
        } else {
            var index = $('#search-bd li.selected').index();
            $('#search-hd .pholder').eq(index).show().siblings('.pholder').hide(0);
        }
    })
    $('#search-bd li').click(function () {
        var index = $(this).index();
        $('#search-hd .pholder').eq(index).show().siblings('.pholder').hide(0);
        $('#search-hd .search-input').eq(index).show().siblings('.search-input').hide(0);
        $(this).addClass('selected').siblings().removeClass('selected');
        $('#search-hd .search-input').val('');
    });
})


//悬浮jQuery
function eee() {
    var sTop = $(window).scrollTop();
    var sTop = parseInt(sTop);
    if (sTop >= 100) {
        if (!$("#hp_searchFollow").is(":visible")) {
            try {
                $("#hp_searchFollow").slideDown();
            } catch (e) {
                $("#hp_searchFollow").show();
            }
        }
    } else {
        if ($("#hp_searchFollow ").is(":visible")) {
            try {
                $("#hp_searchFollow").slideUp();
            } catch (e) {
                $("#hp_searchFollow").hide();
            }
        }
    }
    if (sTop >= 250) {
        if (!$("#leftlei").is(":visible")) {
            try {
                $("#leftlei").slideDown();
            } catch (e) {
                $("#leftlei").show();
            }
        }
    } else {
        if ($("#leftlei").is(":visible")) {
            try {
                $("#leftlei").slideUp();
            } catch (e) {
                $("#leftlei").hide();
            }
        }
    }
}


$(function () {
    $(window).bind("scroll", function () {
        eee();
    });
})

//底部jQuery
function closeThis() {
    $(".nav-footer").animate({
        "bottom": -200 + "px"
    }, 300, function () {
        $(this).remove();
    });
    $(".di_bu").css("margin-bottom", "0px");
}
$(window).scroll(function () {
    if ($(window).scrollTop() >= $(window).height()) {
        $(".nav-footer").show();

    }
    if ($(window).scrollTop() < $(window).height()) {
        $(".nav-footer").hide();
    }
});

//右侧jQuery


$(document).ready(function () {
    $(".vbar-hide").click(function () {
        $(".vbar #box").animate({
            width: (0) + "px"
        });
        $(this).parent().parent().slideToggle();
        $(this).parent().parent().parent().find(".vbar-sub").slideToggle();
    })
    $(".vbar-show").click(function () {
        $(this).parent().slideToggle();
        $(this).parent().parent().find(".vbar-main").slideToggle();
    })
    $(".my,.register,.login,.servicer").click(function () {
        $(".vbar #box").animate({
            width: (0) + "px"
        });
        var myId = $(this).attr("id");
        var active = $("." + myId + "box").width() == 310;
        $("." + myId + "box").animate({
            width: (active ? 0 : 310) + "px"
        });
    });
    $(".mybox,.registerbox,.loginbox,.servicerbox").mouseleave(function () {
        $(".vbar #box").animate({
            width: (0) + "px"
        });
    });
    $(".closebox").click(function () {
        $(".vbar #box").animate({
            width: (0) + "px"
        });
    });
});

//悬浮搜索宽jQuery
var 
    g_emptyguid = '00000000-0000-0000-0000-000000000000',
    g_checkmessageDoing = false,
    g_checkmessageInterval = 30000;

var User = (function () {
    function User(id, no, name, email, popup) {
        this.ID = id || g_emptyguid;
    }
    User.prototype.isLogin = function () {
        return this.ID != g_emptyguid;
    };
    return User;
})();
var Jyeoo = (function () {
    function Jyeoo() {
        this.user = new User();
    }
    Jyeoo.prototype.setUser = function (id, no, name, email, popup) {
        this.user = new User(id, no, name, email, popup);
    };
    Jyeoo.prototype.isLogin = function () {
        return this.user.isLogin();
    };
    Jyeoo.prototype.isPopup = function () {
        return this.user.isPopup();
    };
    return Jyeoo;
})();

var jyeoo = new Jyeoo();
(function (b) {
    var l = "function",
        f = "type",
        n = ":text,:password,:search,textarea";
})(jQuery);;




function starCheckMessage() {
    if (!g_checkmessageDoing && jyeoo.isLogin() && jyeoo.isPopup()) {
        $('#divMsg').hide('slow');
        window.setTimeout(_checkMessage, g_checkmessageInterval);
    }
}



(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        factory(require('jquery'));
    } else {
        factory(jQuery);
    }
}(function ($) {
    var pluses = /\+/g;

    function encode(s) {
        return config.raw ? s : encodeURIComponent(s);
    }

    function decode(s) {
        return config.raw ? s : decodeURIComponent(s);
    }

    function stringifyCookieValue(value) {
        return encode(config.json ? JSON.stringify(value) : String(value));
    }



    function read(s, converter) {
        var value = config.raw ? s : parseCookieValue(s);
        return $.isFunction(converter) ? converter(value) : value;
    }
    var config = $.cookie = function (key, value, options) {
        if (value !== undefined && !$.isFunction(value)) {
            options = $.extend({}, config.defaults, options);
            if (typeof options.expires === 'number') {
                var days = options.expires,
                    t = options.expires = new Date();
                t.setTime(+t + days * 864e+5);
            }
            return (document.cookie = [encode(key), '=', stringifyCookieValue(value), options.expires ? '; expires=' + options.expires.toUTCString() : '', options.path ? '; path=' + options.path : '', options.domain ? '; domain=' + options.domain : '', options.secure ? '; secure' : ''].join(''));
        }
    };
    config.defaults = {};
}));



function initLayout(id) {
    try {
        $("#" + id).focus();
        $("#mathmlHelper").MathSearch(null, function (str) {
            $("#" + id).val(str);
            $("input.JYE_QUES").click();
        });
    } catch (e) {}
    $('a.return-top').hide();
    $(window).scroll(function () {
        if ($(this).scrollTop() == 0) {
            $('a.return-top').hide();
        } else {
            $('a.return-top').show();
        }
    });
    $.cookie('JYERN', Math.random());
}
/*----------------------------------------------*/

