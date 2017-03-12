var tmpl = '<li class="uploader__file" style="background-image:url(#url#)"></li>'
    ,_uploaderInput = $(".input-box input[type='file']")
    ;

_uploaderInput.on("change", function(e){
    var src
        ,url = window.URL || window.webkitURL || window.mozURL
        ,files = e.target.files
        ,_this = $(this)
        ,_pform = _this.parents('form')
        ,_uploaderFiles = _this.parent().prev(".uploaderFiles")
        ,enctype = _pform.attr('enctype')
        ;
    
    if (enctype != 'multipart/form-data') {
        _pform.attr('enctype', 'multipart/form-data');
    }

    for (var i = 0, len = files.length; i < len; ++i) {
        var file = files[i];

        if (url) {
            src = url.createObjectURL(file);
        } else {
            src = e.target.result;
        }

        _uploaderFiles.html($(tmpl.replace('#url#', src)));
    }
});