<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <p class="text-sm text-gray-500">Today's Appointments</p>
                    <p class="text-3xl font-semibold mt-1">{{ $todayCount }}</p>
                </div>
                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <p class="text-sm text-gray-500">This Week's Appointments</p>
                    <p class="text-3xl font-semibold mt-1">{{ $weekCount }}</p>
                </div>
                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <p class="text-sm text-gray-500">Today's Revenue</p>
                    <p class="text-3xl font-semibold mt-1">₱{{ number_format($todayRevenue, 2) }}</p>
                </div>
                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <p class="text-sm text-gray-500">This Week's Revenue</p>
                    <p class="text-3xl font-semibold mt-1">₱{{ number_format($weekRevenue, 2) }}</p>
                </div>
            </div>

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <div class="flex justify-between items-center">
                    <p class="text-sm text-gray-500">Unpaid Invoices</p>
                    <p class="text-lg font-semibold">{{ $unpaidCount }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>