<!--================Home Banner Area =================-->
<div class="jumbotron banner_area jumbotron-fluid" style="background-image: url(<?= base_url('img/banner_area/bg.jpg') ?>); ">
	<div class="container">
		<h1 class="display-4 my-auto text-light text-center">Kelas</h1>
	</div>
</div>
<!--================End Home Banner Area =================-->

<!-- Classes -->
<div class="classes mt-5 mb-5">
	<div class="container">
		<div class="row">
			<?php if(!empty($classes)): ?>
				<?php foreach($classes as $c) : ?>
					<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
						<div class="card h-100">
							<?php if(!empty($c->photo)): ?>
								<img src="<?= base_url('img/classes/' . $c->photo) ?>" class="card-img-top" alt="<?= $c->name ?>" style="height: 250px; object-fit: cover;">
							<?php else: ?>
								<img src="<?= base_url('img/identitas/logo.png') ?>" class="card-img-top" alt="<?= $c->name ?>" style="height: 250px; object-fit: cover;">
							<?php endif; ?>
							<div class="card-body">
								<h5 class="card-title"><?= $c->name ?></h5>
								<p class="card-text"><span class="badge badge-primary"><?= $c->grade ?></span></p>
								<?php if(!empty($c->teacher_name)): ?>
									<p class="card-text"><strong>Wali Kelas:</strong> <?= $c->teacher_name ?></p>
								<?php endif; ?>
								<?php if(!empty($c->description)): ?>
									<p class="card-text"><?= substr($c->description, 0, 150) ?><?= strlen($c->description) > 150 ? '...' : '' ?></p>
								<?php endif; ?>
								<?php if(!empty($c->schedule)): ?>
									<p class="card-text"><small class="text-muted"><strong>Jadwal:</strong> <?= nl2br($c->schedule) ?></small></p>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			<?php else: ?>
				<div class="col-12">
					<div class="alert alert-info text-center">Belum ada data kelas.</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<!-- End of Classes -->
