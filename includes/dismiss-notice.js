( function ( $ ) {
    $( function () {
        $( ".notice[data-dismissible] .notice-dismiss" ).click(function (event) {
            $.post( ajaxurl, {
                notice: $( this ).parent().attr( "data-dismissible" ),
                action: "eae_dismiss_notice",
            } );

            event.preventDefault();
        } );
    } );
} ( jQuery ) );
