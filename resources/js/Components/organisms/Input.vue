<script setup>
/**
 * LabelとInput要素の組み合わせのコンポーネント
 * １行に１つのラベルと入力欄を表示する
 */
defineProps({
    label: {
        type: String,
        required: true,
    },
    id: {
        type: String,
        required: true,
    },
    value: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        required: false,
        default: "",
    },
    required: {
        type: Boolean,
        required: false,
        default: false,
    },
});

// インプット要素の値を定義
const value = defineModel();
</script>

<template>
    <div class="sm:col-span-3">
        <label
            for="af-submit-application-full-name"
            class="inline-block text-sm font-medium text-gray-500 mt-2.5"
        >
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>
    </div>

    <div class="sm:col-span-9">
        <input
            :id="id"
            v-model="value"
            :placeholder="placeholder"
            :type="type"
            :required="required"
            class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
        />
    </div>
</template>
