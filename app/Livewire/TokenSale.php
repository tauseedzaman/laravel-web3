<?php

namespace App\Livewire;

use App\Models\UserToken;
use Livewire\Component;
use Termwind\Components\Dd;

class TokenSale extends Component
{

    public $user;
    public $walletAddress;
    public $buyAmount;
    public $tokenPrice = 0.001; // Price of 1 token in ETH

    // walletConnected event listener
    protected $listeners = ['wallet-connected' => 'ConnectedWallet'];

    protected $rules = [
        'buyAmount' => 'required|numeric|min:0.01', // Adjust validation rules as needed
    ];

    public function mount()
    {
        // You may load user data or perform other initialization here
        $this->user = auth()->user();
        $this->walletAddress = $this->user->wallet_address;
    }

    public function connectWallet()
    {
        $this->dispatch('show-connect-wallet-modal');
    }


    public function buyTokens()
    {
        $this->validate();
        // Implement token purchase logic
        // Use $this->user, $this->walletAddress, and $this->buyAmount as needed

        // Update user token balance in the database
        UserToken::Create(
            [
                'user_id' => auth()->id(),
                'balance' => $this->buyAmount,
                'token_address' => $this->walletAddress
            ]
        );

        // Clear form fields
        $this->buyAmount = '';
    }

    public function ConnectedWallet($account)
    {
        $this->walletAddress = $account;
        $user = auth()->user();
        $user->wallet_address = $account;
        $user->save();
    }

    public function render()
    {
        return view('livewire.token-sale', [
            'userTokens' => UserToken::where('user_id', $this->user->id)->latest()->get()
        ]);
    }
}
