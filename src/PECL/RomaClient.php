<?php
/**
 * @file RomaClient.php
 * @brief Roma PHP client
 * <pre>
 * 
 *  </pre>
 * @example test.php
 * @author hiroaki.kubota@mail.rakuten.co.jp
 * @date 2010-06-15
 * @version $Id: RomaClient.php,v 0.9.1 2011/04/08 09:00:00 hiroaki.kubota Exp $
 */
#extension_loaded('phprmcc') || dl('phprmcc.so');

class RomaClient {
    private $client_id = "";
    private $default_timeout = 2000;
    const RMC_RET_ERROR = 1;
    const RMC_RET_EXCEPTION = 2;
    const RMC_RET_INCDEC_EXCEPTION = -1;
    const RMC_RET_CAS_UNIQUE_NO_VALUE = -1;
    const RMC_RET_ALIST_LENGTH_NOT_FOUND = -1;
    /**
     * @brief Constructor 
     * 
     * @param cid Name of PECL's.
     */
    private function __construct($cid) {
      $this->client_id = $cid;
    }

    /**
     * @brief Destructor
     *
     */
/*
    private function __destruct() {
      // Instance cache
      // rmc_term($this->client_id);
    }
*/

    /**
     * @brief Get roma-client instance.
     * <pre>
     *   When the value of '-d' is contained in this array, it'll not use routing-dump.
     * </pre>
     * @param hosts Host array. It's formated by <hostname>_<port>.
     */
    public static function getInstance($hosts) {
      $ROUTING_MODE = 1;
      foreach ($hosts as &$value) {        
        if ( $value == "-d") {
          // Without route
          $ROUTING_MODE = 0;
          break;
        }
      }
      $client_id = rmc_init($hosts,$ROUTING_MODE);
      if ( $client_id == RomaClient::RMC_RET_EXCEPTION ) {
        return False;
      }
      $client = new RomaClient($client_id);
      if ( rmc_num_connection($client_id) > 0 ) {
        return $client;
      }
      return False;
    }

    /**
     * @brief Close roma-client instance.
     * @param
     * @return
     */
    public function close() {
      rmc_term($this->client_id);
    }
    
    /**
     * @brief Set command timeout (msec)
     * @param timeout
     */
    public function set_default_timeout($timeout) {
      $this->default_timeout = $timeout;
    }

    /**
     * @brief Get value.(Issue 'get' command).
     * @param key 
     * @return value 
     */
    public function get($key) {
      $result = rmc_get($this->client_id, $key,$this->default_timeout);
      if ( is_null($result) || $result == RomaClient::RMC_RET_EXCEPTION ) {
        throw new Exception("rmc_get() failure");
      }else if ( $result == RomaClient::RMC_RET_ERROR ) {
	return False;
      }
      if ( $result[1] < 0 ) {
        return null;
      }
      return $result[0];
    }
    
    /**
     * @brief Set value.(Issue 'store' command).
     * @param key             
     * @param value           
     * @param exptime Specify the value of expire second.
     * @return Returns True if success.
     */
    public function set($key, $value, $exptime) {
      $result = rmc_set($this->client_id, $key, $value, $exptime, $this->default_timeout);
      if ( is_null($result) || $result == RomaClient::RMC_RET_EXCEPTION ) {
        throw new Exception("rmc_set() failure");
      }else if ( $result == RomaClient::RMC_RET_ERROR ) {
	return False;
      }
      return True;
    }
    
    /**
     * @brief Add value.(Issue 'add' command).
     * @param key
     * @param value
     * @param exptime Specify the value of expire second.
     * @return Returns True if success.
     */
    public function add($key, $value, $exptime) {
      $result = rmc_add($this->client_id, $key, $value, $exptime, $this->default_timeout);
      if ( is_null($result) || $result == RomaClient::RMC_RET_EXCEPTION ) {
        throw new Exception("rmc_add() failure");
      }else if ( $result == RomaClient::RMC_RET_ERROR ) {
	return False;
      }
      return True;
    }

    /**
     * @brief Replace value.(Issue 'replace' command).
     * @param key
     * @param value
     * @param exptime Specify the value of expire second.
     * @return Returns True if success.
     */
    public function replace($key, $value, $exptime) {
      $result = rmc_replace($this->client_id, $key, $value, $exptime, $this->default_timeout);
      if ( is_null($result) || $result == RomaClient::RMC_RET_EXCEPTION ) {
        throw new Exception("rmc_replace() failure");
      }else if ( $result == RomaClient::RMC_RET_ERROR ) {
	return False;
      }
      return True;
    }

    /**
     * @brief Append value.(Issue 'append' command).
     * @param key
     * @param value
     * @param exptime Specify the value of expire second.
     * @return Returns True if success.
     */
    public function append($key, $value, $exptime) {
      $result = rmc_append($this->client_id, $key, $value, $exptime, $this->default_timeout);
      if ( is_null($result) || $result == RomaClient::RMC_RET_EXCEPTION ) {
        throw new Exception("rmc_append() failure");
      }else if ( $result == RomaClient::RMC_RET_ERROR ) {
	return False;
      }
      return True;
    }

    /**
     * @brief Prepend value.(Issue 'prepend' command).
     * @param key
     * @param value
     * @param exptime Specify the value of expire second.
     * @return Returns True if success.
     */
    public function prepend($key, $value, $exptime) {
      $result = rmc_prepend($this->client_id, $key, $value, $exptime, $this->default_timeout);
      if ( is_null($result) || $result == RomaClient::RMC_RET_EXCEPTION ) {
        throw new Exception("rmc_prepend() failure");
      }else if ( $result == RomaClient::RMC_RET_ERROR ) {
	return False;
      }
      return True;
    }

    /**
     * @brief Cas value.(Issue 'cas' command).
     * @param key
     * @param value
     * @param cas
     * @param exptime Specify the value of expire second.
     * @return Returns True if success.
     */
    public function cas($key, $value, $cas, $exptime) {
      $result = rmc_cas($this->client_id, $key, $value, $exptime, $cas, $this->default_timeout);
      if ( is_null($result) || $result == RomaClient::RMC_RET_EXCEPTION ) {
        throw new Exception("rmc_cas() failure");
      }else if ( $result == RomaClient::RMC_RET_ERROR ) {
	return False;
      }
      return True;
    }

    /**
     * @brief Delete value.(Issue 'delete' command).
     * @param key             (string)
     * @return Returns True if success.
     */
    public function delete($key) {
      $result = rmc_delete($this->client_id, $key, $this->default_timeout);
      if ( is_null($result) || $result == RomaClient::RMC_RET_EXCEPTION ) {
        throw new Exception("rmc_delete() failure");
      }else if ( $result == RomaClient::RMC_RET_ERROR ) {
	return False;
      }
      return True;
    }

    /**
     * @brief Incr value.(Issue 'incr' command).
     * @param key
     * @param param is the amount by which the client wants to increase the item.
     * @return On success new value of the item's data, other than -1.
     */
    public function incr($key, $param) {
      $result = rmc_incr($this->client_id, $key, $param, $this->default_timeout);
      if (is_null($result) || $result == RomaClient::RMC_RET_INCDEC_EXCEPTION) {
        throw new Exception("rmc_incr() failure");
      }
      return $result;      
    }

    /**
     * @brief Decr value.(Issue 'decr' command).
     * @param key
     * @param param is the amount by which the client wants to decrease the item.
     * @return On success new value of the item's data, other than -1.
     */
    public function decr($key, $param) {
      $result = rmc_decr($this->client_id, $key, $param, $this->default_timeout);
      if (is_null($result) || $result == RomaClient::RMC_RET_INCDEC_EXCEPTION) {
        throw new Exception("rmc_decr() failure");
      }
      return $result;      
    }

    /**
     * @brief Gets value. (Issue 'gets' command).
     * @brief This command is 'cas ID' response only.
     * @param key
     * @return On success new value of the item's data, other than -1.
     */
    public function cas_unique($key) {
      $result = rmc_cas_unique($this->client_id, $key, $this->default_timeout);
      if ( is_null($result) || $result == RomaClient::RMC_RET_EXCEPTION ) {
        throw new Exception("rmc_cas_unique() failure");
      } else if ($result == RomaClient::RMC_RET_ERROR) {
        return False;
      }
      return array($result[2],$result[0]);
    }

    /**
     * @brief ALIST operation. (Issue 'alist_sized_insert' command)
     * @param key
     * @param size
     * @param value
     * @return Returns True if success.
     */
    public function alist_sized_insert($key, $size, $value) {
      $result = rmc_alist_sized_insert($this->client_id,$key, $size, $value,$this->default_timeout);
      if ( is_null($result) || $result == RomaClient::RMC_RET_EXCEPTION ) {
        throw new Exception("rmc_alist_sized_insert() failure");
      }else if ( $result == RomaClient::RMC_RET_ERROR ) {
	return False;
      }

      return True;
    }

    /**
     * @brief ALIST operation. (Issue 'alist_join' command)
     * @param key
     * @param separator Be careful to never conflict with values.
     * @return Return as the array.
     */
    public function alist_join($key, $separator) {
      // @@@ Todo: Should use alist_gets
      $result = rmc_alist_join($this->client_id,$key, $separator,$this->default_timeout);
      if ( is_null($result) || $result == RomaClient::RMC_RET_EXCEPTION ) {
        throw new Exception("rmc_alist_join() failure");
      }else if ( $result == RomaClient::RMC_RET_ERROR ) {
	return False;
      }

      if ( $result[1] < 0 ) {
        return null;
      }
      $token = strtok($result[0], $separator);
      $array = array();
      while($token) {
        array_push($array, ltrim($token, "\r\n"));
        $token = strtok($separator);
      }
      return $array;
    }
    /**
     * @brief ALIST operation. (Issue 'alist_delete' command)
     * @param key
     * @param value
     * @return Returns True if success.
     */
    public function alist_delete($key, $value) {
      $result = rmc_alist_delete($this->client_id,$key, $value,$this->default_timeout);
      if ( is_null($result) || $result == RomaClient::RMC_RET_EXCEPTION ) {
        throw new Exception("rmc_alist_delete() failure");
      }else if(  $result == RomaClient::RMC_RET_ERROR ) {
	return False;
      }
      return True;
    }

    /**
     * @brief ALIST operation. (Issue 'alist_delete_at' command)
     * @param key
     * @param pos
     * @return Returns True if success.
     */
    public function alist_delete_at($key, $pos) {
      $result = rmc_alist_delete_at($this->client_id,$key, $pos,$this->default_timeout);
      if ( is_null($result) || $result == RomaClient::RMC_RET_EXCEPTION ) {
        throw new Exception("rmc_alist_delete_at() failure");
      }else if ( $result == RomaClient::RMC_RET_ERROR ) {
        return False;
      }

      return True;
    }

    /**
     * @brief ALIST operation. (Issue 'alist_clear' command)
     * @param key
     * @return Returns True if success.
     */
    public function alist_clear($key) {
      $result = rmc_alist_clear($this->client_id,$key,$this->default_timeout);
      if ( is_null($result) || $result == RomaClient::RMC_RET_EXCEPTION ) {
        throw new Exception("rmc_alist_clear() failure");
      }else if( $result == RomaClient::RMC_RET_ERROR ) {
        return False;
      }
      return True;
    }

    /**
     * @brief ALIST operation. (Issue 'alist_length' command)
     * @param key
     * @return On success new value of the item's data, other than -1.
     */
    public function alist_length($key) {
      $result = rmc_alist_length($this->client_id,$key,$this->default_timeout);
      if (is_null($result) || $result == RomaClient::RMC_RET_ALIST_LENGTH_NOT_FOUND) {
        throw new Exception("rmc_alist_length() failure");
      }
      return $result;
    }

    /**
     * @brief ALIST operation. (Issue 'alist_update_at' command)
     * @param key
     * @param index
     * @param value
     * @return Retuens True if sccess.
     */
    public function alist_update_at($key, $index, $value) {
      $result = rmc_alist_update_at($this->client_id,$key,$index,$value,$this->default_timeout);
      if ( is_null($result) || $result == RomaClient::RMC_RET_EXCEPTION ) {
        throw new Exception("rmc_alist_update_at() failure");
      }else if( $result == RomaClient::RMC_RET_ERROR ) {
        return False;
      }
      return True;
    }
}

    //===== plugin - alist =====//
    /**
     * alist at.
     * @param key   (string)
     * @param index (int)
     * @return value
     */
    /* public function alist_at($key, $index) { */
    /*     /\* $result = rmc_alist_at($key, $index); *\/ */
    /*     /\* return $result; *\/ */
    /*   throw new Exception("Not implements !"); */
    /* } */

    /**
     * alist empty ?
     * @param key (string)
     * @return status
     */
    /* public function alist_empty($key) { */
    /*     /\* $result = rmc_alist_empty($key); *\/ */
    /*     /\* return ($result == RomaClient::ALIST_TRUE ? True : False); *\/ */
    /*   throw new Exception("Not implements !"); */
    /* } */

    /**
     * alist first.
     * @param key   (string)
     * @return value
     */
    /* public function alist_first($key) { */
    /*     /\* $result = rmc_alist_first($key); *\/ */
    /*     /\* return $result; *\/ */
    /*   throw new Exception("Not implements !"); */
    /* } */

    /**
     * alist include ?
     * @param key   (string)
     * @param value (string)
     * @return status
     */
    /* public function alist_include($key, $value) { */
    /*     /\* $result = rmc_alist_include($key, $value); *\/ */
    /*     /\* return ($result == RomaClient::ALIST_TRUE ? True : False); *\/ */
    /*   throw new Exception("Not implements !"); */
    /* } */

    /**
     * alist index.
     * @param key   (string)
     * @param value (int)
     * @return index/status
     */
    /* public function alist_index($key, $value) { */
    /*     /\* $result = rmc_alist_index($key, $value); *\/ */
    /*     /\* return $result; *\/ */
    /*   throw new Exception("Not implements !"); */
    /* } */

    /**
     * alist insert.
     * @param key   (string)
     * @param index (int)
     * @param value (string)
     * @return status
     */
    /* public function alist_insert($key, $index, $value) { */
    /*     /\* $result = rmc_alist_insert($key, $index, $value); *\/ */
    /*     /\* return ($result == RomaClient::STORED ? True : False); *\/ */
    /*   throw new Exception("Not implements !"); */
    /* } */

    /**
     * alist to json.
     * @param key (string)
     * @return value - json.
     */
    /* public function alist_to_json($key) { */
    /*     /\* $reuslt = rmc_alist_to_json($key); *\/ */
    /*     /\* return $result; *\/ */
    /*   throw new Exception("Not implements !"); */
    /* } */

    /**
     * alist last.
     * @param key (string)
     * @return value
     */
    /* public function alist_last($key) { */
    /*     /\* $result = rmc_alist_last($key); *\/ */
    /*     /\* return $result; *\/ */
    /*   throw new Exception("Not implements !"); */
    /* } */

    /**
     * alist pop.
     * @param key (string)
     * @return value
     */
    /* public function alist_pop($key) { */
    /*     /\* $result = rmc_alist_pop($key); *\/ */
    /*     /\* return $result; *\/ */
    /*   throw new Exception("Not implements !"); */
    /* } */

    /**
     * alist push.
     * @param key   (string)
     * @param value (string)
     * @return status
     */
    /* public function alist_push($key, $value) { */
    /*     /\* $result = rmc_alist_push($key, $value); *\/ */
    /*     /\* return ($result == RomaClient::STORED ? True : False); *\/ */
    /*   throw new Exception("Not implements !"); */
    /* } */

    /**
     * alist shift.
     * @param key (string)
     * @return value
     */
    /* public function alist_shift($key) { */
    /*     /\* $result = rmc_alist_shift($key); *\/ */
    /*     /\* return $result; *\/ */
    /*   throw new Exception("Not implements !"); */
    /* } */

    /**
     * alist to string.
     * @param key (string)
     * @return value
     */
    /* public function alist_to_str($key) { */
    /*     /\* $result = rmc_alist_to_str($key); *\/ */
    /*     /\* return $result; *\/ */
    /*   throw new Exception("Not implements !"); */
    /* } */

?> 
