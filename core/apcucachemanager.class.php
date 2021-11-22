<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2020 The Open University UK                                   *
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

 class APCuCacheManager {

	private $isEnabled = false;

	/**
	 * Constructor.
 	 *
	 * @return APCuCacheManager (this)
	 */
	function APCuCacheManager() {
        $this->isEnabled = apcu_enabled();
        return $this;
    }

	public function isEnabled() {
		return $this->isEnabled;
	}

	public function setStringData($key, $str, $timeout=60) {
		if ($this->isEnabled) {
			$cacheKey = md5($key);
			$data = apcu_store ( $cacheKey, $str, $timeout);
			return $data;
		} else {
			return FALSE;
		}
    }

	public function getStringData($key) {
		if ($this->isEnabled) {
			$cacheKey = md5($key);
			$reply = apcu_fetch($cacheKey, $succeeded);
			if ($reply === "") {
				return FALSE;
			} else {
				return $reply;
			}
		} else {
			return FALSE;
		}
	}

	public function setObjData($key, $obj, $timeout=60) {
		if ($this->isEnabled) {
			$cacheKey = md5($key);
			$data = apcu_store( $cacheKey, serialize($obj), $timeout);
			return $data;
		} else {
			return FALSE;
		}
    }

	public function getObjData($key) {
		if ($this->isEnabled) {
			$cacheKey = md5($key);
			$results = apcu_fetch($cacheKey);
			if ($results === FALSE) {
				return $results;
			} else {
				return unserialize($results);
			}
		} else {
			return FALSE;
		}
	}

    function deleteData($key) {
		$cacheKey = md5($key);
        $success_val = apcu_delete($cacheKey);
        return $success_val;
    }
}

?>