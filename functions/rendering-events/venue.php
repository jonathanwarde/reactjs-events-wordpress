<?php
function getVenuePin( $ID ) {
    $venue = get_field( 'venue', $ID );
    if ( $venue === 'kingsway' ) {
        return '<span class="venue">
            <a href="/find-us/#kingsway" target="_blank"><svg><use href="#icon-search-pin" /></svg>
            23 Kingsway
            </a>
        </span>';
    } else if ( $venue === 'drurylanebasement' ) {
        return '<span class="venue">
            <a href="/find-us/#drurylane" target="_blank"><svg><use href="#icon-search-pin" /></svg>
            170 Drury Lane (basement)
            </a>
        </span>';
    } else if ( $venue === 'drurylaneground' ) {
        return '<span class="venue">
            <a href="/find-us/#drurylane" target="_blank"><svg><use href="#icon-search-pin" /></svg>
            170 Drury Lane (ground floor)
            </a>
        </span>';
    }  else {
        return '<span class="venue">
            <a href="/find-us/#drurylane" target="_blank"><svg><use href="#icon-search-pin" /></svg>
            170 Drury Lane
            </a>
        </span>';
    }
}
