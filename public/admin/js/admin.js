/**
 * Created by onwer on 2017/2/15.
 */
/**
 * Created by Administrator on 2017/3/1.
 */
$(function () {
    $('.sidebarsj').click(function () {

        // var animw=$(window).width()-10;
        // $("#container").animate({width:animw},300);

        if($('.sidebar').hasClass('active')){

            $('.sidebar').animate({left:'-180px'},300);
            $('.main-content').animate({marginLeft:'0px'},300);

            $('.sidebar').removeClass('active');

        }else{
            $('.sidebar').animate({left:'0'},300);
            $('.main-content').animate({marginLeft:'180px'},300);
            $('.sidebar').addClass('active');

        }

    });
    var last_nav_e = $('.li_ac').prev();
    if(last_nav_e.length > 0){
        $('.main_nav').scrollTop(last_nav_e.offset().top);
    }
});

//时间处理
(function(){
    window.DateTime = {
        is_only_date: false,
        newObj: function(){
            return this;
        }
    };
    //得到昨天时间
    DateTime.getLastDay = function(is_zero){
        var theDate = new Date();
        theDate.setDate(theDate.getDate() - 1);
        return DateTime.formatTime({
            now_date: theDate,
            is_zero: is_zero
        });
    }
    //得到今天0点的时间
    DateTime.getNowDay = function(is_zero){
        var theDate = new Date();
        return DateTime.formatTime({
            now_date: theDate,
            is_zero: is_zero
        });
    }
    //得到每周的第一天(周一)
    DateTime.getFirstDateOfWeek = function(is_zero) {
        var theDate = new Date();
        var week = theDate.getDay();
        if(week == 0){
            week = 7;
        }
        theDate.setDate(theDate.getDate() + 1 - week);
        return DateTime.formatTime({
            now_date: theDate,
            is_zero: is_zero
        });
    }
    //得到每周的最后一天(周日)
    DateTime.getLastDateOfWeek = function(is_zero) {
        var theDate = new Date();
        var week = theDate.getDay();
        if(week == 0){
            week = 7;
        }
        theDate.setDate(theDate.getDate() + 7 - week);
        return DateTime.formatTime({
            now_date: theDate,
            is_zero: is_zero
        });
    }
    //得到上周的第一天(周一)
    DateTime.getPreviousFirstDateOfWeek = function(is_zero) {
        var theDate = new Date();
        var week = theDate.getDay();
        if(week == 0){
            week = 7;
        }
        theDate.setDate(theDate.getDate() - 6 - week);
        return DateTime.formatTime({
            now_date: theDate,
            is_zero: is_zero
        });
    }
    //得到上周的最后一天(周日)
    DateTime.getPreviousLastDateOfWeek = function(is_zero) {
        var theDate = new Date();
        var week = theDate.getDay();
        if(week == 0){
            week = 7;
        }
        theDate.setDate(theDate.getDate() - week);
        return DateTime.formatTime({
            now_date: theDate,
            is_zero: is_zero
        });
    }
    //得到本月第一天
    DateTime.getFirstDayOfMonth = function(is_zero){
        var theDate = new Date();
        theDate.setDate(1);
        return DateTime.formatTime({
            now_date: theDate,
            is_zero: is_zero
        });
    }
    //得到本月最后一天
    DateTime.getLastDayOfMonth = function(is_zero){
        var theDate = new Date();
        var y = theDate.getFullYear();
        var m = theDate.getMonth() + 1;
        if(m == 12){
            m = 1;
            y++;
        }
        theDate.setFullYear(y);
        theDate.setMonth(m);
        theDate.setDate(1);
        var lastDay = new Date(theDate.getTime()-1000*60*60*24);
        return DateTime.formatTime({
            now_date: lastDay,
            is_zero: is_zero
        });
    }

    //得到上月第一天
    DateTime.getFirstDayOfLastMonth = function(is_zero){
        var theDate = new Date();
        var y = theDate.getFullYear();
        var m = theDate.getMonth() - 1;
        if(m < 0){
            m = 11;
            y--;
        }
        theDate.setFullYear(y);
        theDate.setMonth(m);
        theDate.setDate(1);

        return DateTime.formatTime({
            now_date: theDate,
            is_zero: is_zero
        });
    }

    //得到上月最后一天
    DateTime.getLastDayOfLastMonth = function(is_zero){
        var theDate = new Date();
        theDate.setDate(1);

        var lastDay = new Date(theDate.getTime()-1000*60*60*24);
        return DateTime.formatTime({
            now_date: lastDay,
            is_zero: is_zero
        });
    }

    DateTime.formatTime = function(param){
        param = $.extend({
            now_date: new Date(),
            is_zero: false,
            is_only_date: false
        },param);
        var now_date = param['now_date'];
        var y, m, d, h = '00', i = '00', s = '00';
        y = now_date.getFullYear();
        m = now_date.getMonth()+1;
        if(m < 10){
            m = '0' + m;
        }
        d = now_date.getDate();
        if(d < 10){
            d = '0'+d;
        }
        if(param.is_zero == false){
            h = now_date.getHours();
            if(h < 10){
                h = '0'+h;
            }
            i = now_date.getMinutes();
            if(i < 10){
                i = '0'+i;
            }
            s = now_date.getSeconds();
            if(s < 10){
                s = '0'+s;
            }
        }

        if(this.is_only_date){
            return y+'-'+m+'-'+d;
        }

        return y+'-'+m+'-'+d+' '+h+':'+i+':'+s;
    }

    $.formatNum = {
        int:function(obj){
            var temp = parseInt(obj.value);
            if(isNaN(temp) || temp == NaN || temp < 0 || temp == undefined || temp == 'NaN'){
                temp = 0;
            }
            obj.value = temp;
            return obj.value;
        },
        float:function(obj,num){
            var fixed_num = 0;
            if(num){
                fixed_num = num;
            }
            var tmep = obj.value.toString();
            if (tmep.match(/[^\d.]/g)) {
                tmep = tmep.replace(/[^\d.]/g, "");
            }
            if (tmep.match(/^\./g)) {
                tmep = tmep.replace(/^\./g, "");
            }
            if (tmep.match(/\.{2,}/g)) {
                tmep = tmep.replace(/\.{2,}/g, ".");
            }
            if ((tmep.split('.').length - 1) >= 2) {
                tmep = tmep.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
            }
            if(fixed_num > 0){
                var reg = new RegExp("^(-?\\d*)\\.?\\d{1,"+fixed_num+"}$");
                if(!reg.test(tmep)){
                    var reg2 = new RegExp("^(.*\\..{"+fixed_num+"}).*$");
                    tmep = tmep.replace(reg2,"$1");
                }
            }

            if(tmep != obj.value){
                var index = 0;
                var is_have = false;
                for(var i in tmep){
                    index = i;
                    if(obj.value[i] != tmep[i]){
                        is_have = true;
                        break;
                    }
                }
                if(!is_have){
                    index = tmep.length;
                }

                obj.value = tmep;

                this.setMouseIndex(obj,index)

                return obj.value;
            }

            return obj.value;
        },
        setMouseIndex:function(obj,index){
            if (obj.setSelectionRange) {
                obj.setSelectionRange(index, index);
            } else {//IE
                var  rtextRange = obj.createTextRange();
                rtextRange.moveStart('character', index);
                rtextRange.collapse(true);
                rtextRange.select();
            }
        },
        getMouseIndex:function(obj){
            var cursurPosition = -1;
            if (obj.selectionStart) {
                cursurPosition = obj.selectionStart;
            } else {//IE
                if(document.selection == undefined){
                    cursurPosition = 0;
                }else{
                    var range = document.selection.createRange();
                    range.moveStart("character", - obj.value.length);
                    cursurPosition = range.text.length;
                }
            }
            return cursurPosition;
        }
    };
})();

function _theInfoSubmit(c,$ow_loading,$confirm){
    c.close();
}