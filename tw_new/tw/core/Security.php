<?php
/**
 * 安全类
 */
defined('BASEPATH') OR exit('禁止访问！');

class TW_Security {

	
	public function __construct() {
		// XML外部实体注入漏洞(XML External Entity Injection，简称 XXE)防范
		libxml_disable_entity_loader(true);
	}

	public function xss_clean($m_str) {
		if (is_array($m_str)) {
			$a_key = array_keys($m_str);
			foreach ($a_key as $s_key)	{
				$m_str[$s_key] = $this->xss_clean($m_str[$s_key]);
			}
			return $m_str;
		}

		$m_str = htmlspecialchars($m_str, ENT_NOQUOTES);

		return $m_str;
	}
}
