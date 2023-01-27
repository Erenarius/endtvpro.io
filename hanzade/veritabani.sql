-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 15 Oca 2022, 18:14:25
-- Sunucu sürümü: 10.5.13-MariaDB
-- PHP Sürümü: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `kazandi6_am5`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `genel`
--

CREATE TABLE `genel` (
  `id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `title` varchar(52) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `description` varchar(252) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `keywords` varchar(252) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `analytics` varchar(15) NOT NULL,
  `eposta` varchar(35) NOT NULL,
  `telefon` varchar(15) NOT NULL,
  `adres` varchar(100) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `logo` varchar(150) NOT NULL,
  `facebook` varchar(52) NOT NULL,
  `twitter` varchar(52) NOT NULL,
  `instagram` varchar(52) NOT NULL,
  `aktif` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `genel`
--

INSERT INTO `genel` (`id`, `link`, `title`, `description`, `keywords`, `analytics`, `eposta`, `telefon`, `adres`, `logo`, `facebook`, `twitter`, `instagram`, `aktif`) VALUES
(1, 'https://demo.scriptindir.net/hesapsatis/', 'Satış Scripti', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has', 'site_keywordss', 'site_analyticss', 'site_epostaa', 'site_telefonn', 'site_adress', 'https://demo.scriptindir.net/pubg/tasarim/images/logo1.png', 'facebook', 'twitter', 'instagram', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

CREATE TABLE `kategoriler` (
  `id` int(11) NOT NULL,
  `k_baslik` varchar(35) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `k_link` varchar(255) NOT NULL,
  `k_sabit` int(1) NOT NULL,
  `k_onay` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL,
  `kulladi` varchar(23) NOT NULL,
  `sifre` varchar(35) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `kulladi`, `sifre`) VALUES
(1, 'demo', '123456');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `paketler`
--

CREATE TABLE `paketler` (
  `id` int(11) NOT NULL,
  `p_baslik` varchar(52) COLLATE utf8_turkish_ci NOT NULL,
  `p_kategori` int(3) NOT NULL,
  `p_fiyat` varchar(5) COLLATE utf8_turkish_ci NOT NULL,
  `p_aciklama` varchar(1552) COLLATE utf8_turkish_ci NOT NULL,
  `p_resim` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `p_link` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `p_onay` int(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `genel`
--
ALTER TABLE `genel`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kategoriler`
--
ALTER TABLE `kategoriler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `paketler`
--
ALTER TABLE `paketler`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `genel`
--
ALTER TABLE `genel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `kategoriler`
--
ALTER TABLE `kategoriler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `paketler`
--
ALTER TABLE `paketler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
