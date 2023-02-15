<?php

namespace MxR\AnonReferrer\XF\BbCode\Renderer;

class Html extends XFCP_Html
{
    public function renderTagUrl(array $children, $option, array $tag, array $options)
    {
        $url = parent::renderTagUrl($children, $option, $tag, $options);
        $xf_options = \XF::options();
        $visitor = \XF::visitor();
        
        // Extract the domain from the URL using parse_url function
        $url_parts = parse_url($url);
        $domain = $url_parts['host'] ?? '';
        
        if (!empty($domain)) {
            if (in_array($domain, explode("\n", $xf_options->AnRefWL))) {
                return $url;
            } elseif (in_array($domain, explode("\n", $xf_options->AnRefML))) {
                return str_ireplace($domain, $_SERVER['HTTP_HOST'], $url);
            } else {
                if ($xf_options->AnRefHRlink): $url = str_replace(' href="', ' href="' . $xf_options->AnRefPrefix, $url); endif;
                if ($visitor['user_id'] == 0 && $xf_options->AnRefHGlink): $url = \XF::phrase('AnRefGL'); endif;
            }
        }

        return $url;
    }
}