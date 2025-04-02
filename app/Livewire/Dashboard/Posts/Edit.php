<?php

namespace App\Livewire\Dashboard\Posts;

use App\Models\Post;
use App\Traits\WithEditModel;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Attributes\Locked;

class Edit extends Component
{
    use WithEditModel;
    protected $model_type = 'post';
    #[Locked]
    public ?Post $post;
    public $user_id;
    public $name;
    public $slug;
    public $type = 'post';
    public $status = 'trash';
    public $content = '';

    public $template;
    public $seo_title;
    public $seo_description;

    public $thumbnail;
    public $files = [];

    protected $fillable_data = ['user_id','name', 'slug', 'type', 'status', 'content'];
    protected $fillable_meta = ['seo_title', 'seo_description', 'template'];
    protected $fillable_media = ['thumbnail', 'files'];
    public function mount(?Post $post)
    {
        $this->post = $post;
    }
    public function afterFill()
    {
        $this->type = 'post';
    }
    public function rules()
    {
        return [
            "user_id" => ["required","integer",Rule::exists('users', 'id')],
            "name" => ["required","string","max:255"],
            "slug" => ["required", "string", "max:255",Rule::unique("posts", "slug")->ignore($this->post)],
            "type" => ["required","string", Rule::in(['post'])],
            "status" => ["required","string",Rule::in(['draft', 'publish', 'trash'])],
            "content" => ["nullable","string",],
            "template" => ["nullable","string",Rule::in(config('layouts.layouts'))],
            "seo_title" => ["nullable","string","max:255"],
            "seo_description" => ["nullable","string","max:255"],
            'thumbnail' => ['nullable','image','max:5120'],
            'files' => ['nullable','array'],
            'files.*' => ['nullable','file'],
        ];
    }
    public function beforeSave() {
        if(empty($this->slug)){
            $this->slug = Post::generateSlug($this->name);
        }
        if(empty($this->user_id)){
            $this->user_id = auth()->user()->id;
        }
        $this->type = 'post';
    }
    public function afterSave() {
        $currentUrl = url()->current();
        $this->toastInfo('its edit current :current, url :url', ['current' => $currentUrl,'url' => $this->post->edit_url]);
        if ($this->post && url()->current() !== $this->post->edit_url) {
            $this->toastError('Not edit :url', ['url' => $this->post->edit_url]);
            //$this->redirect(route('dashboard.posts.edit', $this->post), true);
        }

    }
    public function statusKey() {
        return 'save';
    }

    public function render()
    {
        return view("livewire.dashboard.posts.edit", [
            'previewsThumbnail' => $this->getPreviews('thumbnail'),
            'previewsFiles' => $this->getPreviews('files'),
        ])->layout('layouts.dashboard', [
            'title' => $this->title,
        ]);
    }
}
