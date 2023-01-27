<?php	include("_ust.php");	?>
	<div class="content">
        <div class="container-xl">
          <!-- Page title -->
			<div class="page-header d-print-none">
				<div class="row align-items-center">
					<div class="col">
						<div class="page-pretitle">Genel Bakış</div>
						<h2 class="page-title">Yönetim Paneli</h2>
					</div>
					<div class="col-auto ms-auto d-print-none">
						<div class="btn-list">
							<a href="#" class="btn btn-white" data-bs-toggle="modal" data-bs-target="#modal-kategori">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
							Yeni Kategori Oluştur
							</a>
							<a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-paket">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
							Yeni Paket Oluştur
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="row row-deck row-cards">
			
				<div class="col-12 col-md-8">
				  <div class="card" style="height: calc(24rem + 10px)">
					<div class=" card-body-scrollable card-body-scrollable-shadow">
					  <div class="divide-y-4">
					  
						<table class="table table-vcenter table-mobile-md card-table">
							<thead>
								<tr>
								<th>Son Eklenenler</th>
								<th class="w-2"></th>
								</tr>
							</thead>
						<tbody>
						<?php
							$query = $db->prepare("SELECT * FROM paketler ORDER BY id DESC");
							$query->execute();
							if ( $query->rowCount() ){
								foreach( $query as $ama ){
									
								if(empty($ama["p_resim"])){ $paketResim = "../tasarim/resim-yok.jpg"; }
								else{ $paketResim = siteGetir("link")."tasarim/resim/".$ama["p_resim"]; }
						?>
							<tr>
							  <td data-label="Name">
								<div class="d-flex py-1 align-items-center">
								  <span class="avatar me-2" style="background-image: url(<?php echo $paketResim; ?>)"></span>
								  <div class="flex-fill">
									<div class="font-weight-medium"><?php echo $ama["p_baslik"]; ?></div>
									<div class="text-muted"><a href="#" class="text-reset">(<?php echo $ama["p_fiyat"]; ?>₺)</a></div>
								  </div>
								</div>
							  </td>
							  <td>
								<div class="btn-list flex-nowrap">
								<a href="paketduzenle.php?id=<?php echo $ama["id"]; ?>" class="btn">Düzenle</a>
								<a href="../detay.php?g=<?php echo sifrele($ama["id"]); ?>" target="_blank" class="btn">Görüntüle</a>
								</div>
							  </td>
							</tr>
						</div>
					<?php	
							}
						}else{
					?>
						<tr>
							<td class="row">
								<div class="col-auto"><div class="badge bg-primary"></div></div>
								<div class="col">
									<div class="text-muted">Yeni bir paket oluşturulduğunda burada görünecek.</div>
								</div>
							</td>
						</tr>
							
					<?php		
						}
					?>
						</tbody>
                    </table>
					
					
					 </div>
					</div>
				  </div>
				</div>

				<div class="col-12 col-md-4">
				  <div class="card" style="height: calc(24rem + 10px)">
					<table class="table table-vcenter table-mobile-md card-table">
						<thead>
							<tr>
							<th>Kategoriler</th>
							</tr>
						</thead>
					</table>
					<div class="card-body card-body-scrollable card-body-scrollable-shadow">
					  <div class="divide-y-4">
					<?php
						$s_onay	=	1;	
						
						$query = $db->prepare("SELECT * FROM kategoriler ORDER BY k_baslik ASC");
						$query->execute();
						if ( $query->rowCount() ){
							foreach( $query as $ama ){
					?>
						<div onclick="location.href='kategoriduzenle.php?id=<?php echo $ama["id"]; ?>';" style="cursor:pointer">
						  <div class="row">
							<div class="col">
							  <div class="text-truncate">
								<strong><?php echo $ama["k_baslik"]; ?></strong>
							  </div>
							</div>
						  </div>
						</div>
					<?php	
							}
						}else{
					?>

						<div>
						<div class="row">
							<div class="col-auto"><div class="badge bg-primary"></div></div>
							<div class="col">
								<div class="text-muted">Yeni bir Kategori oluşturulduğunda burada görünecek.</div>
							</div>
						</div>
						</div>
							
					<?php		
						}
					?>
					 </div>
					</div>
				  </div>
				</div>

			</div>
        </div>
		
		
		
	<form id="kategoriFormu" onsubmit="return false">
		<div class="modal modal-blur fade" id="modal-kategori" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Yeni Kategori Oluştur</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-4">
								<div class="mb-3">
									<label class="form-label">Kategori Adı</label>
									<input type="text" class="form-control" name="kategoriadi" placeholder="Kategori adını giriniz">
								</div>
							</div>
							<div class="col-lg-4">
								<div class="mb-3">
									<label class="form-label">Üst Barda Göster</label>
									<select class="form-select" name="kategorisabit">
										<option value="0">Hayır</option>
										<option value="1" selected>Evet</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="mb-3">
									<label class="form-label">Aktif / Pasif</label>
									<select class="form-select" name="kategoridurum">
										<option value="0">Pasif</option>
										<option value="1" selected>Aktif</option>
									</select>
								</div>
							</div>
						</div>

						
						<div id="gizlenmisKAT" style="display:none;line-height: 2rem;" class="mt-2 mb-0 py-2 alert">
							<a id="sonucKAT"></a>
						</div>	
					</div>

					<div class="modal-footer">
						<a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">İptal</a>
						<input type="hidden" name="kategoriekle" value="kategoriekle">
						<input type="submit" value="Yeni Kategoriyi Oluştur" class="btn btn-primary ms-auto kategoriEkle"/>
					</div>
				</div>
			</div>
		</div>
	</form>
	
	<script type="text/javascript">
		$(function(){
			$(".kategoriEkle").on("click", function () {         
				$.ajax({
					type:"POST",
					url:"islem.php",
					data: $('#kategoriFormu').serialize(),
					success:function(donenveri){
						var gelen=JSON.parse(donenveri);
						var deger=gelen.sonucKAT;
						console.log(deger);
						if (deger!="tamam") {
							document.getElementById("gizlenmisKAT").classList.add('alert-danger');
							document.getElementById("gizlenmisKAT").style.display="block";
						} else {
							document.getElementById("gizlenmisKAT").classList.remove('alert-danger');
							document.getElementById("gizlenmisKAT").classList.add('alert-success');
							document.getElementById("gizlenmisKAT").style.display="block";
							document.getElementById("sonucKAT").innerHTML="<b>Yeni Kategori Eklendi.</b><br>Lütfen Bekleyin..";
							setTimeout(function(){ window.location=""; }, 1000);
						};
						if (deger=="bos") {
							$("#sonucKAT").text("Lütfen tüm alanları doldurun!")
						};
						if (deger=="zatenVar") {
							$("#sonucKAT").text("Bu kategori zaten yayınlanmış!")
						};
						if (deger=="yanlis") {
							$("#sonucKAT").text("Girdiğiniz bilgiler hatalı!")
						};
					}
				});
			});
		});
	</script>
	
		
		
		
		

	<form id="paketFormu" onsubmit="return false">
		<div class="modal modal-blur fade" id="modal-paket" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Yeni Paket Oluştur</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-6">
								<div class="mb-3">
									<label class="form-label">Paket Adı</label>
									<input type="text" class="form-control" name="paketadi" placeholder="Paket adını giriniz">
								</div>
							</div>
							<div class="col-lg-2">
								<div class="mb-3">
									<label class="form-label">Paket Fiyatı</label>
									<input type="text" class="form-control" name="paketfiyati" placeholder="Paket fiyatını giriniz">
								</div>
							</div>
							<div class="col-lg-4">
								<div class="mb-3">
									<div class="form-group">
										<label class="form-label">Kategori</label>
										<select name="paketkategori" id="select" class="form-control">
											<?php 	
												$kategoris = $db->prepare("SELECT * FROM kategoriler ORDER BY k_baslik ASC");
												$kategoris->execute();
												if ( $kategoris->rowCount() ){
													foreach( $kategoris as $amas ){
														echo "<option value='{$amas["id"]}'>{$amas["k_baslik"]}</option>"; 
													}
												}
											?>
										</select>
									</div>
								</div>
							</div>
						</div>
						
						<div class="mb-3">
							<div class="col-lg-12">
								<div>
									<label class="form-label">Paket İçeriği</label>
									<textarea class="form-control" name="paketicerigi" rows="7" placeholder="Madde olarak (Enter tuşu ile) alt alta sıralayanız."></textarea>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-lg-12">
								<div class="mb-3">
									<label class="form-label">Paket Link [Yönlendirilecek Link]</label>
									<div class="input-group input-group-flat">
										<input type="text" class="form-control" name="paketlink" placeholder="https://wa.me/905320002233" autocomplete="off">
									</div>
								</div>
							</div>
						</div>
						
						<div class="row">
						
						<div class="col-lg-8">
								<div class="mb-3">
									<div class="row">
										<div class="form-group col-md-12">
											<label for="formFile" class="form-label">Resim Seçin:</label>
											<input class="form-control" type="file" name="files">
										</div>
									</div>
								</div>
							</div>
										
										
							<div class="col-lg-4">
								<div class="mb-3">
									<label class="form-label">Aktif / Pasif</label>
									<select class="form-select" name="paketdurum">
										<option value="0">Pasif</option>
										<option value="1" selected>Aktif</option>
									</select>
								</div>
							</div>
						</div>
						
						
						<div id="gizlenmis" style="display:none;line-height: 2rem;" class="mt-3 py-2 text-left sufee-alert alert with-close  alert-dismissible fade show">
							<a id="sonuc"></a>
						</div>
					</div>

					<div class="modal-footer">
						<a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">İptal</a>
						<input type="hidden" name="paketekle" value="paketekle">
						<input type="submit" value="Yeni Paketi Oluştur" class="btn btn-primary ms-auto paketEkle"/>
					</div>
				</div>
			</div>
		</div>
	</form>
	
	<script type="text/javascript">
		$(document).on("submit", "#paketFormu", function(event){ 
			event.preventDefault();
			$.ajax({
				url: "islem.php", 
				type: "POST",             
				data: new FormData( this ),
				processData: false,
				contentType: false,
					success:function(donenveri){
						var gelen=JSON.parse(donenveri);
						var deger=gelen.sonuc;
						console.log(deger);
						if (deger!="tamam") {
							document.getElementById("gizlenmis").classList.add('alert-danger');
							document.getElementById("gizlenmis").style.display="block";
						} else {
							document.getElementById("gizlenmis").classList.remove('alert-danger');
							document.getElementById("gizlenmis").classList.add('alert-success');
							document.getElementById("gizlenmis").style.display="block";
							document.getElementById("sonuc").innerHTML="<b>Yeni Paket Paylaşıldı.</b><br>Lütfen Bekleyin..";
							setTimeout(function(){ window.location=""; }, 1000);
						};
						if (deger=="resimHata") {
							$("#sonuc").text("Resim yüklenemedi!")
						};
						if (deger=="kategoriSec") {
							$("#sonuc").text("Sanırım bir kategori oluşturmadın ilk önce bir kategori oluşturmalısın!")
						};
						if (deger=="bos") {
							$("#sonuc").text("Lütfen tüm alanları doldurun!")
						};
						if (deger=="zatenVar") {
							$("#sonuc").text("Bu paket önceden yayınlanmış!")
						};
						if (deger=="kurnaz") {
							$("#sonuc").text("Sanırım bir şeyler deniyorsun amacını merek etmedim değil :D")
						};
						if (deger=="yanlis") {
							$("#sonuc").text("Girdiğiniz bilgiler hatalı!")
						};
					}
			});
		});
	</script>
	
	
	
	
<?php	include("_alt.php");	?>