<div class="fixed z-50 block p-0 xl:ml-[380px] 2xl:ml-[500px] overflow-hidden rounded-lg shadow-md top-4 lg:top-20 max-w-max filter"
    x-data="{ alert: true, type: 'success' }" x-init="setTimeout(() => { alert = false }, 5000)" x-show="alert" x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-90">
    <div
        class="flex {{ 'alert-' . $type }} backdrop-blur-xl max-w-[600px]  items-center justify-between xl:max-w-lg px-4 py-2 min-w-[400px] w-96 m-0 text-sm bg-white bg-opacity-75
     border rounded-lg shadow">
        <div class="flex space-x-4 items-center {{ 'alert-' . $type }}">
            <span class="">
                {{ $slot }}
            </span>
            <p class="{{ 'alert-' . $type }}">{{ $message }}</p>
        </div>
        <span @click="alert = false"
            class="tt cursor-pointer text-{{ $type }}-600 hover:bg-{{ $type }}-300 p-2">
            <i class="text-2xl bi bi-x-circle"></i>
        </span>
    </div>
</div>
