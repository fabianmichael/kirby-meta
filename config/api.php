<?php

use Kirby\Cms\Response;
use Kirby\Cms\Url;
use Kirby\Http\Header;
use Kirby\Toolkit\Str;

return [
    'routes' => [
        [
            'pattern' => 'meta/check-internal-links',
            'action' => function () {
                $id = get('id');
                $language = get('language');
                $baseUrl = url();

                if (empty($id) === true) {
                    return Response::json("Empty ID parameter.", 500);
                }

                if (kirby()->multilang() && empty($language) === true) {
                    return Response::json("Empty language parameter.", 500);
                }

                $page = kirby()->page($id);

                if ($page === null) {
                    return Response::json("The page with $id could not be found.", 500);
                }

                site()->visit($page, $language);

                // intercept redirects, so the link checker always returns
                // a 200 status code.
                $handleRedirect = function () use ($baseUrl) {
                    if (in_array(http_response_code(), [301, 302, 303, 304, 307])) {
                        $target = '';
                        foreach (headers_list() as $header) {
                            if (Str::contains($header, ':') === false) {
                                continue;
                            }

                            list($key, $value) = explode(':', $header, 2);

                            if (strtolower($key) === 'location') {
                                $target = str_replace($baseUrl, '', trim($value));

                                break;
                            }
                        }

                        header_remove('location');
                        Header::success();
                        echo Response::json([
                            'type' => 'redirect',
                            'message' => "Links where not checked, because page is a redirect to:\n{$target}",
                        ], 200);
                    }
                };
                header_register_callback($handleRedirect);
                register_shutdown_function($handleRedirect);

                $html = kirby()->impersonate('nobody', fn () => $page->render());

                $brokenLinks = [];

                try {
                    $doc = new DOMDocument();
                    $doc->validateOnParse = true;
                    libxml_use_internal_errors(true);
                    $doc->loadHTML($html);
                    libxml_clear_errors();

                    $elements = array_merge(
                        iterator_to_array($doc->getElementsByTagName('a')),
                    );

                    foreach ($elements as $item) {
                        $href = $item->getAttribute('href');

                        if (empty($href) === true || $href === '#') {
                            continue;
                        }

                        if (Str::contains($href, '#') === true) {
                            // anchor link

                            list($targetUrl, $targetId) = explode('#', $href);

                            if (empty($targetUrl) === true || $targetUrl === $page->url()) {
                                $targetEl = $doc->getElementById($targetId);
                            } else {
                                // only evaluate same-page anchor links for now.
                                continue;
                            }

                            if ($targetEl === null) {
                                // broken anchor link
                                $brokenLinks[] = "Broken anchor link: <code>{$href}</code>";
                            }

                            continue;
                        } else {
                            if (Str::startsWith($href, '/')) {
                                $href = $baseUrl . $href;
                            }

                            if (Str::startsWith($href, $baseUrl) === false) {
                                // skip external links
                                continue;
                            }

                            if (Str::contains(pathinfo($href, PATHINFO_BASENAME), '.')) {
                                // skip links to files
                                continue;
                            }

                            $path = trim(parse_url($href, PHP_URL_PATH), '/');

                            if (empty($path) === true) {
                                // skip links to homepage
                                continue;
                            }

                            if (kirby()->router()->call($path) === null) {
                                // target page does not exist
                                $brokenLinks[] = "Link to non-existant page: <code>" . Url::short($href) . "</code>";
                            }
                        }
                    }
                } catch (Exception $e) {
                    return Response::json([
                        'type' => 'page',
                        'message' => $e->getMessage(),
                    ], 500);
                }

                return Response::json([
                    'type' => 'page',
                    'message' => sizeof($brokenLinks) > 0 ? "This page contains broken links:" : null,
                    'brokenLinks' => $brokenLinks,
                ], 200);
            },
        ],
    ],
];
