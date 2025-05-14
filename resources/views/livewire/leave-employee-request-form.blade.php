<div class="p-6 bg-white rounded shadow-md">
    @if (session()->has('message'))
        <div class="p-3 bg-green-100 text-green-800 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-4">
        <div>
            <label class="block font-semibold">اسم الموظف</label>
            <select wire:model="employee_id" class="w-full border rounded p-2">
                <option value="">-- اختر موظف --</option>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->employee_name }}</option>
                @endforeach
            </select>
            @error('employee_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold">نوع الإجازة</label>
            <select wire:model="leave_type_id" class="w-full border rounded p-2">
                <option value="">-- اختر نوع الإجازة --</option>
                @foreach ($leaveTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
            @error('leave_type_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold">السبب</label>
            <textarea wire:model="reason" class="w-full border rounded p-2"></textarea>
            @error('reason') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold">تاريخ البداية</label>
                <input type="date" wire:model="start_date" class="w-full border rounded p-2">
                @error('start_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-semibold">تاريخ النهاية</label>
                <input type="date" wire:model="end_date" class="w-full border rounded p-2">
                @error('end_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block font-semibold">ملاحظات</label>
            <textarea wire:model="notes" class="w-full border rounded p-2"></textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            إرسال الطلب
        </button>
    </form>
</div>
