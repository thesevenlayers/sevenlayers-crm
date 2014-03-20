$(document).ready(function(){

    /**
     * ACTIONS AJAX CAPABILITIES
     */

    $("body").on("click", ".newSubmit, .editSubmit", function(e){
        e.preventDefault();

        var form = $(e.target).closest("form");
        $(form).find(".errorsWrapper").empty();

        $(e.target).attr("disabled", "disabled");
        $(e.target).text("Saving");
        $.ajax({
            type: "POST",
            url: $(form).attr("action"),
            data: $(form).serialize(),
            success: function(data){
                if(data.code == 200)
                {
                    $(form).find(".modal_reset").click();
                    $(form).find(".modal_close").click();
                    var url = Routing.generate($(e.target).data("route"), {id: "{{ client.id}}" } );
                    $("#"+$(e.target).data("wrapper")).load(url);
                }
                else if(data.code == 403)
                {
                    var errors_wrapper = $(e.target).parent().siblings(".modal-body").find(".errorsWrapper");
                    errors_wrapper.empty();
                    var list = $('<ul style="color: red;">');
                    $.each(data.message, function(key, val){
                        var li = $("<li>");
                        li.text(val);
                        list.append(li);
                    })
                    errors_wrapper.append(list);
                }
                $(e.target).removeAttr("disabled");
                $(e.target).text("save");
            }
        });
    });

    $("body").on("click", ".deleteRecord", function(e){
        e.preventDefault();
        $(e.target).attr("disabled", "disabled");
        $(e.target).text("Deleting");
        var url = $(e.target).parent().attr("action");
        $.ajax({
            type: "POST",
            url: url,
            success: function(data)
            {
                if(data.success){
                    $(e.target).parent().parent().siblings(".modal-header").find("button").click();
                    $(e.target).removeAttr("disabled");
                    $(e.target).text("Delete");
                    var c_id = $(e.target).data("wrapper");
                    $("tr#"+ c_id).remove();
                }
            }
        })
    });

    $("body").on("click", ".renewRecord", function(e){
        e.preventDefault();
        $(".modal_reset").click();
        $(".modal_close").click();

        var form = $(e.target).closest("form");
        var url = form.attr("action");
        var wrapper = $(e.target).data("wrapper");
        var route = $(e.target).data("route");
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function(data)
            {
                var url = Routing.generate(route, {id: "{{ client.id}}" } );
                $("#"+wrapper).load(url);
            }
        })
    });

    $("body").on("click", ".passRevealer", function(e){
        $(e.target).siblings(".originalPass").toggle();
        $(e.target).siblings(".hiddenPass").toggle();
    });

})