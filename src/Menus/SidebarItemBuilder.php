<?php

namespace Amplify\System\Backend\Menus;

class SidebarItemBuilder
{
    protected Sidebar $parent;

    protected array $data = [
        'label' => '',
        'url' => null,
        'icon' => 'la la-question',
        'children' => [],
        'permission' => null,
        'canAny' => [],
        'is_group' => false,
        'condition' => null,
    ];

    public function __construct(Sidebar $parent, string $label, bool $isGroup = false)
    {
        $this->parent = $parent;
        $this->data['label'] = $label;
        $this->data['is_group'] = $isGroup;
    }

    public function url(string $url): self
    {
        $this->data['url'] = $url;
        return $this;
    }

    public function icon(string $icon): self
    {
        $this->data['icon'] = $icon;
        return $this;
    }

    public function can(string $permission): self
    {
        $this->data['permission'] = $permission;
        return $this;
    }

    public function canAny(...$permissions): self
    {
        $this->data['canAny'] = $permissions;
        return $this;
    }

    public function items($callback): self
    {
        $menu = new static($this->parent, '');
        
        $callback($menu);

        $this->data['children'] = array_merge($this->data['children'], $menu->data['children']);

        return $this;
    }

    public function item(string $label): self
    {
        $child = new static($this->parent, $label);
        $this->data['children'][] = $child;
        return $child;
    }

    public function group(string $label): self
    {
        $child = new static($this->parent, $label, true);
        $this->data['children'][] = $child;
        return $child;
    }

    public function resolve(): ?array
    {
        if ($this->data['condition'] !== null) {
            $condition = $this->data['condition'];
            if (is_callable($condition)) {
                $condition = call_user_func($condition);
            }
            if (!$condition) {
                return null;
            }
        }

        if ($this->data['permission'] && !auth()->user()?->can($this->data['permission'])) {
            return null;
        }

        if (!empty($this->data['canAny'])) {
            $allowed = collect($this->data['canAny'])
                ->contains(fn($p) => auth()->user()?->can($p));

            if (!$allowed) return null;
        }

        $children = collect($this->data['children'])
            ->map(fn($child) => $child->resolve())
            ->filter()
            ->values();

        if ($this->data['is_group'] && $children->isEmpty()) {
            return null;
        }

        return [
            'label' => $this->data['label'],
            'url' => $this->data['url'],
            'icon' => $this->data['icon'],
            'children' => $children,
        ];
    }

    public function toArray(): array
    {
        $data = $this->data;
        $data['children'] = collect($this->data['children'])->map(fn($child) => $child->toArray())->all();
        return $data;
    }

    public function getChildren(): array
    {
        return $this->data['children'];
    }

    public function isGroup(): bool
    {
        return $this->data['is_group'];
    }

    public function getLabel(): string
    {
        return $this->data['label'];
    }

    public function if($condition): self
    {
        $this->data['condition'] = $condition;
        return $this;
    }
}