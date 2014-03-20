function ImgCrop(param) {
    this.height = "height" in param ? param.height : 0;
    this.width = "width" in param ? param.width : 0;
    this.image_class = param.image_class;
    this.x = 0;
    this.y = 0;
    this.temp_height = 0;
    this.temp_width = 0;
    this.wrapper = param.wrapper_class;
    this.form = $("." + param.form_class + "");
    this.original_post_url = this.form.attr('action');
    this.query_string = null;
    this.post_url = null;
    this.crop = param.crop;
    this.upload_btn = $("." + param.input_class + "").clone();

    this.init = function () {
        $("." + param.input_class).css("display", "block");
        var _this = this;
        _this.form.on("change", "." + param.input_class, function (e) {
            readURL(this, e.target);
        });

        function readURL(input, trigger) {
            if (input.files && input.files[0]) {
//                var myImg = $(trigger).parentsUntil("."+_this.wrapper).children("div."+_this.image_class).children("img");
                var myImg = $(trigger).siblings().children("img");
                console.log(myImg.attr("src"));
                var type = input.files[0].type;
                var allowed = ["image/png", "image/jpeg", "image/gif"];

                if ($.inArray(type, allowed) == -1) {
                    $(trigger).siblings("div.error_wrapper").text("Only images are allowed (png, jpeg or gif)");
                    $(trigger).replaceWith(_this.upload_btn);
                    if (_this.crop) {
                        myImg.imgAreaSelect({
                            disable: true,
                            hide: true
                        });
                    }
                    myImg.css("cursor", "default");
                    $(myImg).attr("src", "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image");
                    return;
                }
                else {
                    $(trigger).siblings("div.error_wrapper").text("");
                }


                var reader = new FileReader();
                reader.readAsDataURL(input.files[0]);


                reader.onload = function (e) {
                    myImg.attr('src', e.target.result);

//                    _this.query_string = "?temp_height="+_this.temp_height+"&temp_width="+_this.temp_width+"&height="+_this.height+"&width="+_this.width+"&x="+_this.x+"&y="+_this.y;
//                    var post_url = _this.original_post_url + _this.query_string;
//                    _this.form.attr("action", post_url);

//                    var hasCrop = false;
//
//                    var img = new Image();
//                    img.onload = function(e){
//                        console.log("onload called")
//                        if(img.height > _this.height || img.weight > _this.width)
//                        {
//                            console.log("te")
//                            hasCrop = true;
//                        }
//                    }
//                    img.src = reader.result;
//
//                    console.log(hasCrop)
//                    if(!hasCrop) return;


                    if (!_this.crop) {
                        return;
                    }
                    myImg.css("cursor", "crosshair");

                    var cropper = myImg.imgAreaSelect({
                        minHeight: _this.height,
                        minWidth: _this.width,
                        maxHeight: _this.height,
                        maxWidth: _this.width,
                        instance: true,
                        onSelectEnd: function (img, selection) {

                            height = selection.height;
                            width = selection.width;
                            x = selection.x1;
                            y = selection.y1;
                            temp_height = $(myImg).parent().height();
                            temp_width = $(myImg).parent().width();

                            _this.query_string = "?temp_height=" + temp_height + "&temp_width=" + temp_width + "&height=" + height + "&width=" + width + "&x=" + x + "&y=" + y;
                            post_url = _this.original_post_url + _this.query_string;
                            _this.form.attr("action", post_url);
                        },
                        onInit: function (img, selection) {
                            if ("autocrop" in param) {
                                if (param.autocrop == true) {
                                    cropper.setSelection(0, 0, _this.width, _this.height, true);
                                    cropper.setOptions({show: true});
                                    cropper.update();
                                }
                            }

                        }
                    });

                }
            }
        }
    }
}