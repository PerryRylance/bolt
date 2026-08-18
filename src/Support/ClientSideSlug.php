<?php

namespace LaraZeus\Bolt\Support;

class ClientSideSlug
{
    /**
     * Extra attributes for a "name" style field, so that it fills a sibling slug field entirely
     * client side (no Livewire round trip) while the record is being created.
     */
    public static function attributesForSlug(string $slugFieldStatePath = 'form.slug'): array
    {
        return [
            'x-on:input' => <<<JS
                (() => {
                    const slugify = (value) => (value ?? '')
                        .toString()
                        .toLowerCase()
                        .trim()
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/^-+|-+\$/g, '');

                    const target = document.getElementById('{$slugFieldStatePath}');

                    if (!target) {
                        return;
                    }

                    target.value = slugify(\$el.value);
                    target.dispatchEvent(new Event('input'));
                })()
                JS,
        ];
    }

    /**
     * Extra attributes for a field inside a repeater item, so that it mirrors its value into a
     * sibling field within the same item entirely client side (no Livewire round trip), while the
     * record is being created.
     */
    public static function attributesForRepeaterMirror(string $targetFieldName, string $itemScopeSelector = '.fi-grid'): array
    {
        return [
            'x-on:input' => <<<JS
                (() => {
                    const scope = \$el.closest('{$itemScopeSelector}');

                    if (!scope) {
                        return;
                    }

                    const target = scope.querySelector('[id\$=\'.{$targetFieldName}\']');

                    if (!target) {
                        return;
                    }

                    target.value = \$el.value;
                    target.dispatchEvent(new Event('input'));
                })()
                JS,
        ];
    }
}
