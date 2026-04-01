<!--================Home Banner Area =================-->
<div class="jumbotron banner_area jumbotron-fluid" style="background-image: url(<?= base_url('img/banner_area/bg.jpg') ?>); ">
	<div class="container">
		<h1 class="display-4 my-auto text-light text-center">Siswa</h1>
	</div>
</div>
<!--================End Home Banner Area =================-->

<!-- Students -->
<div class="students mt-5 mb-5">
	<div class="container">
		<div class="row">
			<?php if(!empty($students)): ?>
				<?php foreach($students as $st) : ?>
					<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">
						<div class="card h-100">
							<?php if(!empty($st->photo)): ?>
								<img src="<?= base_url('img/students/' . $st->photo) ?>" class="card-img-top" alt="<?= html_escape($st->name) ?>" style="height: 250px; object-fit: cover;">
							<?php else: ?>
								<img src="<?= base_url('img/identitas/logo.png') ?>" class="card-img-top" alt="<?= html_escape($st->name) ?>" style="height: 250px; object-fit: cover;">
							<?php endif; ?>
							<div class="card-body">
								<h6 class="card-title"><?= html_escape($st->name) ?></h6>
								<p class="card-text"><small><strong>NIS:</strong> <?= html_escape($st->student_id) ?></small></p>
								<?php if(!empty($st->class_name)): ?>
									<p class="card-text"><small><strong>Kelas:</strong> <?= html_escape($st->class_name) ?> (<?= html_escape($st->grade) ?>)</small></p>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			<?php else: ?>
				<div class="col-12">
					<div class="alert alert-info text-center">Belum ada data siswa.</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<!-- End of Students -->
