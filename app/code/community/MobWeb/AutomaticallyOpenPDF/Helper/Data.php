<?php

class MobWeb_AutomaticallyOpenPDF_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getJavascriptPopupScript($url)
	{
		return sprintf('<script>window.onload = function() { window.location = "%s"; };</script>', $url);
	}
}