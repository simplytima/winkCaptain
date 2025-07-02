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
                <h2 class="text-2xl font-bold text-blue-500 mb-2">Téléchargez Vos Documents</h2>
                <p class="text-gray-600 mb-6">Pour finaliser votre inscription et garantir la sécurité de tous les utilisateurs, veuillez télécharger les documents suivants</p>

                <!-- Alert -->
                <div id="form-response-alert" class="hidden p-4 mb-6 rounded-lg"></div>

                <!-- Tabs Navigation -->
                <div class="flex border-b border-gray-200 mb-6 overflow-x-auto" style="scrollbar-width: none; scrollbar-color: rgba(100,100,100,0.5) transparent;">

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
                    <div class="space-y-8 ">
                        @foreach ($needed_documents as $index => $document)
                            <div class="tab-content {{ $index === 0 ? 'block' : 'hidden' }}" id="{{ $document['id'] }}-content">
                                
                                @if(in_array($document['id'], ['cin', 'carte_grise', 'permis']))
                                    <!-- Existing document upload sections -->
                                    <div class="mb-6">
                                        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $document['name'] }}</h3>
                                        <p class="text-gray-600">{{ $document['description'] }}</p>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- Document Number -->
                                        <div class="mb-6">
                                            <label for="{{ $document['id'] }}_number" class="block text-sm font-medium text-gray-700 mb-1">
                                                Numéro d'identification <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" 
                                                id="{{ $document['id'] }}_number"
                                                name="documents[{{ $document['id'] }}][identify_number]"
                                                placeholder="Ex: {{ $document['id'] === 'cin' ? 'AB123456' : ($document['id'] === 'carte_grise' ? '123-ABC-45' : '12345678') }}"
                                                class="w-full px-4 py-2 border border-gray-50 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-blue-50 outline-none"
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
                                                class="w-full px-4 py-2 border border-blue-50 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-blue-50"
                                                required>
                                            <p class="text-sm text-gray-500 mt-1">Votre {{ $document['name'] }} doit être en cours de validité</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Front Image Upload -->
                                        <div class="mb-6">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Face avant <span class="text-red-500">*</span>
                                            </label>
                                            
                                            <div class="relative">
                                                <div class="flex flex-col items-center justify-center px-4 py-6 bg-white border-2 border-dashed border-blue-300 rounded-md hover:border-blue-400 transition-colors text-center h-full">
                                                    <div class="mb-3">
                                                        <svg width="40" height="40" viewBox="0 0 320 295" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M107.36 84.1699L144 50.2365V191.724C144 195.637 145.686 199.39 148.686 202.157C151.687 204.924 155.757 206.478 160 206.478C164.243 206.478 168.313 204.924 171.314 202.157C174.314 199.39 176 195.637 176 191.724V50.2365L212.64 84.1699C214.127 85.5528 215.897 86.6504 217.847 87.3994C219.797 88.1484 221.888 88.534 224 88.534C226.112 88.534 228.203 88.1484 230.153 87.3994C232.103 86.6504 233.873 85.5528 235.36 84.1699C236.86 82.7984 238.05 81.1666 238.862 79.3688C239.675 77.5709 240.093 75.6425 240.093 73.6948C240.093 71.7472 239.675 69.8188 238.862 68.0209C238.05 66.223 236.86 64.5913 235.36 63.2197L171.36 4.205C169.838 2.86181 168.044 1.80892 166.08 1.10673C162.185 -0.368908 157.815 -0.368908 153.92 1.10673C151.956 1.80892 150.162 2.86181 148.64 4.205L84.64 63.2197C83.1482 64.5953 81.9648 66.2284 81.1574 68.0257C80.3501 69.8231 79.9345 71.7494 79.9345 73.6948C79.9345 75.6402 80.3501 77.5666 81.1574 79.3639C81.9648 81.1612 83.1482 82.7943 84.64 84.1699C86.1318 85.5455 87.9029 86.6367 89.852 87.3812C91.8012 88.1257 93.8903 88.5089 96 88.5089C98.1097 88.5089 100.199 88.1257 102.148 87.3812C104.097 86.6367 105.868 85.5455 107.36 84.1699ZM304 147.463C299.757 147.463 295.687 149.018 292.686 151.784C289.686 154.551 288 158.304 288 162.217V250.739C288 254.652 286.314 258.405 283.314 261.171C280.313 263.938 276.243 265.493 272 265.493H48C43.7565 265.493 39.6869 263.938 36.6863 261.171C33.6857 258.405 32 254.652 32 250.739V162.217C32 158.304 30.3143 154.551 27.3137 151.784C24.3131 149.018 20.2435 147.463 16 147.463C11.7565 147.463 7.68687 149.018 4.68629 151.784C1.68571 154.551 0 158.304 0 162.217V250.739C0 262.478 5.05713 273.736 14.0589 282.036C23.0606 290.337 35.2696 295 48 295H272C284.73 295 296.939 290.337 305.941 282.036C314.943 273.736 320 262.478 320 250.739V162.217C320 158.304 318.314 154.551 315.314 151.784C312.313 149.018 308.243 147.463 304 147.463Z" fill="#2B7FFF"/>
                                                        </svg>
                                                    </div>
                                                    <span class="font-semibold text-gray-700" id="{{ $document['id'] }}-front-filename">Télécharger la face avant</span>
                                                    <p class="text-xs text-gray-500 mt-2">Formats: JPG, PNG, PDF (max 5MB)</p>
                                                </div>
                                                
                                                <input type="file" 
                                                    name="documents[{{ $document['id'] }}][front_image]"
                                                    id="{{ $document['id'] }}_front"
                                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                                    accept=".jpg,.jpeg,.png,.pdf"
                                                    required>
                                            </div>
                                        </div>

                                        <!-- Back Image Upload -->
                                        <div class="mb-6">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Face arrière <span class="text-red-500">*</span>
                                            </label>
                                            
                                            <div class="relative">
                                                <div class="flex flex-col items-center justify-center px-4 py-6 bg-white border-2 border-dashed border-blue-300 rounded-md hover:border-blue-400 transition-colors text-center h-full">
                                                    <div class="mb-3">
                                                        <svg width="40" height="40" viewBox="0 0 320 295" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M107.36 84.1699L144 50.2365V191.724C144 195.637 145.686 199.39 148.686 202.157C151.687 204.924 155.757 206.478 160 206.478C164.243 206.478 168.313 204.924 171.314 202.157C174.314 199.39 176 195.637 176 191.724V50.2365L212.64 84.1699C214.127 85.5528 215.897 86.6504 217.847 87.3994C219.797 88.1484 221.888 88.534 224 88.534C226.112 88.534 228.203 88.1484 230.153 87.3994C232.103 86.6504 233.873 85.5528 235.36 84.1699C236.86 82.7984 238.05 81.1666 238.862 79.3688C239.675 77.5709 240.093 75.6425 240.093 73.6948C240.093 71.7472 239.675 69.8188 238.862 68.0209C238.05 66.223 236.86 64.5913 235.36 63.2197L171.36 4.205C169.838 2.86181 168.044 1.80892 166.08 1.10673C162.185 -0.368908 157.815 -0.368908 153.92 1.10673C151.956 1.80892 150.162 2.86181 148.64 4.205L84.64 63.2197C83.1482 64.5953 81.9648 66.2284 81.1574 68.0257C80.3501 69.8231 79.9345 71.7494 79.9345 73.6948C79.9345 75.6402 80.3501 77.5666 81.1574 79.3639C81.9648 81.1612 83.1482 82.7943 84.64 84.1699C86.1318 85.5455 87.9029 86.6367 89.852 87.3812C91.8012 88.1257 93.8903 88.5089 96 88.5089C98.1097 88.5089 100.199 88.1257 102.148 87.3812C104.097 86.6367 105.868 85.5455 107.36 84.1699ZM304 147.463C299.757 147.463 295.687 149.018 292.686 151.784C289.686 154.551 288 158.304 288 162.217V250.739C288 254.652 286.314 258.405 283.314 261.171C280.313 263.938 276.243 265.493 272 265.493H48C43.7565 265.493 39.6869 263.938 36.6863 261.171C33.6857 258.405 32 254.652 32 250.739V162.217C32 158.304 30.3143 154.551 27.3137 151.784C24.3131 149.018 20.2435 147.463 16 147.463C11.7565 147.463 7.68687 149.018 4.68629 151.784C1.68571 154.551 0 158.304 0 162.217V250.739C0 262.478 5.05713 273.736 14.0589 282.036C23.0606 290.337 35.2696 295 48 295H272C284.73 295 296.939 290.337 305.941 282.036C314.943 273.736 320 262.478 320 250.739V162.217C320 158.304 318.314 154.551 315.314 151.784C312.313 149.018 308.243 147.463 304 147.463Z" fill="#2B7FFF"/>
                                                        </svg>
                                                    </div>
                                                    <span class="font-semibold text-gray-700" id="{{ $document['id'] }}-back-filename">Télécharger la face arrière</span>
                                                    <p class="text-xs text-gray-500 mt-2">Formats: JPG, PNG, PDF (max 5MB)</p>
                                                </div>
                                                
                                                <input type="file" 
                                                    name="documents[{{ $document['id'] }}][back_image]"
                                                    id="{{ $document['id'] }}_back"
                                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                                    accept=".jpg,.jpeg,.png,.pdf"
                                                    required>
                                            </div>
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
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Choose service <span class="text-red-500">*</span></label>
                                                <select name="vehicle[service]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500  focus:border-blue-500 outline-none bg-blue-50 ">
                                                    <option value="">Select service</option>
                                                    <option value="taxi">Taxi</option>
                                                    <option value="delivery">Delivery</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Location -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Location <span class="text-red-500">*</span></label>
                                                <select name="vehicle[location]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none bg-blue-50">
                                                    <option value="">Choose location</option>
                                                    <option value="city1">City 1</option>
                                                    <option value="city2">City 2</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Taxi Type -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Type <span class="text-red-500">*</span></label>
                                                <select name="vehicle[type]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none bg-blue-50">
                                                    <option value="">Choose taxi type</option>
                                                    <option value="standard">Standard</option>
                                                    <option value="premium">Premium</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Taxi Number -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Taxi number <span class="text-red-500">*</span></label>
                                                <input type="text" 
                                                       name="vehicle[number]"
                                                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none bg-blue-50"
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
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Choose vehicle brand  <span class="text-red-500">*</span></label>
                                                <select name="vehicle[brand]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none bg-blue-50">
                                                    <option value="">Select brand</option>
                                                    <option value="toyota">Toyota</option>
                                                    <option value="honda">Honda</option>
                                                    <option value="bmw">BMW</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Vehicle Model -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Model  <span class="text-red-500">*</span></label>
                                                <select name="vehicle[model]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none bg-blue-50">
                                                    <option value="">Choose vehicle model</option>
                                                    <option value="camry">Camry</option>
                                                    <option value="corolla">Corolla</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Car Year -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Select car year <span class="text-red-500">*</span></label>
                                                <select name="vehicle[year]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none bg-blue-50">
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
                                                class="next-tab-btn inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-blue-800 bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed w-full text-center"
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
                                                class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-blue-700 bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 w-full text-center "
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
