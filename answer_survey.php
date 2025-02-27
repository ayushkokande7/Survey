<?php include 'db_connect.php' ?>
<?php 
$qry = $conn->query("SELECT * FROM survey_set where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	if($k == 'title')
		$k = 'stitle';
	$$k = $v;
}

?>
<div class="col-lg-12">
	<image src="https://ilcslivelihood.com/images/img123.jpeg" alt="no image" style="background-size: cover; width: 100%; height: 100%; aspect-ratio: 16 / 9; margin-bottom: 30px"/>
</div>
	<div class="row">
		<div class="col-md-4">
			<div class="card card-outline card-primary">
				<div class="card-header">
					<h3 class="card-title"><b>Survey Details</b></h3>
				</div>
				<div class="card-body p-0 py-2">
					<div class="container-fluid">
						<p>Title: <b><?php echo $stitle ?></b></p>
						<p>Description:<b><?php echo $description; ?></b></p>
						<p>Start: <b><?php echo date("M d, Y",strtotime($start_date)) ?></b></p>
						<p>End: <b><?php echo date("M d, Y",strtotime($end_date)) ?></b></p>

					</div>
					<hr class="border-primary">
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card card-outline card-success">
				<div class="card-header">
					<h3 class="card-title"><b>Survey Questionaire</b></h3>
					<div id="location-error" style="margin-top: 16px;
						text-align: center;
						color: red;
						font-weight: bold;
						width: 100%;
						display: none;
						font-size: 18px;">⚠️ Please enable location to proceed.</div>
				</div>
				<form action="" id="manage-survey">
					<input type="hidden" name="survey_id" value="<?php echo $id ?>">
					<input type="hidden" name="lat" id="latitude">
					<input type="hidden" name="lon" id="longitude">
				<div class="card-body ui-sortable">
					<?php 
					$question = $conn->query("SELECT * FROM questions where survey_id = $id order by abs(order_by) asc,abs(id) asc");
					while($row=$question->fetch_assoc()):	
					?>
					<div class="callout callout-info">
						<h5><?php echo $row['question'] ?></h5>	
						<div class="col-md-12">
						<input type="hidden" name="qid[<?php echo $row['id'] ?>]" value="<?php echo $row['id'] ?>">	
						<input type="hidden" name="type[<?php echo $row['id'] ?>]" value="<?php echo $row['type'] ?>">	
							<?php
								if($row['type'] == 'radio_opt'):
									foreach(json_decode($row['frm_option']) as $k => $v):
							?>
							<div class="icheck-primary">
		                        <input type="radio" id="option_<?php echo $k ?>" name="answer[<?php echo $row['id'] ?>]" value="<?php echo $k ?>" checked="">
		                        <label for="option_<?php echo $k ?>"><?php echo $v ?></label>
		                     </div>
								<?php endforeach; ?>
						<?php elseif($row['type'] == 'check_opt'): 
									foreach(json_decode($row['frm_option']) as $k => $v):
							?>
							<div class="icheck-primary">
		                        <input type="checkbox" id="option_<?php echo $k ?>" name="answer[<?php echo $row['id'] ?>][]" value="<?php echo $k ?>" >
		                        <label for="option_<?php echo $k ?>"><?php echo $v ?></label>
		                     </div>
								<?php endforeach; ?>
							<?php elseif($row['type'] == 'image'): ?>
							<div class="">	
								<input type="file" name="image[<?php echo $row['id'] ?>][]" id="image" class="form-control" accept="image/*" multiple>
		                     </div>
						<?php else: ?>
							<div class="form-group">
								<textarea name="answer[<?php echo $row['id'] ?>]" id="" cols="30" rows="4" class="form-control" placeholder="Write Something Here..." ></textarea>
							</div>
						<?php endif; ?>
						</div>	
					</div>
					<?php endwhile; ?>
				</div>
				</form>
				<div class="card-footer border-top border-success">
					<div class="d-flex w-100 justify-content-center">
						<button class="btn btn-sm btn-flat bg-gradient-primary mx-1" form="manage-survey">Submit Answer</button>
						<button class="btn btn-sm btn-flat bg-gradient-secondary mx-1" type="button" onclick="location.href = 'index.php?page=survey_widget'">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	document.addEventListener("DOMContentLoaded", function () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(sendPosition, showError);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
});

function sendPosition(position) {
    let lat = position.coords.latitude;
    let lon = position.coords.longitude;
    let latInput = document.getElementById("latitude");
    let lonInput = document.getElementById("longitude");
	latInput.value = lat;
	lonInput.value = lon;
}

function showError(error) {
    let warningDiv = document.getElementById("location-error");
    warningDiv.style.display = "inline-block";
}
	$('#manage-survey').submit(function(e){
		e.preventDefault()
		start_load()

		var formData = new FormData(this);
		console.log(formData)
		$.ajax({
			url: 'ajax.php?action=save_answer',
			method: 'POST',
			data: formData,
			processData: false,  // Prevent jQuery from automatically transforming the data into a query string
			contentType: false,  // Set the content type to false as jQuery will tell the server its a query string request
			success: function(resp){
				if(resp == 1){
					alert_toast("Thank You.", 'success')
					setTimeout(function(){
						location.href = 'index.php?page=survey_widget'
					}, 2000)
				}
			}
		})
	})
</script>