<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2015 - 2024 The Open University UK                            *
 *                                                                              *
 *  This software is freely distributed in accordance with                      *
 *  the GNU Lesser General Public (LGPL) license, version 3 or later            *
 *  as published by the Free Software Foundation.                               *
 *  For details see LGPL: http://www.fsf.org/licensing/licenses/lgpl.html       *
 *               and GPL: http://www.fsf.org/licensing/licenses/gpl-3.0.html    *
 *                                                                              *
 *  This software is provided by the copyright holders and contributors "as is" *
 *  and any express or implied warranties, including, but not limited to, the   *
 *  implied warranties of merchantability and fitness for a particular purpose  *
 *  are disclaimed. In no event shall the copyright owner or contributors be    *
 *  liable for any direct, indirect, incidental, special, exemplary, or         *
 *  consequential damages (including, but not limited to, procurement of        *
 *  substitute goods or services; loss of use, data, or profits; or business    *
 *  interruption) however caused and on any theory of liability, whether in     *
 *  contract, strict liability, or tort (including negligence or otherwise)     *
 *  arising in any way out of the use of this software, even if advised of the  *
 *  possibility of such damage.                                                 *
 *                                                                              *
 ********************************************************************************/
 /** Author: Michelle Bachler, KMi, The Open University **/

 class MemcacheManager {

	private $isEnabled = false;
	private $objCache = null;

	/**
	 * Constructor.
 	 *
	 * @return MemcacheManager (this)
	 */
	function MemcacheManager() {
  		$this->objCache = new Memcache();

  		//$this->objCache = new Memcached();
		//$this->objCache->resetServerList(void);
  		//if ($this->objCache->addServer('localhost', 11211) === TRUE) {

        if ($this->objCache->connect('localhost', 11211) === TRUE) {
        	$this->isEnabled = true;
        } else {
        	$this->isEnabled = false;
        }
        return $this;
    }

	public function isEnabled() {
		return $this->isEnabled;
	}

	public function setStringData($key, $str, $timeout=60) {
		if ($this->isEnabled) {
			$cacheKey = md5($key);
			//$data = $this->objCache->set($cacheKey, $str, $timeout);
			$data = $this->objCache->set($cacheKey, $str, 0, $timeout);
			return $data;
		} else {
			return FALSE;
		}
    }

	public function getStringData($key) {
		if ($this->isEnabled) {
			$cacheKey = md5($key);
			return $this->objCache->get($cacheKey);
		} else {
			return FALSE;
		}
	}

	public function setObjData($key, $obj, $timeout=60) {
		if ($this->isEnabled) {
			$cacheKey = md5($key);
			//$data = $this->objCache->set($cacheKey, serialize($obj), $timeout);
			$data = $this->objCache->set($cacheKey, serialize($obj), 0, $timeout);
			return $data;
		} else {
			return FALSE;
		}
    }

	public function getObjData($key) {
		if ($this->isEnabled) {
			$cacheKey = md5($key);
			$results = $this->objCache->get($cacheKey);
			if ($results === FALSE) {
				return $results;
			} else {
				return unserialize($results);
			}
		} else {
			return FALSE;
		}
	}

  	// delete data from cache server
    function deleteData($key) {
		$cacheKey = md5($key);
        $success_val = $this->objCache->delete($cacheKey);
        return $success_val;
    }
}

?>