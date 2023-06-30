<?php

namespace App\Http\Livewire;

use App\Models\Document;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Documents extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $name, $cid, $image;
    public $perPage = 12;
    public $search = '';

    public $update = false;
    public $form = false;

    protected $listeners = [
        'deleteConfirm' => 'delete',
        'deleteMutipleConfirm' => 'buckDelete'
    ];

    function refreshInputs()
    {
        $this->image = null;
        $this->name = null;
        $this->cid = false;
        $this->form = false;
        $this->update = false;
    }

    function download(Media $mediaItem)
    {
        // return $mediaItem->getFirstMedia('documents');
        return response()->download($mediaItem->getPath(), $mediaItem->file_name);
    }

    function view($value)
    {
        $value->getFirstMedia('documents')->getUrl();
    }
    protected $messages = [
        'image.required' => 'The file cannot be empty',
        'image.max' => 'The file size must not greater than 1mb or 1024kilobyte',
        'image.mimes' => 'The file must be a document file or image file in the format png,jpg,docx,doc,ppt,pptx,jpeg,csv,xlsx,pdf',
    ];
    public function save()
    {
        $data = $this->validate([
            'name' => 'required|min:15|unique:documents,name',
            'image' => ['required', 'mimes:png,jpg,jpeg,docx,doc,ppt,pptx,jpeg,csv,xlsx,pdf', 'max:200'],
        ]);

        try {
            $saved = currentUser()->documents()->create(['name' => $data['name']]);
            $media = $saved->addMedia($this->image->getRealPath())
                ->usingName($this->name)
                ->toMediaCollection('documents');
            $media[0]->file_name = $data['name'];
            $this->image = null;
            $media[0]->save();
            $this->refreshInputs();
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return session()->flash('success', 'Document recorded succesfully');
    }
    // add new image to Document
    public function addImage(Document $Document)
    {
        $done = $Document->addMedia($this->new->getRealPath())
            ->usingName($this->new->getClientOriginalName())
            ->toMediaCollection('galleries');
        if ($done) {
            session()->flash('success', 'Image Added to event');
            $this->refreshInputs();
        }
    }


    public function confirmDelete($id)
    {

        $user = Document::findOrFail($id);

        $this->delete = $id;
        $this->dispatchBrowserEvent('swal:confirm');
    }

    public function delete()
    {

        $document = Document::with('owner')->findOrFail($this->delete);
        $true = $document->delete();

        if ($true) {
            session()->flash('success', 'Document Removed successfully');
        }
        $this->resetPage();
        $this->checked = [];
        $this->update = false;
        $this->search = '';

        // return redirect()->route('document');
    }

    public function edit(Document $document)
    {
        $this->form = true;
        $this->update = true;
        $file = $document;
        $this->name = $document->name;
        $this->cid = $document->id;
    }

    public function update()
    {
        $document = Document::find($this->cid);
        $data = $this->validate([
            'name' => 'required|min:15|unique:documents,name',
            'image' => ['nullable', 'mimes:png,jpg,docx,doc,ppt,pptx,jpeg,csv,xlsx,sql,pdf'],
        ]);

        try {
            $saved = $document->update(['name' => $data['name']]);
            if ($data['image']) {
                $media = $saved->addMedia($this->image->getRealPath())
                    ->usingName($this->name)
                    ->toMediaCollection('documents');
                $media[0]->file_name = $data['name'];
                $media[0]->save();
            }
            $this->refreshInputs();
            return session()->flash('success', 'Document title updated succesfully');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function render()
    {
        $term = '%' . $this->search . '%';
        $documents = Document::latest()->paginate($this->perPage);
        return view('livewire.documents', compact(['documents']))->layout('layouts.dashboard');
    }
}