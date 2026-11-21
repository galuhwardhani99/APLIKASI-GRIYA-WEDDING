@once
<style>
    .description-preview { position: relative; padding-bottom: 21px; margin: 0 0 10px; }
    .formatted-description { color: inherit; line-height: 1.55; overflow-wrap: anywhere; }
    .formatted-description.preview { max-height: 6.1em; overflow: hidden; }
    .formatted-description p { margin: 0 0 .55em; }
    .formatted-description p:last-child { margin-bottom: 0; }
    .formatted-description ul { margin: .2em 0 .65em; padding-left: 1.25em; list-style: disc; }
    .formatted-description li { margin: .15em 0; }
    .detail-trigger { position: absolute; right: 0; bottom: 0; border: 0; border-radius: 5px; padding: 4px 8px; background: #F7EDDD; color: #8C5D26; font-family: inherit; font-size: 11px; font-weight: 700; cursor: pointer; }
    .detail-trigger:hover { background: #EED9B7; }
    .catalog-detail-dialog { width: min(560px, calc(100% - 28px)); max-height: min(82vh, 760px); margin: auto; padding: 0; border: 0; border-radius: 14px; color: #241A16; box-shadow: 0 20px 70px rgba(0,0,0,.25); }
    .catalog-detail-dialog::backdrop { background: rgba(24,18,15,.58); }
    .catalog-detail-content { position: relative; max-height: min(82vh, 760px); overflow: auto; background: #fff; }
    .detail-image { display: block; width: 100%; height: 230px; object-fit: cover; background: #F1E7DF; }
    .detail-image-placeholder { display: grid; place-items: center; height: 180px; padding: 20px; background: linear-gradient(135deg, #F7EDDD, #EBD9C1); color: #8C5D26; text-align: center; font: 700 1.2rem 'Playfair Display', Georgia, serif; }
    .detail-body { padding: 22px; }
    .detail-body h3 { margin: 0 36px 8px 0; color: #241A16; font: 700 1.35rem 'Playfair Display', Georgia, serif; }
    .detail-extra { color: #8C8279; margin: 0 0 12px; font-size: .9rem; }
    .detail-body .formatted-description { color: #6E5B50; }
    .detail-price { display: block; margin-top: 16px; color: #A87632; }
    .detail-close { position: absolute; z-index: 2; top: 10px; right: 10px; display: grid; place-items: center; width: 34px; height: 34px; border: 0; border-radius: 50%; background: rgba(255,255,255,.94); color: #241A16; font-size: 24px; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,.15); }
</style>
@endonce
@php
    $descriptionText = trim((string) ($descriptionText ?? ''));
    $descriptionLines = preg_split('/\r\n|\r|\n/', $descriptionText) ?: [];
    $descriptionBlocks = [];
    $paragraphLines = [];
    $listItems = [];
    $flushParagraph = function () use (&$paragraphLines, &$descriptionBlocks) {
        if ($paragraphLines) {
            $descriptionBlocks[] = ['type' => 'paragraph', 'lines' => $paragraphLines];
            $paragraphLines = [];
        }
    };
    $flushList = function () use (&$listItems, &$descriptionBlocks) {
        if ($listItems) {
            $descriptionBlocks[] = ['type' => 'list', 'lines' => $listItems];
            $listItems = [];
        }
    };
    foreach ($descriptionLines as $descriptionLine) {
        $descriptionLine = trim($descriptionLine);
        if ($descriptionLine === '') {
            $flushParagraph();
            $flushList();
            continue;
        }
        if (preg_match('/^(?:[-*•]\s+|\d+[.)]\s+)/u', $descriptionLine)) {
            $flushParagraph();
            $listItems[] = preg_replace('/^(?:[-*•]\s+|\d+[.)]\s+)/u', '', $descriptionLine);
            continue;
        }
        $flushList();
        $paragraphLines[] = $descriptionLine;
    }
    $flushParagraph();
    $flushList();
@endphp
<div class="formatted-description {{ $descriptionClass ?? '' }}">
    @foreach($descriptionBlocks as $block)
        @if($block['type'] === 'list')
            <ul>
                @foreach($block['lines'] as $line)<li>{{ $line }}</li>@endforeach
            </ul>
        @else
            <p>{{ implode(' ', $block['lines']) }}</p>
        @endif
    @endforeach
</div>
