<?php

namespace MxR\AnonReferrer\XF\BbCode\Renderer;

class Html extends XFCP_Html
{
	public function renderTagUrl(array $children, $option, array $tag, array $options)
	{
		$url = parent::renderTagUrl($children, $option, $tag, $options);
		$xfstt = \XF::options();
		$vstr = \XF::visitor();

		/*  # Old version, regular expression didn't find domain without ' / ' at the end

			preg_match_all('|//(.*?)/|is', $url, $siteurl);

			if(!empty($siteurl[1][0])) {
				if (in_array($siteurl[1][0], explode("\n", $xfstt->AnRefWL))) {
					return $url;
				} elseif (in_array($siteurl[1][0], explode("\n", $xfstt->AnRefML))) {
					return str_ireplace($siteurl[1][0], $_SERVER['HTTP_HOST'], $url);
				} else {
					if ($xfstt->AnRefHRlink == true): $url = str_replace(' href="', ' href="' . $xfstt->AnRefPrefix, $url);; endif;
					if ($vstr['user_id'] == 0 && $xfstt->AnRefHGlink): $url = \XF::phrase('AnRefGL'); endif;

				}
			} 
		*/

		preg_match('<a href="(.*?)">', $url, $match);

		if(!empty($match)) {
			$domain = parse_url($match[1], PHP_URL_HOST);

			if (in_array($domain, explode("\n", $xfstt->AnRefWL))) {
				return $url;
			} elseif (in_array($domain, explode("\n", $xfstt->AnRefML))) {
				return str_ireplace($domain, $_SERVER['HTTP_HOST'], $url);
			} else {
				if ($xfstt->AnRefHRlink == true): $url = str_replace(' href="', ' href="' . $xfstt->AnRefPrefix, $url);; endif;
				if ($vstr['user_id'] == 0 && $xfstt->AnRefHGlink): $url = \XF::phrase('AnRefGL'); endif;

			}
		}

		return $url;
	}
}