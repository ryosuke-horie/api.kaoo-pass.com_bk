<script setup>
defineProps({
    label: {
        type: String,
        required: true,
    },
    id: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        default: "",
    },
    required: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["file-selected"]);
</script>

<template>
    <div class="sm:col-span-3">
        <label
            :for="id"
            class="inline-block text-sm font-medium text-gray-500 mt-2.5"
        >
            {{ label }}
        </label>
    </div>
    <div class="sm:col-span-9">
        <label :for="id" class="sr-only">ファイルを選択</label>
        <input
            :id="id"
            :placeholder="placeholder"
            type="file"
            :required="required"
            class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600 file:bg-transparent file:border-0 file:bg-gray-100 file:me-4 file:py-2 file:px-3 dark:file:bg-gray-700 dark:file:text-gray-400"
            @change="emit('file-selected', $event.target.files[0])"
        />
    </div>
</template>
