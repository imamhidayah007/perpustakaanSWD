<!-- right column -->
<div class="col-md-12">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title"><?= $title; ?></h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?= base_url('buku/simpan'); ?>">
      <div class="box-body">
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Id Buku</label>
          <div class="col-sm-10">
            <input type="text" name="id_buku" value="<?= $id_buku ?>" class="form-control" readonly>
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Judul Buku</label>
          <div class="col-sm-10">
            <input type="text" name="judul_buku" class="form-control" required placeholder="Judul buku...">
          </div>
        </div>

        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Pengarang</label>
          <div class="col-sm-10">
            <select name="id_pengarang" class="form-control select2" id="" required>
              <option value="">-Pilih Pengarang-</option>
              <?php foreach($pengarang as $row): ?>
              <option value="<?= $row->id_pengarang ?>"><?= $row->nama_pengarang; ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Penerbit</label>
          <div class="col-sm-10">
            <select name="id_penerbit" class="form-control select2" id="" required>
              <option value="">-Pilih Penerbit-</option>
              <?php foreach($penerbit as $row): ?>
              <option value="<?= $row->id_penerbit ?>"><?= $row->nama_penerbit; ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Tahun Terbit</label>
          <div class="col-sm-10">
            <select name="tahun_terbit" class="form-control select2" id="" required>
              <option value="">-Pilih tahun-</option>
              <?php for($tahun = 2000; $tahun <= 2020; $tahun++){ ?>
                <option value="<?= $tahun ?>"><?= $tahun; ?></option>
              <?php } ?>  
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Jumlah</label>

          <div class="col-sm-10">
            <input type="number" name="jumlah" class="form-control">
          </div>
        </div>
		  <div class="form-group">
			  <div class="text-center" id="pratinjauGambar"></div>
		  </div>

		  <div class="form-group">
			  <label for="inputPassword3" class="col-sm-2 control-label">Foto/ Gambar Buku</label>
			  <div class="col-sm-10">
				  <input type="file" name="gambarbuku" class="form-control" onchange="return masok()" required accept="image/jpeg, image/jpg, image/png" id="file">
			  </div>
		  </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
          <a href="<?= base_url('buku'); ?>" class="btn btn-warning">Cancel</a>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
      <!-- /.box-footer -->
    </form>
  </div>
</div>


<script type="text/javascript">
	function masok(){
		var inputFile = document.getElementById('file');
		var pathFile = inputFile.value;
		var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;

		var oFile = inputFile.files[0];

		if(!ekstensiOk.exec(pathFile)){
			iziToast.warning({
				title: 'Peringatan !',
				message: 'Silakan upload file yang memiliki ekstensi .jpeg/.jpg/.png',
				position: 'topRight'
			});

			inputFile.value = '';
			return false;
		}else{
			//Pratinjau gambar
			if (inputFile.files && inputFile.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					document.getElementById('pratinjauGambar').innerHTML = '<img width="30%" src="'+e.target.result+'"/>';
				};
				reader.readAsDataURL(inputFile.files[0]);
			}
		}
	}
</script>
