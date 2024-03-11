<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
defineProps({
    members: {
        type: Array,
        required: true,
    },
    user: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <AuthenticatedLayout :user="user">
        <div class="flex flex-col items-center">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div
                        class="border rounded-lg divide-y divide-gray-200 dark:border-gray-700 dark:divide-gray-700"
                    >
                        <div class="overflow-hidden">
                            <table
                                class="min-w-full divide-y divide-gray-200 dark:divide-gray-700"
                            >
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                                        >
                                            氏名
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                                        >
                                            住所
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                                        >
                                            メールアドレス
                                        </th>

                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                                        >
                                            電話番号
                                        </th>

                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase"
                                        >
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="divide-y divide-gray-200 dark:divide-gray-700"
                                >
                                    <template
                                        v-for="member in members"
                                        :key="member.id"
                                    >
                                        <tr>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200"
                                            >
                                                {{ member.last_name
                                                }}{{ member.first_name }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"
                                            >
                                                {{ member.address }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"
                                            >
                                                {{ member.email }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"
                                            >
                                                {{ member.phone }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium"
                                            >
                                                <button
                                                    type="button"
                                                    class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                                >
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
