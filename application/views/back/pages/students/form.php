<div class="container">
	<div class="row mb-4">
		<div class="col">
			<h3>Form <?= $title ?></h3>
		</div>
	</div>

	<?= form_open_multipart($form_action) ?>
		<?= isset($input->id) ? form_hidden('id', $input->id) : '' ?>

		<div class="form-group row">
			<label for="student_id" class="col-sm-2 col-form-label">NIS</label>
			<div class="col-sm-8">
				<input type="text" name="student_id" id="student_id" value="<?= $input->student_id ?>" required class="form-control">
				<?= form_error('student_id', '<small class="form-text text-danger">', '</small>') ?>
			</div>
		</div>

		<div class="form-group row">
			<label for="name" class="col-sm-2 col-form-label">Nama Siswa</label>
			<div class="col-sm-8">
				<input type="text" name="name" id="name" value="<?= $input->name ?>" required class="form-control">
				<?= form_error('name', '<small class="form-text text-danger">', '</small>') ?>
			</div>
		</div>

		<div class="form-group row">
			<label for="class_id" class="col-sm-2 col-form-label">Kelas</label>
			<div class="col-sm-8">
				<select name="class_id" id="class_id" class="form-control">
					<option value="">-- Pilih Kelas --</option>
					<?php foreach($classes_list as $class): ?>
						<option value="<?= $class->id ?>" <?= $input->class_id == $class->id ? 'selected' : '' ?>>
							<?= $class->name ?> (<?= $class->grade ?>)
						</option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<div class="form-group row">
			<label for="email" class="col-sm-2 col-form-label">Email</label>
			<div class="col-sm-8">
				<input type="email" name="email" id="email" value="<?= $input->email ?>" class="form-control">
			</div>
		</div>

		<div class="form-group row">
			<label for="phone" class="col-sm-2 col-form-label">Telepon</label>
			<div class="col-sm-8">
				<input type="text" name="phone" id="phone" value="<?= $input->phone ?>" class="form-control">
			</div>
		</div>

		<div class="form-group row">
			<label for="address" class="col-sm-2 col-form-label">Alamat</label>
			<div class="col-sm-8">
				<textarea name="address" id="address" rows="4" class="form-control"><?= $input->address ?></textarea>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 col-form-label" id="label-photo">Foto</label>
			<div class="col-sm-8">
				<?php if(!empty($input->photo)) : ?>
					<img src="<?= base_url("img/students/$input->photo") ?>" alt="" height="150">
				<?php else: ?>
					<p>No Photo</p>
				<?php endif; ?>
				<br> 
				<small><span class="text-danger">*</span>	Maksimal ukuran gambar adalah 3 MB</small>
				<br> <br>
				<input name="photo" type="file" class="form-control-file">
				<?php if($this->session->flashdata('image_error')) :  ?>
                <small class="form-text text-danger">
                  <?= $this->session->flashdata('image_error') ?>
                </small>
				<?php endif ?>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-8 offset-2">
				<a href="<?= base_url('students') ?>" class="btn btn-sm btn-secondary"><i class="fas fa-angle-left mr-1"></i>Kembali</a>
				<button type="submit" class="btn btn-sm btn-primary float-right"><i class="fas fa-check mr-1"></i> Simpan</button>
			</div>
		</div>
	<?= form_close() ?>
</div>
