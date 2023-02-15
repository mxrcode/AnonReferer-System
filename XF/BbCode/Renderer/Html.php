<?php

namespace MxR\AnonReferrer\XF\BbCode\Renderer;

class Html extends XFCP_Html
{
	public function renderTagUrl(array $children, $option, array $tag, array $options)
	{
		$url = parent::renderTagUrl($children, $option, $tag, $options);
		$xfOptions = \XF::options();

		if ($xfOptions->AnonReferrerActive)
		{
			$anonreferrer = $xfOptions->AnonReferrerPrefix;
			if ((strpos($url, $xfOptions->boardUrl) !== false)) {
				return $url;
			} else {
				return str_replace('href="', 'href="' . $anonreferrer, $url);
			}
		}
		
		return $url;
	}
}