<!-- Modal Display - Edit video -->
	<!-- Styling for thumbnail previews for the video and Photo upload modals -->
		<style>
			.thumb {
				width: 100px;
				height: 100px;
				object-fit:cover; 
				object-position:0,0;
			}
			#photoThumb, #thumb {
				box-shadow: -1px 2px 10px 0px rgba(0,0,0,1);
				background-size: 100px 100px;
				background-repeat:  no-repeat;
				background-position:  center;
				object-fit:cover; 
				object-position:0,0;
			}
		</style>
	<!-- Styling for thumbnail previews for the video and Photo upload modals -->

	<div class="modal fade" id="editVideo" tabindex="-1" role="dialog" aria-labelledby="editVideoTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
			<!-- Close Modal Window -->
			    <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLongTitle">Edit This Video</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			        	<span aria-hidden="true">&times;</span>
			        </button>
			    </div>
		    <!-- /Close Modal Window -->
		    	<form method="post" action="viewAllVid.php" name="editVid" enctype="multipart/form-data">
			      	<div class="modal-body">
				    	<div class="form-group">
				    		<!-- <h6 class="text-danger" style="font-weight:bold" for="vidTalent">Warning!!!</h6> -->
				    		<!-- <p>Removing a talent from your profile will automatically remove any videos associated with that talent. </p> -->
				    			
				    			<input type="hidden" name="id" value="">
				    			<input type="hidden" name="iLoginID" value="<?php echo $currentUserID;?>">
				    			<input type="hidden" name="videoThumbnailPath">
				    			<input type="hidden" name="videoPath">
				    			<?php 
					      			if($currentUserType == 'admin'){
					      				if($_GET['churchID'] != ''){
					      					$curr_u_type = 'church';
					      				}
					      				elseif($_GET['artistID'] != ''){
					      					$curr_u_type = 'artist';
					      				}
					      				else{
					      					$curr_u_type = 'group';
					      				}

					      				/* pass the administrator's id */
					      					echo '<input type="hidden" name="adminID" value="'.$currentUserID.'">';
					      			}
					      			else{
					      				$curr_u_type = $currentUserType;
					      			}
					      		?>
					      		<input type="hidden" name="u_type" value="<?php echo $curr_u_type;?>">

				    			<div class="prepend-element d-none">
				    				<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="videoName">Replace current thumbnail photo</label> 
				    				<!-- Show Upload Thumbnail Photo -->
				    					<div class="mb-2" id="thumb" style="height:100px;width:100px;"></div>
									<!-- Show Upload Thumbnail Photo -->
				    				<div class="container px-0"><input type="file" id="videoThumbnailPath" name="videoThumbnailPath" value=""></div>
				    			</div>
				    			<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="videoName">Edit Video Title</label>
				    			<!-- <div class="container"> -->
					    			<input  class="form-control form-control-sm my-2" type="text" id="videoName" name="videoName" placeholder="Enter Video Title">
					    		<!-- </div> -->
				    			<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="videoDescription">Edit Video Description</label>
				    			<!-- <div class="container"> -->
					    			<textarea class="form-control form-control-sm my-2" type="text" id="videoDescription" name="videoDescription" rows="5" placeholder="Enter Video Description"></textarea>
					    		<!-- </div> -->
				    			<button type="submit" id="saveChanges" class="btn btn-gs btn-sm sectionEdit">Save Changes</button>
				    		
						</div>
			      	</div>
			      	
			      	<div class="modal-footer">
			      		<h6> To remove this video click the button below</h6>
			        	<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#removeVidWarning">Remove Video</button>
			      	</div>
		      	</form>
	    </div>
	  </div>
	</div>
<!-- /Modal Display to Edit vidoes -->

<!-- Modal Display - Video Removal Warning -->
	<div class="modal fade" id="removeVidWarning" tabindex="-1" role="dialog" aria-labelledby="removeVidWarning" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
			<!-- Exit Modal -->
			    <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLongTitle">Remove Video</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			        	<span aria-hidden="true">&times;</span>
			        </button>
			    </div>
		    <!-- /Exit Modal -->

		      	<div class="modal-body">
			    	<div class="form-group">
			    		<h6 class="text-danger" style="font-weight:bold" for="vidTalent">Warning!!!</h6>
			    		<p>This will permenantly remove this video!!!</p>
			    		<?php if($currentUserType == 'admin'){?>
				    		<label for="vidTalent">Reason For Deletion</label>
							<textarea class="form-control mb-2" name="vidDelReason" placeholder="Please Explain..." wrap="" rows="4" aria-label="With textarea"></textarea>
							
							<!-- Display error message if admin fails to provide reason for deletion -->
							<div class="container d-none" id="err_mess">
								<div class="row">
									<div class="col">
										<p class="text-danger mb-0" style="font-size:14px;"></p>
									</div>
								</div>
							</div>
						<?php }?>
					</div>
		      	</div>
		      	
		      	<div class="modal-footer">
		        	<button type="submit" id="removeVideo" u-type="<?php echo $curr_u_type;?>" class="btn btn-gs btn-sm sectionEdit" table="talentmaster" formId="talentRemove">Remove Video</button>
		      	</div>
	    </div>
	  </div>
	</div>
<!-- /Modal Display - Video Removal Warning -->