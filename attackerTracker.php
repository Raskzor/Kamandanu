<?php
	
	date_default_timezone_set("Asia/Jakarta");
	set_time_limit(0);


	track();
	

	function track()
	{
		$d_date = date("d-M-Y h:i:s");
		$visitorIP = getIPVisitor(TRUE);
		$ipAddress = getIPVisitor(FALSE);

		$id_negara = geoIP($ipAddress)[0];
		$provinsi = geoIP($ipAddress)[1];
		$kota = geoIP($ipAddress)[2];


		$info = $d_date." | ".$visitorIP."[".$ipAddress."] | ".$id_negara." | ".$provinsi." | ".$kota ." (".getOS().")";
		tulisReport($info);
	}


	// Modul buat Get IP-> check GEOIP
	// Ambil data Negara | Provinsi | Kota
	// Ambil user Agent -> OS | Browser etc.
	

	function getOS()		// User region , Operation Sistem 
	{
		$user_agent	=	$_SERVER['HTTP_USER_AGENT'];

		return $user_agent;
		
	}

	function tulisReport($info)		// Untuk save ke text file log
	{
		$myfile = fopen("./log/log.txt", "a+")or die("Unable to open file!");
		fwrite($myfile,$info."\r\n");
	}

	

	function getIPVisitor($getHostByAddr)
	{
		foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key)
		{
			if (array_key_exists($key, $_SERVER) === true)
			{
				foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip)
				{
					if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false)
					{
						if ($getHostByAddr === TRUE)
						{
							return getHostByAddr($ip);
						}
						else
						{
							return $ip;
						}
					}
				}
			}
		}
	}


	function geoIP($ip)		// geography IP user
	{				
		

		$cha = curl_init();
		curl_setopt_array($cha, Array(
		CURLOPT_URL => 'https://www.netip.de/search?query='.$ip, // Request web untuk menentukan IP region
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_USERAGENT => "Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/Ferenz Safari/419.3",
		CURLOPT_HEADER => false,
		CURLOPT_REFERER => 'https://www.netip.de/',
		));
		$responsea = curl_exec($cha);	// Untuk exe proses sebelumnya	
		curl_close($cha);



		preg_match('/Country: (.*?) - (.*)&nbsp;/', $responsea , $country);	// Ambil semua data $
		// Ambil dari data web, sesuai dengan IP user 
		preg_match('/State\/Region: (.*?)	<br \/>City: (.*)/', $responsea , $state);

		//print $country[1].$state[1].$state[2];

		return array($country[1],$state[1],$state[2]); // Negara, Provinsi, Kota


	}

?>