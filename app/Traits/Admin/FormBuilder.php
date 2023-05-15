<?php

namespace App\Traits\Admin;

trait FormBuilder
{
    public $form = [];
    public $formKey = 0;

    public $formName;
    public $formRequired = '0';
    public $formWidth = '2';
    public $formLabel;
    public $formPlaceholder;
    public $formValue;
    public $formOptions;
    public $formConditions;

    private function createInput(string $type)
    {
        $input = [
            'position' => 0,
            'type' => $type,
            'name' => $type . '-' . uniqid(),
            'required' => '0',
            'width' => '2',
            'label' => '',
            'placeholder' => '',
            'value' => '',
            'options' => [],
            'conditions' => [],
        ];

        if ($type == 'speedPlus') {
            $input['label'] = 'آیا مایل به دریافت سریع تر سفارش خود هستید؟';
            $input['options'] = [
                ['value' => 'بله', 'price' => 0],
                ['value' => 'خیر', 'price' => 0]
            ];
        }

        return $input;
    }

    public function addForm(string $type)
    {
        array_unshift($this->form, $this->createInput($type));
        $this->editForm(0);
    }

    public function setFormData()
    {
        $this->validate([
            'formRequired' => ['required', 'boolean'],
            'formWidth' => ['required', 'in:1,2'],
            'formLabel' => ['required', 'string', 'max:6500'],
            'formPlaceholder' => ['present', 'string', 'max:250'],
            'formValue' => ['present', 'string', 'max:250'],
            'formOptions' => ['present', 'array'],
            'formOptions.*.value' => ['required_with:options', 'string', 'max:250'],
            'formOptions.*.price' => ['required_with:options', 'between:0,999999999.999'],
            'formOptions.*.license' => ['nullable', 'exists:products,slug'],
            'formConditions' => ['present', 'array'],
            'formConditions.*.value' => ['required_with:conditions', 'string', 'max:250'],
            'formConditions.*.target' => ['required_with:conditions', 'string', 'max:250'],
            'formConditions.*.visibility' => ['required_with:conditions', 'in:show,hide'],
        ]);

        $this->form[$this->formKey]['required'] = $this->formRequired;
        $this->form[$this->formKey]['width'] = $this->formWidth;
        $this->form[$this->formKey]['label'] = $this->formLabel;
        $this->form[$this->formKey]['placeholder'] = $this->formPlaceholder;
        $this->form[$this->formKey]['value'] = $this->formValue;
        $this->form[$this->formKey]['options'] = $this->formOptions;
        $this->form[$this->formKey]['conditions'] = $this->formConditions;

        if (in_array($this->form[$this->formKey]['type'], ['text', 'textArea'])) {
            $this->emit('hideModal', 'text');
        } elseif (in_array($this->form[$this->formKey]['type'], ['select', 'radio', 'customRadio', 'speedPlus'])) {
            $this->emit('hideModal', 'select');
        } else {
            $this->emit('hideModal', $this->form[$this->formKey]['type']);
        }
    }

    public function editForm($key)
    {
        $this->formKey = $key;

        $this->formName = $this->form[$this->formKey]['name'];
        $this->formRequired = $this->form[$this->formKey]['required'];
        $this->formWidth = $this->form[$this->formKey]['width'];
        $this->formLabel = $this->form[$this->formKey]['label'];
        $this->formPlaceholder = $this->form[$this->formKey]['placeholder'];
        $this->formValue = $this->form[$this->formKey]['value'];
        $this->formOptions = $this->form[$this->formKey]['options'];
        $this->formConditions = $this->form[$this->formKey]['conditions'];

        $this->resetErrorBag();

        if (in_array($this->form[$this->formKey]['type'], ['text', 'textArea'])) {
            $this->emit('showModal', 'text');
        } elseif (in_array($this->form[$this->formKey]['type'], ['select', 'radio', 'customRadio', 'speedPlus'])) {
            $this->emit('showModal', 'select');
        } else {
            $this->emit('showModal', $this->form[$this->formKey]['type']);
        }
    }

    public function deleteForm($key)
    {
        unset($this->form[$key]);
    }

    public function addOption($key)
    {
        array_unshift($this->formOptions, ['value' => '', 'price' => 0, 'license' => '']);
    }

    public function deleteOption($key, $optionKey)
    {
        unset($this->formOptions[$optionKey]);
    }

    public function addCondition($key)
    {
        array_unshift($this->formConditions, ['value' => '', 'target' => '', 'visibility' => '']);
    }

    public function deleteCondition($key, $optionKey)
    {
        unset($this->formConditions[$optionKey]);
    }

    public function updateFormPosition($data)
    {
        foreach ($this->form as $key => $form) {
            foreach ($data as $item) {
                if ($form['name'] == $item['value']) {
                    $this->form[$key]['position'] = $item['order'];
                }
            }
        }

        usort($this->form, function ($a, $b) {
            return strnatcmp($a['position'], $b['position']);
        });
    }
}
