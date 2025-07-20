<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Account;
use Livewire\WithPagination;

class AkunIndex extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function delete($id)
    {
        Account::findOrFail($id)->delete();
        session()->flash('message', 'Akun berhasil dihapus.');
    }

    public function render()
    {
        $akunList = Account::where('nama', 'like', '%' . $this->search . '%')
            ->orderBy('kode')
            ->paginate(10);

        return view('livewire.akun-index', compact('akunList'));
    }
}
