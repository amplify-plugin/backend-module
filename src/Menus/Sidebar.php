<?php

namespace Amplify\System\Backend\Menus;

use Illuminate\Support\Collection;

class Sidebar
{
    protected Collection $items;

    public static function make(): self
    {
        return new self();
    }

    public function __construct()
    {
        $this->items = collect();
    }

    public function item(string $label): SidebarItemBuilder
    {
        $item = new SidebarItemBuilder($this, $label);
        $this->items->push($item);
        return $item;
    }

    public function group(string $label): SidebarItemBuilder
    {
        $item = new SidebarItemBuilder($this, $label, true);
        $this->items->push($item);
        return $item;
    }

    public function all(): Collection
    {
        return $this->items;
    }

    public function build(): Collection
    {
        return $this->items
            ->map(fn($item) => $item->resolve())
            ->filter()
            ->values();
    }

    public function render(): string
    {
        $userId = auth()->id() ?? session()->getId();
        $cacheKey = "sidebar.{$userId}";

        if (session()->has($cacheKey)) {
            return session($cacheKey);
        }

        $items = $this->build();

        $html = view('components.sidebar', [
            'links' => $items,
            'grouped' => false,
        ])->render();

        session([$cacheKey => $html]);

        return $html;
    }
}
