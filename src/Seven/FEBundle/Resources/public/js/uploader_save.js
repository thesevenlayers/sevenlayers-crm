function Pluploader(params)
{
    this.wrapperID = params.wrapperID;
    this.listWrapperClass = params.listWrapperClass;
    this.browseClass = params.browseClass;
    this.saveButtonClass= params.saveButtonClass;
    this.thumbClass = params.thumbClass;
    this.targetUrl = params.targetUrl;
    this.multipartVars = params.multipartVars;
    this.filtersVars = params.filtersVars;
    this.multiSelection = params.hasOwnProperty("multiSelection") ? false : params.multiSelection;
    this.imageAvatar = params.imageAvatar ;
    this.ajaxLoadUrl = params.ajaxLoadUrl;

    this.uploader = new plupload.Uploader({
        browse_button: $("#"+this.wrapperID).find("."+this.browseClass).get(0),
        url: this.targetUrl,
        max_file_size: "2mb",
        multi_selection: this.multiSelection,
        multipart_params: this.multipartVars,
        filters: this.filtersVars
    });

    this.init = function()
    {
        var _this = this;

        this.uploader.init();

        this.uploader.bind("FilesAdded", function(up, files){
            var preloader = new mOxie.Image();
            preloader.onload = function() {
                $("#"+_this.wrapperID).find(" ."+_this.thumbClass).find("img").attr("src", preloader.getAsDataURL());
            };
            preloader.load( files[0].getSource() );

            $(up.getOption("browse_button")).text(files[0].name);
        });

        this.uploader.bind("FileUploaded", function(up, file, response){
            if($.parseJSON(response.response).success == true)
            {
                refresh_uploader(_this.wrapperID, _this.listWrapperClass, _this.saveButtonClass, _this.thumbClass, _this.browseClass, _this.imageAvatar, _this.ajaxLoadUrl, up, file);
            }
        });

        this.uploader.bind("UploadProgress", function(up, files){
            $("#"+_this.wrapperID).find("."+_this.saveButtonClass).text(up.total.percent+"%").attr("disabled", "disabled");
        });

        this.uploader.bind("QueueChanged", function(up){
            var count = up.files.length;
            if(count > 1)
            {
                up.splice(0, count - 1);
            }
        });

        $("body").on("click", "#"+_this.wrapperID +" ."+_this.saveButtonClass , function(e){
            e.preventDefault();
            var name = $("#"+_this.wrapperID).find(".name_input").val();
            if(name.length <= 0)
            {
                $("#"+_this.wrapperID).find(".name_input").after("<span style='color: red;'>Name is required</span>")
                return;
            }
            if(_this.uploader.files.length == 0)
            {
                $.ajax({
                    type: "POST",
                    url: _this.targetUrl,
                    data:{
                        name_input: name,
                        address_input: $("#"+_this.wrapperID).find(".address_input").val()
                    },
                    success: function(data){
                        refresh_uploader(_this.wrapperID, _this.listWrapperClass, _this.saveButtonClass, _this.thumbClass, _this.browseClass, _this.imageAvatar, _this.ajaxLoadUrl, null, null);
                    }
                });
            }

            for(var key in _this.multipartVars)
            {
                if(_this.multipartVars.hasOwnProperty(key))
                {
//                    _this.uploader.settings.multipart_params[key] = _this.multipartVars[key];
                    _this.uploader.settings.multipart_params[key] = $("#"+_this.wrapperID).find("."+key).val();
                }
            }

            _this.uploader.start();
        });
    }
}

function refresh_uploader(wrapper, list_wrapper_class, savebtn, thumb_class, browse_class, avatar, ajax_url, uploader, file)
{
    var w = $("#"+wrapper);
    w.hide();
    w.find("."+savebtn).text("save").removeAttr("disabled");
    w.find("."+browse_class).text("Browse");
    w.find("."+thumb_class).find("img").attr("src",avatar);
    w.find(".modal_reset").click();
    w.find(".modal_close").click();
    if(uploader !== null){
        uploader.removeFile(file);
    }
    $("."+list_wrapper_class).load(ajax_url);
}

