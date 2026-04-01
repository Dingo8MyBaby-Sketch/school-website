<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Laporan</h1>
		<a href="<?= base_url('laporan/print_report?tahun=' . $selected_year . ($selected_month ? '&bulan=' . $selected_month : '')) ?>" 
		   target="_blank" class="btn btn-sm btn-primary shadow-sm">
			<i class="fas fa-print fa-sm text-white-50 mr-1"></i> Cetak Laporan
		</a>
	</div>

	<!-- Alert -->
	<div class="row">
		<div class="col">
			<?php if($this->session->flashdata('success')): ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<?= $this->session->flashdata('success') ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php endif ?>
		</div>
	</div>

	<!-- Summary Cards -->
	<div class="row mb-4">

		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Berita</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $summary['total_berita'] ?></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-newspaper fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-success shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Berita Aktif</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $summary['berita_aktif'] ?></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-check-circle fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-warning shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Fasilitas</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $summary['total_fasilitas'] ?></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-place-of-worship fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-info shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Banner</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $summary['total_banner'] ?></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-desktop fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<!-- Filter -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
		</div>
		<div class="card-body">
			<form method="get" action="<?= base_url('laporan') ?>">
				<div class="form-row align-items-end">
					<div class="col-md-3 mb-3">
						<label for="tahun">Tahun</label>
						<select name="tahun" id="tahun" class="form-control">
							<?php foreach($years as $y) : ?>
								<option value="<?= $y->tahun ?>" <?= ($selected_year == $y->tahun) ? 'selected' : '' ?>>
									<?= $y->tahun ?>
								</option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="col-md-3 mb-3">
						<label for="bulan">Bulan (Opsional)</label>
						<select name="bulan" id="bulan" class="form-control">
							<option value="">Semua Bulan</option>
							<?php foreach($bulan_list as $num => $nama) :
							?>
								<option value="<?= $num ?>" <?= ($selected_month == $num) ? 'selected' : '' ?>>
									<?= $nama ?>
								</option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="col-md-2 mb-3">
						<button type="submit" class="btn btn-primary btn-block">
							<i class="fas fa-search mr-1"></i> Tampilkan
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- Monthly Chart -->
	<div class="row">
		<div class="col-xl-12 col-lg-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Jumlah Berita per Bulan (Tahun <?= $selected_year ?>)</h6>
				</div>
				<div class="card-body">
					<?php if(count($posts_by_month) > 0) : ?>
					<div class="table-responsive">
						<table class="table table-bordered table-sm">
							<thead>
								<tr>
									<th>Bulan</th>
									<th>Jumlah Berita</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($posts_by_month as $pm) : ?>
									<tr>
										<td><?= $pm->nama_bulan ?></td>
										<td><?= $pm->jumlah ?></td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
					<?php else : ?>
						<p class="text-muted">Tidak ada data untuk tahun <?= $selected_year ?>.</p>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>

	<!-- Posts Table -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">
				Daftar Berita
				<?= $selected_month ? '- ' . $bulan_list[$selected_month] : '' ?>
				<?= $selected_year ?>
			</h6>
		</div>
		<div class="card-body">
			<?php if(count($posts) > 0) : ?>
			<div class="table-responsive">
				<table class="table table-bordered table-striped" id="tableLaporan" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>#</th>
							<th>Judul Berita</th>
							<th>Status</th>
							<th>Tanggal</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1; foreach($posts as $p) : ?>
							<tr>
								<td><?= $no++ ?></td>
								<td><?= htmlspecialchars($p->title) ?></td>
								<td>
									<?php if($p->is_active == 'Y') : ?>
										<span class="badge badge-success">Aktif</span>
									<?php else : ?>
										<span class="badge badge-secondary">Nonaktif</span>
									<?php endif ?>
								</td>
								<td><?= date('d M Y', strtotime($p->date)) ?></td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
			<?php else : ?>
				<p class="text-muted">Tidak ada data berita untuk filter yang dipilih.</p>
			<?php endif ?>
		</div>
	</div>

</div>

<script>
$(document).ready(function() {
	$('#tableLaporan').DataTable({
		lengthMenu: [10, 25, 50, 100],
		order: [[3, 'desc']]
	});
});
</script>
