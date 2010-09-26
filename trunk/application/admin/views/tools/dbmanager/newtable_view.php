<ul class="btnTabs idTabs">
	<li>
		<a href="#main">Main settings</a>
	</li>	
	<li>
        <a href="#fields">Table fields</a>
    </li>
	<li>
		<a href="#finish">Finish</a>
	</li>
</ul>
<form method="post" action="<? echo site_url();?>/tools/dbmanager/ajax/createtable" >
<input type="hidden" name="project" value="<?php echo $_POST["project"]?>" />
<div id="main">
	<table cellspacing="1" cellpadding="0" border="0" style="width: 100%;">
	    <tbody>
	    	<tr>
	    		<th>
	    			Table name
	    		</th>
	        	<td>
	        		<input type="text" name="tablename" />
				</td>
	    	</tr>
	    	<tr>
	    		<th>
	    			Table squema
	    		</th>
	        	<td>
					<select name="table_type">
					    <option title="Supports transactions, row-level locking, and foreign keys" value="InnoDB">
					        InnoDB
					    </option>
					    <option title="Default engine as of MySQL 3.23 with great performance" value="MyISAM">
					        MyISAM
					    </option>
					    <option title="Hash based, stored in memory, useful for temporary tables" value="MEMORY">
					        MEMORY
					    </option>
					    <option title="/dev/null storage engine (anything you write to it disappears)" value="BLACKHOLE">
					        BLACKHOLE
					    </option>
					</select>				
				</td>
	    	</tr>
	    	<tr>
	    		<th>
	    			Index
	    		</th>
	        	<td>
					<select name="table_collation">
		                <optgroup title="UTF-8 Unicode" label="utf8">
		                	<option selected="selected" title="Unicode (multilingüe), independiente de mayúsculas y minúsculas" value="utf8_general_ci">utf8_general_ci</option>
		                	<option title="Unicode (multilingüe), independiente de mayúsculas y minúsculas" value="utf8_unicode_ci">utf8_unicode_ci</option>
		                    <option title="Unicode (multilingüe),  Binario " value="utf8_bin">utf8_bin</option>
		                    <option title="Checo, independiente de mayúsculas y minúsculas" value="utf8_czech_ci">utf8_czech_ci</option>
		                    <option title="Danés, independiente de mayúsculas y minúsculas" value="utf8_danish_ci">utf8_danish_ci</option>
		                    <option title="Esperanto, independiente de mayúsculas y minúsculas" value="utf8_esperanto_ci">utf8_esperanto_ci</option>
		                    <option title="Estonio, independiente de mayúsculas y minúsculas" value="utf8_estonian_ci">utf8_estonian_ci</option>
		                    <option title="Húngaro, independiente de mayúsculas y minúsculas" value="utf8_hungarian_ci">utf8_hungarian_ci</option>
		                    <option title="Islandés, independiente de mayúsculas y minúsculas" value="utf8_icelandic_ci">utf8_icelandic_ci</option>
		                    <option title="Letón, independiente de mayúsculas y minúsculas" value="utf8_latvian_ci">utf8_latvian_ci</option>
		                    <option title="Lituano, independiente de mayúsculas y minúsculas" value="utf8_lithuanian_ci">utf8_lithuanian_ci</option>
		                    <option title="Persa, independiente de mayúsculas y minúsculas" value="utf8_persian_ci">utf8_persian_ci</option>
		                    <option title="Polaco, independiente de mayúsculas y minúsculas" value="utf8_polish_ci">utf8_polish_ci</option>
		                    <option title="Europea occidental, independiente de mayúsculas y minúsculas" value="utf8_roman_ci">utf8_roman_ci</option>
		                    <option title="Rumano, independiente de mayúsculas y minúsculas" value="utf8_romanian_ci">utf8_romanian_ci</option>
		                    <option title="Eslovaco, independiente de mayúsculas y minúsculas" value="utf8_slovak_ci">utf8_slovak_ci</option>
		                    <option title="Esloveno, independiente de mayúsculas y minúsculas" value="utf8_slovenian_ci">utf8_slovenian_ci</option>
		                    <option title="Español tradicional, independiente de mayúsculas y minúsculas" value="utf8_spanish2_ci">utf8_spanish2_ci</option>
		                    <option title="Español, independiente de mayúsculas y minúsculas" value="utf8_spanish_ci">utf8_spanish_ci</option>
		                    <option title="Sueco, independiente de mayúsculas y minúsculas" value="utf8_swedish_ci">utf8_swedish_ci</option>
		                    <option title="Turco, independiente de mayúsculas y minúsculas" value="utf8_turkish_ci">utf8_turkish_ci</option>
		                </optgroup>
		                <optgroup title="ARMSCII-8 Armenian" label="armscii8">
		                    <option title="Armenio,  Binario " value="armscii8_bin">armscii8_bin</option>
		                    <option title="Armenio, independiente de mayúsculas y minúsculas" value="armscii8_general_ci">armscii8_general_ci</option>
		                </optgroup>
		                <optgroup title="US ASCII" label="ascii">
		                    <option title="Europea occidental (multilingüe),  Binario " value="ascii_bin">ascii_bin</option>
		                    <option title="Europea occidental (multilingüe), independiente de mayúsculas y minúsculas" value="ascii_general_ci">ascii_general_ci</option>
		                </optgroup>
		                <optgroup title="Big5 Traditional Chinese" label="big5">
		                    <option title="Chino tradicional,  Binario " value="big5_bin">big5_bin</option>
		                    <option title="Chino tradicional, independiente de mayúsculas y minúsculas" value="big5_chinese_ci">big5_chinese_ci</option>
		                </optgroup>
		                <optgroup title="Binary pseudo charset" label="binary">
		                    <option title=" Binario " value="binary">binary</option>
		                </optgroup>
		                <optgroup title="Windows Central European" label="cp1250">
		                    <option title="Europeo central (multilingüe),  Binario " value="cp1250_bin">cp1250_bin</option>
		                    <option title="Croata, independiente de mayúsculas y minúsculas" value="cp1250_croatian_ci">cp1250_croatian_ci</option>
		                    <option title="Checo, dependiente de mayúsculas y minúsculas" value="cp1250_czech_cs">cp1250_czech_cs</option>
		                    <option title="Europeo central (multilingüe), independiente de mayúsculas y minúsculas" value="cp1250_general_ci">cp1250_general_ci</option>
		                </optgroup>
		                <optgroup title="Windows Cyrillic" label="cp1251">
		                    <option title="Cirílico (multilingüe),  Binario " value="cp1251_bin">cp1251_bin</option>
		                    <option title="Búlgaro, independiente de mayúsculas y minúsculas" value="cp1251_bulgarian_ci">cp1251_bulgarian_ci</option>
		                    <option title="Cirílico (multilingüe), independiente de mayúsculas y minúsculas" value="cp1251_general_ci">cp1251_general_ci</option>
		                    <option title="Cirílico (multilingüe), dependiente de mayúsculas y minúsculas" value="cp1251_general_cs">cp1251_general_cs</option>
		                    <option title="Ucraniano, independiente de mayúsculas y minúsculas" value="cp1251_ukrainian_ci">cp1251_ukrainian_ci</option>
		                </optgroup>
		                <optgroup title="Windows Arabic" label="cp1256">
		                    <option title="Árabe,  Binario " value="cp1256_bin">cp1256_bin</option>
		                    <option title="Árabe, independiente de mayúsculas y minúsculas" value="cp1256_general_ci">cp1256_general_ci</option>
		                </optgroup>
		                <optgroup title="Windows Baltic" label="cp1257">
		                    <option title="Báltico (multilingüe),  Binario " value="cp1257_bin">cp1257_bin</option>
		                    <option title="Báltico (multilingüe), independiente de mayúsculas y minúsculas" value="cp1257_general_ci">cp1257_general_ci</option>
		                    <option title="Lituano, independiente de mayúsculas y minúsculas" value="cp1257_lithuanian_ci">cp1257_lithuanian_ci</option>
		                </optgroup>
		                <optgroup title="DOS West European" label="cp850">
		                    <option title="Europea occidental (multilingüe),  Binario " value="cp850_bin">cp850_bin</option>
		                    <option title="Europea occidental (multilingüe), independiente de mayúsculas y minúsculas" value="cp850_general_ci">cp850_general_ci</option>
		                </optgroup>
		                <optgroup title="DOS Central European" label="cp852">
		                    <option title="Europeo central (multilingüe),  Binario " value="cp852_bin">cp852_bin</option>
		                    <option title="Europeo central (multilingüe), independiente de mayúsculas y minúsculas" value="cp852_general_ci">cp852_general_ci</option>
		                </optgroup>
		                <optgroup title="DOS Russian" label="cp866">
		                    <option title="Ruso,  Binario " value="cp866_bin">cp866_bin</option>
		                    <option title="Ruso, independiente de mayúsculas y minúsculas" value="cp866_general_ci">cp866_general_ci</option>
		                </optgroup>
		                <optgroup title="SJIS for Windows Japanese" label="cp932">
		                    <option title="Japonés,  Binario " value="cp932_bin">cp932_bin</option>
		                    <option title="Japonés, independiente de mayúsculas y minúsculas" value="cp932_japanese_ci">cp932_japanese_ci</option>
		                </optgroup>
		                <optgroup title="DEC West European" label="dec8">
		                    <option title="Europea occidental (multilingüe),  Binario " value="dec8_bin">dec8_bin</option>
		                    <option title="Sueco, independiente de mayúsculas y minúsculas" value="dec8_swedish_ci">dec8_swedish_ci</option>
		                </optgroup>
		                <optgroup title="UJIS for Windows Japanese" label="eucjpms">
		                    <option title="Japonés,  Binario " value="eucjpms_bin">eucjpms_bin</option>
		                    <option title="Japonés, independiente de mayúsculas y minúsculas" value="eucjpms_japanese_ci">eucjpms_japanese_ci</option>
		                </optgroup>
		                <optgroup title="EUC-KR Korean" label="euckr">
		                    <option title="Coreano,  Binario " value="euckr_bin">euckr_bin</option>
		                    <option title="Coreano, independiente de mayúsculas y minúsculas" value="euckr_korean_ci">euckr_korean_ci</option>
		                </optgroup>
		                <optgroup title="GB2312 Simplified Chinese" label="gb2312">
		                    <option title="Chino simplificado,  Binario " value="gb2312_bin">gb2312_bin</option>
		                    <option title="Chino simplificado, independiente de mayúsculas y minúsculas" value="gb2312_chinese_ci">gb2312_chinese_ci</option>
		                </optgroup>
		                <optgroup title="GBK Simplified Chinese" label="gbk">
		                    <option title="Chino simplificado,  Binario " value="gbk_bin">gbk_bin</option>
		                    <option title="Chino simplificado, independiente de mayúsculas y minúsculas" value="gbk_chinese_ci">gbk_chinese_ci</option>
		                </optgroup>
		                <optgroup title="GEOSTD8 Georgian" label="geostd8">
		                    <option title="Georgiano,  Binario " value="geostd8_bin">geostd8_bin</option>
		                    <option title="Georgiano, independiente de mayúsculas y minúsculas" value="geostd8_general_ci">geostd8_general_ci</option>
		                </optgroup>
		                <optgroup title="ISO 8859-7 Greek" label="greek">
		                    <option title="Griego,  Binario " value="greek_bin">greek_bin</option>
		                    <option title="Griego, independiente de mayúsculas y minúsculas" value="greek_general_ci">greek_general_ci</option>
		                </optgroup>
		                <optgroup title="ISO 8859-8 Hebrew" label="hebrew">
		                    <option title="Hebreo,  Binario " value="hebrew_bin">hebrew_bin</option>
		                    <option title="Hebreo, independiente de mayúsculas y minúsculas" value="hebrew_general_ci">hebrew_general_ci</option>
		                </optgroup>
		                <optgroup title="HP West European" label="hp8">
		                    <option title="Europea occidental (multilingüe),  Binario " value="hp8_bin">hp8_bin</option>
		                    <option title="Inglés, independiente de mayúsculas y minúsculas" value="hp8_english_ci">hp8_english_ci</option>
		                </optgroup>
		                <optgroup title="DOS Kamenicky Czech-Slovak" label="keybcs2">
		                    <option title="Checo-Eslovaco,  Binario " value="keybcs2_bin">keybcs2_bin</option>
		                    <option title="Checo-Eslovaco, independiente de mayúsculas y minúsculas" value="keybcs2_general_ci">keybcs2_general_ci</option>
		                </optgroup>
		                <optgroup title="KOI8-R Relcom Russian" label="koi8r">
		                    <option title="Ruso,  Binario " value="koi8r_bin">koi8r_bin</option>
		                    <option title="Ruso, independiente de mayúsculas y minúsculas" value="koi8r_general_ci">koi8r_general_ci</option>
		                </optgroup>
		                <optgroup title="KOI8-U Ukrainian" label="koi8u">
		                    <option title="Ucraniano,  Binario " value="koi8u_bin">koi8u_bin</option>
		                    <option title="Ucraniano, independiente de mayúsculas y minúsculas" value="koi8u_general_ci">koi8u_general_ci</option>
		                </optgroup>
		                <optgroup title="cp1252 West European" label="latin1">
		                    <option title="Europea occidental (multilingüe),  Binario " value="latin1_bin">latin1_bin</option>
		                    <option title="Danés, independiente de mayúsculas y minúsculas" value="latin1_danish_ci">latin1_danish_ci</option>
		                    <option title="Europea occidental (multilingüe), independiente de mayúsculas y minúsculas" value="latin1_general_ci">latin1_general_ci</option>
		                    <option title="Europea occidental (multilingüe), dependiente de mayúsculas y minúsculas" value="latin1_general_cs">latin1_general_cs</option>
		                    <option title="Alemán (diccionario), independiente de mayúsculas y minúsculas" value="latin1_german1_ci">latin1_german1_ci</option>
		                    <option title="Alemán (directorio telefónico), independiente de mayúsculas y minúsculas" value="latin1_german2_ci">latin1_german2_ci</option>
		                    <option title="Español, independiente de mayúsculas y minúsculas" value="latin1_spanish_ci">latin1_spanish_ci</option>
		                    <option title="Sueco, independiente de mayúsculas y minúsculas" value="latin1_swedish_ci">latin1_swedish_ci</option>
		                </optgroup>
		                <optgroup title="ISO 8859-2 Central European" label="latin2">
		                    <option title="Europeo central (multilingüe),  Binario " value="latin2_bin">latin2_bin</option>
		                    <option title="Croata, independiente de mayúsculas y minúsculas" value="latin2_croatian_ci">latin2_croatian_ci</option>
		                    <option title="Checo, dependiente de mayúsculas y minúsculas" value="latin2_czech_cs">latin2_czech_cs</option>
		                    <option title="Europeo central (multilingüe), independiente de mayúsculas y minúsculas" value="latin2_general_ci">latin2_general_ci</option>
		                    <option title="Húngaro, independiente de mayúsculas y minúsculas" value="latin2_hungarian_ci">latin2_hungarian_ci</option>
		                </optgroup>
		                <optgroup title="ISO 8859-9 Turkish" label="latin5">
		                    <option title="Turco,  Binario " value="latin5_bin">latin5_bin</option>
		                    <option title="Turco, independiente de mayúsculas y minúsculas" value="latin5_turkish_ci">latin5_turkish_ci</option>
		                </optgroup>
		                <optgroup title="ISO 8859-13 Baltic" label="latin7">
		                    <option title="Báltico (multilingüe),  Binario " value="latin7_bin">latin7_bin</option>
		                    <option title="Estonio, dependiente de mayúsculas y minúsculas" value="latin7_estonian_cs">latin7_estonian_cs</option>
		                    <option title="Báltico (multilingüe), independiente de mayúsculas y minúsculas" value="latin7_general_ci">latin7_general_ci</option>
		                    <option title="Báltico (multilingüe), dependiente de mayúsculas y minúsculas" value="latin7_general_cs">latin7_general_cs</option>
		                </optgroup>
		                <optgroup title="Mac Central European" label="macce">
		                    <option title="Europeo central (multilingüe),  Binario " value="macce_bin">macce_bin</option>
		                    <option title="Europeo central (multilingüe), independiente de mayúsculas y minúsculas" value="macce_general_ci">macce_general_ci</option>
		                </optgroup>
		                <optgroup title="Mac West European" label="macroman">
		                    <option title="Europea occidental (multilingüe),  Binario " value="macroman_bin">macroman_bin</option>
		                    <option title="Europea occidental (multilingüe), independiente de mayúsculas y minúsculas" value="macroman_general_ci">macroman_general_ci</option>
		                </optgroup>
		                <optgroup title="Shift-JIS Japanese" label="sjis">
		                    <option title="Japonés,  Binario " value="sjis_bin">sjis_bin</option>
		                    <option title="Japonés, independiente de mayúsculas y minúsculas" value="sjis_japanese_ci">sjis_japanese_ci</option>
		                </optgroup>
		                <optgroup title="7bit Swedish" label="swe7">
		                    <option title="Sueco,  Binario " value="swe7_bin">swe7_bin</option>
		                    <option title="Sueco, independiente de mayúsculas y minúsculas" value="swe7_swedish_ci">swe7_swedish_ci</option>
		                </optgroup>
		                <optgroup title="TIS620 Thai" label="tis620">
		                    <option title="Tailandés,  Binario " value="tis620_bin">tis620_bin</option>
		                    <option title="Tailandés, independiente de mayúsculas y minúsculas" value="tis620_thai_ci">tis620_thai_ci</option>
		                </optgroup>
		                <optgroup title="UCS-2 Unicode" label="ucs2">
		                    <option title="Unicode (multilingüe),  Binario " value="ucs2_bin">ucs2_bin</option>
		                    <option title="Checo, independiente de mayúsculas y minúsculas" value="ucs2_czech_ci">ucs2_czech_ci</option>
		                    <option title="Danés, independiente de mayúsculas y minúsculas" value="ucs2_danish_ci">ucs2_danish_ci</option>
		                    <option title="Esperanto, independiente de mayúsculas y minúsculas" value="ucs2_esperanto_ci">ucs2_esperanto_ci</option>
		                    <option title="Estonio, independiente de mayúsculas y minúsculas" value="ucs2_estonian_ci">ucs2_estonian_ci</option>
		                    <option title="Unicode (multilingüe), independiente de mayúsculas y minúsculas" value="ucs2_general_ci">ucs2_general_ci</option>
		                    <option title="Húngaro, independiente de mayúsculas y minúsculas" value="ucs2_hungarian_ci">ucs2_hungarian_ci</option>
		                    <option title="Islandés, independiente de mayúsculas y minúsculas" value="ucs2_icelandic_ci">ucs2_icelandic_ci</option>
		                    <option title="Letón, independiente de mayúsculas y minúsculas" value="ucs2_latvian_ci">ucs2_latvian_ci</option>
		                    <option title="Lituano, independiente de mayúsculas y minúsculas" value="ucs2_lithuanian_ci">ucs2_lithuanian_ci</option>
		                    <option title="Persa, independiente de mayúsculas y minúsculas" value="ucs2_persian_ci">ucs2_persian_ci</option>
		                    <option title="Polaco, independiente de mayúsculas y minúsculas" value="ucs2_polish_ci">ucs2_polish_ci</option>
		                    <option title="Europea occidental, independiente de mayúsculas y minúsculas" value="ucs2_roman_ci">ucs2_roman_ci</option>
		                    <option title="Rumano, independiente de mayúsculas y minúsculas" value="ucs2_romanian_ci">ucs2_romanian_ci</option>
		                    <option title="Eslovaco, independiente de mayúsculas y minúsculas" value="ucs2_slovak_ci">ucs2_slovak_ci</option>
		                    <option title="Esloveno, independiente de mayúsculas y minúsculas" value="ucs2_slovenian_ci">ucs2_slovenian_ci</option>
		                    <option title="Español tradicional, independiente de mayúsculas y minúsculas" value="ucs2_spanish2_ci">ucs2_spanish2_ci</option>
		                    <option title="Español, independiente de mayúsculas y minúsculas" value="ucs2_spanish_ci">ucs2_spanish_ci</option>
		                    <option title="Sueco, independiente de mayúsculas y minúsculas" value="ucs2_swedish_ci">ucs2_swedish_ci</option>
		                    <option title="Turco, independiente de mayúsculas y minúsculas" value="ucs2_turkish_ci">ucs2_turkish_ci</option>
		                    <option title="Unicode (multilingüe), independiente de mayúsculas y minúsculas" value="ucs2_unicode_ci">ucs2_unicode_ci</option>
		                </optgroup>
		                <optgroup title="EUC-JP Japanese" label="ujis">
		                    <option title="Japonés,  Binario " value="ujis_bin">ujis_bin</option>
		                    <option title="Japonés, independiente de mayúsculas y minúsculas" value="ujis_japanese_ci">ujis_japanese_ci</option>
		                </optgroup>
		            </select>
				</td>
	   		</tr>
	    </tbody>
	</table>
	<div style="text-align:right;">
		<input type="button" class="next" rel="1" value="Next" />
	</div>
</div>
<div id="fields">
	<table cellspacing="1" cellpadding="0" border="0" style="width: 100%;">
	    <tbody>
	    	<tr>
	    		<th>
	    			Field name
	    		</th>
	        	<td>
	        		<input name="fname" type="text" />
				</td>
	    	</tr>
	    	<tr>
	    		<th>
	    			Type
	    		</th>
	        	<td>
					<select name="ftype" style="width:185px">
                        <optgroup title="Numeric" label="Numeric">
                            <option value="TINYINT" rel="Numeric">TINYINT</option>
                            <option value="SMALLINT" rel="Numeric">SMALLINT</option>
                            <option value="MEDIUMINT" rel="Numeric">MEDIUMINT</option>
                            <option value="INT" rel="Numeric">INT</option>
                            <option value="BIGINT" rel="Numeric">BIGINT</option>
                            <option value="DECIMAL" rel="Numeric">DECIMAL</option>
                            <option value="FLOAT" rel="Numeric">FLOAT</option>
                            <option value="DOUBLE" rel="Numeric">DOUBLE</option>
                        </optgroup>
                        <optgroup title="String" label="String">
                            <option value="VARCHAR" rel="String">VARCHAR</option>
                            <option value="TEXT" rel="String">TEXT</option>
                            <option value="ENUM" rel="String">ENUM</option>
                        </optgroup>
                        <optgroup title="Time" label="Time">
                            <option value="TIME" rel="Time">TIME</option>
                            <option value="TIMESTAMP" rel="Time">TIMESTAMP</option>
                        </optgroup>
                        <optgroup title="Date" label="Date">
                            <option value="DATE" rel="Date">DATE</option>
                            <option value="DATETIME" rel="Date">DATETIME</option>
                            <option value="YEAR" rel="Date">YEAR</option>
                        </optgroup>
                        <optgroup title="Other" label="Other">
                            <option value="BLOB" rel="Other">BLOB</option>
                            <option value="BIT" rel="Other">BIT</option>
                            <option value="BOOL" rel="Other">BOOL</option>
                            <option value="BINARY" rel="Other">BINARY</option>
                            <option value="VARBINARY" rel="Other">VARBINARY</option>
                        </optgroup>
				    </select>
				</td>
	    	</tr>
	    	<tr>
	    		<th>
	    			Long
	    		</th>
	        	<td>
	        		<input name="flong" type="text" />
				</td>
	    	</tr>
	    	<tr>
	    		<th>
	    			Default
	    		</th>
	        	<td>
	        		<input name="fdefault" type="text" />
                    <span style="display:none;">
                        <input type="checkbox" class="checkbox" name="fdefault" value="current_timestamp" checked="checked" disabled="disabled" /> Current timestamp
                    </span>
				</td>
	    	</tr>
	    	<tr>
	    		<th>
	    			Attributes
	    		</th>
	        	<td>
					<input type="radio" name="fattr" value="" />None
					<input type="radio" name="fattr" value="unsigned" />Unsigned
					<input type="radio" name="fattr" value="unsigned zerofill" />Unsigned zerofill
					<input type="radio" name="fattr" value="on update current_timestamp" />On update current time stamp
				</td>
	    	</tr>
	    	<tr>
	    		<th>
	    			Null
	    		</th>
	        	<td>
					<input type="radio" name="fnull" value="null" />null
					<input type="radio" name="fnull" value="not null" />not null
				</td>
	    	</tr>
	    	<tr>
	    		<th>
	    			Index
	    		</th>
	        	<td>
	        		<input type="radio" name="findex" value="" />None
					<input type="radio" name="findex" value="primary key" />Primary key
					<input type="radio" name="findex" value="index" />Index
					<input type="radio" name="findex" value="unique" />Unique
				</td>
	   		</tr>
	    	<tr>
	    		<th>
	    			Extra
	    		</th>
	        	<td>
					<input type="checkbox" class="checkbox" value="auto_increment" name="auto_increment" disabled="disabled" />auto increment
				</td>
	   		</tr>
			<tr>
				<td colspan="2">
                    <center>
                        <input type="button" id="reset" value="reset" />
                        <input type="button" id="addfield" value="add"/>
                    </center>
				</td>
			</tr>
	    </tbody>
	</table>
    <code></code>    
	<div style="text-align:right;">
		<input type="button" class="prev" rel="0" value="Prev" />
		<input type="button" class="next" rel="2" value="Next" />
	</div>
</div>
<div id="finish">
    <input type="submit" class="preview" value="Code preview" />
    <pre></pre>
	<div style="text-align:right;">
		<input type="submit" class="submit" value="Create table" />
	</div>
</div>
</form>