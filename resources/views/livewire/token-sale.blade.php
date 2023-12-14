<div>
    <div>
        <script>
            function copyToClipboard(element) {
                var copyText = document.querySelector(element);
                copyText.select();
                document.execCommand("copy");
            }
        </script>
        @if (!$walletAddress)
            <button wire:click="connectWallet">Connect Wallet To Continue</button>
            @script
                <script>
                    $wire.on('show-connect-wallet-modal', function() {
                        try_connect()
                    });
                </script>
            @endscript
        @else
            <div class="container p-8 mx-auto mt-8">
                <div class="max-w-md p-8 mx-auto bg-white rounded-md shadow-md">
                    <h2 class="mb-4 text-2xl font-bold text-green-800"><b>TTN</b> Token Purchase</h2>

                    <div class="mb-4">
                        <label for="walletAddress" class="block text-sm font-medium text-gray-600">Connected
                            Wallet:</label>
                        <div class="flex items-center p-2 border rounded-md">
                            <input id="walletAddress" type="text" value="{{ $walletAddress }}" readonly
                                class="flex-1 w-full text-gray-700 bg-transparent border-none appearance-none">
                            <button onclick="copyToClipboard('#walletAddress')"
                                class="text-blue-500 hover:text-blue-700 focus:outline-none">
                                Copy
                            </button>
                        </div>
                    </div>

                    <form wire:submit.prevent="buyTokens">
                        <div class="mb-4">
                            <label for="buyAmount" class="block text-sm font-medium text-gray-600">Get TTN:</label>
                            <div class="flex items-center">
                                <input id="buyAmount" type="number" wire:model="buyAmount" placeholder="Enter Amount"
                                    step="0.01" class="flex-1 p-2 bg-gray-100 border rounded-md appearance-none">
                            </div>
                            @error('buyAmount')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="w-full p-2 mt-4 text-white bg-blue-500 rounded-md">Buy
                            Tokens
                            <i wire:loading wire:target="buyTokens" class="fas fa-spinner fa-spin"></i>
                        </button>
                    </form>
                </div>

                @if ($userTokens->count() > 0)
                    <div class="mt-8">
                        <h2 class="mb-4 text-2xl font-bold">Your TTN Tokens Transactions</h2>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Token Address</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Balance</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        DateTime</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-red-500 bg-white divide-y divide-green-200">
                                @foreach ($userTokens as $userToken)
                                    <tr>
                                        <td class="px-6 py-4 text-green-500 whitespace-nowrap">
                                            <a target="__blank"
                                                href="https://sepolia.etherscan.io/tx/{{ $userToken->transaction_hash }}"
                                                target="_blank" rel="noopener noreferrer">
                                                {{ substr($userToken->transaction_hash, 0, 20) }}.....
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-green-500 whitespace-nowrap">{{ $userToken->balance }}
                                            TTN Tokens
                                        </td>
                                        <td class="px-6 py-4 text-green-500 whitespace-nowrap">
                                            {{ $userToken->created_at->diffForHumans() }}</td>
                                        <td class="px-6 py-4 text-green-500 whitespace-nowrap">
                                            <span
                                                class="text-sm {{ $userToken->status === 'completed' ? 'text-green-500' : ($userToken->status === 'failed' ? 'text-red-500' : 'text-yellow-500') }}">
                                                {{ ucfirst($userToken->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endif
    </div>

    @script
        <script>
            if (typeof window.ethereum !== 'undefined') {
                window.ethereum
                    .request({
                        method: 'eth_requestAccounts'
                    })
                    .then((accounts) => {
                        console.log(accounts)
                        $wire.walletAddress = accounts[0]
                        $wire.dispatch('wallet-connected', {
                            account: accounts[0]
                        });
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            } else {
                console.error('MetaMask not installed');
            }

            function copyToClipboard(element) {
                var copyText = document.querySelector(element);
                copyText.select();
                document.execCommand("copy");
            }
        </script>
    @endscript
</div>
