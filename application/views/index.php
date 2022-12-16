<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


	<!-- jquery -->

</head>

<body>
	<div class="row justify-content-center mt-4 pt-4">
		<div class="col-8">
			<form id="form" class="row g-3 needs-validation" novalidate>
				<div class="col-md-4">
					<label for="validationCustom01" class="form-label">First name</label>
					<input name="first_name" type="text" class="form-control" id="validationCustom01" value="Mark" required>
					<div class="invalid-feedback"></div>
				</div>
				<div class="col-md-4">
					<label for="validationCustom02" class="form-label">Last name</label>
					<input name="last_name" type="text" class="form-control" id="validationCustom02" value="Otto" required>
					<div class="invalid-feedback"></div>
				</div>
				<div class="col-md-4">
					<label for="validationCustomUsername" class="form-label">Username</label>
					<div class="input-group has-validation">
						<span class="input-group-text" id="inputGroupPrepend">@</span>
						<input name="username" type="text" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
						<div class="invalid-feedback"></div>
					</div>
				</div>
				<div class="col-md-6">
					<label for="validationCustom03" class="form-label">City</label>
					<input name="city" type="text" class="form-control" id="validationCustom03" required>
					<div class="invalid-feedback"></div>
				</div>
				<div class="col-md-3">
					<label for="validationCustom04" class="form-label">State</label>
					<select name="state" class="form-select" id="validationCustom04" required>
						<option selected disabled value="">Choose...</option>
						<option value="1">Jateng</option>
						<option value="2">Jatim</option>
					</select>
					<div class="invalid-feedback"></div>
				</div>
				<div class="col-md-3">
					<label for="validationCustom05" class="form-label">Zip</label>
					<input name="zip" type="text" class="form-control" id="validationCustom05" required>
					<div class="invalid-feedback"></div>
				</div>
				<div class="col-12">
					<div class="form-check">
						<input name="agreement" class="form-check-input" type="checkbox" value="1" id="invalidCheck" required>
						<label class="form-check-label" for="invalidCheck">
							Agree to terms and conditions
						</label>
						<div class="invalid-feedback"></div>
					</div>
				</div>
				<div class="col-12">
					<button class="btn btn-primary" type="submit">Submit form</button>
				</div>
			</form>
		</div>
	</div>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.15/dist/sweetalert2.all.min.js"></script>

	<script>
		$(document).ready(function() {
			// #form on submit
			$('#form').submit(function(e) {
				e.preventDefault();

				Swal.fire({
					icon: 'question',
					title: 'Apakah and yakin?',
					text: 'Pastikan semua adata yang diisi sudah benar',
					showCancelButton: true,
					confirmButtonText: 'Ya, saya yakin',
					cancelButtonText: 'Batal',
					reverseButtons: true
				}).then((result) => {
					if (result.isConfirmed) {
						let formdata = $(this).serialize()
						$.ajax({
							url: '<?= site_url('Coba/ajaxSubmit') ?>',
							type: 'POST',
							data: formdata,
							beforeSend: function() {
								// remove was-validated
								$('#form').removeClass('was-validated');
								$('.invalid-feedback').text('');
								$('.is-invalid').removeClass('is-invalid');
							},
							success: function(data) {
								console.log(data);
								if (data == 'success') {
									Swal.fire({
										icon: 'success',
										title: 'Berhasil',
										text: 'Data berhasil disimpan',
										showConfirmButton: false,
										timer: 1500
									}).then(() => {
										$('#form')[0].reset();
									})
								} else {
									Swal.fire({
										icon: 'error',
										title: 'Gagal',
										text: 'Data gagal disimpan',
										showConfirmButton: false,
										timer: 1500
									})
								}
							},
							error: (xhr, status, error) => {
								const resp = xhr.responseJSON;

								if (resp.errors) {
									$('#form').addClass('was-validated');

									$.each(resp.errors, function(key, value) {
										let field = $(`[name="${key}"]`)
										let invalidFeedback = field.next('.invalid-feedback');
										invalidFeedback.text(value)
										field.addClass('is-invalid');

										// add :invalid on field
										
									})
								}

								Swal.fire({
									icon: 'error',
									title: resp.message.title,
									text: resp.message.body,
								})
							}
						})
					}
				})



			})

		});
	</script>

</body>

</html>
