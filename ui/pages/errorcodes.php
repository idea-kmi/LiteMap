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
    include_once("../../config.php");

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

    include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
?>

<h1><?php echo $LNG->CORE_HELP_ERRORCODES_TITLE; ?></h1>
<table>

<tr>
    <td width="20%" style="font-weight:bold; font-size:12pt"><?php echo $LNG->CORE_HELP_ERRORCODES_CODE_HEADING; ?></td>
    <td width="80%" style="font-weight:bold; font-size:12pt"><?php echo $LNG->CORE_HELP_ERRORCODES_MEANING_HEADING; ?></td>
</tr>

<tr>
    <td>1000</td>
    <td><?php echo $LNG->ERROR_REQUIRED_PARAMETER_MISSING_MESSAGE; ?></td>
</tr>
<tr>
    <td>1001</td>
    <td><?php echo $LNG->ERROR_INVALID_METHOD_SPECIFIED_MESSAGE; ?></td>
</tr>
<tr>
    <td>1002</td>
    <td><?php echo $LNG->ERROR_INVALID_ORDERBY_MESSAGE; ?></td>
</tr>
<tr>
    <td>1003</td>
    <td><?php echo $LNG->ERROR_INVALID_SORT_MESSAGE; ?></td>
</tr>
<tr>
    <td>1004</td>
    <td><?php echo $LNG->ERROR_BLANK_NODEID_MESSAGE; ?></td>
</tr>
<tr>
    <td>2000</td>
    <td><?php echo $LNG->ERROR_LOGIN_FAILED_MESSAGE; ?></td>
</tr>
<tr>
    <td>2001</td>
    <td><?php echo $LNG->ERROR_LOGIN_FAILED_UNAUTHORISED_MESSAGE; ?></td>
</tr>
<tr>
    <td>2002</td>
    <td><?php echo $LNG->ERROR_LOGIN_FAILED_SUSPENDED_MESSAGE; ?></td>
</tr>
<tr>
    <td>2003</td>
    <td><?php echo $LNG->ERROR_LOGIN_FAILED_UNVALIDATED_MESSAGE; ?></td>
</tr>
<tr>
    <td>2004</td>
    <td><?php echo $LNG->ERROR_LOGIN_FAILED_EXTERNAL_MESSAGE; ?></td>
</tr>
<tr>
    <td>2010</td>
    <td><?php echo $LNG->ERROR_ACCESS_DENIED_MESSAGE; ?></td>
</tr>

<tr>
    <td>2011</td>
    <td><?php echo $LNG->CORE_SESSION_INVALID; ?></td>
</tr>

<tr>
    <td>3000</td>
    <td><?php echo $LNG->ERROR_INVALID_METHOD_FOR_TYPE_MESSAGE; ?></td>
</tr>
<tr>
    <td>3001</td>
    <td><?php echo $LNG->ERROR_DUPLICATION_MESSAGE; ?></td>
</tr>
<tr>
    <td>4000</td>
    <td><?php echo $LNG->ERROR_INVALID_EMAIL_FORMAT_MESSAGE; ?></td>
</tr>
<tr>
    <td>5000</td>
    <td><?php echo $LNG->ERROR_INVALID_JSON_ERROR_DEFAULT; ?></td>
</tr>
<tr>
    <td>7000</td>
    <td><?php echo $LNG->ERROR_DATABASE_MESSAGE; ?></td>
</tr>
<tr>
    <td>7002</td>
    <td><?php echo $LNG->ERROR_USER_NOT_FOUND_MESSAGE; ?></td>
</tr>
<tr>
    <td>7003</td>
    <td><?php echo $LNG->ERROR_URL_NOT_FOUND_MESSAGE; ?></td>
</tr>
<tr>
    <td>7004</td>
    <td><?php echo $LNG->ERROR_TAG_NOT_FOUND_MESSAGE; ?></td>
</tr>
<tr>
    <td>7005</td>
    <td><?php echo $LNG->ERROR_ROLE_NOT_FOUND_MESSAGE; ?></td>
</tr>
<tr>
    <td>7006</td>
    <td><?php echo $LNG->ERROR_LINKTYPE_NOT_FOUND_MESSAGE; ?></td>
</tr>
<tr>
    <td>7007</td>
    <td><?php echo $LNG->ERROR_NODE_NOT_FOUND_MESSAGE; ?></td>
</tr>
<tr>
    <td>7008</td>
    <td><?php echo $LNG->ERROR_CONNECTION_NOT_FOUND_MESSAGE; ?></td>
</tr>
<tr>
    <td>7009</td>
    <td><?php echo $LNG->ERROR_GROUP_NOT_FOUND_MESSAGE; ?></td>
</tr>
<tr>
    <td>7010</td>
    <td><?php echo $LNG->ERROR_GROUP_EXISTS_MESSAGE; ?></td>
</tr>
<tr>
    <td>7011</td>
    <td><?php echo $LNG->ERROR_GROUP_USER_LAST_ADMIN; ?></td>
</tr>
<tr>
    <td>7012</td>
    <td><?php echo $LNG->ERROR_GROUP_USER_NOT_MEMBER; ?></td>
</tr>
<tr>
    <td>7013</td>
    <td><?php echo $LNG->ERROR_GROUP_USER_NOT_MEMBER; ?></td>
</tr>
<tr>
    <td>8000</td>
    <td><?php echo $LNG->ERROR_INVALID_CONNECTION_MESSAGE; ?></td>
</tr>
<tr>
    <td>10001</td>
    <td><?php echo $LNG->ERROR_INVALID_PARAMETER_TYPE_MESSAGE; ?></td>
</tr>
</table>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>