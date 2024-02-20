<?php if($_settings->chk_flashdata('success')): ?>
    <!-- Display a success flash message as a toast notification -->
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
    </script>
<?php endif;?>

<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h5 class="card-title">About</h5>
        </div>
        <div class="card-body">
            <!-- Form for updating About content -->
            <form id="about_c">
                <div class="form-group">
                    <input type="hidden" name="file" value="about">
                    <label for="" class="control-label">About Content</label>
                    <!-- Textarea for About content -->
                    <textarea name="content" id="" cols="30" rows="10" class="form-control summernote">
                        <?php echo (is_file(base_app.'about.html')) ? file_get_contents((base_app.'about.html')) : '' ?>
                    </textarea>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <!-- Button to submit the form for updating About content -->
            <button class="btn btn-primary btn-sm" form="about_c">Update </button>
        </div>
    </div>
</div>

<script>
	$(document).ready(function(){
        	// Event listener for form submission
		$('#about_c').submit(function(e){
			e.preventDefault();
			start_loader();

            		// AJAX request for updating About content
			$.ajax({
				url:_base_url_+"classes/Content.php?f=update",
				method:"POST",
				data:$(this).serialize(),
				error: err=>{
			                // Display an error toast if AJAX request fails
					alert_toast("An error occured",'error')
					console.log(err);
				},
				success:function(resp){
					if(resp != undefined){
                        			// Parse the JSON response
						resp = JSON.parse(resp)
						if(resp.status == 'success'){
 			                        	// Reload the page on successful update
							location.reload()
						}else{
			                            	// Display an error toast if the update fails
							alert_toast("An error occured",'error')
							console.log(resp);
							end_loader();
						}
					}
				}
			})
		})

	        // Initialize Summernote WYSIWYG editor
		$('.summernote').summernote({
		        height: 200,
		        toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontname', [ 'fontname' ] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
		            [ 'table', [ 'table' ] ],
		            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
		        ]
		    })
	})
	
</script>