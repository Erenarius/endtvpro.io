<?php	include("../xcn_baglanti/baglan.php");
		include("../xcn_baglanti/fonk.php");
		
		if(isset($_COOKIE['scriptindirnet_satisscriptv1'])){
			$sifrecozulmus = sifrecoz($_COOKIE['scriptindirnet_satisscriptv1']);
			$cozulmusArray = explode('+', $sifrecozulmus);
			$girisyapan 	= $cozulmusArray[0];
			$rutbe 			= $cozulmusArray[1];
		}else{header("location:giris.php");}
		?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Site Yönetim ve Kontrol Paneli</title>
    <!-- CSS files -->
    <link href="./dist/libs/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="./dist/css/demo.min.css" rel="stylesheet"/>
    <link href="../tasarim/yduzen.css" rel="stylesheet"/>
	
	<script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  </head>
  <body class="antialiased">
    <div class="page">
      <header class="navbar navbar-expand-md navbar-light d-print-none d-md-none">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
      </header>
      <div class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div class="navbar navbar-light">
            <div class="container-xl">
              <ul class="navbar-nav">
                <li class="nav-item active">
                  <a class="nav-link" href="./index.php" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="5 12 3 12 12 3 21 12 19 12" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                    </span>
                    <span class="nav-link-title">
                      Anasayfa
                    </span>
                  </a>
                </li>
              </ul>
			  
			  <div class="navbar-nav flex-row order-md-last">
				<div class="nav-item dropdown">
				  <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
					<span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span>
					<div class="d-none d-xl-block ps-2">
					  <div><?php echo siteGetir("title"); ?></div>
					  <div class="mt-1 small text-muted">Yönetim Paneli</div>
					</div>
				  </a>
				  <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
					<a href="siteayar.php" class="dropdown-item">Site Ayarları</a>
					<a href="cikis.php" class="dropdown-item">Çıkış</a>
				  </div>
				</div>
			  </div>
			
			</div>
          </div>
		</div>
      </div>