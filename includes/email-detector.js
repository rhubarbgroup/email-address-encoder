( function () {
    var fetchPageSource = function () {
        if ( ! ( "fetch" in window ) ) {
            return;
        }

        if ( ! document.getElementById( "wp-admin-bar-root-default" ) ) {
            return;
        }

        fetch( document.location.href, {
            credentials: "omit",
            headers: { "X-Email-Detector": "true" },
        }).then( function ( response ) {
            if ( ! response.ok ) {
                console.info( eae_detector.fetch_failed );
            }

            return response;
        } ).then( function ( response ) {
            return response.text();
        } ).then( findEmails ).catch( function () {
            //
        } );
    };

    var findEmails = function ( pageSource ) {
        if ( typeof( Worker ) === "undefined" ) {
            return;
        }

        var worker = new Worker(
            URL.createObjectURL(
                new Blob(
                    [ "(", emailWorker.toString(), ")()" ],
                    { type: "application/javascript" }
                )
            )
        );

        worker.addEventListener( "message", function ( message ) {
            if ( message.data.command === "done" ) {
                appendToAdminbar( message.data.emails );
            }
        }, false );

        worker.postMessage({ pageSource: pageSource });
    };

    var emailWorker = function () {
        self.addEventListener( "message", function ( message ) {
            var match;
            var emails = [];
            var regex = /(?:mailto:)?(?:[-!#$%&*+/=?^_`.{|}~\w\x80-\xFF]+|".*?")@(?:[-a-z0-9\x80-\xFF]+(\.[-a-z0-9\x80-\xFF]+)*\.[a-z]+|\[[\d.a-fA-F:]+\])/gi;

            while ( ( match = regex.exec( message.data.pageSource ) ) !== null ) {
                if ( match.index === regex.lastIndex ) {
                    regex.lastIndex++;
                }

                emails.push( match[ 0 ] );
            }

            self.postMessage({
                command: "done",
                emails: emails,
            });
        } );
    };

    var appendToAdminbar = function ( emails ) {
        if ( ! emails.length ) {
            return;
        }

        var scannerUrl = "https://encoder.till.im/scanner?utm_source=wp-plugin&utm_medium=adminbar";

        var text = emails.length === 1
            ? eae_detector.one_email
            : eae_detector.many_emails.replace( "{number}", emails.length );

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
