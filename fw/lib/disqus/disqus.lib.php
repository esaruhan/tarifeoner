<?php

/**
 * @author Özgür Kuru
 * @since
 * @version
 */
class disqus {

    private $api_key;
    private $forum;
    private $url;
    private $endpoint;

    function __construct($disqus_info) {
        $this->api_key = $disqus_info['api_key'];
        $this->forum = $disqus_info['forum'];
        $this->url = $disqus_info['url'];
    }

    function getUserPosts($username) {
        $this->endpoint = $this->url . 'users/listPosts.json?api_key=' . urldecode($this->api_key) . '&user:username=' . $username;
    }
    
    function getUserPostCount($username){
        self::getUserPosts($username);
    }

    function makeCall() {
        $session = curl_init($this->endpoint);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($session);
        curl_close($session);
        return $result;
        
    }

}

?>
