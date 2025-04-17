<?php
/*
 ==================
 Ajax Search
======================
*/
// add the ajax fetch js
add_action( 'wp_footer', 'ajax_fetch' );
function ajax_fetch() {
    ?>
    <script type="text/javascript">
        function fetchSearchResults(event){
            event.preventDefault();
            //check that input#keyword has a value before making post request
            var formInputVal = document.getElementById('keyword').value;
            var datafetch = document.getElementById('datafetch');
            var errorNoResults = "<p class='small -error'><?php _e('No results found. Please try again using a different search term', 'inchcape') ?></p>";
            var errorEmpty = "<p class='small -error'><?php _e('Please enter a search term and try again', 'inchcape') ?></p>";

            if (/^\s*$/.test(formInputVal)){
                //value is either empty or contains whitespace characters
                datafetch.innerHTML = errorEmpty;
                return;
            }

            let xhr = new XMLHttpRequest();
            //xhr.open('POST', '<!?php echo get_admin_url(1, 'admin-ajax.php'); ?>', true);
            xhr.open('POST', '<?php echo admin_url('admin-ajax.php'); ?>', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
            xhr.onload = function () {
                if (this.status >= 200 && this.status < 400) {
                    if(this.response){
                        datafetch.innerHTML = this.response;
                        datafetch.classList.add('-open-results');
                        datafetch.style = "overflow: scroll";
                    } else {
                        datafetch.innerHTML = errorEmpty;
                    }

                    if(!this.response){
                        datafetch.innerHTML = errorNoResults;
                    }

                } else {
                    // If fail
                    console.log('search fail', this.response);
                }
            };
            xhr.onerror = function() {
                // Connection error
                console.log('search fail!', this.response);
            };

            xhr.send('action=data_fetch&keyword=' + document.getElementById('keyword').value)

        }
        var searchClose = document.querySelector(".js-search-results__close");

        if(searchClose){
            searchClose.addEventListener('click', function() {
                console.log('Search closed')
                const resultsContainer = document.querySelector('.search_result');
                if(resultsContainer) {
                    resultsContainer.classList.remove('-open-results');
                }
            });
        }

    </script>
    <?php
}

// the ajax function
add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');
function data_fetch(){

    $searchedValue = esc_attr( $_POST['keyword'] );

    // Get search results.
    // Is a comedian being searched for? Check if they are secret...
    $allPostsArgs = array(
        'post_type' => array('event', 'comedian'),
        'posts_per_page' => -1,
        's' => $searchedValue,
    );

    $query = new WP_Query($allPostsArgs);

    $idOfSearchedComedian =  idsOfPostsToRemoveFromResults($query);

    if($idOfSearchedComedian) {
        $idsOfEventsToHideFromResults = getEventsThatContainHiddenComedian($idOfSearchedComedian);
    }

    if($query->have_posts()):

        $count = $query->found_posts;
        $posts = $query->get_posts();

        echo '<h4>There were '.$count.' results for "'. $searchedValue . '"</h4>';

       echo '<div class="search-results">';
       echo '<button class="search-results__close js-search-results__close" onClick="closeSearch()"><span></span><span></span></button>';
       echo '<ul>';

        foreach( $posts as $post ) {

            if( !empty($idsOfEventsToHideFromResults )){
                if(!in_array($post->ID, $idsOfEventsToHideFromResults)){
                    echo '<li class="search-result -some-results-hidden">';
                    echo '<span>'.$post->post_type.'</span>';
                    echo '<a href="'.$post->guid.'">';
                    echo $post->post_title;
                    echo '</a>';
                    echo '</li>';
               }
            } else {
                echo '<li class="search-result">';
                echo '<span>'.$post->post_type.'</span>';
                echo '<a href="'.$post->guid.'">';
                echo $post->post_title;
                echo '</a>';
                echo '</li>';
            }

        }

        echo '</ul>';

        echo '</div>';

    else:
        echo '<div class="search-results">';
        echo '<button class="search-results__close js-search-results__close" onClick="closeSearch()"><span></span><span></span></button>';
        echo "<h4 style='text-align:center'>Sorry, we couldn't find anything for '". $searchedValue . "'. Try searching for something else...</h4>";
        echo '</div>';
        //wp_send_json_error('<!-- no more comedians -->');

    endif;

    die();
}
