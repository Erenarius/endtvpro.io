<?php	include("_ust.php");	

	if(isset($_GET["id"])){
		$id 		= $_GET["id"];
		$id_sfrli	= sifrele($id);
		$id_sfrsz	= sifrecoz($id_sfrli);
	
		//COKLU VERI CEKIMI VE LISTELEME / DETAYLI
		$query = $db->prepare("SELECT * FROM paketler WHERE id IN (:id)");
		$query->bindValue(':id', (int) trim($id), PDO::PARAM_INT);
		$query->execute();
		if ( $query->rowCount() ){
			foreach( $query as $detay ){
?>
<div class="content">
    <div class="container-xl">
		<div class="page-header d-print-none">
			<div class="row align-items-center">
				<div class="col">
					<div class="page-pretitle">Paket Düzenle</div>
					<h2 class="page-title"><?php echo $detay["p_baslik"]; ?></h2>
				</div>
			</div>
		</div>
          <div class="row row-deck row-cards">
			<form id="paketDuzenleFormu" onsubmit="return false">
				<div class="col-12">
					<div class="card" style="height: calc(24rem + 10px)">
						<div class="card-body card-body-scrollable card-body-scrollable-shadow">
							<div class="divide-y-4">
								<div class="modal-body">
									<div class="row">
										<div class="col-lg-6">
											<div class="mb-3">
												<label class="form-label">Paket Adı</label>
												<input type="text" class="form-control" name="paketadi" placeholder="<?php echo $detay["p_baslik"]; ?>" value="<?php echo $detay["p_baslik"]; ?>">
											</div>
										</div>
										<div class="col-lg-2">
											<div class="mb-3">
												<label class="form-label">Paket Fiyatı</label>
												<input type="text" class="form-control" name="paketfiyati" placeholder="<?php echo $detay["p_fiyat"]; ?>" value="<?php echo $detay["p_fiyat"]; ?>">
											</div>
										</div>
										<div class="col-lg-4">
											<div class="mb-3">
												<div class="form-group">
													<label class="duzen-baslik mb-1">Kategori</label>
													<select name="paketkategori" id="select" class="form-control">
														<?php 	
															$kategoris = $db->prepare("SELECT * FROM kategoriler ORDER BY k_baslik ASC");
															$kategoris->execute();
															if ( $kategoris->rowCount() ){
																foreach( $kategoris as $amas ){
																	if($amas["id"] == $detay["p_kategori"]) { echo "<option value='{$amas["id"]}' selected>{$amas["k_baslik"]}</option>"; } 
																	else { echo "<option value='{$amas["id"]}'>{$amas["k_baslik"]}</option>"; } 
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
												<textarea class="form-control" name="paketicerigi" rows="7" placeholder="<?php echo $detay["p_aciklama"]; ?>"><?php $p_aciklama = str_replace(array("<li>","</li>","\r"),array('','',''),trim($detay['p_aciklama'],"\n\r")); echo $p_aciklama; ?></textarea>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-lg-12">
											<div class="mb-3">
												<label class="form-label">Paket Link [Yönlendirilecek Link]</label>
												<div class="input-group input-group-flat">
													<input type="text" class="form-control" name="paketlink" placeholder="https://wa.me/905320002233" autocomplete="off" value="<?php echo $detay["p_link"]; ?>">
												</div>
											</div>
										</div>
									</div>
									
									<div class="row">
										
										<div class="col-lg-8">
											<div class="mb-3">
												<div class="row">
													<div class="form-group col-md-2 text-center">
														<label class="imagecheck mb-12">
															<figure class="imagecheck-figure">
																<img class="imagecheck-image" src="<?php echo siteGetir("link"); ?>tasarim/resim/<?php echo $detay["p_resim"]; ?>" style="width: 65px;">
															</figure>
														</label>
													</div>
												
													<div class="form-group col-md-10">
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
												<?php 
													$degerler = array('0','1'); 
													$vtdeger = $detay["p_onay"];
													foreach ($degerler as $secilmisdeger) { 
														if($secilmisdeger == 0){$metin = "Pasif";}
														elseif($secilmisdeger == 1){$metin = "Aktif";}

														if($vtdeger == $secilmisdeger){ 
															echo '<option value="'.$secilmisdeger.'" selected>'.$metin.'</option>'; 
														}else{ 
															echo '<option value="'.$secilmisdeger.'">'.$metin.'</option>'; 
														} 
													} 
												?>
												</select>
											</div>
										</div>
									</div>
									<div id="gizlenmis" style="display:none;" class="mt-3 my-1 alert">
										<a id="sonuc"></a>
									</div>
									<div class="modal-footer mt-3 px-0">
										<input type="hidden" name="paketDuzenle" value="<?php echo $id_sfrli; ?>">
										<input type="submit" name="update" value="Düzenlemeyi Kaydet" class="btn btn-primary ms-auto mx-0 paketDuzenle"/>
									</div>
									
									<div id="screen" style="display:none">
										<div class="loader"></div>
									</div>
									
								</div>
							</div>
						</div>
					</div>
				</div>
            </form>
		</div>
    </div>
	

		
	
	<script type="text/javascript">
$(document).on("submit", "#paketDuzenleFormu", function(event){ //infoForm id li form post edildiğinde

	event.preventDefault();
	$.ajax({
		url: "islem.php", 
		type: "POST",             
		data: new FormData( this ),
		processData: false,
		contentType: false,
		beforeSend:function () { $('#screen').show(); },
		success:function(donenveri){
			$('#screen').hide();
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
				document.getElementById("sonuc").innerHTML="<b>Güncelleme işlemi başarılı bir şekilde yapıldı.</b>";
				setTimeout(function(){ window.location=""; }, 2800);
			};
			if (deger=="resimHata") {
				$("#sonuc").text("Resim yüklenemedi!")
			};
			if (deger=="bos") {
				$("#sonuc").text("Lütfen tüm alanları doldurun!")
			};
			if (deger=="zatenVar") {
				$("#sonuc").text("Bu SSS önceden yayınlanmış!")
			};
			if (deger=="kurnaz") {
				$("#sonuc").text("Sanırım bir şeyler deniyorsun amacını merek etmedim değil :D")
			};
			if (deger=="yanlis") {
				$("#sonuc").text("Güncelleme işlemi yapılamadı.")
			};
		}
				
	});
});
	
	
	
		$(function(){
			$(".paketDuzenles").on("click", function () {         
				$.ajax({
					type:"POST",
					url:"islem.php",
					data: $('#paketDuzenleFormu').serialize(),
					
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
							document.getElementById("sonuc").innerHTML="<b>Güncelleme işlemi başarılı bir şekilde yapıldı.</b>";
							setTimeout(function(){ window.location=""; }, 2800);
						};
						if (deger=="resimHata") {
							$("#sonuc").text("Resim yüklenemedi!")
						};
						if (deger=="bos") {
							$("#sonuc").text("Lütfen tüm alanları doldurun!")
						};
						if (deger=="zatenVar") {
							$("#sonuc").text("Bu önceden yayınlanmış!")
						};
						if (deger=="kurnaz") {
							$("#sonuc").text("Sanırım bir şeyler deniyorsun amacını merek etmedim değil :D")
						};
						if (deger=="yanlis") {
							$("#sonuc").text("Güncelleme işlemi yapılamadı.")
						};
					}
				
				});
			});
		});
	</script>
<?php	
			}
		}else{header("location:../index.php");}
	}else{header("location:../index.php");}
include("_alt.php");	
?>