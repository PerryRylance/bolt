<?php

use LaraZeus\Bolt\Filament\Resources\CategoryResource;
use LaraZeus\Bolt\Filament\Resources\CategoryResource\Pages\CreateCategory;
use LaraZeus\Bolt\Filament\Resources\CategoryResource\Pages\EditCategory;
use LaraZeus\Bolt\Filament\Resources\CollectionResource;
use LaraZeus\Bolt\Filament\Resources\CollectionResource\Pages\CreateCollection;
use LaraZeus\Bolt\Filament\Resources\CollectionResource\Pages\EditCollection;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Models\Category;
use LaraZeus\Bolt\Models\Collection;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

it('can render category list', function () {
    get(CategoryResource::getUrl())
        ->assertSuccessful();
});

it('can render collection list', function () {
    get(CollectionResource::getUrl())
        ->assertSuccessful();
});

it('can render form list', function () {
    get(FormResource::getUrl())
        ->assertSuccessful();
});

it('fills the category slug client side while creating', function () {
    livewire(CreateCategory::class)
        ->assertSuccessful()
        ->assertSeeHtml("getElementById('form.slug')");
});

it('does not touch the category slug client side while editing', function () {
    $category = Category::factory()->create();

    livewire(EditCategory::class, ['record' => $category->getRouteKey()])
        ->assertSuccessful()
        ->assertDontSeeHtml("getElementById('form.slug')");
});

it('mirrors the collection item value into the item key client side while creating', function () {
    livewire(CreateCollection::class)
        ->assertSuccessful()
        ->assertSeeHtml('querySelector(\'[id$=\\\'.itemKey\\\']\')');
});

it('does not mirror the collection item value client side while editing', function () {
    $collection = Collection::create([
        'name' => 'Test collection',
        'values' => 'abc',
    ]);

    livewire(EditCollection::class, ['record' => $collection->getRouteKey()])
        ->assertSuccessful()
        ->assertDontSeeHtml('querySelector(\'[id$=\\\'.itemKey\\\']\')');
});
