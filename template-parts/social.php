<?php

    // globals
    $facebook_page_url = 'http://facebook.com/coostr';
    $twitter_page_url = 'https://twitter.com/coostr';
    $instagram_page_url = 'http://instagram.com/coostr';

    require_once('lib/facebook-php-sdk-master/src/facebook.php');
    require_once('lib/tweet-php-master/TweetPHP.php');

    // FACEBOOK

    // connect to app
    $config = array();
    $config['appId'] = '1553393808214402';
    $config['secret'] = 'd754e72c29f042b6d96d41d1336df4df';
    $config['fileUpload'] = false; // optional

    // instantiate
    $facebook = new Facebook($config);

    // set page id
    $pageid = "1535091483372913";

    // now we can access various parts of the graph, starting with the feed
    $pagefeed = $facebook->api("/" . $pageid . "/feed");

    // INSTAGRAM

    // Supply a user id and an access token
    $userid = "1411947405";
    $accessToken = "1411947405.74de813.4b915d14d2fa45e8bbba7c18ef8df230";

    // Gets our data
    function fetchData($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    // Pulls and parses data.
    $igResult = fetchData("https://api.instagram.com/v1/users/{$userid}/media/recent/?access_token={$accessToken}&count=4");
    $igResult = json_decode($igResult);

    // TWITTER 

    $TweetPHP = new TweetPHP(array(
        'consumer_key'          => '3SyFRzTtfcvpdWS39YCz2qYl9',
        'consumer_secret'       => 'jGDUP8oUt5OKhxZzBGVmMzwyeUPtyJaCjhgGYixOWNNqxvYIl5',
        'access_token'          => '148641495-igNpxFIO9F4BQWQbvRqByiBpYOm54fkJXe9FkYvV',
        'access_token_secret'   => 'Uud9COHflpJwtSnevW5OrY1aVpTbc9cRZReRTAfooQt8O',
        'twitter_screen_name'   => 'coostr',
        'cache_file'            => dirname(__FILE__) . '/cache/coostr.txt', // Where on the server to save the cached formatted tweets
        'cache_file_raw'        => dirname(__FILE__) . '/cache/coostr-array.txt', // Where on the server to save the cached raw tweets
        'tweets_to_display'     => 4 // How many tweets to fetch
    )); 
?>


    <div class="row">

        <div class="col-md-4 instagram">
            <div class="row text-center">
                <div class="col-xs-12">
	                <div class="social-icon">
	                    <a href="<?php echo $instagram_page_url; ?>" target="_blank">
	                        <i class="fa fa-instagram"></i>
	                    </a>
	                </div>
	                <div class="ig-follow">
		                <script>(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.src="http://instagramfollowbutton.com/components/instagram/v2/js/ig-follow.js";s.parentNode.insertBefore(g,s);}(document,"script"));</script>
		                <span class="ig-follow" data-id="866bf12925" data-count="true" data-size="small" data-username="true"></span>
	                </div>
                </div>
            </div>                
            <div class="row clearfix ig-feed">
                <?php foreach ($igResult->data as $igPost): ?>
                    <!-- Renders images. @Options (thumbnail,low_resoulution, high_resolution) -->
                    <div class="col-xs-6 ig-photo">
                        <!--<a data-lightbox="ig-photo-album" href="<?php echo $igPost->images->standard_resolution->url ?>">-->
                            <img src="<?php echo $igPost->images->thumbnail->url ?>">
                        <!--</a>-->
                    </div>
                <?php endforeach ?>
            </div>
        </div><!-- /.col-md-4 -->

        <div class="col-md-4 twitter">
            <div class="row text-center">
                <div class="col-xs-12">
	                <div class="social-icon">
	                    <a href="<?php echo $twitter_page_url; ?>" target="_blank">
	                        <i class="fa fa-twitter"></i>
	                    </a>
	                </div>
	                <div class="tw-follow">
		                <a href="https://twitter.com/Coostr" class="twitter-follow-button" data-show-count="false">Follow @Coostr</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
	                </div>
                </div>
            </div>
            <div class="row clearfix tw-feed">
                <div class="col-xs-12">
                    <div class="tweets-wrapper">
                        <?php echo $TweetPHP->get_tweet_list(); ?>
                    </div>
                </div>
            </div>
        </div><!-- /.col-md-4 -->

        <div class="col-md-4 facebook">
            <div class="row text-center">
                <div class="col-xs-12">
	                <div class="social-icon facebook">
	                    <a href="<?php echo $facebook_page_url; ?>" target="_blank">
	                        <i class="fa fa-facebook"></i>
	                    </a>
	                </div>
                    <div class="fb-like" data-href="https://www.facebook.com/coostr" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
                </div>
            </div>
            
            <?php

            echo "<div class=\"fb-feed\">";

            // set counter to 0, because we only want to display 10 posts
            $i = 0;
            foreach($pagefeed['data'] as $fbPost) {


                if ($fbPost['type'] == 'status' || $fbPost['type'] == 'link' || $fbPost['type'] == 'photo') {


                    // open up an fb-update div
                    echo "<div class=\"fb-update\">";

                    // post the time


                    // check if post type is a status
                    if ($fbPost['type'] == 'status') {
                        echo "<h2>Status updated: " . date("jS M, Y", (strtotime($fbPost['created_time']))) . "</h2>";
                        if (empty($fbPost['story']) === false) {
                            echo "<p>" . $fbPost['story'] . "</p>";
                        } elseif (empty($fbPost['message']) === false) {
                            echo "<p>" . $fbPost['message'] . "</p>";
                        }
                    }

                    // check if post type is a link
                    if ($fbPost['type'] == 'link') {
                        echo "<h2>Link posted on: " . date("jS M, Y", (strtotime($fbPost['created_time']))) . "</h2>";
                        echo "<p>" . $fbPost['name'] . "</p>";
                        echo "<p><a href=\"" . $fbPost['link'] . "\" target=\"_blank\">" . $fbPost['link'] . "</a></p>";
                    }

                    // check if post type is a photo
                    if ($fbPost['type'] == 'photo') {
                        echo "<h2>Photo posted on: " . date("jS M, Y", (strtotime($fbPost['created_time']))) . "</h2>";
                        if (empty($fbPost['story']) === false) {
                            echo "<p>" . $fbPost['story'] . "</p>";
                        } elseif (empty($fbPost['message']) === false) {
                            echo "<p>" . $fbPost['message'] . "</p>";
                        }
                        echo "<div class=\"fb-photo\"><img src=\"" . $fbPost['picture'] . "\" /></div>";
                    }


                    echo "</div>"; // close fb-update div

                    $i++; // add 1 to the counter if our condition for $post['type'] is met
                }


                //  break out of the loop if counter has reached 10
                if ($i == 2) {
                    break;
                }
            } // end the foreach statement

            echo "</div>";

            ?>
        </div>
    </div><!-- /.col-md-4 -->
