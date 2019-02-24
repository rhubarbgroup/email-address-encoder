( function () {
    var fetchPageSource = function () {
        if ( ! document.getElementById( "wp-admin-bar-root-default" ) ) {
            return;
        }

        if ( ! ( "fetch" in window ) ) {
            return;
        }

        fetch( document.location.href ).then( function ( response ) {
            if ( ! response.ok ) {
                throw Error( response.statusText );
            }

            return response;
        } ).then( function ( response ) {
            return response.text();
        } ).then( function ( pageSource ) {
            appendToAdminbar( findEmails( pageSource ) );
        } ).catch( function () {
            //
        } );
    };

    var findEmails = function ( content ) {
        var match;
        var emails = [];
        var regex = /(?:mailto:)?(?:[-!#$%&*+/=?^_`.{|}~\w\x80-\xFF]+|".*?")@(?:[-a-z0-9\x80-\xFF]+(\.[-a-z0-9\x80-\xFF]+)*\.[a-z]+|\[[\d.a-fA-F:]+\])/gi;

        while ( ( match = regex.exec( content ) ) !== null ) {
            if ( match.index === regex.lastIndex ) {
                regex.lastIndex++;
            }

            emails.push( match[ 0 ] );
        }

        return emails;
    };

    var appendToAdminbar = function ( emails ) {
        if ( ! emails.length ) {
            return;
        }

        var scannerUrl = "https://encoder.till.im/scanner?utm_source=wp-plugin&utm_medium=adminbar";

        var text = emails.length === 1
            ? eaeDetectorL10n.one_email
            : eaeDetectorL10n.many_emails.replace( "{number}", emails.length );

        var a = document.createElement( "a" );
        a.setAttribute( "class", "ab-item" );
        a.setAttribute( "href", scannerUrl + "&url=" + encodeURIComponent( window.location.href ) );
        a.appendChild( document.createTextNode( text ) );

        var li = document.createElement( "li" );
        li.setAttribute( "id", "wp-admin-bar-eae" );
        li.setAttribute( "class", "" );
        li.appendChild( a );

        document.getElementById( "wp-admin-bar-root-default" ).appendChild( li );
    };

    if ( document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading" ) {
        fetchPageSource();
    } else {
        document.addEventListener( "DOMContentLoaded", fetchPageSource );
    }
} () );
