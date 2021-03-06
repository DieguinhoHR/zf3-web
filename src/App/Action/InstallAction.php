<?php

namespace App\Action;

use App\Model\Release;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template;

class InstallAction implements MiddlewareInterface
{
    /** @var Release */
    private $release;

    /** @var Template\TemplateRendererInterface */
    private $template;

    public function __construct(Release $release, Template\TemplateRendererInterface $template)
    {
        $this->release  = $release;
        $this->template = $template;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $page = $request->getAttribute('page', false);

        if (false === $page) {
            $url = 'https://raw.githubusercontent.com/zendframework/zendframework/master/composer.json';
            $composer = file_get_contents($url);
            if (false !== $composer) {
                $composer = json_decode($composer, true);
            }
            return new HtmlResponse($this->template->render('app::install', [
                'require'     => $composer['require'],
                'composerUrl' => $url,
            ]));
        }

        if (! in_array($page, ['skeleton-app', 'expressive', 'archives'], true)) {
            return new HtmlResponse($this->template->render('error::404'));
        }

        if ($page === 'archives') {
            return new HtmlResponse($this->template->render(sprintf('app::%s', $page), ['releases' => $this->release]));
        }
        return new HtmlResponse($this->template->render(sprintf('app::%s', $page)));
    }
}
