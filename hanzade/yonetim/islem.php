<?php 
include("../xcn_baglanti/baglan.php");
include("../xcn_baglanti/fonk.php");
require 'class.upload.php';
ob_start();
session_start();


	if(isset($_COOKIE['scriptindirnet_satisscriptv1'])){
		$sifrecozulmus = sifrecoz($_COOKIE['scriptindirnet_satisscriptv1']);
		$cozulmusArray = explode('+', $sifrecozulmus);
		$girisyapan 	= $cozulmusArray[0];
	}

/****************************************************/


	if (isset($_POST['oturumacgiris'])) {
		$kulladi	= $_POST['kul_mail'];
		$sifre 		= $_POST['kul_sifre'];
		
			if( ($kulladi == "") or ($sifre == "") ){
				echo '{"sonuc":"bos"}';
			}else{
				$uyeler = $db->prepare("select * from kullanicilar where kulladi=? and sifre=?");
				$uyeler->execute(array($kulladi, $sifre));
				$islem = $uyeler->fetch();
					if($islem){
						$sifrelenmis = sifrele($kulladi."+1");
						setcookie("scriptindirnet_satisscriptv1",$sifrelenmis, time()+60*60*24*365, "/"); 
						echo '{"sonuc":"tamam"}';
						exit;
					}else{echo '{"sonuc":"yanlis"}';}
			}
		exit;
	}
	
	if (isset($_POST['siteAyar'])) {
		$title			= htmlspecialchars($_POST['title']);
		$description	= htmlspecialchars($_POST['description']);
		$keywords		= htmlspecialchars($_POST['keywords']);
		$analytics		= htmlspecialchars($_POST['analytics']);
		$facebook		= htmlspecialchars($_POST['facebook']);
		$twitter		= htmlspecialchars($_POST['twitter']);
		$instagram		= htmlspecialchars($_POST['instagram']);
		$aktif 			= htmlspecialchars($_POST['aktif']);
		$id 			= 1;

			if(empty($title) || empty($description) || !isset($aktif)) {
				echo '{"sonuc":"bos"}';
				exit;
			}
			elseif(!is_numeric($aktif)) {
				echo '{"sonuc":"kurnaz"}';
				exit;
			}
			else{
				$query = $db->prepare("UPDATE genel SET 
					title			= :title, 
					description		= :description, 
					keywords		= :keywords, 
					analytics 		= :analytics, 
					facebook 		= :facebook, 
					twitter 		= :twitter, 
					instagram 		= :instagram, 
					aktif			= :aktif 
					WHERE id		= :id"
				);
				$insert = $query->execute(array(
					"title" 		=> $title,
					"description" 	=> $description,
					"keywords" 		=> $keywords,
					"analytics"		=> $analytics,
					"facebook"		=> $facebook,
					"twitter"		=> $twitter,
					"instagram"		=> $instagram,
					"aktif" 		=> $aktif,
					"id" 			=> $id
				));
					//HICBIR SORUN YOKSA KAYDET
					if ($insert){echo '{"sonuc":"tamam"}'; exit; }
					else{echo '{"sonuc":"yanlis"}';}
			}
		exit;
	}



/****************************************************/

	
	if (isset($_POST['paketekle'])) {
		$p_baslik	= htmlspecialchars($_POST['paketadi']);
		$p_fiyat	= htmlspecialchars($_POST['paketfiyati']);
		$p_link		= htmlspecialchars($_POST['paketlink']);
		$p_kategori	= htmlspecialchars($_POST['paketkategori']);
		$p_onay 	= htmlspecialchars($_POST['paketdurum']);
		$p_aciklama = htmlspecialchars(trim($_POST['paketicerigi']));
		$resimAdi	= seo($p_baslik);
		
		$varmi = $db->prepare("select * from paketler where p_baslik = ? AND p_fiyat = ? ");
		$varmi->execute(array($p_baslik, $p_fiyat));
		
		

			$image = new \Verot\Upload\Upload($_FILES['files']);
			if ( $image->uploaded ) {
				$image->file_new_name_body = $resimAdi;
				$image->image_convert = 'jpg';
				$image->allowed = array ( 'image/*' );
				$image->Process('../tasarim/resim/');
				$resimYolu = $image->file_dst_name;
				if ( $image->processed ){$resimOk = 1;} 
				else {$resimOk = 0;}
			}
		
		
		
			if ( $resimOk != 1 ){
				echo '{"sonuc":"resimHata"}';
			}
			elseif ( $varmi->rowCount() ){
				echo '{"sonuc":"zatenVar"}';
				exit;
			}
			elseif(empty($p_kategori) ) {
				echo '{"sonuc":"kategoriSec"}';
				exit;
			}
			elseif(!is_numeric($p_onay) || !is_numeric($p_kategori)) {
				echo '{"sonuc":"kurnaz"}';
				exit;
			}
			elseif(	(!isset($p_baslik)) ){
				echo '{"sonuc":"bos"}';
				exit;
			}
			else{
				$query = $db->prepare("INSERT INTO paketler SET 
					p_baslik	= :p_baslik, 
					p_fiyat 	= :p_fiyat, 
					p_resim		= :p_resim, 
					p_aciklama 	= :p_aciklama, 
					p_link 		= :p_link, 
					p_kategori 	= :p_kategori, 
					p_onay		= :p_onay"
				);
				$insert = $query->execute(array(
					"p_baslik" 		=> $p_baslik,
					"p_fiyat" 		=> $p_fiyat,
					"p_resim" 		=> $resimYolu,
					"p_aciklama"	=> $p_aciklama,
					"p_link" 		=> $p_link,
					"p_kategori" 	=> $p_kategori,
					"p_onay" 		=> $p_onay
				));
					//HICBIR SORUN YOKSA IHALE DETAYLARINI KAYDET
					if ($insert){echo '{"sonuc":"tamam"}'; exit; }
					else{echo '{"sonuc":"yanlis"}';}
			}
		exit;
	}
	
	if (isset($_POST['paketDuzenle'])) {
		$p_baslik	= htmlspecialchars($_POST['paketadi']);
		$p_fiyat	= htmlspecialchars($_POST['paketfiyati']);
		$p_link		= htmlspecialchars($_POST['paketlink']);
		$p_kategori	= htmlspecialchars($_POST['paketkategori']);
		$p_onay 	= htmlspecialchars($_POST['paketdurum']);
		$p_aciklama = htmlspecialchars(trim($_POST['paketicerigi']));
		$id 		= sifrecoz(htmlspecialchars($_POST['paketDuzenle']));
		$resimAdi	= seo($p_baslik);
		
		//TEKLI VERI VERI CEKIMI
		$urunsor=$db->prepare("SELECT * FROM paketler WHERE id IN (:id)");
		$urunsor->execute(array(":id" => $id));
		$urun=$urunsor->fetch(PDO::FETCH_ASSOC);
		//YENI RESIM YUKLMEDIYSE AYNI RESMI KULLANSIN
		if ($_FILES['files']['name'] != null){
			$image = new \Verot\Upload\Upload($_FILES['files']);
			if ( $image->uploaded ) {
				$image->file_new_name_body = $resimAdi;
				$image->image_convert = 'jpg';
				$image->allowed = array ( 'image/*' );
				$image->Process('../tasarim/resim/');
				$resimYolu = $image->file_dst_name;
				if ( $image->processed ){$resimOk = 1;} 
				else {$resimOk = 0;}
			}
		}else{$resimYolu = $urun["p_resim"];}
			


			if ( !isset($resimYolu) ){
				echo '{"sonuc":"resimHata"}';
			}
			

			elseif(empty($p_baslik) || empty($p_fiyat) || empty($p_link) || empty($p_aciklama) || !isset($p_onay)) {
				echo '{"sonuc":"bos"}';
				exit;
			}
			elseif(!is_numeric($p_onay) || !is_numeric($p_kategori)) {
				echo '{"sonuc":"kurnaz"}';
				exit;
			}
			else{
				$query = $db->prepare("UPDATE paketler SET 
					p_baslik	= :p_baslik, 
					p_fiyat		= :p_fiyat, 
					p_resim		= :p_resim, 
					p_link		= :p_link, 
					p_aciklama 	= :p_aciklama, 
					p_kategori 	= :p_kategori, 
					p_onay		= :p_onay 
					WHERE id	= :id"
				);
				$insert = $query->execute(array(
					"p_baslik" 		=> $p_baslik,
					"p_fiyat" 		=> $p_fiyat,
					"p_resim" 		=> $resimYolu,
					"p_link" 		=> $p_link,
					"p_aciklama"	=> $p_aciklama,
					"p_kategori"	=> $p_kategori,
					"p_onay" 		=> $p_onay,
					"id" 			=> $id
				));
					//HICBIR SORUN YOKSA KAYDET
					if ($insert){echo '{"sonuc":"tamam"}'; exit; }
					else{echo '{"sonuc":"yanlis"}';}
			}
		exit;
	}


/****************************************************/

	
	if (isset($_POST['kategoriekle'])) {
		$k_baslik	= htmlspecialchars($_POST['kategoriadi']);
		$k_onay 	= htmlspecialchars($_POST['kategoridurum']);
		$k_sabit	= htmlspecialchars($_POST['kategorisabit']);
		$k_link		= seo($k_baslik);


		$varmi = $db->prepare("select * from kategoriler where k_baslik = ? AND k_link = ? ");
		$varmi->execute(array($k_baslik, $k_link));

			if ( $varmi->rowCount() ){
				echo '{"sonucKAT":"zatenVar"}';
				exit;
			}
			elseif(!is_numeric($k_onay) || !is_numeric($k_sabit)) {
				echo '{"sonucKAT":"kurnaz"}';
				exit;
			}
			elseif(	(!isset($k_baslik)) ){
				echo '{"sonucKAT":"bos"}';
				exit;
			}
			else{
				$query = $db->prepare("INSERT INTO kategoriler SET 
					k_baslik	= :k_baslik, 
					k_link		= :k_link, 
					k_sabit 	= :k_sabit, 
					k_onay		= :k_onay"
				);
				$insert = $query->execute(array(
					"k_baslik" 		=> $k_baslik,
					"k_link" 		=> $k_link,
					"k_sabit"		=> $k_sabit,
					"k_onay" 		=> $k_onay
				));
					//HICBIR SORUN YOKSA KAYDET
					if ($insert){echo '{"sonucKAT":"tamam"}'; exit; }
					else{echo '{"sonucKAT":"yanlis"}';}
			}
		exit;
	}

	if (isset($_POST['kategoriDuzenle'])) {
		$k_baslik	= htmlspecialchars($_POST['kategoriadi']);
		$k_onay 	= htmlspecialchars($_POST['kategoridurum']);
		$k_sabit	= htmlspecialchars($_POST['kategorisabit']);
		$k_link		= seo($k_baslik);
		$id 		= sifrecoz(htmlspecialchars($_POST['kategoriDuzenle']));

		$varmi = $db->prepare("select * from kategoriler where k_baslik = ? AND k_link = ? AND id NOT IN (?)");
		$varmi->execute(array($k_baslik, $k_link, $id));

			if ( $varmi->rowCount() ){
				echo '{"sonuc":"zatenVar"}';
				exit;
			}
			elseif(!isset($k_baslik) || !isset($k_onay) || !isset($k_sabit)) {
				echo '{"sonuc":"bos"}';
				exit;
			}
			elseif(!is_numeric($k_onay) || !is_numeric($k_sabit)) {
				echo '{"sonuc":"kurnaz"}';
				exit;
			}
			else{
				$query = $db->prepare("UPDATE kategoriler SET 
					k_baslik	= :k_baslik, 
					k_link		= :k_link, 
					k_sabit 	= :k_sabit, 
					k_onay		= :k_onay
					WHERE id	= :id"
				);
				$insert = $query->execute(array(
					"k_baslik" 		=> $k_baslik,
					"k_link" 		=> $k_link,
					"k_sabit"		=> $k_sabit,
					"k_onay" 		=> $k_onay,
					"id" 			=> $id
				));
					//HICBIR SORUN YOKSA KAYDET
					if ($insert){echo '{"sonuc":"tamam"}'; exit; }
					else{echo '{"sonuc":"yanlis"}';}
			}
		exit;
	}


/****************************************************/
?>