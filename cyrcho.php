<?php /**
* Cyrcho: converts cyrilic to latin using the correct transliteration rules
* 
* based on the work of "Loshia" at {@link http://loshia.com/wp/cyrillic-slugs/}
* @link https://github.com/kktsvetkov/cyrcho/
* @license http://opensource.org/licenses/LGPL-3.0 GNU Lesser General Public License, version 3.0
*/
Class cyrcho 
{

	/**
	* @var array Transliteration map
	*/
	private static $transliteration = array(
		192 => 'a',
		193 => 'b',
		194 => 'v',
		195 => 'g',
		196 => 'd',
		197 => 'e',
		198 => 'zh',
		199 => 'z',
		200 => 'i',
		201 => 'y',
		202 => 'k',
		203 => 'l',
		204 => 'm',
		205 => 'n',
		206 => 'o',
		207 => 'p',
		208 => 'r',
		209 => 's',
		210 => 't',
		211 => 'u',
		212 => 'f',
		213 => 'h',
		214 => 'ts',
		215 => 'tch',
		216 => 'sh',
		217 => 'sht',
		218 => 'a',
		220 => 'y',
		222 => 'yu',
		223 => 'ya',
		224 => 'a',
		225 => 'b',
		226 => 'v',
		227 => 'g',
		228 => 'd',
		229 => 'e',
		230 => 'zh',
		231 => 'z',
		232 => 'i',
		233 => 'y',
		234 => 'k',
		235 => 'l',
		236 => 'm',
		237 => 'n',
		238 => 'o',
		239 => 'p',
		240 => 'r',
		241 => 's',
		242 => 't',
		243 => 'u',
		244 => 'f',
		245 => 'h',
		246 => 'ts',
		247 => 'tch',
		248 => 'sh',
		249 => 'sht',
		250 => 'a',
		252 => 'y',
		254 => 'yu',
		255 => 'ya'
		);

	// -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 
	
	/**
	* Converts the Cyrillic chars to their latin equivalent.
	*
	* @param string $value
	* @return string
	*/
	Public Static Function cyr2lat($value) 
	{
		$string = self::utf2win1251($value);

		$result = '';
		for($i = 0; $i < strlen($string); $i++) 
		{
			if (ord($string[$i]) > 128) 
			{
				$result .= self::$transliteration[ord($string[$i])];
			} else {
				$result .= $string[$i];
			}
		}

		return $result;
	}

	/**
	* Converts a UTF-encoded string into a Win1251-encoded one
	*
	* @param string $string
	* @return string
	*/
	Private Static Function utf2win1251($string) 
	{
		
		$out = '';
		
		for ($i=0; $i<strlen($string); $i++) 
		{
			$c1 = substr ($string, $i, 1);
			$byte1 = ord ($c1);
			
			if ($byte1>>5 == 6) 
			{ /* 110x xxxx, 110 prefix for 2 bytes unicode */
				$i++;
				$c2 = substr ($string, $i, 1);
				$byte2 = ord ($c2);

				$byte1 &= 31; /* remove the 3 bit two bytes prefix */
				$byte2 &= 63; /* remove the 2 bit trailing byte prefix */
				$byte2 |= (($byte1 & 3) << 6); /* last 2 bits of c1 become first 2 of c2 */
				$byte1 >>= 2; /* c1 shifts 2 to the right */
		
				$word = ($byte1<<8) + $byte2;
				if ($word==1025) $out .= chr(168);                    // ?
					elseif ($word==1105) $out .= chr(184);                // ?
					elseif ($word>=0x0410 && $word<=0x044F) $out .= chr($word-848); // ?-? ?-?
					else { 
						$a = dechex($byte1);
						$a = str_pad($a, 2, '0', STR_PAD_LEFT);
						$b = dechex($byte2);
						$b = str_pad($b, 2, '0', STR_PAD_LEFT);
						$out .= "&#x".$a.$b.";";
				}
			} else {
				$out .= $c1;
			}
		}
		return $out;
	}
}
