$(document).ready(function(){

    /*********************************************************/
    /*********** Mutation Observer (domainsWrapper) **********/
    /*
     Loads (Ajax) popover plugin after each ajax load call
     */
    /********************************************************/

    var target = $('.wrapperToWatch');

    var config = { attributes: true, childList: true, characterData: true };

    function mutationHandler(mutations){
        mutations.forEach(function(mutation){
            $('.popover-area [data-toggle="popover"]').popover();
            $('.popover-area-hover [data-toggle="popover"]').popover({ trigger:"hover" });
        })
    }

    var observer = new MutationObserver(mutationHandler);

    $.each(target, function(key, val){
        observer.observe(this, config);
    });
})