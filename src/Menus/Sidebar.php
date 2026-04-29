<?php

namespace Amplify\System\Backend\Menus;

use Illuminate\Support\Collection;

class Sidebar
{
    protected Collection $items;

    public static function make(): self
    {
        return new static();
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
        $parts = explode('.', $label);
        $current = null;
        $container = $this->items;

        foreach ($parts as $part) {
            $found = null;
            foreach ($container as $item) {
                if ($item->getLabel() === $part && $item->isGroup()) {
                    $found = $item;
                    break;
                }
            }

            if (!$found) {
                $found = new SidebarItemBuilder($this, $part, true);
                $container->push($found);
            }

            $current = $found;
            $container = collect($current->getChildren());
        }

        return $current;
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

    /**
     * @throws \Throwable
     */
    public function render(): string
    {
//        $userId = auth()->id() ?? session()->getId();
//
//        $cacheKey = "sidebar.{$userId}";

//        if (session()->has($cacheKey)) {
//            return session($cacheKey);
//        }

        $items = $this->build();

        $html = view('backend::sidebar.index', [
            'links' => $items,
            'grouped' => false,
        ])->render();

//        session([$cacheKey => $html]);

        return $html;
    }
}
