<?php

namespace MxR\AnonReferrer\XF\BbCode\Renderer;

class Html extends XFCP_Html
{
	public function renderTagUrl(array $children, $option, array $tag, array $options)
	{
		$url = parent::renderTagUrl($children, $option, $tag, $options);
		$options = \XF::options();
		$visitor = \XF::visitor();

		preg_match('/<a href="(.*?)">/i', $url, $matches);

		if (!empty($matches)) {
			$domain = parse_url($matches[1], PHP_URL_HOST);

			if (in_array($domain, explode("\n", $options->AnRefWL))) {
				return $url;
			} elseif (in_array($domain, explode("\n", $options->AnRefML))) {
				return str_ireplace($domain, $_SERVER['HTTP_HOST'], $url);
			} else {
				if ($options->AnRefHRlink) {
					$url = str_replace(' href="', ' href="' . $options->AnRefPrefix, $url);
				}
				if ($visitor['user_id'] == 0 && $options->AnRefHGlink) {
					$url = \XF::phrase('AnRefGL');
				}
			}
		}

		return $url;
	}
}