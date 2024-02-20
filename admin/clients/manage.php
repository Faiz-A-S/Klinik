<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php 
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * from doctors where id = '{$_GET['id']}' ");
	foreach($qry->fetch_array() as $k => $v){
		if(!is_numeric($k)){
			$$k = $v;
		}
	}
}

// Add the following lines after your SQL query execution
if ($conn->error) {
    echo "<script>console.log('MySQL Error: " . $conn->error . "');</script>";
}
?>
<style>
	#cimg{
		max-width: 50%;
		object-fit: contain;
	}
</style>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<h5 class="card-title"><?php echo isset($id) ? "Manage" : "Create" ?> Doctors</h5>
		</div>
		<div class="card-body">
			<form id="client">
				<div class="row" class="details">
					<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="" class="control-label">Nama Dokter</label>
							<textarea name="doctor_name" cols="30" rows="1" class="form-control"><?php echo isset($doctor_name) ? $doctor_name : '' ?></textarea>
						</div>
						<div class="form-group">
							<label for="" class="control-label">Spesialis</label>
							<textarea name="spesialis" cols="30" rows="1" class="form-control"><?php echo isset($spesialis) ? $spesialis : '' ?></textarea>
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-sm-2">
						<div class="form-group">
							<label for="" class="control-label">Senin</label>
				             <textarea name="senin" id="" cols="1" rows="1" class="form-control"><?php echo isset($senin) ? $senin : '' ?></textarea>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="form-group">
							<label for="" class="control-label">Selasa</label>
				             <textarea name="selasa" id="" cols="1" rows="1" class="form-control"><?php echo isset($selasa) ? $selasa : '' ?></textarea>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="form-group">
							<label for="" class="control-label">Rabu</label>
				             <textarea name="rabu" id="" cols="1" rows="1" class="form-control"><?php echo isset($rabu) ? $rabu : '' ?></textarea>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="form-group">
							<label for="" class="control-label">Kamis</label>
				             <textarea name="kamis" id="" cols="1" rows="1" class="form-control"><?php echo isset($kamis) ? $kamis : '' ?></textarea>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="form-group">
							<label for="" class="control-label">Jumat</label>
				             <textarea name="jumat" id="" cols="1" rows="1" class="form-control"><?php echo isset($jumat) ? $jumat : '' ?></textarea>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="form-group">
							<label for="" class="control-label">Sabtu</label>
				             <textarea name="sabtu" id="" cols="1" rows="1" class="form-control"><?php echo isset($sabtu) ? $sabtu : '' ?></textarea>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label">Foto</label>
					<div class="custom-file">
						<input type="hidden" name="old_file" value="<?php echo isset($file_path) ? $file_path :'' ?>">
		              <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
		              <label class="custom-file-label" for="customFile">Choose file</label>
		            </div>
				</div>
				<div class="form-group d-flex justify-content-center">
					<img src="<?php echo validate_image(isset($file_path) ? $file_path :'') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
				</div>
			</form>
		</div>
		<div class="card-footer">
			<button class="btn btn-primary btn-sm" form="client"><?php echo isset($_GET['id']) ? "Update": "Save" ?></button>
			<a class="btn btn-primary btn-sm" href="./?page=clients">Cancel</a>
		</div>
	</div>
</div>

<script>
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$(document).ready(function(){
		$('.select')
		$('#client').submit(function(e){
			e.preventDefault();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Content.php?f=client",
				data: new FormData($(this)[0]),
			    cache: false,
			    contentType: false,
			    processData: false,
			    method: 'POST',
			    type: 'POST',
			    dataType: 'json',
				error: err=>{
					alert_toast("An error occured",'error')
					console.log(err);
					end_loader();
				},
				success:function(resp){
					if(resp != undefined){
						if(resp.status == 'success'){
							location.href=_base_url_+"admin/?page=clients";
						}else{
							alert_toast("An error occured",'error')
							console.log(resp);
						}
						end_loader();
					}
				}
			})
		})
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
		            [ 'view', [ 'link','undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
		        ]
		    })
	})
	
</script>