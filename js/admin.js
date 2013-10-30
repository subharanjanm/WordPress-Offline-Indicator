(function ( $ ) {
    "use strict";

    $( function () {

        Offline.options = {
            game: true
        }

        var run = function () {
            if ( Offline.state === 'up' )
                Offline.check();
        }
        setInterval( run, 5000 );

    } );

}( jQuery ));