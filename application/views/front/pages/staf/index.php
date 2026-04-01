<!--================Home Banner Area =================-->
<div class="jumbotron banner_area jumbotron-fluid" style="background-image: url(<?= base_url('img/banner_area/bg.jpg') ?>); ">
	<div class="container">
		<h1 class="display-4 my-auto text-light text-center">Staff</h1>
	</div>
</div>
<!--================End Home Banner Area =================-->

<!-- Staff -->
<div class="staff mt-5 mb-5">
	<div class="container">
		<div class="row">
			<?php if(!empty($staff)): ?>
				<?php foreach($staff as $s) : ?>
					<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
						<div class="card h-100">
							<?php if(!empty($s->photo)): ?>
								<img src="<?= base_url('img/staff/' . $s->photo) ?>" class="card-img-top" alt="<?= html_escape($s->name) ?>" style="height: 300px; object-fit: cover;">
							<?php else: ?>
								<img src="<?= base_url('img/identitas/logo.png') ?>" class="card-img-top" alt="<?= html_escape($s->name) ?>" style="height: 300px; object-fit: cover;">
							<?php endif; ?>
							<div class="card-body">
								<h5 class="card-title"><?= html_escape($s->name) ?></h5>
								<p class="card-text"><strong><?= html_escape($s->position) ?></strong></p>
								<?php if(!empty($s->email)): ?>
									<p class="card-text"><small><i class="fas fa-envelope"></i> <?= html_escape($s->email) ?></small></p>
								<?php endif; ?>
								<?php if(!empty($s->phone)): ?>
									<p class="card-text"><small><i class="fas fa-phone"></i> <?= html_escape($s->phone) ?></small></p>
								<?php endif; ?>
								<?php if(!empty($s->bio)): ?>
									<p class="card-text"><?= html_escape(substr($s->bio, 0, 100)) ?><?= strlen($s->bio) > 100 ? '...' : '' ?></p>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			<?php else: ?>
				<div class="col-12">
					<div class="alert alert-info text-center">Belum ada data staff.</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<!-- End of Staff -->
