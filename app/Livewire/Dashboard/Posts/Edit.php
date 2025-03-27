<?php

namespace App\Livewire\Dashboard\Posts;

use App\Models\Post;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Edit extends Component
{
    public $title;
    public ?Post $post;
    #[Validate]
    public $name;
    #[Validate]
    public $slug;
    #[Validate]
    public $description;
    #[Validate]
    public $content;

    public function mount(?Post $post)
    {
        $this->post = $post;
        $this->fill($this->post->only(["name", "slug", "description", "content"]));
        $this->title = $post->id
            ? __("Edit post :name", ["name" => $this->name])
            : __("Create post");
    }

    public function rules()
    {
        return [
            "name" => [
                "required",
                "string",
                "max:255",
            ],
            "slug" => [
                "nullable",
                "string",
                "max:255",
                Rule::unique("posts", "slug")->ignore(
                    $this->post
                ),
            ],
            "description" => [
                "nullable",
                "string",
                "max:255",
            ],
            "content" => [
                "nullable",
                "string",
            ],
        ];
    }
    public function save()
    {
        $this->validate();
        if(empty($this->slug)){
            $this->slug = Post::generateSlug($this->name);
        }
        $this->post->fill($this->only(["name", "slug", "description", "content"]));
        $save = $this->post->save();
        if ($save) {
            session()->flash("status", __("Post saved."));
        } else {
            $this->addError("status", __("Save failed!"));
        }
    }
    public function render()
    {
        return view("livewire.dashboard.posts.edit")->layout("layouts.dashboard", [
            "title" => $this->title,
        ]);
    }
}
