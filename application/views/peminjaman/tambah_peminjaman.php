<!-- right column -->
<div class="col-md-12">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title"><?= $title; ?></h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
<!--    <form class="form-horizontal" method="post" action="--><?//= base_url('peminjaman/simpan'); ?><!--">-->
      <form id="pinjam" class="form-horizontal">
	  <div class="box-body">
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Id Peminjaman</label>
          <div class="col-sm-10">
            <input type="text" name="id_pm" id="id_pm" value="<?= $id_pm ?>" class="form-control" readonly>
          </div>
        </div>

        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Peminjam</label>
          <div class="col-sm-10">
            <select name="id_anggota" class="form-control select2" id="id_anggota">
              <option value="">-Pilih Peminjam-</option>
              <?php foreach($peminjam as $row): ?>
              <option value="<?= $row->id_anggota ?>"><?= $row->nama_anggota; ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Buku</label>
          <div class="col-sm-10">
            <select name="id_buku" class="form-control select2" id="id_buku">
              <option value="">-Pilih Buku-</option>
              <?php foreach($buku as $row): ?>
              <option value="<?= $row->id_buku ?>"><?= $row->judul_buku; ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Tanggal Pinjam</label>
          <div class="col-sm-10">
            <input type="date" name="tgl_pinjam" id="tgl_pinjam" class="form-control">
          </div>
        </div>

        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Tanggal Kembali</label>
          <div class="col-sm-10">
            <input type="date" name="tgl_kembali" id="tgl_kembali" class="form-control">
          </div>
        </div>

		  <div class="form-group">
			  <label for="inputPassword3" class="col-sm-2 control-label">Ambil Foto Peminjam</label>
			  <div class="text-center col-sm-10" id="my_camera">

			  </div>
		  </div>

      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
          <a href="<?= base_url('peminjaman'); ?>" class="btn btn-warning">Cancel</a>
          <button type="button" onclick="simpanpinjam()" class="btn btn-primary">Simpan</button>
        </div>
      </div>
      <!-- /.box-footer -->
    </form>
  </div>
</div>


<script type="text/javascript">
	function simpanpinjam (){

		// console.log('asu')
		event.preventDefault();
		var image = '';
		var idpinjam = $('#id_pm').val();
		var idanggota = $('#id_anggota').val();
		var idbuku = $('#id_buku').val();
		var tglpinjam = $('#tgl_pinjam').val();
		var tglkembali = $('#tgl_kembali').val();
		Webcam.snap( function(data_uri) {
			image = data_uri;
		});
		$.ajax({
			url: '<?php echo base_url('peminjaman/simpan');?>',
			type: 'POST',
			dataType: 'json',
			data: {
				id_pm: idpinjam,
				id_anggota: idanggota,
				id_buku: idbuku,
				tgl_pinjam: tglpinjam,
				tgl_kembali: tglkembali,
				image:image},
		})
			.done(function(data) {
					if (data > 0) {
						 iziToast.success({
						 	title: 'Info !',
						 	message: 'Data Peminjaman Berhasil Disimpan',
						 	position: 'bottomCenter'
						 });
						setTimeout(function () {
							window.location = "<?php echo base_url('peminjaman')?>"
						}, 3000); //will call the function after 3 secs.


					}


			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});



	}

</script>
