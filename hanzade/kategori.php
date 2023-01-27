<?php	include("_ust.php");
		$filtre	=	filter_var($_GET['k_link'], FILTER_SANITIZE_SPECIAL_CHARS);
		
		$sefilekategoriBulma	=  $db->prepare("SELECT * FROM kategoriler WHERE k_link = :k_link");
		$sefilekategoriBulma	-> execute(array("k_link"=> $filtre));
		$sefilekategori			=  $sefilekategoriBulma->fetch(PDO::FETCH_ASSOC);
		
		$kategori_id = $sefilekategori["id"];
		$kategori_ad = $sefilekategori["k_baslik"];
		
		$p_onay	=	1;		
		$query	=	$db->prepare("SELECT * FROM paketler WHERE p_onay IN (:p_onay) AND p_kategori = :p_kategori ORDER BY id DESC");
		$query	->bindValue(':p_onay', (int) trim($p_onay), PDO::PARAM_INT);
		$query	->bindValue(':p_kategori', (int) trim($kategori_id), PDO::PARAM_INT);
		$query	->execute();
	?>
		<div class="py-5 px-lg-5">
			<div class="container-fluid">
			<h1 class="genelBaslik altrenkYazi"><?php echo $kategori_ad; ?></h1>
				<div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">	
				<?php
				if ( $query->rowCount() ){
					foreach( $query as $ama ){
						if(empty($ama["p_resim"])){ $paketResim = siteGetir("link")."tasarim/resim-yok.jpg"; }
						else{ $paketResim = siteGetir("link")."tasarim/resim/".$ama["p_resim"]; }
					?>
					<a class="text-decoration-none" href="<?php echo siteGetir("link"); ?>detay.php?g=<?php echo sifrele($ama["id"]); ?>">
						<div class="col customKart">
							<div class="card shadow-sm">
							<img class="card-img-top" width="100%" height="325" src="<?php echo $paketResim; ?>">
								<div class="card-body pb-0">
									<p class="card-title text-muted text-uppercase p-0 sigdir"><?php echo $ama["p_baslik"]; ?></p>
									<p class="card-subtitle text-muted m-0"><?php echo $ama["p_fiyat"]; ?>₺</p>
									<span class="btn btn-outline-success shadow-sm mt-2">Detayları Göster</span>
								</div>
							</div>
						</div>
					</a>
						<?php	
						}
					}else{ ?>
					
					<div class="col-12 mt-5 customKart">
						<div class="card shadow-sm py-4">Bu kategoriye henüz içerik eklenmemiş.</div>
					</div>
					
					<?php	
					}
					?>
				</div>
			</div>
		</div>
		
<?php	include("_alt.php"); ?>