<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Upload image</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<style>
    .error-message{
        color: red;
    }
</style>
</head>
<body>
<div class="container">
	<div class="row mt-4">
		<div class="col-sm-4">
			<div class="card p-5">
				<form id="save_form" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
					  <label for="image">Image Name</label>
					  <input type="text" name="name" id="name" class="form-control">
                      <div class="error-message help-inline">
                      </div>
					</div>
					<div class="form-group">
					  <label for="image">Select Image</label>
					  <input type="file" name="image" id="image" class="form-control">
                      <div class="error-message help-inline">
                      </div>
					</div>
					<button type="submit"   class="btn btn-info">Upload</button>
				</form>
			</div>
		</div>
		<div class="col-sm-8">
			<div class="row">
				<div class="col-sm-3">
                    @foreach($records as $record)
                        {{$record->name}}
                        <img src="{{asset('public/images/'.$record->image)}}" id="" height="150">
                    @endforeach
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function () {


 $(document).on('submit','#save_form',(function(e) {
    $('.help-inline').removeClass('error');
      $('.help-inline').html('');
  e.preventDefault();
  var formData = new FormData(this);
  $.ajax({
        headers: {
            'X-CSRF-TOKEN': "{{csrf_token()}}",
        },
        url:"{{url('upload-image')}}",
        type: "POST",
        data : formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if(response.status == 400 ){
                $.each(response.errors, function (index, html) {
                    $("input[name = "+index+"]").next().addClass('error');
                    $("input[name = "+index+"]").next().html(html);
                });
            }
            if(response.status == 200 ){
                location.reload();
            }
        }
  });
}));
});
</script>
</body>
</html>
