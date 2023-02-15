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
		if(!empty($siteurl[1][0])) {
			if (in_array($siteurl[1][0], explode("\n", $xfstt->AnRefWL))) {
				return $url;
			} elseif (in_array($siteurl[1][0], explode("\n", $xfstt->AnRefML))) {
				return str_ireplace($siteurl[1][0], $_SERVER['HTTP_HOST'], $url);
			} else {
				if ($xfstt->AnRefHRlink == true): $url = str_replace(' href="', ' href="' . $xfstt->AnRefPrefix, $url);; endif;
				if ($visitor['user_id'] == 0 && $xfstt->AnRefHGlink): $url = \XF::phrase('AnRefGL'); endif;

			}
		}
		return $url;
	}
}