<?php
/******************************************************************************************\
 *
 *    Name [Nama]             : rAiDeoWX
 *    Description [Deskripsi] :
 *       PHP script to retrieve data from Radionomy's API (Radionomy.com).
 *       [Script PHP untuk mengambil data dari API Radionomy (Radionomy.com).]
 *    Version [Versi]         : 0.0.7
 *    Language [Bahasa]       : English [Bahasa Indonesia]
 *    Author [Pembuat]        : adisp007 (Adi Sucipta Pratama)
 *    Site [Situs]            : http://code.adisp007.com
 *    License [Lisensi]       : MIT License
 *    http://www.opensource.org/licenses/mit-license.php
 *    Copyright (c) 2012 Adi Sucipta Pratama | Hak Cipta (c) 2012 Adi Sucipta Pratama
 *
\******************************************************************************************/
      /*                                              *\
      |  Required Configurations [Konfigurasi Wajib]   |
      \*                                              */
/* Your Radio UID - Find it in http://rmo.radionomy.com [UID Radio Anda - Temukan itu di http://rmo.radionomy.com] */
$radiouid = '';
/* Your API Key - Find it in http://rmo.radionomy.com [Kunci API Anda - Temukan itu di http://rmo.radionomy.com] */
$apikey = '';
   /* <<< ?menu= playlist */
/* Your RMO Email - For log in to RMO [Email RMO Anda - Untuk masuk ke RMO] */
$login = '';
/* Your RMO Password - For log in to RMO [Kata Sandi RMO Anda - Untuk masuk ke RMO] */
$password = '';
   /* ?menu= playlist >>> */
      /*       *\
      |         |
      \*       */
      /*                                                 *\
      |  Optional Configurations [Konfigurasi Tambahan]   |
      \*                                                 */
/* Data Type [Tipe Data] */
$type = 'xml'; // string/xml | !isset: string | Default: xml
   /* <<< ?menu= tracklist toptracks currentsong */
/* Cover Picture URL [URL Gambar Cover] */
$cover = 'yes'; // no/yes | !isset: no | Default: yes | $type = xml
/* Default Cover Picture URL [URL Gambar Cover Baku] */
$defaultcover = 'yes'; // no/yes | !isset: no | Default: yes | $type = xml
   /* ?menu= tracklist toptracks currentsong >>> */
   /* <<< ?menu= tracklist toptracks */
/* The Number Of Tracks [Jumlah Lagu] */
/* &amount=1 | $amount = '1'; | 1-50 | !isset: 1 | Default: 1 */
   /* ?menu= tracklist toptracks >>> */
   /* <<< ?menu= toptracks */
/* The Number Of Days [Jumlah Hari] */
$days = '7'; // 1-7 | !isset: 1 | Default: 7
   /* ?menu= toptracks >>> */
   /* <<< ?menu= currentsong */
/* Current Track Duration [Durasi Lagu Sekarang] */
$callmeback = 'yes'; // no/yes | !isset: no | Default: yes
/* Previous Track [Lagu Sebelumnya] */
$previous = 'yes'; // no/yes | !isset: no | Default: yes | $type = xml
   /* ?menu= currentsong >>> */
   /* <<< ?menu= playlist */
/* Playlist Date [Tanggal Daftar Putar] */
$playlistdate = date('Y-m-d'); // 'YYYY-mm-dd' | !isset: today | Default: date('Y-m-d')/today |
   /* ?menu= playlist >>> */
/* Language [Bahasa] */
$language = 'id'; // en/id | !isset: en | Default: id
      /*       *\
      |         |
      \*       */
      /*                   *\
      |  Language [Bahasa]  |
      \*                   */
/* Check $language [Cek $language] */
if (empty($language) || !preg_match('/^[a-z]{2}$/', $language)) $language = 'en';
if ($language == 'id') {
   define('LANG_UIDAPI', '<strong>Kesalahan 1</strong>: $radiouid atau $apikey tidak mempunyai nilai!');
   define('LANG_TYPE', '<strong>Kesalahan 2</strong>: Nilai $type harus string atau xml!');
   define('LANG_COVER', '<strong>Kesalahan 3</strong>: Nilai $cover harus no atau yes!');
   define('LANG_DCOVER', '<strong>Kesalahan 4</strong>: Nilai $defaultcover harus no atau yes!');
   define('LANG_AMOUNT', '<strong>Kesalahan 5</strong>: Nilai $amount harus antara 1-50!');
   define('LANG_DAYS', '<strong>Kesalahan 6</strong>: Nilai $days harus antara 1-7!');
   define('LANG_CALLBACK', '<strong>Kesalahan 7</strong>: Nilai $callmeback harus no atau yes!');
   define('LANG_PREV', '<strong>Kesalahan 8</strong>: Nilai $previous harus no atau yes!');
   define('LANG_LOGINPASS', '<strong>Kesalahan 9</strong>: $login atau $password tidak mempunyai nilai!');
   define('LANG_PLSDATE', '<strong>Kesalahan 10</strong>: Nilai $playlistdate tidak dalam format yang benar (TTTT-BB-HH)!');
   define('LANG_FEXIST', '<strong>Kesalahan 11</strong>: Pastikan berkas tembolok ada!');
   define('LANG_FWRITE', '<strong>Kesalahan 12</strong>: Pastikan server diizinkan untuk menulis dalam berkas tembolok!');
   define('LANG_PHP', '<strong>Kesalahan 13</strong>: Dibutuhkan versi PHP >= 5!');
   define('LANG_FOPEN', '<strong>Kesalahan 14</strong>: Pastikan allow_url_fopen diaktifkan!');
   define('LANG_CURL', '<strong>Kesalahan 15</strong>: Pastikan ekstensi cURL diinstal!');
   define('LANG_ERROR', '<strong>Kesalahan 16</strong>: Tidak dapat terhubung ke server API!');
} else {
   define('LANG_UIDAPI', '<strong>Error 1</strong>: $radiouid or $apikey has no value!');
   define('LANG_TYPE', '<strong>Error 2</strong>: $type value must be string or xml!');
   define('LANG_COVER', '<strong>Error 3</strong>: $cover value must be no or yes!');
   define('LANG_DCOVER', '<strong>Error 4</strong>: $defaultcover value must be no or yes!');
   define('LANG_AMOUNT', '<strong>Error 5</strong>: $amount value must be between 1-50!');
   define('LANG_DAYS', '<strong>Error 6</strong>: $days value must be between 1-7!');
   define('LANG_CALLBACK', '<strong>Error 7</strong>: $callmeback value must be no or yes!');
   define('LANG_PREV', '<strong>Error 8</strong>: $previous value must be no or yes!');
   define('LANG_LOGINPASS', '<strong>Error 9</strong>: $login or $password has no value!');
   define('LANG_PLSDATE', '<strong>Error 10</strong>: $playlistdate value is not in right format (YYYY-MM-DD)!');
   define('LANG_FEXIST', '<strong>Error 11</strong>: Make sure cache file exists!');
   define('LANG_FWRITE', '<strong>Error 12</strong>: Make sure server is allowed to write on cache file!');
   define('LANG_PHP', '<strong>Error 13</strong>: Required PHP version >= 5!');
   define('LANG_FOPEN', '<strong>Error 14</strong>: Make sure allow_url_fopen is turned on!');
   define('LANG_CURL', '<strong>Error 15</strong>: Make sure cURL extension is installed!');
   define('LANG_ERROR', '<strong>Error 16</strong>: Can not connect to API server!');
}
      /*       *\
      |         |
      \*       */
      /*                                                                         *\
      |  Don't edit, unless you really know what you're doing!                    |
      |  [Jangan diedit, kecuali jika anda sungguh tahu apa yang anda lakukan!]   |
      \*                                                                         */
/* Radionomy API URL [URL API Radionomy] */
$radionomyAPI = 'http://api.radionomy.com/'; // http://www.example.com/ | !isset: http://api.radionomy.com/ | Default: http://api.radionomy.com/
/* Remote Type [Tipe Remote] */
$via = 'curl'; // curl/fopen | !isset: curl | Default: curl
/* API Menu [Menu API] */
$menu = $_GET['menu']; // ?menu=
$apiMenu = array('currentaudience', 'radionews', 'currentsong', 'tracklist', 'toptracks', 'playlist'); // http://board.radionomy.com/index.php?/topic/13764-documentation-list-of-apis/
$noYes = array('no', 'yes');
if (empty($menu) || !in_array($menu, $apiMenu)) header('Location: ' . $_SERVER['SCRIPT_NAME'] . '?menu=currentsong');
/* Cache Folder [Folder Tembolok] */
$cacheDir = 'cache/'; // folder/ | !isset: cache/ | Default: cache/
/* Cache File [Berkas Tembolok] */
$cacheFile = $cacheDir . $menu . '.dat';
/* Check $radiouid & $apikey [Cek $radiouid & $apikey] */
if (empty($radiouid) || empty($apikey)) die(LANG_UIDAPI);
/* Check $type [Cek $tipe] */
if (isset($type)) {
   if (!in_array($type, array('string', 'xml'))) die(LANG_TYPE);
   $typeURL = '&type=' . $type;
} else {
   $typeURL = '';
}
/* Check $cover & $defaultcover [Cek $cover & $defaultcover] */
if (isset($cover) && !empty($type) && $type == 'xml' && in_array($menu, array('currentsong', 'tracklist', 'toptracks'))) {
   if (!in_array($cover, $noYes)) die(LANG_COVER);
   $coverURL = '&cover=' . $cover;
   if (isset($defaultcover)) {
      if (!in_array($defaultcover, $noYes)) die(LANG_DCOVER);
      $defaultcoverURL = '&defaultcover=' . $defaultcover;
   } else {
      $defaultcoverURL = '';
   }
} else {
   $coverURL = '';
   $defaultcoverURL = '';
}
/* Check $amount [Cek $amount] */
if (in_array($menu, array('tracklist', 'toptracks'))) {
   $amount = intval($_GET['amount']);
   if (empty($amount)) header('Location: ' . $_SERVER['SCRIPT_NAME'] . '?menu=' . $menu . '&amount=1');
   if ($amount <= 0 || $amount > 50) die(LANG_AMOUNT);
   $amountURL = '&amount=' . $amount;
} else {
   $amountURL = '';
}
/* Check $days [Cek $days] */
if (isset($days) && $menu == 'toptracks') {
   $intDays = intval($days);
   if ($intDays <= 0 || $intDays > 7) die(LANG_DAYS);
   $daysURL = '&days=' . $intDays;
} else {
   $daysURL = '';
}
/* Check $callmeback & $previous [Cek $callmeback & $previous] */
if ($menu == 'currentsong') {
   if (isset($callmeback)) {
      if (!in_array($callmeback, $noYes)) die(LANG_CALLBACK);
      $callmebackURL = '&callmeback=' . $callmeback;
   } else {
      $callmebackURL = '';
   }
   if (isset($previous) && !empty($type) && $type == 'xml') {
      if (!in_array($previous, $noYes)) die(LANG_PREV);
      $previousURL = '&previous=' . $previous;
   } else {
      $previousURL = '';
   }
} else {
   $callmebackURL = '';
   $previousURL = '';
}
/* Check $playlistdate $login $password [Cek $playlistdate $login $password] */
if ($menu == 'playlist') {
   if (!empty($login) && !empty($password)) {
      $loginURL = '&login=' . urlencode($login);
      $passwordURL = '&password=' . $password;
   } else {
      die(LANG_LOGINPASS);
   }
   if (isset($playlistdate)) {
      if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $playlistdate)) die(LANG_PLSDATE);
      $playlistdateURL = '&playlistdate=' . $playlistdate;
   } else {
      $playlistdateURL = '';
   }
} else {
   $loginURL = '';
   $passwordURL = '';
   $playlistdateURL = '';
}
/* Check $radionomyAPI [Cek $radionomyAPI] */
if (empty($radionomyAPI)) $radionomyAPI = 'http://api.radionomy.com/';
/* Check $cacheDir [Cek $cacheDir] */
if (empty($cacheDir)) $cacheDir = 'cache/';
/* Check $cacheFile [Cek $cacheFile] */
if (!file_exists($cacheFile)) die(LANG_FEXIST);
if (!is_writeable($cacheFile)) die(LANG_FWRITE);
/* Full API URL [URL API Lengkap] */
$dataURL = $radionomyAPI . $menu . '.cfm?radiouid=' . $radiouid . '&apikey=' . $apikey . $typeURL . $coverURL . $defaultcoverURL . $amountURL . $daysURL . $callmebackURL . $previousURL . $loginURL . $passwordURL . $playlistdateURL;
/* Check PHP Version [Cek Versi PHP] */
$vphp = str_replace('.', '', phpversion());
if ($vphp < 500) die(LANG_PHP); // @file_put_contents @simplexml_load_file = PHP 5
/* Define Cache File Expire Time [Definisikan Masa Berlaku Berkas Tembolok] */
if ($menu == 'currentsong' && !empty($callmeback) && $callmeback == 'yes' && file_get_contents($cacheFile) != '') {
   if (!empty($type) && $type == 'xml') {
      $dataCallBack = simplexml_load_file($cacheFile);
      $data2Arr = (array) $dataCallBack;
      $trackArr = $data2Arr['track'];
      $countTrack = count($trackArr);
      $currentTrack = end($trackArr);
      $callBack = ($countTrack > 3) ? $currentTrack : $currentTrack->callmeback;
   } else {
      $dataCallBack = file_get_contents($cacheFile);
      $data2Arr = explode(',', $dataCallBack);
      $callBack = $data2Arr[0];
   }
   $convertTime = round($callBack / 1000);
   $expire = ($convertTime < 60) ? time() - 60 : time() - $convertTime;
} else if (in_array($menu, array('radionews', 'playlist', 'toptracks'))) {
   $expire = time() - (24 * 60 * 60);
} else {
   $expire = time() - (5 * 60);
}
/* Retrieve Data [Ambil Data] */
if (file_get_contents($cacheFile) == '' || $expire > filemtime($cacheFile)) {
   touch($cacheFile);
   if (empty($via)) $via = 'curl';
   if ($via == 'fopen') {
      if (!ini_get('allow_url_fopen')) die(LANG_FOPEN);
      $remote = stream_context_create(array('http' => array('timeout' => 30)));
      $data = file_get_contents($dataURL, 0, $remote);
   } else {
      if (!function_exists('curl_version')) die(LANG_CURL);
      function remote($url) {
         $curl = curl_init();
         $timeout = 30;
         curl_setopt($curl, CURLOPT_URL, $url);
         curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
         $remote = curl_exec($curl);
         curl_close($curl);
         return $remote;
      }
      $data = remote($dataURL);
   }
   if ($data) {
      file_put_contents($cacheFile, $data);
   } else {
      die(LANG_ERROR);
   }
   echo file_get_contents($cacheFile);
} else {
   echo file_get_contents($cacheFile);
}
      /*                                               *\
      |  BlueFish Editor http://bluefish.openoffice.nl  |
      \*                                               */
?>