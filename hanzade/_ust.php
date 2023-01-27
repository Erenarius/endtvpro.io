<?php	include("xcn_baglanti/baglan.php");
		include("xcn_baglanti/fonk.php");
		if(siteGetir("aktif") != 1){ header("HTTP/1.0 403 Forbidden"); exit; }
	?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title><?php echo title($sayfaURL); ?></title>
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"><!-- Bootstrap core CSS -->
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><!-- SITE GENEL YAZI FONTU-->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><!-- SITE GENEL YAZI FONTU-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" /><!-- ANIMATE -->
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/> <!-- ICON-SET -->
	
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="<?php echo siteGetir("link"); ?>tasarim/duzen.css?v=<?php echo strtotime(date("d.m.Y H:i:s")); ?>">
  </head>
  <body class="customDuzen">
	<header class="py-3 px-lg-5 border-bottom tepeMenu bg-white">
		<div class="container-fluid d-flex flex-wrap justify-content-center">
			<a href="<?php echo siteGetir("link"); ?>" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
				<span class="fs-3 navbar-brand anarenkYazi"><?php echo siteGetir("title"); ?></span>
			</a>
		</div>
	</header>
	<div class="nav-scroller anarenkArka border-bottom shadow-sm px-lg-5 tepeMenu">
		<nav class="nav nav-underline py-2">
			<a class="nav-links text-uppercase active" aria-current="page" href="<?php echo siteGetir("link"); ?>">Ana Sayfa</a>
			<?php
			$k_onay		=	1;	
			$k_sabit	=	1;	

			$query = $db->prepare("SELECT * FROM kategoriler WHERE k_onay IN (:k_onay) AND k_sabit IN (:k_sabit) ORDER BY id ASC");
			$query->bindValue(':k_onay', (int) trim($k_onay), PDO::PARAM_INT);
			$query->bindValue(':k_sabit', (int) trim($k_sabit), PDO::PARAM_INT);
			$query->execute();
			if ( $query->rowCount() ){
				foreach( $query as $ama ){
				?>
					<a class="nav-links text-uppercase" href="<?php echo siteGetir("link"); ?>kategori/<?php echo $ama["k_link"]; ?>"><?php echo $ama["k_baslik"]; ?></a>
				<?php	
				}
			}
			?>
		</nav>
	</div>

