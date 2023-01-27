<?php	include("_ust.php");?>
	

	<?php
	$p_onay		=	1;	

	$query = $db->prepare("SELECT * FROM kategoriler WHERE k_onay IN (:k_onay) ORDER BY id ASC");
	$query->bindValue(':k_onay', (int) trim($k_onay), PDO::PARAM_INT);
	$query->execute();
	if ( $query->rowCount() ){
		foreach( $query as $kategori ){
		?>
		
		<div class="py-5 px-lg-5 siraliarkaRenk">
			<div class="container-fluid">
			<h1 class="genelBaslik altrenkYazi"><?php echo $kategori["k_baslik"]; ?></h1>
				<div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
					<?php
					$p_onay		=	1;	
					$p_kategori	=	$kategori["id"];	

					$query = $db->prepare("SELECT * FROM paketler WHERE p_onay IN (:p_onay) AND p_kategori IN (:p_kategori) ORDER BY id ASC");
					$query->bindValue(':p_onay', (int) trim($p_onay), PDO::PARAM_INT);
					$query->bindValue(':p_kategori', (int) trim($p_kategori), PDO::PARAM_INT);
					$query->execute();
					if ( $query->rowCount() ){
						foreach( $query as $ama ){ $sifreliID = sifrele($ama["id"]);
						
						if(empty($ama["p_resim"])){ $paketResim = "./tasarim/resim-yok.jpg"; }
						else{ $paketResim = "./tasarim/resim/".$ama["p_resim"]; }
						?>
						<a class="text-decoration-none" href="detay.php?g=<?php echo $sifreliID; ?>">
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
					}
					?>
				</div>
			</div>
		</div>

		<?php	
		}
	}
	?>

<?php	include("_alt.php"); ?>