( function ( $ ) {
    $( function () {
        $( ".notice.is-dismissible[data-dismissible]" ).on(
            "click.eae-dismiss-notice",
            ".notice-dismiss",
            function ( event ) {
                $.post( ajaxurl, {
                    notice: $( this ).parent().attr( "data-dismissible" ),
                    action: "eae_dismiss_notice",
                } );

                event.preventDefault();
            }
        );
    } );
} ( jQuery ) );
