<?php	include("_ust.php");	

	if(isset($_GET["id"])){
		$id 		= $_GET["id"];
		$id_sfrli	= sifrele($id);
		$id_sfrsz	= sifrecoz($id_sfrli);
		
		$s_onay = 1;
		$query = $db->prepare("SELECT * FROM paketler WHERE id = :id");
		$query->bindValue(':id', (int) trim($id), PDO::PARAM_INT);
		$query->execute();
		$detay=$query->fetch(PDO::FETCH_ASSOC);	
	}
?>
<div class="content">
    <div class="container-xl">
		<div class="page-header d-print-none">
			<div class="row align-items-center">
				<div class="col">
					<div class="page-pretitle">Site Ayarları</div>
					<h2 class="page-title">Genel Ayarlar</h2>
				</div>
			</div>
		</div>
          <div class="row row-deck row-cards">
			<form id="siteAyarFormu" onsubmit="return false">
				<div class="col-12">
					<div class="card" style="height: calc(24rem + 10px)">
						<div class="card-body card-body-scrollable card-body-scrollable-shadow">
							<div class="divide-y-4">
							
								<div class="modal-body">
									
									<div class="form-group mb-3 row">
										<label class="form-label col-3 col-form-label">Başlık</label>
										<div class="col">
											<input type="text" class="form-control" name="title" placeholder="<?php echo siteGetir("title"); ?>" value="<?php echo siteGetir("title"); ?>">
											<small class="form-hint">Side Başlığını buraya yazınız.</small>
										</div>
									</div>
									
									<div class="form-group mb-3 row">
										<label class="form-label col-3 col-form-label">Site Açıklaması</label>
										<div class="col">
											<input type="text" class="form-control" name="description" placeholder="<?php echo siteGetir("description"); ?>" value="<?php echo siteGetir("description"); ?>">
											<small class="form-hint">Footer kısmında yer alan site açıklamasını buraya yazınız.</small>
										</div>
									</div>
									
									<div class="form-group mb-3 row">
										<label class="form-label col-3 col-form-label">Keywords</label>
										<div class="col">
											<input type="text" class="form-control" name="keywords" placeholder="<?php echo siteGetir("keywords"); ?>" value="<?php echo siteGetir("keywords"); ?>">
											<small class="form-hint">Arama motarlarında kolay bulunma için tavsiye edilir.</small>
										</div>
									</div>
									
									<div class="form-group mb-3 row">
										<label class="form-label col-3 col-form-label">Google Analytics</label>
										<div class="col">
											<input type="text" class="form-control" name="analytics" placeholder="<?php echo siteGetir("analytics"); ?>" value="<?php echo siteGetir("analytics"); ?>">
											<small class="form-hint">Google Analytics kodunuzu buraya yazabilirsiniz.</small>
										</div>
									</div>
									
									<div class="form-group mb-3 row">
										<label class="form-label col-3 col-form-label">Sosyal Medya Hesapları</label>
										<div class="col">
											<div class="input-group mb-3">
												<span class="input-group-text" id="basic-addon1">facebook.com/</span>
												<input type="text" class="form-control" name="facebook" placeholder="<?php echo siteGetir("facebook"); ?>" value="<?php echo siteGetir("facebook"); ?>">
												<small class="form-hint">facebook.com/<b>kullaniciadiniz</b></small>
											</div>	
										</div>
										<div class="col">
											<div class="input-group mb-3">
												<span class="input-group-text" id="basic-addon1">twitter.com/</span>
												<input type="text" class="form-control" name="twitter" placeholder="<?php echo siteGetir("twitter"); ?>" value="<?php echo siteGetir("twitter"); ?>">
												<small class="form-hint">twitter.com/<b>kullaniciadiniz</b></small>
											</div>	
										</div>
										<div class="col">
											<div class="input-group mb-3">
												<span class="input-group-text" id="basic-addon1">instagram.com/</span>
												<input type="text" class="form-control" name="instagram" placeholder="<?php echo siteGetir("instagram"); ?>" value="<?php echo siteGetir("instagram"); ?>">
												<small class="form-hint">instagram.com/<b>kullaniciadiniz</b></small>
											</div>	
										</div>
									</div>
								</div>
								
								<div class="form-group mb-3 row">
									<label class="form-label col-3 col-form-label">Site Aktif / Pasif</label>
									<div class="col">
										<select class="form-select" name="aktif">
										<?php 
											$degerler = array('0','1'); 
											$vtdeger = siteGetir("aktif");
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
										<small class="form-hint">Sitenizin aktif/pasif ayarlarını buradan yönetebilirsiniz.</small>
									</div>
								</div>

									<div id="gizlenmis" style="display:none;" class="mt-3 my-1 alert">
										<a id="sonuc"></a>
									</div>
									
									<div class="modal-footer mt-3 px-0">
										<input type="hidden" name="siteAyar" value="siteAyar">
										<input type="submit" name="update" value="Düzenlemeyi Kaydet" class="btn btn-primary ms-auto mx-0 siteAyar"/>
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
			$(".siteAyar").on("click", function () {         
				$.ajax({
					type:"POST",
					url:"islem.php",
					data: $('#siteAyarFormu').serialize(),
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
		});
	</script>
<?php	include("_alt.php");	?>