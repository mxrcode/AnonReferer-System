<?php

namespace MxR\AnonReferrer\XF\BbCode\Renderer;

class Html extends XFCP_Html
{
	public function renderTagUrl(array $children, $option, array $tag, array $options)
	{
		$url = parent::renderTagUrl($children, $option, $tag, $options);
		$xfstt = \XF::options();
		$visitor = \XF::visitor();

		preg_match_all('|//(.*?)/|is', $url, $siteurl);
		if (in_array($siteurl[1][0], explode("\n", $xfstt->AnRefWL))) {
			return $url;
		} else {
			$url = str_replace('href="', 'href="' . $xfstt->AnRefPrefix, $url);
			if ($visitor['user_id'] == 0 && $xfstt->AnRefHGlink): $url = \XF::phrase('AnRefGL'); endif;
		}
		return $url;
	}
}