$(document).ready(function(){

    /**********************************************/
    /********* Search Initialization **************/
    /*
     * Search textbox and Dropdown filtration
     */
    /*********************************************/


    $("a.toggle-column").on('click',function(e){
        $(this).toggleClass( "toggle-column-hide" );
        $(this).find('.fa').toggleClass( "fa-times" );
    });

    $(".inputSearch").on("keyup", function(e){
        initSearch($(e.target), $(".dropdown-menu"));
    });

    $(".dropdown-menu").on("click", "a.toggle-column", function(e){
        var search_input = $(e.target).closest("section.panel").find(".inputSearch");
        initSearch(search_input, $(e.target).parent().parent());
    })

    function initSearch(input, dropdown)
    {
        var search_query = input.val();
        var id = input.data("controller_id") == "null" ? null : input.data("controller_id");
        var ignore_elements = dropdown.find("a.toggle-column-hide");

        var controller_url = input.data("url");
        var modal_wrapper = input.data("wrapper");

        var enc_arr = null;
        if(ignore_elements.length > 0)
        {
            var io = {}; //$.param accepts object only
            io.isp = [];
            $.each(ignore_elements, function(key, value){
                io.isp.push($(value).data("id"));
            });
            enc_arr = $.param(io);
        }
        var url = Routing.generate(controller_url, {id: id, q: search_query, isp: enc_arr } );
//        console.log(url);
        $("#"+modal_wrapper).load(url);
    }

})