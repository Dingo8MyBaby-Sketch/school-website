<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Cetak Laporan <?= $selected_year ?></title>
	<style>
		body {
			font-family: Arial, sans-serif;
			font-size: 13px;
			color: #333;
			margin: 20px;
		}
		h2 {
			text-align: center;
			margin-bottom: 4px;
		}
		.subtitle {
			text-align: center;
			margin-bottom: 20px;
			color: #555;
		}
		.summary-table, .posts-table {
			width: 100%;
			border-collapse: collapse;
			margin-bottom: 24px;
		}
		.summary-table th, .summary-table td,
		.posts-table th, .posts-table td {
			border: 1px solid #aaa;
			padding: 6px 10px;
		}
		.summary-table th, .posts-table th {
			background-color: #f0f0f0;
			font-weight: bold;
		}
		.section-title {
			font-weight: bold;
			font-size: 14px;
			margin: 16px 0 6px;
			border-bottom: 1px solid #ccc;
			padding-bottom: 4px;
		}
		.badge-active {
			color: #155724;
			background-color: #d4edda;
			padding: 2px 6px;
			border-radius: 4px;
		}
		.badge-inactive {
			color: #383d41;
			background-color: #e2e3e5;
			padding: 2px 6px;
			border-radius: 4px;
		}
		.print-footer {
			text-align: right;
			color: #777;
			font-size: 11px;
			margin-top: 30px;
		}
		@media print {
			.no-print { display: none; }
		}
	</style>
</head>
<body>

	<h2>Laporan Website Sekolah</h2>
	<p class="subtitle">
		Tahun: <?= $selected_year ?>
		<?php if($selected_month) : ?>
			&ndash; Bulan: <?= $bulan_list[$selected_month] ?>
		<?php endif ?>
	</p>

	<!-- Summary -->
	<div class="section-title">Ringkasan Data</div>
	<table class="summary-table">
		<thead>
			<tr>
				<th>Keterangan</th>
				<th>Jumlah</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Total Berita</td>
				<td><?= $summary['total_berita'] ?></td>
			</tr>
			<tr>
				<td>Berita Aktif</td>
				<td><?= $summary['berita_aktif'] ?></td>
			</tr>
			<tr>
				<td>Berita Nonaktif</td>
				<td><?= $summary['berita_nonaktif'] ?></td>
			</tr>
			<tr>
				<td>Total Fasilitas</td>
				<td><?= $summary['total_fasilitas'] ?></td>
			</tr>
			<tr>
				<td>Total Banner</td>
				<td><?= $summary['total_banner'] ?></td>
			</tr>
		</tbody>
	</table>

	<!-- Monthly Breakdown -->
	<?php if(count($posts_by_month) > 0) : ?>
	<div class="section-title">Jumlah Berita per Bulan (Tahun <?= $selected_year ?>)</div>
	<table class="summary-table">
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
	<?php endif ?>

	<!-- Posts List -->
	<?php if(count($posts) > 0) : ?>
	<div class="section-title">Daftar Berita</div>
	<table class="posts-table">
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
							<span class="badge-active">Aktif</span>
						<?php else : ?>
							<span class="badge-inactive">Nonaktif</span>
						<?php endif ?>
					</td>
					<td><?= date('d M Y', strtotime($p->date)) ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<?php endif ?>

	<div class="print-footer">
		Dicetak pada: <?= date('d M Y H:i') ?>
	</div>

	<div class="no-print" style="text-align:center; margin-top:20px;">
		<button onclick="window.print()" style="padding:8px 20px; cursor:pointer;">Cetak</button>
		<button onclick="window.close()" style="padding:8px 20px; cursor:pointer; margin-left:10px;">Tutup</button>
	</div>

	<script>
		window.onload = function() {
			window.print();
		};
	</script>

</body>
</html>
