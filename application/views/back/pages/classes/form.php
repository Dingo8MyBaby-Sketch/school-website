<div class="container">
	<div class="row mb-4">
		<div class="col">
			<h3>Form <?= $title ?></h3>
		</div>
	</div>

	<?= form_open_multipart($form_action) ?>
		<?= isset($input->id) ? form_hidden('id', $input->id) : '' ?>

		<div class="form-group row">
			<label for="name" class="col-sm-2 col-form-label">Nama Kelas</label>
			<div class="col-sm-8">
				<input type="text" name="name" id="name" value="<?= $input->name ?>" required class="form-control">
				<?= form_error('name', '<small class="form-text text-danger">', '</small>') ?>
			</div>
		</div>

		<div class="form-group row">
			<label for="grade" class="col-sm-2 col-form-label">Tingkat</label>
			<div class="col-sm-8">
				<select name="grade" id="grade" required class="form-control">
					<option value="">-- Pilih Tingkat --</option>
					<option value="X" <?= $input->grade == 'X' ? 'selected' : '' ?>>Kelas X</option>
					<option value="XI" <?= $input->grade == 'XI' ? 'selected' : '' ?>>Kelas XI</option>
					<option value="XII" <?= $input->grade == 'XII' ? 'selected' : '' ?>>Kelas XII</option>
				</select>
				<?= form_error('grade', '<small class="form-text text-danger">', '</small>') ?>
			</div>
		</div>

		<div class="form-group row">
			<label for="teacher_id" class="col-sm-2 col-form-label">Wali Kelas</label>
			<div class="col-sm-8">
				<select name="teacher_id" id="teacher_id" class="form-control">
					<option value="">-- Pilih Wali Kelas --</option>
					<?php foreach($staff_list as $staff): ?>
						<option value="<?= $staff->id ?>" <?= $input->teacher_id == $staff->id ? 'selected' : '' ?>>
							<?= $staff->name ?> - <?= $staff->position ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<div class="form-group row">
			<label for="description" class="col-sm-2 col-form-label">Deskripsi</label>
			<div class="col-sm-8">
				<textarea name="description" id="description" rows="4" class="form-control"><?= $input->description ?></textarea>
			</div>
		</div>

		<div class="form-group row">
			<label for="schedule" class="col-sm-2 col-form-label">Jadwal</label>
			<div class="col-sm-8">
				<textarea name="schedule" id="schedule" rows="4" class="form-control"><?= $input->schedule ?></textarea>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 col-form-label" id="label-photo">Foto</label>
			<div class="col-sm-8">
				<?php if(!empty($input->photo)) : ?>
					<img src="<?= base_url("img/classes/$input->photo") ?>" alt="" height="150">
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
				<a href="<?= base_url('classes') ?>" class="btn btn-sm btn-secondary"><i class="fas fa-angle-left mr-1"></i>Kembali</a>
				<button type="submit" class="btn btn-sm btn-primary float-right"><i class="fas fa-check mr-1"></i> Simpan</button>
			</div>
		</div>
	<?= form_close() ?>
</div>
