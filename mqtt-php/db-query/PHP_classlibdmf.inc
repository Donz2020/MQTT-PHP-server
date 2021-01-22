<?php
class classLIBDMF
{
	public 	$cLingua = "";
	
	private $sHError = null;
	private $sHErrorParent;
	private $stDayLabel = array(
	 'IT'	=> array(1=>"Luned&#xEC;", 2=>"Marted&#xEC;", 3=>"Mercoled&#xEC;", 4=>"Gioved&#xEC;", 5=>"Venerd&#xEC;", 6=>"Sabato", 7=>"Domenica"),
	 'EN'	=> array(1=>"Monday", 2=>"Tuesday", 3=>"Wednesday", 4=>"Thursday", 5=>"Friday", 6=>"Saturday", 7=>"Sunday"),
	);
	private $stMonthLabel = array(
	 'IT'	=> array(1=>"Gennaio", 2=>"Febbraio", 3=>"Marzo", 4=>"Aprile", 5=>"Maggio", 6=>"Giugno", 7=>"Luglio", 8=>"Agosto", 9=>"Settembre", 10=>"Ottobre", 11=>"Novembre", 12=>"Dicembre"),
	 'EN'	=> array(1=>"January", 2=>"February", 3=>"March", 4=>"April", 5=>"May", 6=>"June", 7=>"July", 8=>"August", 9=>"September", 10=>"October", 11=>"November", 12=>"December"),
	);
	
	public function __construct($sHerr)
	{
		$this->sHErrorParent = $sHerr;
		$this->sHError = new classPXError();
	}
	
	public	function __destruct()
	{
		unset($this->sHErrorParent);
		unset($this->sHError);
		unset($this->cLingua);
		unset($this->stDayLabel);
		unset($this->stMonthLabel);
	}
	
	public function fchar_libDMF_N2DT($lData, $cFormato)
	{	$cReturn = "";
		if ($lData===null) {
			$stCurrentDate = getdate();
			$cReturn = $this->fchar_libDMF_DMY2DT($cFormato, $stCurrentDate["mday"], $stCurrentDate["mon"], $stCurrentDate["year"]);
			unset($stCurrentDate);
		} else
		if ($lData > 0) {
			$lData -= 693961;
			for ($sYear=1900; $lData>=366; $sYear++) {
				$lData -= 365;
				if (strftime ("%d", mktime (0,0,0,3,0,$sYear)) == '29')
					$lData--;
			}
			if ($lData==0) {
				$sYear--;
				$lData += 365;
				if (strftime ("%d", mktime (0,0,0,3,0,$sYear)) == '29')
					$lData++;
			}
			for ($sMonth=1; $lData>28 && $sMonth<=12; $sMonth++) {
				$sDay = 0;
				switch ($sMonth) {
				case 1: case 3: case 5: case 7: case 8: case 10: case 12: $sDay = 31; break;
				case 2:
					$sDay = 28;
					if (strftime ("%d", mktime (0,0,0,3,0,$sYear)) == '29')
						$sDay++;
					break;
				case 4: case 6: case 9: case 11: $sDay = 30; break;
				}
				if ($lData > $sDay)
					$lData -= $sDay;
				else
					break;
			}
			$sDay = $lData;
			$cReturn = $this->fchar_libDMF_DMY2DT($cFormato, $sDay, $sMonth, $sYear);
		}
		$this->sHErrorParent->fvoid_Error_Xfer ($this->sHError, __FUNCTION__);
		return $cReturn;
	}
	
	public function fchar_libDMF_N2TM($lTime, $cFormato)
	{	$cReturn = "";
		if ($lTime===null) {
			$stCurrentTime = getdate();
			$cReturn = $this->fchar_libDMF_HMS2TM($cFormato, $stCurrentTime["hours"], $stCurrentTime["minutes"], $stCurrentTime["seconds"]);
			unset($stCurrentTime);
		} else
		if ($lTime > 0) {
			$lTime--;
			$sHour = floor($lTime/3600);
			$sMinute = floor(($lTime-($sHour*3600)) / 60);
			$sSecond = $lTime-($sHour*3600)-($sMinute*60);
			$cReturn = $this->fchar_libDMF_HMS2TM($cFormato, $sHour, $sMinute, $sSecond);
		}
		$this->sHErrorParent->fvoid_Error_Xfer ($this->sHError, __FUNCTION__);
		return $cReturn;
	}

	public function fint_libDMF_DT2N($cData)
	{	
		$lReturn = null;
		$sHDBE = new classDBEngine($GLOBALS['sHERROR']);
		$sHDBE->bNN_MANAGEMENT = 0;	// disattivo automatismo per sostituire i NULL con il dato vuoto
		$sHDBE->fvoid_DBE_SetPromptFromArray(array("TX_DATA_STR" => $GLOBALS['sHlibDev']->fchar_libDEV_EncodeSQL("CV", $cData)));
		$stOutDati = array();
		if ($sHDBE->fshort_DBEngine("~SYS.DMF.DATAS2DATAN", $stOutDati) == DBE_RETURN_OK && count($stOutDati) > 0)
			$lReturn = $stOutDati[0]['TX_DATA_SMK'];
		unset($stOutDati);
		unset($sHDBE);
		return($lReturn);
	}
	
	public function fint_libDMF_TM2N($cTime)
	{
		$lReturn = null;
		$sHDBE = new classDBEngine($GLOBALS['sHERROR']);
		$sHDBE->bNN_MANAGEMENT = 0;	// disattivo automatismo per sostituire i NULL con il dato vuoto
		$sHDBE->fvoid_DBE_SetPromptFromArray(array("TX_ORA_STR" => $GLOBALS['sHlibDev']->fchar_libDEV_EncodeSQL("CV", $cTime)));
		$stOutDati = array();
		if ($sHDBE->fshort_DBEngine("~SYS.DMF.ORAS2ORAN", $stOutDati) == DBE_RETURN_OK && count($stOutDati) > 0)
			$lReturn = $stOutDati[0]['TX_ORA_SMK'];
		unset($stOutDati);
		unset($sHDBE);
		return($lReturn);
	}
	
	public function fchar_libDMF_N2S($rValue, $cDecimalSep, $cFormato)
	{	switch ($cDecimalSep) {
		case ',': $cThousandSep = '.'; break;
		case '.': $cThousandSep = ','; break;
		default: $cDecimalSep = ','; $cThousandSep = '.'; break;
		}
		$cReturn = "";
		$bReturn = true;
		$rInt = floor ( abs($rValue) );
		if (strlen($rInt) > strlen($cFormato))
			$bReturn = false;
		else {
			$cFormatoParz = strtok ( $cFormato, $cDecimalSep );
			if ($cFormatoParz === false)
				$cFormatoParz = $cFormato;
			if (strchr($cFormatoParz, $cThousandSep) !== false)
				$cValue = number_format($rInt, 0, $cDecimalSep, $cThousandSep);
			else
				$cValue = (string)$rInt;
			$cValue = str_pad($cValue, strlen($cFormatoParz), "0", STR_PAD_LEFT);
			$bZeroSign = false;
			for ($sIdx=0; $sIdx<strlen($cFormatoParz); $sIdx++) {
				$cChrForm = substr($cFormatoParz, $sIdx, 1);
				$cChrValue = substr($cValue, $sIdx, 1);
				if ($cChrValue != '0')
					$bZeroSign = true;
				switch ($cChrForm)
				{
				case '+': break;
				case '-': break;
				case '9':
					if ($bZeroSign != false)
						$cReturn .= $cChrValue;
					break;
				case '0': $cReturn .= $cChrValue; break;
				case $cDecimalSep:
				case $cThousandSep:
					if ($bZeroSign != false)
						$cReturn .= $cChrValue;
					break;
				default: $bReturn = false; /*SWP_FML_BAD_CHAR;*/ break;
				}
			}
			if (strlen($cFormatoParz) > strlen($cReturn))
				$cReturn = str_pad($cReturn, strlen($cFormatoParz), " ", STR_PAD_LEFT);
			if ($bReturn) {
				$sSegno = 0; // 0: senza segno; 1: + davanti; 2: + dietro; 3: - davanti; 4: - dietro
				switch (substr($cFormato, 0, 1))
				{
				case '+': $sSegno = 1; break;
				case '-': $sSegno = 3; break;
				}
				switch (substr($cFormato, -1, 1))
				{
				case '+': $sSegno = 2; break;
				case '-': $sSegno = 4; break;
				}
				$cSegno = "";
				if ($sSegno > 0) {
					if ($rValue < 0.0)
						$cSegno = "-";
					else {
						if ($rValue > 0.0)
							$cSegno = ($sSegno == 1 || $sSegno == 2) ? "+" : " ";
					}
				}
			}
			if ($bReturn) {
				$cFormatoParz = strchr( $cFormato, $cDecimalSep );
				if ($cFormatoParz !== false) {
					$sLen = strlen($cFormatoParz)-1;
					if ($sSegno == 2 || $sSegno == 4)
						$sLen--;
					$cFormatoParz = substr($cFormatoParz, 1, $sLen);
					if ($rValue < 0.0)
						$rInt *= -1;
					$rDiff = $rValue - $rInt;
					$rDiff = round($rDiff, 6);
					$rDiff = abs($rDiff);
					$cValue = (string)$rDiff;
					$cValue = substr($cValue, 2); // tolgo "0."
					$cValue = str_pad($cValue, $sLen, "0", STR_PAD_RIGHT);
					$bZeroSign = false;
					$cDec = "";
					for ($sIdx=strlen($cFormatoParz)-1; $sIdx>=0 && $bReturn; $sIdx--) {
						$cChrForm = substr($cFormatoParz, $sIdx, 1);
						$cChrValue = substr($cValue, $sIdx, 1);
						if ($cChrValue != '0')
							$bZeroSign = true;
						switch ($cChrForm) {
						case '9':
							if ($bZeroSign != false)
								$cDec = $cChrValue.$cDec;
							break;
						case '0': $cDec = $cChrValue.$cDec; break;
						default: $bReturn = false; break;
						}
					}
					if (strlen($cDec) > 0) {
						if (strlen(trim($cReturn)) == 0)
							$cReturn = "0";
						$cReturn .= $cDecimalSep.$cDec;
					}
				}
			}
			if ($bReturn) {
				switch ($sSegno) {
				case 1: case 3: $cReturn = $cSegno.$cReturn; break;
				case 2: case 4: $cReturn .= $cSegno; break;
				}
			}
		}
		if (!$bReturn)
			$this->sHError->fvoid_Error_Set (__FUNCTION__, ERROR_LIB_DMF_BADFORMAT, "", ERROR_LEVEL_ERROR, ERROR_CODE_LIB);
		$this->sHErrorParent->fvoid_Error_Xfer ($this->sHError, __FUNCTION__);
		return $cReturn;
	}
	
	public function fint_libDMF_N2DataPart($lData, $cTipoPart)
	{
		$lDataPart = 0;
		if ($this->fbool_libDMF_Check(__FUNCTION__, $lData, $cTipoPart)) {
			if ($lData <= 719529)
				$timestamp = 1;
			else {
				$timestamp = (($lData - 719529) * 86400);
				if ($timestamp > 2147483647)
					$timestamp = 2147483647;
			}
			$cStringa = date("d", $timestamp);
			$sDay = (integer)$cStringa;
			$cStringa = date("m", $timestamp);
			$sMonth = (integer)$cStringa;
			$cStringa = date("Y", $timestamp);
			$sYear = (integer)$cStringa;
			switch ($cTipoPart) {
			case 'A': $lDataPart = $sYear; break;	// A=anno
			case 'M': $lDataPart = $sMonth; break;	// M=mese
			case 'G': $lDataPart = $sDay; break;	// G=giorno
			case 'AM': $lDataPart = ($sYear * 100) + $sMonth; break;	// AM=annomese
			case 'MG': $lDataPart = ($sMonth * 100) + $sDay; break;	// MG=mesegiorno
			case 'DY':	// DY=day of year
				$cStringa = date("z", $timestamp);
				$lDataPart = (integer)$cStringa;
				$lDataPart++;
				break;
			case 'DW':	// DW=weekday
				$cStringa = date("w", $timestamp);
				$lDataPart = (integer)$cStringa;
				if ($lDataPart == 0)
					$lDataPart = 7;
				break;
			case 'WY':	// WY=week of year
				/* da scrivere */
				break;
			}
		}
		$this->sHErrorParent->fvoid_Error_Xfer ($this->sHError, __FUNCTION__);
		return ($lDataPart);
	}
	
	public function fint_libDMF_aammgg2N($sYear, $sMonth, $sDay)
	{
		$timestamp = mktime(0, 0, 0, $sMonth, $sDay, $sYear);
		$lData = ($timestamp / 86400) +  719529;
		$GLOBALS['sHlibMath']->fbool_libMATH_Arrotonda($lData, 1, LIBMATH_ARROT_INTERO, LIBMATH_ARROT_GIUSTO);
		return ($lData);
	}
	
	private function fchar_libDMF_DMY2DT($cFormato, $sDay, $sMonth, $sYear)
	{
		$cReturn = "";
		$bReturn = true;
		for ($uiIdx=0; $uiIdx<strlen($cFormato) && $bReturn; $uiIdx++) {
			$cChr = $cFormato[$uiIdx];
			switch ($cChr) {
			case 'D': case 'd': case 'G': case 'g':
				$cFormatoPart = "";
				if ($this->fbool_libDMF_DatePart($cFormato, $cChr, $uiIdx, $cFormatoPart)) {
					switch (strlen($cFormatoPart)) {
					case 2:
						if ($sDay < 10)
							$cReturn .= "0";
					case 1: $cReturn .= $sDay; break;
					case 3: case 4:
						$cID = date ("w", mktime (0,0,0,$sMonth,$sDay,$sYear));
						if ($cID == 0)
							$cID = "7";
						if (isset($this->stDayLabel[$this->cLingua][$cID]) ) {
							$cDatePart = $this->stDayLabel[$this->cLingua][$cID];
							$cReturn .= (strlen($cFormatoPart) == 3) ? substr($cDatePart, 0, 3) : $cDatePart;
						} else {
							$this->sHError->fvoid_Error_Set (__FUNCTION__, ERROR_LIB_DMF_BADDAY, "", ERROR_LEVEL_ERROR, ERROR_CODE_LIB);
							$bReturn = false;
						}
						break;
					}
				} else
					$bReturn = false;
				break;
			case 'M': case 'm':
				$cFormatoPart = "";
				if ($this->fbool_libDMF_DatePart($cFormato, $cChr, $uiIdx, $cFormatoPart)) {
					switch (strlen($cFormatoPart)) {
					case 2:
						if ($sMonth < 10)
							$cReturn .= "0";
					case 1: $cReturn .= $sMonth; break;
					case 3: case 4:
						if (isset($this->stMonthLabel[$this->cLingua][$sMonth]) ) {
							$cDatePart = $this->stMonthLabel[$this->cLingua][$sMonth];
							$cReturn .= (strlen($cFormatoPart) == 3) ? substr($cDatePart, 0, 3) : $cDatePart;
						} else {
							$this->sHError->fvoid_Error_Set (__FUNCTION__, ERROR_LIB_DMF_BADMONTH, "", ERROR_LEVEL_ERROR, ERROR_CODE_LIB);
							$bReturn = false;
						}
						break;
					}
				} else
					$bReturn = false;
				break;
			case 'Y': case 'y': case 'A': case 'a':
				$cFormatoPart = "";
				if ($this->fbool_libDMF_DatePart($cFormato, $cChr, $uiIdx, $cFormatoPart)) {
					switch (strlen($cFormatoPart)) {
					case 1: case 4: $cReturn .= $sYear; break;
					case 2: $cReturn .= substr($sYear, -2); break;
					}
				} else
					$bReturn = false;
				break;
//			case '(': case '[': case '{': $uiIdx = strlen($cFormato); break;
			default: $cReturn .= $cChr;
			}
		}
		if (!$bReturn)
			$cReturn = str_repeat("*", strlen($cFormato));
		return $cReturn;
	}
	
	private function fbool_libDMF_DatePart($cFormato, $cTypePart, &$uiIdx, &$cDatePart=null)
	{
		$bReturn = true;
		$cDatePart = "";
		for (; $uiIdx<strlen($cFormato) && strcasecmp(substr($cFormato, $uiIdx, 1), $cTypePart) == 0; $uiIdx++)
			$cDatePart .= substr($cFormato, $uiIdx, 1);
		if ($uiIdx<strlen($cFormato) && strcasecmp(substr($cFormato, $uiIdx, 1), $cTypePart) != 0)
			$uiIdx--;
		switch (strlen($cDatePart)) {
		case 0: case 1: case 2: case 4: break;
		case 3:
			if ($cTypePart != 'Y' && $cTypePart != 'y' && $cTypePart != 'A' && $cTypePart != 'a')
				break;
		default:
			$this->sHError->fvoid_Error_Set (__FUNCTION__, ERROR_LIB_DMF_BADFORMAT, "", ERROR_LEVEL_ERROR, ERROR_CODE_LIB);
			$cReturn = false;
		}
		return $bReturn;
	}
	
	private function fchar_libDMF_HMS2TM($cFormato, $sHour, $sMinute, $sSecond)
	{
		$cReturn = "";
		$bReturn = true;
		$sSize = strlen($cFormato);
		for ($uiIdx=0, $sCount=0, $cChrPrec=""; $uiIdx<=$sSize && $bReturn; $uiIdx++) {
			$cChr = ($uiIdx<$sSize) ? strtoupper($cFormato[$uiIdx]) : null;
			if ($cChr===null || strcmp($cChrPrec, $cChr) != 0) {
				switch ($cChrPrec)
				{
				case 'H':
					if ($sCount == 2)
						$cReturn .= str_pad($sHour, 2, "0", STR_PAD_LEFT);
					else
						$bReturn = false;
					break;
				case 'M':
					if ($sCount == 2)
						$cReturn .= str_pad($sMinute, 2, "0", STR_PAD_LEFT);
					elseif ($sCount == 4)
						$cReturn .= str_pad(($sMinute + ($sHour *24)), 4, "0", STR_PAD_LEFT);
					else
						$bReturn = false;
					break;
				case 'S':
					if ($sCount == 2)
						$cReturn .= str_pad($sSecond, 2, "0", STR_PAD_LEFT);
					elseif ($sCount == 5)
						$cReturn .= str_pad(($sSecond + ($sMinute * 60) + ($sHour * 24)), 5, "0", STR_PAD_LEFT);
					else
						$bReturn = false;
					break;
				}
				$cChrPrec = $cChr;
				$sCount = 0;
			}
			if ($cChr!==null) {
				switch ($cChr)
				{
				case 'H': case 'M': case 'S': $sCount++; break;
				case '0': case '9': case '-': case '+': $bReturn = false; break;
				default: $cReturn .= $cChr; break;
				}
			}
		}
		if (!$bReturn) {
			$cReturn = str_repeat("*", $sSize);
			$this->sHError->fvoid_Error_Set (__FUNCTION__, ERROR_LIB_DMF_BADFORMAT, "", ERROR_LEVEL_ERROR, ERROR_CODE_LIB);
		}
		return $cReturn;
	}

	public function fint_libDMF_hhmmss2N($sHour, $sMinute, $sSecond)
	{
		$lOra = ($sHour*3600) + ($sMinute*60) + $sSecond + 1;
		return ($lOra);
	}
	
	public function fint_libDMF_N2TimePart($lTime, $cTipoPart)
	{
		$lTimePart = 0;
		if ($this->fbool_libDMF_Check(__FUNCTION__, $lTime, $cTipoPart)) {
			$lTime--;
			$sHour = floor($lTime/3600);
			$sMinute = floor(($lTime-($sHour*3600)) / 60);
			$sSecond = $lTime-($sHour*3600)-($sMinute*60);
			switch ($cTipoPart) {
			case 'H': $lTimePart = $sHour; break;
			case 'M': $lTimePart = $sMinute; break;
			case 'S': $lTimePart = $sSecond; break;
			}
		}
		$this->sHErrorParent->fvoid_Error_Xfer ($this->sHError, __FUNCTION__);
		return ($lTimePart);
	}
	
	public function freal_libDMF_dttm2N($lData, $lTime)
	{
		$rReturn = 0.0;
		if ($lData!==null && $lTime!==null) {
			$rReturn = $lData.".".str_pad($lTime,5,'0',STR_PAD_LEFT);
			settype($rReturn, "float");
		}
		$this->sHErrorParent->fvoid_Error_Xfer ($this->sHError, __FUNCTION__);
		return $rReturn;
	}
	
	public function fchar_libDMF_N2DTM($rDataOra, $cFormato)
	{
		$cReturn = "";
		if ($rDataOra===null) {
			$stCurrentTime = getdate();
			$cReturn = $this->fchar_libDMF_DMY2DT($cFormato, $stCurrentDate["mday"], $stCurrentDate["mon"], $stCurrentDate["year"]);
			$cReturn = $this->fchar_libDMF_HMS2TM($cReturn, $stCurrentTime["hours"], $stCurrentTime["minutes"], $stCurrentTime["seconds"]);
			unset($stCurrentTime);
		} else
		if ($rDataOra > 0.0) {
			$lData = floor($rDataOra);
			$lTime = floor(($rDataOra-$lData)*100000);
			if ($lTime > 0) {
				$lTime--;
				$sHour = floor($lTime/3600);
				$sMinute = floor(($lTime-($sHour*3600)) / 60);
				$sSecond = $lTime-($sHour*3600)-($sMinute*60);
			} else
				$sHour = $sMinute = $sSecond = 0;
			// Parsing formato ora
			$sSize = strlen($cFormato);
			for ($uiIdx=0, $sCount=0, $cChrPrec=""; $uiIdx<=$sSize; $uiIdx++) {
				$cChr = ($uiIdx<$sSize) ? $cFormato[$uiIdx] : null;
				if ($cChr===null || strcmp($cChrPrec, $cChr) != 0) {
					switch ($cChrPrec)
					{	case 'H':
							if ($sCount == 2)
								$cReturn .= str_pad($sHour, 2, "0", STR_PAD_LEFT);
							break;
						case 'm':
							if ($sCount == 2)
								$cReturn .= str_pad($sMinute, 2, "0", STR_PAD_LEFT);
							elseif ($sCount == 4)
								$cReturn .= str_pad(($sMinute + ($sHour *24)), 4, "0", STR_PAD_LEFT);
							break;
						case 'S':
							if ($sCount == 2)
								$cReturn .= str_pad($sSecond, 2, "0", STR_PAD_LEFT);
							elseif ($sCount == 5)
								$cReturn .= str_pad(($sSecond + ($sMinute * 60) + ($sHour * 24)), 5, "0", STR_PAD_LEFT);
							break;
					}
					$cChrPrec = $cChr;
					$sCount = 0;
				}
				if ($cChr!==null) {
					switch ($cChr)
					{	case 'H': case 'm': case 'S': $sCount++; break;
						default: $cReturn .= $cChr; break;
					}
				}
			}
//			$cReturn = $this->fchar_libDMF_N2TM($lTime, $cFormato);
			$cReturn = $this->fchar_libDMF_N2DT($lData, $cReturn);
		}
		$this->sHErrorParent->fvoid_Error_Xfer ($this->sHError, __FUNCTION__);
		return $cReturn;
	}
	private function fbool_libDMF_Check($cMetodo, $cParam1=null, $cParam2=null)
	{
		$bReturn = true;
		switch ($cMetodo) {
		case "fint_libDMF_N2DataPart":
			if ($cParam1 == null || $cParam1 <= 0)
				$bReturn = false;
			else {
				switch ($cParam2) {
				case 'A': case 'M': case 'G': case 'AM': case 'MG': case 'DY': case 'DW': case 'WY': break;
				default: $bReturn = false;
				}
			}
			break;
		case "fint_libDMF_N2TimePart":
			if ($cParam1 == null || $cParam1 <= 0)
				$bReturn = false;
			else {
				switch ($cParam2) {
				case 'H': case 'M': case 'S': break;
				default: $bReturn = false;
				}
			}
			break;
		}
		if (!$bReturn)
			$this->sHError->fvoid_Error_Set (__FUNCTION__, ERROR_PHP_DEVELOP, $cMetodo);
		return($bReturn);
	}
}
?>
