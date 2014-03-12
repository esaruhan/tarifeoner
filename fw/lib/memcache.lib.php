<?php

/**
 * @author Özgür Kuru
 * @since
 * @version
 */
class Cache {
    private $memcache;
    private $compress;
    function __construct($memcacheInfo) {
        $this->memcache = new Memcache();
        $this->compress= $memcacheInfo['compress'];
        foreach($memcacheInfo['server'] as $host => $port){
            $this->memcache->addServer($host,$port);
        }
    }
    
    function add($data){
       $result= $this->memcache->add($data['key'],$data['value'],$this->compress,$data['timeout']);
    }
    
    function get($key){
        return $this->memcache->get($key);
    }
    
    function delete($key){
        return $this->memcache->delete($key);
    }
    
    
}

?>
