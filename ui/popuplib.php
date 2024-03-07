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

function insertIdeas() {
	global $ideanamearray, $ideadescarray, $CFG, $LNG, $HUB_FLM;
?>
   <div class="mb-3 row" id="ideadiv">
		<div style="display: block; float:left">
	        <div class="formrow" id="ideaformdiv">
	  			<?php
					$count = 0;
					if (is_countable($ideanamearray)) {
						$count = count($ideanamearray);
					}
	                for($i=0; $i<$count; $i++){
	            		?>
						<div id="ideafield<?php echo $i; ?>" class="formrow">
							<div class="formrowsm">
								<input class="subforminput hgrwide" placeholder="<?php echo $LNG->FORM_IDEA_LABEL_TITLE; ?>" id="ideaname-'+noIdeas+'" name="ideanamearray[]"  value="<?php echo $ideanamearray[$i]; ?>" />
							</div>
							<div class="formrowsm">
								<textarea rows="3" class="subforminput hgrwide" placeholder="<?php echo $LNG->FORM_IDEA_LABEL_DESC; ?>" id="ideadesc-'+noIdeas+'" name="ideadescarray[]"><?php echo $ideadescarray[$i]; ?></textarea>
							</div>
						</div>
						<?php if ($i > 1) { ?>
						< a href="javascript:removeMultiple('idea', <?php echo $i; ?>)" class="form" style="float:right;margin-right: 5px;"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></a><br>
						<?php } ?>
		         <?php } ?>
			</div>
	        <div class="formrow">
	    		<span class="formsubmit form active" style="margin-left: 10px;" onclick="noIdeas = addIdea(noIdeas);"><?php echo $LNG->FORM_BUTTON_ADD_ANOTHER." ".$LNG->SOLUTION_NAME; ?></span>
	    	</div>
		</div>
	</div>
<?php }


function insertFormHeaderMessage() {
	global $LNG; ?>
	<p><?php echo $LNG->FORM_HEADER_MESSAGE; ?>
	<br><?php echo $LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART1; ?> <span class="required">*</span> <?php echo $LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART2; ?><?php echo $LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART3; ?>
	</p>
<?php }

function insertFormHeaderMessageShort() {
	global $LNG; ?>
	<p><?php echo $LNG->FORM_HEADER_MESSAGE; ?>
	<?php echo $LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART1; ?> <span class="required">*</span> <?php echo $LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART2; ?><?php echo $LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART4; ?>
	</p>
<?php }

function insertSummary($hintname, $title = "") {
	global $summary, $CFG, $LNG, $HUB_FLM;
	if ($title == "") {
		$title = $LNG->FORM_LABEL_SUMMARY;
	}
	?>
   <div class="mb-3 row" id="summarydiv">
		<label class="col-sm-3 col-form-label" for="summary">
			<?php echo $title; ?>
			<span class="active" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
				<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
				<span class="sr-only">More info</span>
			</span>
			<span class="required">*</span>
		</label>
		<div class="col-sm-9">
			<input class="form-control" id="summary" name="summary" value="<?php echo( $summary ); ?>" />
		</div>
	</div>
<?php }

function insertDescriptionPlain($hintname) {
	global $desc, $CFG, $LNG, $HUB_FLM; ?>
	<div class="mb-3 row" id="descdiv">
		<label for="desc" class="col-sm-3 col-form-label">
			<?php echo $LNG->FORM_LABEL_DESC; ?>
			<span class="active" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
				<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
				<span class="sr-only">More info</span>
			</span>
			<span class="required">*</span>
		</label>
		<div class="col-sm-9" id="textareadiv">
			<textarea rows="4" class="form-control" id="desc" name="desc"><?php echo( $desc ); ?></textarea>
		</div>
	</div>
<?php }

function insertDescription($hintname) {
	global $desc, $CFG, $LNG, $HUB_FLM; ?>
	<div class="mb-3 row" id="descdiv">
		<label for="desc" class="col-sm-3 col-form-label">
			<?php echo $LNG->FORM_LABEL_DESC; ?>
			<span class="active" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
				<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
				<span class="sr-only">More info</span>
			</span>
			<span class="required">*</span>
			<br />		
			<span id="editortogglebutton" href="javascript:void(0)" onclick="switchCKEditorMode(this, 'textareadiv', 'desc')" title="<?php echo $LNG->FORM_DESC_HTML_TEXT_HINT; ?>"><?php echo $LNG->FORM_DESC_HTML_TEXT_LINK; ?></span>
		</label>
		<div class="col-sm-9" id="textareadiv">
			<?php if (isProbablyHTML($desc)) { ?>
				<textarea rows="4" class="ckeditor form-control" id="desc" name="desc"><?php echo( $desc ); ?></textarea>
			<?php } else { ?>
				<textarea rows="4" class="form-control" id="desc" name="desc"><?php echo( $desc ); ?></textarea>
			<?php } ?>
		</div>
	</div>
<?php }

function insertPrivate($hintname, $private) {
	global $CFG, $LNG, $HUB_FLM; ?>

	<div class="mb-3 row">
        <label class="col-sm-3 col-form-label" for="private">
			<?php echo $LNG->FORM_PRIVACY; ?>
			<span class="active" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
				<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
				<span class="sr-only">More info</span>
			</span>
			<span class="required">*</span>
        </label>
		<div class="col-sm-9 d-flex flex-row gap-1 align-items-center">
			<input type="checkbox" onchange="if (this.checked) {$('privacylockimg').src='<?php echo $HUB_FLM->getImagePath('unlock-32.png'); ?>' } else {$('privacylockimg').src='<?php echo $HUB_FLM->getImagePath('lock-32.png'); ?>'}" class="forminput" id="private" name="private" value="N"
				<?php
					if($private == "N"){
						echo ' checked="true"';
					}
				?>
			>
			<img id="privacylockimg" onclick="$('private').click()"
				<?php
					if($private == "N"){
					echo ' src="'.$HUB_FLM->getImagePath('unlock-32.png').'"';
					} else {
					echo ' src="'.$HUB_FLM->getImagePath('lock-32.png').'"';
					}
				?>
			/>
		</div>
    </div>
<?php }

function insertUrl($hintname) {
	global $url, $CFG, $LNG, $HUB_FLM; ?>

	<div class="formrow" id="urldiv">
		<label  class="col-sm-3 col-form-label" for="url"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_URL; ?></span>
			<span class="active" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span class="required">*</span>
		</label>
     	<input class="forminputmust inputshort" id="url" name="url" value="<?php echo( htmlspecialchars($url) ); ?>">
		<img class="active" style="vertical-align: middle; padding-bottom: 2px;" title="<?php echo $LNG->FORM_AUTOCOMPLETE_TITLE_HINT; ?>" src="<?php echo $HUB_FLM->getImagePath('autofill.png'); ?>" onClick="autoCompleteWebsiteDetails()" onkeypress="enterKeyPressed(event)" />
    </div>
<?php }

/**
 * Inser the location form fields
 * @param hintstem the string representing the type of item. Used to form the hint rolloever key.
 */
function insertLocation($hintstem) {
	global $CFG, $LNG, $address1, $address2, $city, $postcode, $orgcountry, $countries, $HUB_FLM;?>

	<div id="locationdiv">
		<div id="address1div" class="mb-3 row">
			<div style="display: block; clear:both;float:left">
				<label class="col-sm-3 col-form-label" style="padding-left:10px;text-align: left;width: 65px;"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_LOCATION; ?></span></label>
				<label class="col-sm-3 col-form-label" for="address1" style="width:100px;"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_ADDRESS1; ?></span></label>
				<input class="forminput" id="address1" name="address1" style="width:250px;" value="<?php echo $address1; ?>">
			</div>
		</div>
		<div id="address2div" class="mb-3 row">
			<div style="display: block; float:left">
				<label class="col-sm-3 col-form-label" for="address2"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_ADDRESS2; ?></span></label>
				<input class="forminput" id="address2" name="address2" style="width:250px;" value="<?php echo $address2; ?>">
			</div>
		</div>
		<div id="citydiv" class="mb-3 row">
			<div style="display: block; float:left">
				<label class="col-sm-3 col-form-label" for="city"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_TOWN; ?></span>
					<span class="active" onMouseOver="showFormHint('<?php echo $hintstem; ?>Town', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
				</label>
				<input class="forminput" id="city" name="city" style="width:250px;" value="<?php echo $city; ?>">
			</div>
		</div>
		<div id="postcodediv" class="mb-3 row">
			<div style="display: block; float:left">
				<label class="col-sm-3 col-form-label" for="postcode"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_POSTAL_CODE; ?></span></label>
				<input class="forminput" id="postcode" name="postcode" style="width:250px;" value="<?php echo $postcode; ?>">
			</div>
		</div>
		<div id="countrydiv" class="mb-3 row">
			<div style="display: block; float:left">
				<label class="col-sm-3 col-form-label" for="orgcountry"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_COUNTRY; ?></span>
					<span class="active" onMouseOver="showFormHint('<?php echo $hintstem; ?>Country', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
				</label>
				<select class="forminput" id="orgcountry" name="orgcountry" style="margin-left: 5px;width:160px;">
					<option value="" ><?php echo $LNG->FORM_LABEL_COUNTRY_CHOICE; ?></option>
					<?php
						foreach($countries as $code=>$c){
							echo "<option value='".$code."'";
							if($code == $orgcountry){
								echo " selected='true'";
							}
							echo ">".$c."</option>";
						}
					?>
				</select>
			</div>
		</div>
	</div>
<?php }

function insertResourceForm($hintname, $title = "") {
	global $CFG, $LNG, $HUB_FLM, $resourceurlarray, $resourcetitlearray, $identifierarray, $resourcenodeidsarray, $resourcecliparray, $resourceclippatharray;
	// removed $resourcetypesarray - not used anymore?

	if ($title == "") {
		$title = $LNG->FORM_LABEL_RESOURCES;
	}
	?>

    <div class="mb-3 row">
		<div class="d-flex flex-row" id="resourcediv">
			<label class="col-sm-3 col-form-label" for="resourceform">
				<?php echo $title; ?>
			    <a href="javascript:void(0)" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
					<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
					<span class="sr-only">More info</span>
				</a>
			</label>
			<div class="col-sm-9">
				<div id="resourceform">
					<?php
						$count =  is_countable($resourceurlarray) ? count($resourceurlarray) : 0;
						for($i=0; $i<$count; $i++){
							if($i != 0){
								echo '<hr id="resourcehr<?php echo $i; ?>" class="urldivider"/>';
							}

							if (isset($resourceurlarray[$i]) === FALSE || $resourceurlarray[$i] == "") {
								$resourceurlarray[$i] = "http://";
							}
						?>

						<div id="resourcefield<?php echo $i; ?>">

							<input type="hidden" id="resourcenodeidsarray-<?php echo $i; ?>" name="resourcenodeidsarray[]" value="<?php echo $resourcenodeidsarray[$i]; ?>" />
							<input type="hidden" id="resourcecliparray-<?php echo $i; ?>" name="resourcecliparray[]" value="<?php if (isset($resourcecliparray[$i])) { echo $resourcecliparray[$i]; } ?>" />
							<input type="hidden" id="resourceclippatharray-<?php echo $i; ?>" name="resourceclippatharray[]" value="<?php if (isset($resourceclippatharray[$i])) { echo $resourceclippatharray[$i]; } ?>" />
							<input type="hidden" id="identifierarray-<?php echo $i; ?>" name="identifierarray[]" value="<?php if (isset($identifierarray[$i])) { echo $identifierarray[$i]; } ?>" />

							<div class="mb-3 row" id="resourceurldiv-<?php echo $i; ?>">
								<label  class="col-sm-2 col-form-label" for="resourceurl-<?php echo $i; ?>">
									<?php echo $LNG->FORM_LABEL_URL; ?>
									<a href="javascript:void(0)" onMouseOver="showFormHint('ResourceURL', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
										<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
										<span class="sr-only">More info</span>
									</a>
									<span class="required">*</span>
								</label>
								<div class="col-sm-10 d-flex flex-row align-items-center">
									<input class="form-control" id="resourceurl-<?php echo $i; ?>" name="resourceurlarray[]" value="<?php echo( htmlspecialchars($resourceurlarray[$i]) ); ?>" />
									<img class="active" style="vertical-align: middle; padding-bottom: 2px; margin-left:4px; height: 19px; width: auto;" title="<?php echo $LNG->FORM_AUTOCOMPLETE_TITLE_HINT; ?>" src="<?php echo $HUB_FLM->getImagePath('autofill.png'); ?>" onClick="autoCompleteWebsiteDetailsMulti(<?php echo $i; ?>)" onkeypress="enterKeyPressed(event)" />
								</div>
							</div>

							<div class="mb-3 row">
								<label  class="col-sm-2 col-form-label" for="resourcetitle-<?php echo $i; ?>">
									<?php echo $LNG->FORM_LABEL_TITLE; ?>
									<a href="javascript:void(0)" onMouseOver="showFormHint('ResourceTitle', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
										<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
										<span class="sr-only">More info</span>
									</a>
									<span class="required">*</span>
								</label>
								<div class="col-sm-10">
									<input class="form-control" id="resourcetitle-<?php echo $i; ?>" name="resourcetitlearray[]" value="<?php echo( $resourcetitlearray[$i] ); ?>">
								</div>
							</div>

							<?php if (isset($resourcecliparray[$i]) && $resourcecliparray[$i] != "") { ?>
								<div class="mb-3 row"  id="resourcedescdiv-<?php echo $i; ?>">
									<label  class="col-sm-3 col-form-label" for="resourcecliparray-<?php echo $i; ?>"><?php echo $LNG->FORM_LABEL_CLIP; ?>
										<a href="javascript:void(0)" onMouseOver="showFormHint('ResourceClip', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
											<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
											<span class="sr-only">More info</span>
										</a>
									</label>
									<textarea class="form-control" readonly style="border: none" id="resourcecliparray-<?php echo $i; ?>" name="resourcecliparray[]" rows="3"><?php echo( $resourcecliparray[$i] ); ?></textarea>
									<a href="javascript:removeMultiple('resource', <?php echo $i; ?>)" class="form">
										<?php echo $LNG->FORM_BUTTON_REMOVE; ?>
									</a>
								</div>
							<?php } else { ?>
								<div class="mb-3 row"  id="resourcedescdiv-<?php echo $i; ?>">
									<input type="hidden" id="resourcecliparray-<?php echo $i; ?>" name="resourcecliparray[]" value="<?php if (isset($resourcecliparray[$i])) { echo $resourcecliparray[$i]; } ?>" />
									<a id="resourceremovebutton-<?php echo $i; ?>" href="javascript:void(0)" onclick="javascript:removeMultiple('resource', <?php echo $i; ?>)" class="form" style="clear:both;float:right">
										<?php echo $LNG->FORM_BUTTON_REMOVE; ?>
									</a>
								</div>
							<?php } ?>
						</div>
					<?php } ?>

				</div>
			
				<div class="btn btn-link">
					<span id="resourceaddbutton" class="formsubmit form active" onclick="javascript:noResources = addResource(noResources);">
						<?php echo $LNG->FORM_RESOURCE_ADD_ANOTHER; ?>
					</span>
				</div>
	    	</div>
	    </div>
	</div>
<?php }