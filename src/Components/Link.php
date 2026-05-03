<?php

namespace Amplify\System\Backend\Components;

use Illuminate\View\Component;

class Link extends Component
{
    public array $item;
    public bool $hasChildren = false;
    public bool $isActive = false;
    public bool $hasActiveChild = false;
    public bool $isOpen = false;

    public string $liClass = 'nav-item';
    public string $linkClass = 'nav-link';

    public function __construct($item)
    {
        $this->item = $item;
        $this->prepare();
    }

    protected function prepare(): void
    {
        $this->hasChildren = !empty($this->item['children']) && count($this->item['children']);

        $this->isActive = $this->checkActive($this->item);

        if ($this->hasChildren) {
            $this->hasActiveChild = $this->checkChildren($this->item['children']);
        }

        $this->isOpen = $this->isActive || $this->hasActiveChild;

        if ($this->hasChildren) {
            $this->liClass .= ' nav-dropdown';
            $this->linkClass .= ' nav-dropdown-toggle';

            if ($this->isOpen) {
                $this->liClass .= ' open';
            }
        }

        if ($this->isActive) {
            $this->linkClass .= ' active';
        }
    }

    protected function checkActive(array $item): bool
    {
        if (empty($item['url'])) return false;

        $path = trim(parse_url($item['url'], PHP_URL_PATH), '/');

        return request()->is($path . '*');
    }

    protected function checkChildren($children): bool
    {
        foreach ($children as $child) {
            if ($this->checkActive($child)) return true;

            if (!empty($child['children']) && $this->checkChildren($child['children'])) {
                return true;
            }
        }

        return false;
    }

    public function render()
    {
        return view('backend::sidebar.link');
    }
}