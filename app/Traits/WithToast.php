<?php

namespace App\Traits;

trait WithToast
{
    public function toast($message, $options = [])
    {
        $options = array_merge([
            'type' => 'info',
            'position' => 'top-end',
        ], $options);
        $this->dispatch('toast', [
            'message' => $message,
            'options' => $options,
        ]);
    }
    public function toastInfo($message, $position = 'top-end')
    {
        $this->toast($message, ['type' => 'info', 'position' => $position]);
    }
    public function toastSuccess($message, $position = 'top-end')
    {
        $this->toast($message, ['type' => 'success', 'position' => $position]);
    }
    public function toastError($message, $position = 'top-end')
    {
        $this->toast($message, ['type' => 'error', 'position' => $position]);
    }
}
