<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Reviews') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Client Reviews</h1>
                
                <!-- Rating Overview -->
                <div class="bg-gradient-to-br from-purple-50 to-blue-50 p-6 rounded-xl shadow mb-8">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="mb-4 md:mb-0">
                            <h3 class="text-gray-500 text-sm font-medium">Overall Rating</h3>
                            <div class="flex items-center">
                                <p class="text-5xl font-bold text-gray-800 mr-2">{{ number_format($averageRating, 1) }}</p>
                                <div class="text-yellow-500 text-2xl">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($averageRating))
                                            <span>★</span>
                                        @else
                                            <span class="text-gray-300">★</span>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-500">Based on {{ $reviewCount }} reviews</p>
                        </div>
                        
                        <div class="w-full md:w-1/2">
                            @foreach(range(5, 1) as $rating)
                                <div class="flex items-center mb-2">
                                    <div class="text-sm text-gray-600 w-3">{{ $rating }}</div>
                                    <div class="text-yellow-500 mx-2">★</div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        @php
                                            $percentage = $reviewCount > 0 ? ($ratingBreakdown[$rating] / $reviewCount) * 100 : 0;
                                        @endphp
                                        <div class="bg-yellow-500 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <div class="text-sm text-gray-600 ml-2">{{ $ratingBreakdown[$rating] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Reviews List -->
                @if($reviews->count() > 0)
                    <div class="space-y-6">
                        @foreach($reviews as $review)
                            <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <p class="font-medium">{{ $review->client->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="text-yellow-500">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <span>★</span>
                                            @else
                                                <span class="text-gray-300">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-700">{{ $review->comment }}</p>
                                
                                @if($review->trainer_response)
                                    <div class="mt-4 pl-4 border-l-4 border-gray-200">
                                        <p class="text-sm font-medium">Your Response:</p>
                                        <p class="text-sm text-gray-700">{{ $review->trainer_response }}</p>
                                    </div>
                                @else
                                    <div class="mt-4">
                                        <button class="text-sm text-indigo-600 hover:text-indigo-900">Respond to this review</button>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6">
                        {{ $reviews->links() }}
                    </div>
                @else
                    <p class="text-gray-500">No reviews yet.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
