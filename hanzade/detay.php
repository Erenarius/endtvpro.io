<?php	include("_ust.php"); 
		$sifresizID = sifrecoz($_GET["g"]); 
	?>
		<div class="py-5 px-lg-5">
			<div class="container-fluid detaySayfasi">
			<?php
			$id		=	$sifresizID;	
			$p_onay	=	1;	

			$query = $db->prepare("SELECT * FROM paketler WHERE id IN (:id) AND p_onay IN (:p_onay) ORDER BY id ASC");
			$query->bindValue(':id', (int) trim($id), PDO::PARAM_INT);
			$query->bindValue(':p_onay', (int) trim($p_onay), PDO::PARAM_INT);
			$query->execute();
			if ( $query->rowCount() ){
				foreach( $query as $ama ){
					
				if(empty($ama["p_resim"])){ $paketResim = "./tasarim/resim-yok.jpg"; }
				else{ $paketResim = "./tasarim/resim/".$ama["p_resim"]; }
				?>
				<div class="bg-white shadow-sm p-4">
					<div class="row g-4">
						<div class="col-12 col-md-3 col-lg-3">
							<img class="card-img" width="100%" height="325" src="<?php echo $paketResim; ?>">
						</div>
						<div class="col-12 col-md-9 col-lg-9">
							<div class="px-lg-2">
								<p class="card-title m-0">
									<h2 class="p-0 sigdir"><?php echo $ama["p_baslik"]; ?></h2>
								</p>
								<p class="card-text m-0"><?php echo html_entity_decode($ama["p_aciklama"]); ?></p>
								<div class="mt-3 d-flex justify-content-start align-items-center">
									<div class="d-block">
										<h5 class="fiyat d-inline"><?php echo $ama["p_fiyat"]; ?>₺</h5>
									</div>
									<a class="btn btn-success" target="_blank" href="<?php echo $ama["p_link"]; ?>"><i class="fa fa-shopping-basket"></i> Sipariş Ver</a>
								</div>
							</div>
						</div>
							
					</div>
				</div>
				<?php	
				}
			}
			?>
			</div>
		</div>
<?php	include("_alt.php"); ?>