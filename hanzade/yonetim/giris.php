<?php	include("../xcn_baglanti/baglan.php");
		include("../xcn_baglanti/fonk.php");
		
		if(isset($_COOKIE['scriptindirnet_satisscriptv1'])){
			header("location:index.php");
		}
		?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Site Yönetim ve Kontrol Paneli</title>
    <!-- CSS files -->
    <link href="./dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="./dist/css/demo.min.css" rel="stylesheet"/>
	
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	</head>
	<body  class="d-flex flex-column">
		<div class="page page-center">
			<div class="container-tight mt-4 py-4">
				<form class="card card-md" id="girisFormu" onsubmit="return false">
					<div class="card-body">
						<h2 class="card-title text-center mb-4">Yönetim Paneli</h2>
						<div class="mb-3">
							<label class="form-label">Kullanıcı Adı</label>
							<input type="text" name="kul_mail" class="form-control" placeholder="Kullanıcı Adı">
						</div>
						<div class="mb-2">
							<label class="form-label">Şifre</label>
							<div class="input-group input-group-flat">
								<input type="password" name="kul_sifre" class="form-control" placeholder="Şifre"  autocomplete="off">
							</div>
						</div>
						
						<div id="gizlenmis" style="display:none;" class="mt-3 my-1 alert">
							<a id="sonuc"></a>
						</div>
						<input type="hidden" name="oturumacgiris" value="oturumacgiris">
						<div class="form-footer">
							<input type="submit" name="sub1" class="btn btn-primary w-100 oturumAc" value="Giriş Yap">
						</div>
					</div>
				</form>
			</div>
		</div>
		<script type="text/javascript">
			$(function(){
				$(".oturumAc").on("click", function () {         
					$.ajax({
						type:"POST",
						url:"islem.php",
						data: $('#girisFormu').serialize(),
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
								document.getElementById("sonuc").innerHTML="<b>Giriş yapıldı.</b> Yönlendiriliyorsun..";
								setTimeout(function(){ window.location=""; }, 2800);
							};
							if (deger=="bos") {
								$("#sonuc").text("Lütfen tüm alanları doldurun!")
							};
							if (deger=="yanlis") {
								$("#sonuc").text("Girdiğiniz bilgiler hatalı!")
							};
						}
					});
				});
			});
		</script>
	</body>
</html>