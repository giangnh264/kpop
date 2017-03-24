var host 	=  	"http://"+window.location.hostname;
var port 	= 	window.location.port;

if(port != "" && port != "80" ){
    host = host + ":" + port;
}
$('#cid_all').live('click',function() {
    var checked=this.checked;
    $("input[name='cid\[\]']").each(function() {
        this.checked=checked;
    });
    if(checked){
        $('#total-selected').html($("input[name='cid\[\]']").length);
    }else{
        $('#total-selected').html(0);
        $('#all-item').attr('checked',false);
    }
});

$("input[name='cid\[\]']").live('click', function() {
    $('#cid_all').attr('checked', $("input[name='cid\[\]']").length==$("input[name='cid\[\]']:checked").length);
    $('#total-selected').html($("input[name='cid\[\]']:checked").length);
});

$('#show-exp').live('click', function() {
    if($('#mn-expand').css('display') == 'none'){
        $('#mn-expand').show();
    }else{
        $('#mn-expand').hide();
    }
});
jQuery('html').click(function(){
    $('#mn-expand').hide();
});

jQuery('#mn-expand').click(function(e){
    //e.stopPropagation();
    });

$('.item-in-page').live('click',function(){
    $('#cid_all').attr('checked',true);
    $('#all-item').attr('checked',false);
    $("input[name='cid\[\]']").each(function(){
        this.checked = true;
    });
    $('#total-selected').html($("input[name='cid\[\]']:checked").length);
    $('.grid-view > table > tbody > tr').each(function(){
        $(this).addClass('marked');
    });
    return false;
});

$('.all-item').live('click',function(){
    $('#cid_all').attr('checked',true);
    $('#all-item').attr('checked',true);
    $("input[name='cid\[\]']").each(function(){
        this.checked = true;
    });
    $('#total-selected').html($('#all-item').val());

    $('.grid-view > table > tbody > tr').each(function(){
        $(this).addClass('marked');
    });
});

$('.uncheck-all').live('click',function(){
    $('#cid_all').attr('checked',false);
    $('#all-item').attr('checked',false);
    $("input[name='cid\[\]']").each(function(){
        this.checked = false;
    });
    $('#total-selected').html('0');

    $('.grid-view > table > tbody > tr').each(function(){
        $(this).removeClass('marked');
    })
});

$('.search-button').live('click',function(){
    $('.search-form').toggle();
    return false;
});


$(document).ready(function() {
    $('.has-ajax-pop a.view, .has-ajax-pop a.update, a.show-pop').live('click',function(){
        xhr = jQuery.ajax({
            'onclick':'$("#jobDialog").dialog("open"); return false;',
            'url':$(this).attr("href"),
            'type':'GET',
            'cache':false,
            'beforeSend':function(){
                /*LOADING IMAGE*/
                //$.fn.overlayShow();
                overlayShow();
            },
            'success':function(html){
                //$.fn.overlayHide();
                overlayHide();
                jQuery('#jobDialog').html(html);
            },
            'complete':function(){
                overlayHide();
            }
        });
        return false;

    })
    // create nice name
    var createnicename = function(el){
        //str= $(this).val().trim();
        str= el.value;
        str= str.toLowerCase();
        str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");
        str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");
        str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");
        str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");
        str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");
        str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");
        str= str.replace(/đ/g,"d");
        //        str= str.replace(/ |#|&|\(|\)|\?|{|}|\[|]|!|@|%|\$|\^|\*|\+/g,"-");
        str= str.replace(/\W/g,"-");
        $('.txtrcv').val(str);
    }

    $('.txtchange').keypress(function(){
        var _self = this;
        setTimeout(function(){
            createnicename(_self);
        },100);
    });
    $("input:submit, input:reset, button").button();

    // style for gridview
    $('.grid-view > table > tbody > tr').hover(function(){
        $(this).addClass('rhover');
    }, function(){
        $(this).removeClass('rhover');
    })

    $('.grid-view #cid_all').live("click",function(){
        if($(this).attr("checked")){
            $('.grid-view > table > tbody > tr').each(function(){
                $(this).addClass('marked');
            })
        }else{
            $('.grid-view > table > tbody > tr').each(function(){
                $(this).removeClass('marked');
            })
        }
    })
    $('.grid-view > table > tbody > tr > td >input[type="checkbox"]').live("click",function(){
        if($(this).attr("checked")){
            $(this).parent().parent().addClass('marked');
        }else{
            $(this).parent().parent().removeClass('marked');
        }

    });

    // add icon to menu
    $('.top_link').each(function(index){
        if($(this).index() == 0){
            $(this).find("span").before('<span class="menu-icon"><img alt="" src="'+host+'/themes/admin-blue/images/icons/menu-icon-'+index+'.png" width="16"></span>');
        }
    });

    //Delete song
    $('.delete-obj').live('click',function() {
        var url = $(this).attr('href');
        deleteConfirm('delete-obj-form',url);
        return false;
    });

	$('#artist-search').keypress(function(){
	    var _self = this;
	    setTimeout(function(){
	    	var name = $(_self).val();
	    	var url = $("#url_merge").val();
	    	var org_id = $("#org_id").val();
	    	jQuery.ajax({
	            'url':url,
	            'type':'GET',
	            'data':{name:name,org_id:org_id},
	            'cache':false,
	            'beforeSend':function(){
	            },
	            'complete':function(){
	            },
	            'success':function(html){
	            	var newOptions = html;

            		var select = $('#artist_list');
            		if(select.prop) {
            		  var options = select.prop('options');
            		}
            		else {
            		  var options = select.attr('options');
            		}
            		$('option', select).remove();

            		$.each(newOptions, function(val, text) {
            		    options[options.length] = new Option(text, val);
            		});

	            }
	        });

	    },100);
	});
	
})

$('.reorder').live('click',function() {
    var url = $(this).attr('rel');
    $.post(url,$('.adminform').serialize(), function(data){
        });
    return false;
})

window.submitform = function(el){
    var itemselected =   $('#total-selected').html();
    itemselected = parseInt(jQuery.trim(itemselected));
    if(el.value != '' && itemselected > 0){
        if(confirm("Bạn có chắc chắn muốn thực hiện?") ){
            el.form.submit();
        }else{
            el.value = '';
        }
    }else{
        if(el.value != ''){
            alert(LANG['Chưa có bản ghi nào được chọn']);
            el.value = '';
        }
    }
}
window.song_submit_form = function(el){
    var itemselected =   $('#total-selected').html();
    itemselected = parseInt(jQuery.trim(itemselected));
    if(el.value != '' && itemselected > 0){
        if(el.value == 1){
            jQuery.ajax({
                'onclick':'$("#jobDialog").dialog("open"); return false;',
                'url':host+songUrlUpdate,
                'type':'POST',
                'data':$('#yw1').serialize(),
                'cache':false,
                'beforeSend':function(){
                    $("#loading").css({
                        'z-index':'999',
                        'width':'100%',
                        'margin-top':'0px',
                        'height':'100%',
                        'display':'block'
                    });
                },
                'complete':function(){
                    $("#loading").css({
                        'z-index':'0',
                        'width':'0',
                        'margin-top':'0px',
                        'height':'0',
                        'display':'none'
                    });
                },
                'success':function(html){
                    jQuery('#jobDialog').html(html)
                }
            });
            el.value = '';
            return false;
        }
        if(el.value == 'deleteAll'){
            deleteConfirm('yw1',host+songUrlDelete);
            el.value = '';
            return false;
        }
        el.form.submit();
        el.value = '';
    }else{
        if(el.value != ''){
            //alert('Chưa có bản ghi nào được chọn');
            alert(LANG['Chưa có bản ghi nào được chọn']);
            el.value = '';
        }
    }
}

window.video_submit_form = function(el){
    var itemselected =   $('#total-selected').html();
    itemselected = parseInt(jQuery.trim(itemselected));
    if(el.value != '' && itemselected > 0){
        if(el.value == 1){
            jQuery.ajax({
                'onclick':'$("#jobDialog").dialog("open"); return false;',
                'url':host+videoUrlUpdate,
                'type':'POST',
                'data':$('#yw1').serialize(),
                'cache':false,
                'beforeSend':function(){
                    $("#loading").css({
                        'z-index':'999',
                        'width':'100%',
                        'margin-top':'0px',
                        'height':'100%',
                        'display':'block'
                    });
                },
                'complete':function(){
                    $("#loading").css({
                        'z-index':'0',
                        'width':'0',
                        'margin-top':'0px',
                        'height':'0',
                        'display':'none'
                    });
                },
                'success':function(html){
                    jQuery('#jobDialog').html(html)
                }
            });
            el.value = '';
            return false;
        }
        if(el.value == 'deleteAll'){
            deleteConfirm('yw1',host+videoUrlDelete);
            el.value = '';
            return false;
        }
        el.form.submit();
        el.value = '';
    }else{
        if(el.value != ''){
            alert(LANG['Chưa có bản ghi nào được chọn']);
            el.value = '';
        }
    }
}

window.album_submit_form = function(el){
    var itemselected =   $('#total-selected').html();
    itemselected = parseInt(jQuery.trim(itemselected));
    if(el.value != '' && itemselected > 0){
        if(el.value == 1){
            jQuery.ajax({
                'onclick':'$("#jobDialog").dialog("open"); return false;',
                'url':host+albumUrlUpdate,
                'type':'POST',
                'data':$('#yw1').serialize(),
                'cache':false,
                'beforeSend':function(){
                    $("#loading").css({
                        'z-index':'999',
                        'width':'100%',
                        'margin-top':'0px',
                        'height':'100%',
                        'display':'block'
                    });
                },
                'complete':function(){
                    $("#loading").css({
                        'z-index':'0',
                        'width':'0',
                        'margin-top':'0px',
                        'height':'0',
                        'display':'none'
                    });
                },
                'success':function(html){
                    jQuery('#jobDialog').html(html)
                }
            });
            el.value = '';
            return false;
        }
        if(el.value == 'deleteAll'){
            deleteConfirm('yw1',host+albumUrlDelete);
            el.value = '';
            return false;
        }

        el.form.submit();
    }else{
        if(el.value != ''){
            alert(LANG['Chưa có bản ghi nào được chọn']);
            el.value = '';
        }
    }
}



window.ringtone_submit_form = function(el){
    var itemselected =   $('#total-selected').html();
    itemselected = parseInt(jQuery.trim(itemselected));
    if(el.value != '' && itemselected > 0){
        if(el.value == 'deleteAll'){
            deleteConfirm('yw1',host+ringtoneUrlDelete);
            el.value = '';
            return false;
        }
        el.form.submit();
    }else{
        if(el.value != ''){
            alert(LANG['Chưa có bản ghi nào được chọn']);
            el.value = '';
        }
    }
}

window.deleteConfirm = function(idForm, url){
    jQuery.ajax({
        'onclick':'$("#jobDialog").dialog("open"); return false;',
        'url':url,
        'type':'POST',
        'data':$('#'+idForm).serialize(),
        'cache':false,
        'beforeSend':function(){
            $("#loading").css({
                'z-index':'999',
                'width':'100%',
                'margin-top':'0px',
                'height':'100%',
                'display':'block'
            });
        },
        'complete':function(){
            $("#loading").css({
                'z-index':'0',
                'width':'0',
                'margin-top':'0px',
                'height':'0',
                'display':'none'
            });
        },
        'success':function(html){
            jQuery('#jobDialog').html(html)
        }
    });
}
window.deleteButton = function()
{
    return;
}

window.showGlobalForm = function(el){
    //$('.portlet-content > li').removeClass('active');
    $('li.active').removeClass('active');
    $(el).parent().addClass('active');
    $('.global_field').removeClass('hide').addClass('show');
    $('.meta_field').removeClass('show').addClass('hide');
    return false;
}

window.showMetaForm = function(el){
    $('li.active').removeClass('active');
    $(el).parent().addClass('active');
    $('.global_field').removeClass('show').addClass('hide');
    $('.meta_field').removeClass('hide').addClass('show');
    return false;
}

window._player = function(urlFile){
    return
    "<object width='290' height='24' type='application/x-shockwave-flash' data='"+host+"/flash/player-mini.swf' id='audioplayer1'>" +
    "<param name='movie' value='"+host+"/flash/player-mini.swf'>" +
    "<param name='FlashVars' value='playerID=1&amp;soundFile="+urlFile+"'>" +
    "<param name='quality' value='high'>" +
    "<param name='menu' value='false'>" +
    "<param name='wmode' value='transparent'>"+
    " </object>";

}
function importBefore(target) {
    $('.loading-import').show();
//$('#resultImport').html('Đang import dữ liệu bạn hãy chờ trong chốc lát ...');
}
var interval;
function importAfter(target) {
    result = $.parseJSON(target);
    if(result.not_exist_file != 1 && result.total_record > 0)
    {
        getImport();
    }
    else
    {

    	if(result.total_record == 0){
    		alert("Danh sách rỗng không lấy đọc dữ liệu từ file");
    	}
        $('#resultImport').hide();
        $('.loading-import').hide();
        $('.error-result').html(result.data);
    }
    console.log(target);
}
function importAfterScan(data) {
    result = $.parseJSON(data);
    if(result.errorCode == 0)
    {
    	$('.loading-import').hide();
    	$('#ads').html('<a href="/index.php?r=import_song/importSongFile/index">Import File List</a>');
    }
    else
    {
    	$('.loading-import').hide();
        $('#ads').html(result.errorDesc);
    }
    console.log(data);
}
function getImport(){
    $.get("index.php?r=importSong/AjaxImport",
    {
        'key':12.3213332
    },
    function(result){
        ///finish insert all rows
        if(result.indexOf('finished')>=0){
            ///console.log('finished HERE');
            setTimeout(function(){
                var confi = confirm('Cập nhật giá trị update_time các bài hát này');
                if(confi){
                    $.post("index.php?r=importSong/updateTime",{
                        'update':1
                    });
                }
            },200);

        }

        result = $.parseJSON(result);
        $('#resultImport').show();
        if(result.is_error == 1)
        {

            $('.data-import').show();
            $('.result_row').append(result.data);
            $('.count-import-err').html(result.count_error);
        }
        else
        {
            if(result.imported != null){
                $('.imported').fadeOut();
                $('.imported').html('Import thành công: <b>'+ result.imported.name +'('+ result.imported.stt +')</b>');
                $('.imported').slideDown();
            }
            else{
                clearInterval(interval);
            }

        }
        interval = setInterval(function() {
            clearInterval(interval);
            getImport();
        }, 100);
        if(result.success == 1)
        {
            $('.loading-import').hide();
            clearInterval(interval);
        }
    //console.log(result);
    });
}

function ajaxImport() {
    $('.loading-import').hide();
}

window.editlyric = function(url){
    jQuery.ajax({
        'onclick':'$("#jobDialog").dialog("open"); return false;',
        'url':url,
        'type':'POST',
        'cache':false,
        'beforeSend':function(){
            $("#loading").css({
                'z-index':'999',
                'width':'100%',
                'height':'100%',
                'position':'fixed',
                'display':'block'
            });
        },
        'complete':function(){
            $("#loading").css({
                'z-index':'0',
                'width':'0',
                'height':'0',
                'display':'none'
            });
        },
        'success':function(html){
            jQuery('#jobDialog').html(html);
            $("#jobDialog").css('height','auto');
            $(".ui-dialog").css('top','100px');
            $(".ui-dialog").css('position','fixed');
        }
    });
}

function gotoPage(e,id,page){
    if (typeof e == 'undefined' && window.event) {
        e = window.event;
    }
    if (e.keyCode == 13)
    {
        var arr = new Object();
        var arr1 = new Object();
        arr1[page] = $("#goto").val();
        arr.data = arr1;
        $.fn.yiiGridView.update(id,arr);
        $('.adminform').submit(function(){
            return false;
        });
    }
}

window.getCheckbox = function(form,orgTags)
{
	var output = [{}];
    $(form + " tbody input[type='checkbox']").each(function() {
        if ($(this).attr('checked')) {
            val = $(this).val();
            text = $(".artist_name", $(this).parent().parent()).text();
            var flag = true;
            if(orgTags !== null){
                for (var i in orgTags) {
                    if (orgTags[i].id == val) {
                        flag = false;
                        break;
                    }
                }
            }
            if (flag) {
                output.push({
                    id: val,
                    name: text
                });
            }
        }
    });
    if(orgTags !== null){
        orgTags = orgTags.concat(output);
    }else{
        orgTags = output;
    }
    return orgTags;
}

window.display_artist = function(alist, idElement)
{
        //artistList = alist;
        artistList = null;
        var html = "";
        for (i in alist) {
            if (alist[i].id) {
                html += '<p id="'+ alist[i].id +'">';
                html += '<input type="hidden" name="' + idElement + '_list[]" value="' + alist[i].id + '" />';
                html += '<span>' + alist[i].name + '</span>';
                html += '<span class="remove-artist" onclick="remove_artist2(' + alist[i].id + ',\'' + idElement + '\')">Remove</span>';
                html += '</p>';
            }
        }
        $('#' + idElement).prepend(html);
}
window.display_artist2 = function(alist, index,count)
{
        artistList = null;
        var html = "";
        for (i in alist) {
            if (alist[i].id) {
                html += '<p id="'+ alist[i].id +'">';
                html += '<input class="SongNameIF" type="hidden" name="songInfo['+index+'][arids][]" value="' + alist[i].id + '" />';
                html += '<span>' + alist[i].name + '</span>';
                html += '<span class="remove-artist" onclick="remove_artist2(' + alist[i].id + ',\'artist_ids_'+index+'\')">Remove</span>';
                html += '</p>';
            }
        }
        $('#'+count).prepend(html);

}
window.remove_artist2 = function(artistId,idElement){
	$("#"+idElement+" p#"+artistId).remove();
}
window.remove_artist = function(artistId,idElement){
    for (var i in artistList) {
        if(artistList[i].id == artistId){
            delete artistList[i];
            break;
        }
    }
    display_artist(artistList,idElement);
}

window.overlayShow = function(){
    $('#overlay').fadeIn('fast',function(){
        $('#box').show();
    });
};
window.overlayHide = function(){
    setTimeout(function() {
        $('#box').hide();
        $('#overlay').fadeOut('fast');
    },3);
};

window.dump =  function(obj) {
    var out = '';
    for (var i in obj) {
        if(typeof obj[i] =='object'){
            out += i + ": \n" + dump(obj[i]) + "\n";
        }else{
            out += i + ": " + obj[i] + "\n";
        }
    }

    return out;

}
window.dumpjs =  function(obj) {
    out = dump(obj);
    alert(out);

    // or, if you wanted to avoid alerts...

    var pre = document.createElement('pre');
    pre.innerHTML = out;
    document.body.appendChild(pre)
}

var lastChecked = null;
$(document).ready(function() {
    var $chkboxes = $('input[type="checkbox"]');
    $chkboxes.click(function(e) {
        if(!lastChecked) {
            lastChecked = this;
            return;
        }
        if(e.shiftKey) {
            var start = $chkboxes.index(this);
            var end = $chkboxes.index(lastChecked);
            $chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).attr('checked', lastChecked.checked);
        }
        lastChecked = this;
    });
});

window.addcopy1 = function(){
    var val0 = $('#copyright0').val();
    var txt0 = document.getElementById("copyright0");
    var val1 = $('#copyright1').val();
    var txt1 = document.getElementById("copyright1");
    if(val0){
        for(var i = 0; i < val0.length; i++){
            var flag = 1;
            var x=document.getElementById("slcopy0");
            for(var j=0;j<x.length;j++){
                if(val0[i] == x.options[j].value)
                    flag = 0;
            }
            if(flag == 1){
                var txt = $('#copyright0 option[value='+val0[i]+']').text();
                $('#slcopy0').prepend('<option value="'+val0[i]+'">'+txt+'</option>');
            }
            $("#copyright0 option").prop("selected", false);
        }
        var values = [];
        $('#slcopy0 option').each(function() {
            values.push($(this).attr('value'));
        });
        $("#valcopy0").val(values);
    }
    if(val1){
        for(var i = 0; i < val1.length; i++){
            var flag = 1;
            var x=document.getElementById("slcopy1");
            for(var j=0;j<x.length;j++){
                if(val1[i] == x.options[j].value)
                    flag = 0;
            }
            if(flag == 1){
                var txt = $('#copyright1 option[value='+val1[i]+']').text();
                $('#slcopy1').prepend('<option value="'+val1[i]+'">'+txt+'</option>');
            }
            $("#copyright1 option").prop("selected", false);
        }
        var values = [];
        $('#slcopy1 option').each(function() {
            values.push($(this).attr('value'));
        });
        $("#valcopy1").val(values);
    }
}

window.removecopy = function(){
    $('#slcopy0 option:selected').remove();
    var values = [];
    $('#slcopy0 option').each(function() {
        values.push($(this).attr('value'));
    });
    $("#valcopy0").val(values);

    $('#slcopy1 option:selected').remove();
    var values = [];
    $('#slcopy1 option').each(function() {
        values.push($(this).attr('value'));
    });
    $("#valcopy1").val(values);
}

window.up = function() {
    var selected = $("#slcopy0").find(":selected");
    var before = selected.prev();
    if (before.length > 0)
        selected.detach().insertBefore(before);
    var values = [];
    $('#slcopy0 option').each(function() {
        values.push($(this).attr('value'));
    });
    $("#valcopy0").val(values);

    var selected = $("#slcopy1").find(":selected");
    var before = selected.prev();
    if (before.length > 0)
        selected.detach().insertBefore(before);

    var values = [];
    $('#slcopy1 option').each(function() {
        values.push($(this).attr('value'));
    });
    $("#valcopy1").val(values);

    $("#slcopy0 option").prop("selected", false);
    $("#slcopy1 option").prop("selected", false);
}

window.down = function() {
    var selected = $("#slcopy0").find(":selected");
    var next = selected.next();
    if (next.length > 0)
        selected.detach().insertAfter(next);
    var values = [];
    $('#slcopy0 option').each(function() {
        values.push($(this).attr('value'));
    });
    $("#valcopy0").val(values);

    var selected = $("#slcopy1").find(":selected");
    var next = selected.next();
    if (next.length > 0)
        selected.detach().insertAfter(next);
    var values = [];
    $('#slcopy1 option').each(function() {
        values.push($(this).attr('value'));
    });
    $("#valcopy1").val(values);

    $("#slcopy0 option").prop("selected", false);
    $("#slcopy1 option").prop("selected", false);
}

window.add_copyright = function(type){
    var val = $("#copyright"+type).val();
    var txt = $("#copyright"+type+" option:selected").text();
    if(val > 0)
        $("#appendix_no0").prepend('<p id="'+val+'"><span style="float:left; margin:5px 5px 0px 0px; width: 80px;">'+txt+'</span><input class="val-cpy" checked="true" style="float:left;" type="radio" value="'+val+'" name="cpy[]"/><span style="float:left; margin-top:4px;">active</span><span style="float:left; margin:5px 5px 0px 5px;">Từ</span><input type="text" value="2013-06-18" style="width:85px;"/><span style="float:left; margin:5px 5px 0px 5px;">Đến</span><input type="text" value="2013-06-18" style="width:85px;"/><select style="width:120px; height: 23px; margin-left:5px;"><option value="0">Hình thức</option><option value="0">Không độc quyền</option><option value="1">Độc quyền</option></select><span style="margin-top:5px;" class="remove-artist" onclick="remove_copy('+val+');">Remove</span></p>');
    var values = [];
    $('.val-cpy').each(function() {
        values.push($(this).attr('value'));
    });
    $("#valcopy").val(values);
}
window.remove_copy = function(copy){
    $("#"+copy).remove();
    var values = [];
    $('.val-cpy0').each(function() {
        values.push($(this).attr('value'));
    });
    $("#valcopy0").val(values);

    var values = [];
    $('.val-cpy1').each(function() {
        values.push($(this).attr('value'));
    });
    $("#valcopy1").val(values);
}

window.slcopy = function(type){
    $.ajax({
        onclick: '$("#jobDialog").dialog("open"); return false;',
        url: "/index.php?r=song/copyright",
        data: "type=" + type,
        success: function(html) {
            $('#jobDialog').html(html);
        }
    });
}

window.addcopy = function(type){
    var output = [];
    $(".popupform tbody input[type='checkbox']:checked").each(function(){
        output.push($(this).attr('value'));
    });
    $.ajax({
        url: "/index.php?r=song/getcopy",
        data: "ids=" + output,
        success: function(data) {
            var tags = $.parseJSON(data);
            for(var i=0;i<tags.length;i++){
                var flag = 1;
                var valu = $("#valcopy"+type).val();
                valu = valu.split(",");
                for(var j=0;j<valu.length;j++){
                    if(tags[i]["id"] == valu[j])
                        flag = 0;
                }
                if(flag)
                    $("#appendix_no"+type).prepend('<p id="'+tags[i]["id"]+'"><span style="float:left; margin:5px 5px 0px 0px; width: 350px;">'+tags[i]["appendix_no"]+'</span><input class="val-cpy'+type+'" style="float:left;" type="radio" value="'+tags[i]["id"]+'" name="cpy'+type+'"/><span style="float:left; margin-top:4px;">active</span><span style="float:left; margin:5px 5px 0px 5px;">Từ</span><input name="start_date_'+tags[i]["id"]+'" type="text" value="'+tags[i]["start_date"]+'" style="width:85px;"/><span style="float:left; margin:5px 5px 0px 5px;">Đến</span><input name="due_date_'+tags[i]["id"]+'" type="text" value="'+tags[i]["due_date"]+'" style="width:85px;"/><select name="copy_type_'+tags[i]["id"]+'" style="width:120px; height: 23px; margin-left:5px;"><option value="0">Không độc quyền</option><option value="1">Độc quyền</option></select><span style="margin-top:5px;" class="remove-artist" onclick="remove_copy('+tags[i]["id"]+');">Remove</span></p>');
            }
            var values = [];
            $('.val-cpy'+type).each(function() {
                values.push($(this).attr('value'));
            });
            $("#valcopy"+type).val(values);
        }
    });
}

window.left2right = function(){
    var val0 = $('#artist_list').val();
    var txt0 = document.getElementById("artist_list");
    if(val0){
            var flag = 1;
            var x=document.getElementById("artist_ids");
            for(var j=0;j<x.length;j++){
                if(val0 == x.options[j].value)
                    flag = 0;
            }
            if(flag == 1){
                var txt = $('#artist_list option[value='+val0+']').text();
                $('#artist_ids').prepend('<option value="'+val0+'">'+txt+'</option>');
                $("#artist_ids option").prop("selected", false);
            }
        var values = [];
        $('#artist_ids option').each(function() {
            values.push($(this).attr('value'));
        });
        $("#a_ids").val(values);
    }
}

window.right2left = function(){
    $('#artist_ids option:selected').remove();
    var values = [];
    $('#artist_ids option').each(function() {
        values.push($(this).attr('value'));
    });
    $("#a_ids").val(values);

}

function suggettk(){
	var va = $('#AdminArtistModel_name').val();
	if(va.length > 3)
	$('#timkiem').submit();
}

function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}
function getCookie(c_name)
{
	var c_value = document.cookie;
	var c_start = c_value.indexOf(" " + c_name + "=");
	if (c_start == -1)
	  {
	  c_start = c_value.indexOf(c_name + "=");
	  }
	if (c_start == -1)
	  {
	  c_value = null;
	  }
	else
	  {
	  c_start = c_value.indexOf("=", c_start) + 1;
	  var c_end = c_value.indexOf(";", c_start);
	  if (c_end == -1)
	  {
	c_end = c_value.length;
	}
	c_value = unescape(c_value.substring(c_start,c_end));
	}
	return c_value;
}
$(document.body).ready(function(){
	var u = getCookie('active_menuleft');
	if(u=='deactive'){
			$("#left").css({width:'0px'}).addClass("sss");
			$("#tButtonImage").addClass("icon-chevron-right");
    	}else{
    		$("#left").css({width:'210px'});
    		$("#tButtonImage").addClass("icon-chevron-right icon-chevron-left");
    	}
	
    $("#toggleButton").live("click", function(){
		var duration = 150;
		//$("#left").toggleClass("showB");
		if($("#left").hasClass("sss")){
			$(".sss").animate({
				width: '210px'
			},duration).removeClass('sss');
			setCookie('active_menuleft','active',1);
		}else{
			$("#left").animate({
				width: 0+'px'
			},duration).addClass("sss");
			setCookie('active_menuleft','deactive');
		}
		$(this).find("i").toggleClass("icon-chevron-left");
	})
});