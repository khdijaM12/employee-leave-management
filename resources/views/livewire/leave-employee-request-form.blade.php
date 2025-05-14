<div class="p-8 bg-white rounded-2xl shadow-lg max-w-2xl mx-auto mt-10">
    @if (session()->has('message'))
        <div class="p-4 bg-indigo-100 text-indigo-800 border border-indigo-300 rounded mb-6 text-center">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-6">
        <h2 class="text-2xl font-bold text-indigo-700 mb-6 text-center">طلب إجازة موظف</h2>

        <div>
            <label class="block font-semibold text-indigo-700 mb-1">اسم الموظف</label>
            <select wire:model="employee_id" class="w-full border border-indigo-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <option value="">-- اختر موظف --</option>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->employee_name }}</option>
                @endforeach
            </select>
            @error('employee_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold text-indigo-700 mb-1">نوع الإجازة</label>
            <select wire:model="leave_type_id" class="w-full border border-indigo-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <option value="">-- اختر نوع الإجازة --</option>
                @foreach ($leaveTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
            @error('leave_type_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold text-indigo-700 mb-1">السبب</label>
            <textarea wire:model="reason" class="w-full border border-indigo-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400"></textarea>
            @error('reason') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-semibold text-indigo-700 mb-1">تاريخ البداية</label>
                <input type="date" wire:model="start_date" class="w-full border border-indigo-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                @error('start_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-semibold text-indigo-700 mb-1">تاريخ النهاية</label>
                <input type="date" wire:model="end_date" class="w-full border border-indigo-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                @error('end_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block font-semibold text-indigo-700 mb-1">ملاحظات</label>
            <textarea wire:model="notes" class="w-full border border-indigo-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400"></textarea>
        </div>

        <div class="text-center">
                    <button
            class="relative inline-flex items-center gap-2 px-6 py-3 rounded-full bg-indigo-600 text-white font-semibold transition duration-300 ease-in-out hover:bg-indigo-700 active:scale-95 shadow-lg hover:shadow-indigo-500/50"
        >
            <svg class="w-5 h-5 text-white animate-pulse" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 4v16m8-8H4"></path>
            </svg>
            <span>إرسال الطلب</span>
        </button>

        </div>
    </form>
</div>
