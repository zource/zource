<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\UI\Navigation\Item;

use InvalidArgumentException;

trait UrlTrait
{
    private function getUrl(array $options)
    {
        if (array_key_exists('route', $options)) {
            $routeParams = empty($options['route_params']) ? [] : $options['route_params'];
            $routeOptions = empty($options['route_options']) ? [] : $options['route_options'];
            $routeReuseMatchedParams = empty($options['route_reuse_matched_params'])
                ? false
                : $options['route_reuse_matched_params'];

            $url = $this->getView()->url($options['route'], $routeParams, $routeOptions, $routeReuseMatchedParams);
        } elseif (array_key_exists('url', $options)) {
            $url = $options['url'];
        } else {
            throw new InvalidArgumentException('The options are missing the "route" or "url" option.');
        }

        return $url;
    }
}
