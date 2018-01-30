<?php

/**
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 *
 * Mail
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */
namespace OCA\Mail\Model;

class ReplyMessage extends Message {

	public function setSubject($subject) {
		/**
		 * Prevent 'Re: Re:' stacking
		 * The list of abbreviations is taken from
		 * https://en.wikipedia.org/wiki/List_of_email_subject_abbreviations
		 */
		$subjectAbbreviations = array_unique([
			'رد', 'إعادة توجيه', # Arabic
			'回复', '转发',   # Chinese (Simplified)
			'回覆', '轉寄',   # Chinese (Traditional)
			'SV', 'VS',       # Danish
			'Antw', 'Doorst', # Dutch
			'Re', 'Fwd',      # English
			'VL', 'VS',       # Finnish
			'REF', 'TR',      # French
			'AW', 'WG',       # German
			'ΑΠ', 'ΣΧΕΤ', 'ΠΡΘ', # Greek
			'תגובה', 'הועבר', # Hebrew
			'Vá', 'Továbbítás', # Hungarian
			'R', 'RIF', 'I',  # Italian
			'SV', 'FS',       # Icelandic
			'BLS', 'TRS',     # Indonesian
			'SV', 'VS',       # Norwegian
			'SV', 'VB',       # Swedish
			'RE', 'RV',       # Spanish
			'RE', 'ENC',      # Portugese
			'Odp', 'PD',      # Polish
			'YNT', 'İLT'      # Turkish
		]);
		foreach ($subjectAbbreviations as $abbreviation) {
			$upperCaseAbbreviation = mb_strtolower($abbreviation) . ': ';
			$upperCaseSubject = mb_strtolower($subject);
			if (mb_stripos($upperCaseSubject, $upperCaseAbbreviation) === 0) {
				parent::setSubject($subject);
				return;
			}
		}
		parent::setSubject("Re: $subject");
	}

}
