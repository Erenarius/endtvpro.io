<?php	include("_ust.php");	

	if(isset($_GET["id"])){
		$id 		= $_GET["id"];
		$id_sfrli	= sifrele($id);
		$id_sfrsz	= sifrecoz($id_sfrli);

		//COKLU VERI CEKIMI VE LISTELEME / DETAYLI
		$query = $db->prepare("SELECT * FROM kategoriler WHERE id IN (:id)");
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
					<div class="page-pretitle">Kategori Düzenle</div>
					<h2 class="page-title"><?php echo $detay["k_baslik"]; ?></h2>
				</div>
			</div>
		</div>
          <div class="row row-deck row-cards">
			<form id="kategoriDuzenleFormu" onsubmit="return false">
				<div class="col-12">
					<div class="card" style="height: calc(24rem + 10px)">
						<div class="card-body card-body-scrollable card-body-scrollable-shadow">
							<div class="divide-y-4">
								<div class="modal-body">
									<div class="row">
										<div class="col-lg-4">
											<div class="mb-3">
												<label class="form-label">Kategori Adı</label>
												<input type="text" class="form-control" name="kategoriadi" placeholder="<?php echo $detay["k_baslik"]; ?>" value="<?php echo $detay["k_baslik"]; ?>">
											</div>
										</div>
										<div class="col-lg-4">
											<div class="mb-3">
												<label class="form-label">Üst Barda Göster</label>
												<select class="form-select" name="kategorisabit">
												<?php 
													$degerler = array('0','1'); 
													$vtdeger = $detay["k_sabit"];
													foreach ($degerler as $secilmisdeger) { 
														if($secilmisdeger == 0){$metin = "Hayır";}
														elseif($secilmisdeger == 1){$metin = "Evet";}

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
										<div class="col-lg-4">
											<div class="mb-3">
												<label class="form-label">Aktif / Pasif</label>
												<select class="form-select" name="kategoridurum">
												<?php 
													$degerler = array('0','1'); 
													$vtdeger = $detay["k_onay"];
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
										<input type="hidden" name="kategoriDuzenle" value="<?php echo $id_sfrli; ?>">
										<input type="submit" name="update" value="Düzenlemeyi Kaydet" class="btn btn-primary ms-auto mx-0 kategoriDuzenle"/>
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
		$(function(){
			$(".kategoriDuzenle").on("click", function () {         
				$.ajax({
					type:"POST",
					url:"islem.php",
					data: $('#kategoriDuzenleFormu').serialize(),
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
						if (deger=="bos") {
							$("#sonuc").text("Lütfen tüm alanları doldurun!")
						};
						if (deger=="zatenVar") {
							$("#sonuc").text("Bu kategori önceden yayınlanmış!")
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