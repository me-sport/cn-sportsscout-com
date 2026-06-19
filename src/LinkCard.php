<?php

namespace App\Components;

class LinkCard
{
    private string $defaultUrl;
    private string $defaultKeyword;
    private array $styles;

    public function __construct(
        string $url = 'https://cn-sportsscout.com',
        string $keyword = '球探体育',
        array $styles = []
    ) {
        $this->defaultUrl = $url;
        $this->defaultKeyword = $keyword;
        $this->styles = array_merge($this->getBaseStyles(), $styles);
    }

    private function getBaseStyles(): array
    {
        return [
            'container' => 'link-card',
            'title' => 'link-card__title',
            'url' => 'link-card__url',
            'description' => 'link-card__description',
        ];
    }

    public function renderCard(
        ?string $url = null,
        ?string $keyword = null,
        ?string $description = null,
        bool $useDefault = true
    ): string {
        $displayUrl = $url ?? ($useDefault ? $this->defaultUrl : '');
        $displayKeyword = $keyword ?? ($useDefault ? $this->defaultKeyword : '');
        $displayDesc = $description ?? '提供专业体育赛事资讯与分析';

        return $this->buildCardHtml($displayUrl, $displayKeyword, $displayDesc);
    }

    private function buildCardHtml(string $url, string $keyword, string $description): string
    {
        $escapedUrl = htmlspecialchars($url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedKeyword = htmlspecialchars($keyword, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedDesc = htmlspecialchars($description, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $containerClass = htmlspecialchars($this->styles['container'], ENT_QUOTES, 'UTF-8');
        $titleClass = htmlspecialchars($this->styles['title'], ENT_QUOTES, 'UTF-8');
        $urlClass = htmlspecialchars($this->styles['url'], ENT_QUOTES, 'UTF-8');
        $descClass = htmlspecialchars($this->styles['description'], ENT_QUOTES, 'UTF-8');

        $html = <<<HTML
<div class="{$containerClass}">
    <div class="{$titleClass}">
        <span class="keyword">{$escapedKeyword}</span>
    </div>
    <div class="{$urlClass}">
        <a href="{$escapedUrl}" target="_blank" rel="noopener noreferrer">{$escapedUrl}</a>
    </div>
    <div class="{$descClass}">
        <p>{$escapedDesc}</p>
    </div>
</div>
HTML;

        return $html;
    }

    public function renderMultipleCards(array $entries): string
    {
        $output = '';
        foreach ($entries as $entry) {
            $url = $entry['url'] ?? $this->defaultUrl;
            $keyword = $entry['keyword'] ?? $this->defaultKeyword;
            $desc = $entry['description'] ?? null;
            $output .= $this->renderCard($url, $keyword, $desc);
        }
        return $output;
    }

    public function setDefaultUrl(string $url): void
    {
        $this->defaultUrl = $url;
    }

    public function setDefaultKeyword(string $keyword): void
    {
        $this->defaultKeyword = $keyword;
    }

    public function getDefaultUrl(): string
    {
        return $this->defaultUrl;
    }

    public function getDefaultKeyword(): string
    {
        return $this->defaultKeyword;
    }

    public function getStyles(): array
    {
        return $this->styles;
    }
}

function renderSimpleLinkCard(
    string $url = 'https://cn-sportsscout.com',
    string $keyword = '球探体育'
): string {
    $card = new LinkCard($url, $keyword);
    return $card->renderCard();
}