<?php

namespace Amplify\System\Backend\Traits;

use Amplify\System\Backend\Services\CrudCustomButton;

trait CrudCustomButtonTrait
{
    private array $buttons = [];

    public function addCustomButton($name, string $route, array $button_definition = [], array $attributes = []): void
    {
        $stack = $button_definition['stack'] ?? 'line';
        $view = $button_definition['view'] ?? 'custom-button';
        $position = $button_definition['position'] ?? false;

        $attributes['stack'] = $stack;

        $this->buttons[$name] = new CrudCustomButton($name, $route, $attributes);

        $this->crud->addButtonFromView($stack, $name, $view, $position);

        $menuCrud = $this;
        $this->crud->macro('getCustomButton', function ($name) use ($menuCrud) {
            return $menuCrud->getCustomButton($name);
        });
    }

    public function getCustomButton($name)
    {
        if (! isset($this->buttons[$name])) {
            return false;
        }

        return $this->buttons[$name];
    }

    public function customButtonExists($name)
    {
        return isset($this->buttons[$name]);
    }
}
