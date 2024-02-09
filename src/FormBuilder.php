<?php

namespace Rignchen\Forms;

class FormBuilder {
    /**
     * @var array<FormType> $fields
     */
    private array $fields = [];
    private bool $is_rendered = false;
    private array $data = [];
    private array $displayData = [];

    public function __construct(
        private string $method = 'get',
        private readonly string $action = '',
        private readonly string $class = ''
    ) {
        if (!in_array($method, ['get', 'post','safe_post']))
            throw new \InvalidArgumentException('Invalid action');
        if ($this->method === 'get') {
            $this->data = $_GET;
            $this->displayData = $this->data;
        }
        elseif ($this->method === 'post') {
            $this->data = $_POST;
            $this->displayData = $this->data;
        }
        elseif ($this->method === 'safe_post') {
            session_start();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $_SESSION['Rignchen\Forms\safePost'] = $_POST;
                $_SESSION['Rignchen\Forms\safePostDisplay'] = $_POST;
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit;
            }
            else {
                if (isset($_SESSION['Rignchen\Forms\safePostDisplay']))
                    $this->displayData = $_SESSION['Rignchen\Forms\safePostDisplay'];
                else
                    $this->displayData = [];
            }
            if (isset($_SESSION['Rignchen\Forms\safePost'])) {
                $this->data = $_SESSION['Rignchen\Forms\safePost'];
                unset($_SESSION['Rignchen\Forms\safePost']);
            }
            else $this->data = [];
            $this->method = 'post';
        }
    }

    public function add(FormType $type): void {
        if ($this->is_rendered)
            throw new \RuntimeException('Form is already rendered');
        $temp = $type;
        $name = $temp->getName();
        if (isset($this->fields[$name]))
            throw new \InvalidArgumentException('Field already exists');
        $temp->setID($name . "-" . count($this->fields));
        $this->fields[$name] = $temp;
    }

    /**
     * @param array<FormType> $types
     */
    public function addList(array $types): void {
        foreach ($types as $type) $this->add($type);
    }

    public function render(): FormRenderer {
        if ($this->is_rendered)
            throw new \RuntimeException('Form is already rendered');
        $this->try_call();
        $this->is_rendered = true;
        return new FormRenderer($this->action, $this->method, $this->class, $this->fields, $this->displayData);
    }

    private function try_call(): void {
        foreach ($this->fields as $name => $field)
            if (isset($this->data[$name]))
                $field->call($this->data[$name], $field->getCallable());
    }
}

