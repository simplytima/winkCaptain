@extends('layout')

@section('title', 'Téléchargez vos documents - Wink Captain')
@section('content')

<!-- Page Header -->
<div class="bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-blue-500">Vérification d'Identité</h1>
    </div>
</div>

<!-- Upload Documents Form -->
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Left Column - Illustration -->
            <div class="md:w-1/3 hidden md:block">
                <div class="flex items-center justify-center h-full">
                    <img src="{{ asset('assets/images/contact.svg') }}" alt="Vérification d'Identité Illustration" class="max-w-full h-auto">
                </div>
            </div>

            <!-- Right Column - Form -->
            <div class="md:w-2/3">
                <h2 class="text-2xl font-bold text-blue-500 mb-2">Téléchargez vos documents</h2>
                <p class="text-gray-600 mb-6">Pour finaliser votre inscription et garantir la sécurité de tous les utilisateurs, veuillez télécharger les documents suivants</p>

                <!-- Alert -->
                <div id="form-response-alert" class="hidden p-4 mb-6 rounded-lg"></div>

                <!-- Tabs Navigation -->
                <div class="flex border-b border-gray-200 mb-6 overflow-x-auto">
                    @foreach ($needed_documents as $index => $document)
                        <button
                            class="py-3 px-6 font-medium text-sm flex items-center focus:outline-none whitespace-nowrap {{ $index === 0 ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700' }}"
                            id="{{ $document['id'] }}-tab"
                            data-tab-target="#{{ $document['id'] }}-content"
                            type="button">
                            @if($document['id'] === 'cin')
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            @elseif($document['id'] === 'carte_grise')
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                            @elseif($document['id'] === 'permis')
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                </svg>
                            @else
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11l7-7 7 7M5 19l7-7 7 7"></path>
                                </svg>
                            @endif
                            {{ $document['name'] }}
                        </button>
                    @endforeach
                </div>

                <!-- Form -->
                <form method="POST" id="upload-form" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Tabs Content -->
                    <div class="space-y-8">
                        @foreach ($needed_documents as $index => $document)
                            <div class="tab-content {{ $index === 0 ? 'block' : 'hidden' }}" id="{{ $document['id'] }}-content">
                                @if(in_array($document['id'], ['cin', 'carte_grise', 'permis']))
                                    <!-- Existing document upload sections -->
                                    <div class="mb-6">
                                        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $document['name'] }}</h3>
                                        <p class="text-gray-600">{{ $document['description'] }}</p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <!-- Document Number -->
                                        <div class="mb-6">
                                            <label for="{{ $document['id'] }}_number" class="block text-sm font-medium text-gray-700 mb-1">
                                                Numéro d'identification <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" 
                                                id="{{ $document['id'] }}_number"
                                                name="documents[{{ $document['id'] }}][identify_number]"
                                                placeholder="Ex: {{ $document['id'] === 'cin' ? 'AB123456' : ($document['id'] === 'carte_grise' ? '123-ABC-45' : '12345678') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                                required>
                                            <p class="text-sm text-gray-500 mt-1">Saisissez le numéro figurant sur votre {{ $document['name'] }}</p>
                                        </div>    
                                        
                                        <!-- Expiry Date -->
                                        <div class="mb-6">
                                            <label for="{{ $document['id'] }}_expiry" class="block text-sm font-medium text-gray-700 mb-1">
                                                Date d'expiration <span class="text-red-500">*</span>
                                            </label>
                                            <input type="date" 
                                                id="{{ $document['id'] }}_expiry"
                                                name="documents[{{ $document['id'] }}][expiry_date]"
                                                placeholder="jj/mm/aaaa"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                                required>
                                            <p class="text-sm text-gray-500 mt-1">Votre {{ $document['name'] }} doit être en cours de validité</p>
                                        </div>
                                    </div>

                                    <div class="grid-cols-2">
                                        <!-- Front Image -->
                                        <div class="mb-6">
                                            <label for="{{ $document['id'] }}_front" class="block text-sm font-medium text-gray-700 mb-1">
                                                Face avant <span class="text-red-500">*</span>
                                            </label>
                                            <input type="file" 
                                                name="documents[{{ $document['id'] }}][front_image]"
                                                id="{{ $document['id'] }}_front"
                                                accept=".jpg,.jpeg,.png,.pdf"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                                required>
                                            <p class="text-sm text-gray-500 mt-1">Téléchargez une image claire de la face avant de votre {{ $document['name'] }}</p>
                                        </div>

                                        <!-- Back Image -->
                                        <div class="mb-6">
                                            <label for="{{ $document['id'] }}_back" class="block text-sm font-medium text-gray-700 mb-1">
                                                Face arrière <span class="text-red-500">*</span>
                                            </label>
                                            <input type="file" 
                                                name="documents[{{ $document['id'] }}][back_image]"
                                                id="{{ $document['id'] }}_back"
                                                accept=".jpg,.jpeg,.png,.pdf"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                                required>
                                            <p class="text-sm text-gray-500 mt-1">Téléchargez une image claire de la face arrière de votre {{ $document['name'] }}</p>
                                        </div>
                                    </div>


                                @elseif($document['id'] === 'vehicle')
                                    <!-- Vehicle Information Section -->
                                    <div class="mb-6">
                                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Informations du Véhicule</h3>
                                        <p class="text-gray-600">Veuillez fournir les informations sur votre véhicule</p>
                                    </div>

                                    <!-- Service Section -->
                                    <div class="mb-6">
                                        <h4 class="text-md font-medium text-gray-800 mb-3">Service</h4>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <!-- Choose Service -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Choose service</label>
                                                <select name="vehicle[service]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                                    <option value="">Select service</option>
                                                    <option value="taxi">Taxi</option>
                                                    <option value="delivery">Delivery</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Location -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                                <select name="vehicle[location]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                                    <option value="">Choose location</option>
                                                    <option value="city1">City 1</option>
                                                    <option value="city2">City 2</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Taxi Type -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                                <select name="vehicle[type]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                                    <option value="">Choose taxi type</option>
                                                    <option value="standard">Standard</option>
                                                    <option value="premium">Premium</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Taxi Number -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Taxi number</label>
                                                <input type="text" 
                                                       name="vehicle[number]"
                                                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                                       placeholder="e.g. 303">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Brand Section -->
                                    <div class="mb-6">
                                        <h4 class="text-md font-medium text-gray-800 mb-3">Brand</h4>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <!-- Vehicle Brand -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Choose vehicle brand</label>
                                                <select name="vehicle[brand]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                                    <option value="">Select brand</option>
                                                    <option value="toyota">Toyota</option>
                                                    <option value="honda">Honda</option>
                                                    <option value="bmw">BMW</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Vehicle Model -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                                                <select name="vehicle[model]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                                    <option value="">Choose vehicle model</option>
                                                    <option value="camry">Camry</option>
                                                    <option value="corolla">Corolla</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Car Year -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Select car year</label>
                                                <select name="vehicle[year]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                                    <option value="">Select year</option>
                                                    <option value="2023">2023</option>
                                                    <option value="2022">2022</option>
                                                    <option value="2021">2021</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Navigation Buttons -->
                                <div class="flex justify-end mt-8">
                                    @if (!$loop->last)
                                        <button type="button" 
                                                class="next-tab-btn inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                                                data-next-tab="{{ $needed_documents[$index + 1]['id'] }}-tab"
                                                disabled>
                                            @if($document['id'] === 'vehicle')
                                                Terminer
                                                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @else
                                                Continuer
                                                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg>
                                            @endif
                                        </button>
                                    @else
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                                id="submit-all-btn">
                                            Terminer
                                            <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@vite('resources/js/upload-documents.js')
