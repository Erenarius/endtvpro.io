<?php
	//SIFRELEME
	function sifrele( $obj ){
	 return base64_encode(gzcompress(serialize($obj)));
	}
	function sifrecoz($txt){
	 return unserialize(gzuncompress(base64_decode($txt)));
	}

	//SEF_LINK
	function seo($bas) {
		$bas = str_replace(array("",""), NULL, $bas);
		$bul = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '-');
		$yap = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', ' ');
		$perma = strtolower(str_replace($bul, $yap, $bas));
		$perma = preg_replace("@[^A-Za-z0-9\-_]@i", ' ', $perma);
		$perma = trim(preg_replace('/\s+/',' ', $perma));
		$perma = str_replace(' ', '-', $perma);
		return $perma;
	}

	//SITE DETAY CEKME ISLEMI
	function siteGetir($neistedi){ global $db;
		$secid		=	1;
		$genelsor	=	$db->prepare("SELECT * FROM genel WHERE id = :id");
		$genelsor	->	execute(array("id"=> $secid));
		$genel		=	$genelsor->fetch(PDO::FETCH_ASSOC);
		
		if ($neistedi	== "link")			{ return $genel["link"]; }
		if ($neistedi	== "title")			{ return $genel["title"]; }
		if ($neistedi	== "description")	{ return $genel["description"]; }
		if ($neistedi	== "keywords")		{ return $genel["keywords"]; }
		if ($neistedi	== "analytics")		{ return $genel["analytics"]; }
		if ($neistedi	== "facebook")		{ return $genel["facebook"]; }
		if ($neistedi	== "twitter")		{ return $genel["twitter"]; }
		if ($neistedi	== "instagram")		{ return $genel["instagram"]; }
		if ($neistedi	== "aktif")			{ return $genel["aktif"]; }
	}
	
	//SITE DETAY CEKME ISLEMI
	$sayfaURL	=	basename($_SERVER["SCRIPT_FILENAME"]);
	function title($sayfaURL){ global $db;
	
	
		if($sayfaURL == "index.php"){ 
			return	siteGetir("title"); 
		}
	
		if($sayfaURL == "detay.php"){
			$urunsor=$db->prepare("SELECT * FROM paketler WHERE id = :id");
			$urunsor->execute(array( "id" => sifrecoz($_GET["g"])));
			$urun=$urunsor->fetch(PDO::FETCH_ASSOC);
			
			return	$urun["p_baslik"]." - ".siteGetir("title");
		}
		
		if($sayfaURL == "kategori.php"){
			$urunsor=$db->prepare("SELECT * FROM kategoriler WHERE k_link = :k_link");
			$urunsor->execute(array( "k_link" => $_GET["k_link"]));
			$urun=$urunsor->fetch(PDO::FETCH_ASSOC);
			
			return	$urun["k_baslik"]." - ".siteGetir("title");
		}
		
	}
?>