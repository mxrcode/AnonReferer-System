<?php

namespace MxR\AnonReferrer\XF\BbCode\Renderer;

class Html extends XFCP_Html
{
	public function renderTagUrl(array $children, $option, array $tag, array $options)
	{
		$url = parent::renderTagUrl($children, $option, $tag, $options);
		$xfOptions = \XF::options();
		$visitor_arr = \XF::visitor();
		$mxrlinkfg = \XF::phrase('AnonReferrerGuestLink');

		if ($xfOptions->AnonReferrerActive) {
			$anonreferrer = $xfOptions->AnonReferrerPrefix;
			if ($visitor_arr['user_id'] === 0 && $xfOptions->AnonReferrerHideGuestLink && $xfOptions->AnonReferrerHideGuestLinkInternal) {
				return $mxrlinkfg;
			} else {
				if ($xfOptions->AnonReferrerInternalActive) {
					if ($visitor_arr['user_id'] === 0 && $xfOptions->AnonReferrerHideGuestLink) {
						if ((strpos($url, $xfOptions->boardUrl) !== false)) {
							return str_replace('href="', 'href="' . $anonreferrer, $url);
						} else {
							return $mxrlinkfg;
						}
					} else {
						return str_replace('href="', 'href="' . $anonreferrer, $url);
					}
				} else {
					if ((strpos($url, $xfOptions->boardUrl) !== false)) {
						return $url;
					} else {
						if ($visitor_arr['user_id'] === 0 && $xfOptions->AnonReferrerHideGuestLink) {
							return $mxrlinkfg;
						} else {
							return str_replace('href="', 'href="' . $anonreferrer, $url);
						}
					}
				}
			}
		}
		return $url;
	}
}